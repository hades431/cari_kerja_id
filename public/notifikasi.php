<?php
session_start();

$id_pelamar = $_SESSION['id_pelamar'] ?? null;
if (!$id_pelamar) {
    // no pelamar in session -> nothing to return
    http_response_code(204);
    exit;
} 

$conn = mysqli_connect("localhost", "root", "", "lowongan_kerja");
if (!$conn) {
    http_response_code(500);
    echo "Koneksi gagal";
    exit;
}

// support count endpoint: ?count=1 -> JSON { count: N }
if (isset($_GET['count']) && $_GET['count'] == '1') {
    $stmt = mysqli_prepare($conn, "SELECT COUNT(*) AS cnt FROM notifikasi_lamaran WHERE id_pelamar = ? AND is_read = 0");
    mysqli_stmt_bind_param($stmt, "i", $id_pelamar);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $cnt = 0;
    if ($res && $r = mysqli_fetch_assoc($res)) $cnt = (int)$r['cnt'];
    mysqli_stmt_close($stmt);

    // hitung ekstra: lamaran "di proses" baru (1 hari terakhir) yang belum punya notifikasi serupa
    $extra_cnt = 0;
    $q_extra = "SELECT COUNT(*) AS cnt
                FROM lamaran lam
                JOIN lowongan l ON lam.id_lowongan = l.id_lowongan
                JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan
                WHERE lam.id_pelamar = ?
                  AND lam.status_lamaran = 'di proses'
                  AND lam.tanggal_lamar >= DATE_SUB(NOW(), INTERVAL 1 DAY)
                  AND NOT EXISTS (
                      SELECT 1 FROM notifikasi_lamaran n
                      WHERE n.id_pelamar = lam.id_pelamar
                        AND n.pesan LIKE CONCAT('%', l.posisi, '%', p.nama_perusahaan, '%')
                  )";
    $st2 = mysqli_prepare($conn, $q_extra);
    if ($st2) {
        mysqli_stmt_bind_param($st2, "i", $id_pelamar);
        mysqli_stmt_execute($st2);
        $res2 = mysqli_stmt_get_result($st2);
        if ($res2 && $r2 = mysqli_fetch_assoc($res2)) {
            $extra_cnt = (int)$r2['cnt'];
        }
        mysqli_stmt_close($st2);
    }

    header('Content-Type: application/json');
    echo json_encode(['count' => $cnt + $extra_cnt]);
    mysqli_close($conn);
    exit;
}

// HTML: mark unread as read, then fetch recent notifications (so they remain visible but marked as read)

// ambil unread ids dulu (sebelum marking)
$unread_stmt = mysqli_prepare($conn, "SELECT id_notifikasi FROM notifikasi_lamaran WHERE id_pelamar = ? AND is_read = 0");
$unread_ids = [];
if ($unread_stmt) {
    mysqli_stmt_bind_param($unread_stmt, "i", $id_pelamar);
    mysqli_stmt_execute($unread_stmt);
    $resu = mysqli_stmt_get_result($unread_stmt);
    if ($resu) {
        while ($r = mysqli_fetch_assoc($resu)) {
            $unread_ids[] = (int)$r['id_notifikasi'];
        }
    }
    mysqli_stmt_close($unread_stmt);
}

// tandai unread dari DB sebagai sudah dibaca (agar panel menunjukkan "Sudah dibaca" setelah dibuka)
if (!empty($unread_ids)) {
    $mark = mysqli_prepare($conn, "UPDATE notifikasi_lamaran SET is_read = 1 WHERE id_pelamar = ? AND is_read = 0");
    if ($mark) {
        mysqli_stmt_bind_param($mark, "i", $id_pelamar);
        mysqli_stmt_execute($mark);
        mysqli_stmt_close($mark);
    }
}

// ambil notifikasi dari DB
$notifications = [];
$stmt = mysqli_prepare($conn, "SELECT id_notifikasi, pesan, is_read, created_at FROM notifikasi_lamaran WHERE id_pelamar = ? ORDER BY created_at DESC LIMIT 50");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $id_pelamar);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res) {
        while ($row = mysqli_fetch_assoc($res)) {
            $notifications[] = $row;
        }
    }
    mysqli_stmt_close($stmt);
}

// tambahkan notifikasi sintetis untuk lamaran "di proses" baru (1 hari terakhir) jika belum ada notifikasi serupa
$synthetic_unread = 0;
$existing_msgs = [];
foreach ($notifications as $n) {
    $existing_msgs[] = mb_strtolower($n['pesan'] ?? '');
}

$q_lp = "SELECT lam.id_lamaran, l.posisi, p.nama_perusahaan, lam.tanggal_lamar
         FROM lamaran lam
         JOIN lowongan l ON lam.id_lowongan = l.id_lowongan
         JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan
         WHERE lam.id_pelamar = ?
           AND lam.status_lamaran = 'di proses'
           AND lam.tanggal_lamar >= DATE_SUB(NOW(), INTERVAL 1 DAY)
         ORDER BY lam.tanggal_lamar DESC
         LIMIT 10";
$st_lp = mysqli_prepare($conn, $q_lp);
if ($st_lp) {
    mysqli_stmt_bind_param($st_lp, "i", $id_pelamar);
    mysqli_stmt_execute($st_lp);
    $res_lp = mysqli_stmt_get_result($st_lp);
    if ($res_lp) {
        while ($r = mysqli_fetch_assoc($res_lp)) {
            $posisi = trim($r['posisi'] ?? '');
            $perusahaan = trim($r['nama_perusahaan'] ?? '');
            $tanggal = $r['tanggal_lamar'] ?? date('Y-m-d H:i:s');
            if ($posisi === '' && $perusahaan === '') continue;

            $msg = "Lamaran Anda untuk posisi {$posisi} di {$perusahaan} sedang di proses.";
            $msg_lc = mb_strtolower($msg);

            $duplicate = false;
            foreach ($existing_msgs as $em) {
                if ($posisi !== '' && $perusahaan !== '' && (mb_stripos($em, mb_strtolower($posisi)) !== false && mb_stripos($em, mb_strtolower($perusahaan)) !== false)) {
                    $duplicate = true;
                    break;
                }
                if (mb_stripos($em, $msg_lc) !== false) {
                    $duplicate = true;
                    break;
                }
            }
            if ($duplicate) continue;

            array_unshift($notifications, [
                'id_notifikasi' => 0, // sintetis
                'pesan' => $msg,
                'is_read' => 0,
                'created_at' => $tanggal,
            ]);
            $existing_msgs[] = $msg_lc;
            $synthetic_unread++;
        }
    }
    mysqli_stmt_close($st_lp);
}

// render HTML fragment
header('Content-Type: text/html; charset=utf-8'); // ensure correct content-type
echo '<div class="max-w-4xl mb-4">';

if (empty($notifications)) {
    // no fallback gray text — return empty container
    echo '<div class="bg-white rounded p-6 text-center text-gray-600">';
    echo '<div class="text-lg font-medium mb-2">Belum ada notifikasi.</div>';
    echo '<div class="text-sm">Notifikasi akan muncul setelah perusahaan memperbarui status lamaran Anda.</div>';
    echo '</div>';
    echo '</div>'; // .max-w-4xl
    mysqli_close($conn);
    exit;
}

$unreadCount = count($unread_ids) + $synthetic_unread;
echo '<div class="mb-3 text-sm">';
if ($unreadCount > 0) {
    echo '<span class="text-[#00797a] font-medium">Pesan Belum Dibaca: ' . $unreadCount . '</span>';
}
echo '</div>';


echo '<div class="space-y-2">';
foreach ($notifications as $n) {
    $id_notif = (int)($n['id_notifikasi'] ?? 0);
    $pesan = htmlspecialchars($n['pesan'] ?? '');
    $waktu = htmlspecialchars($n['created_at'] ?? '');
    $isRead = (int)($n['is_read'] ?? 0);
    if ($id_notif === 0) $isRead = 0; // sintetis -> unread

    $colorClass = 'text-gray-800';
    if (stripos($pesan, 'diterima') !== false || stripos($pesan, 'terima') !== false) $colorClass = 'text-[#00797a] font-semibold';
    elseif (stripos($pesan, 'ditolak') !== false || stripos($pesan, 'tolak') !== false) $colorClass = 'text-red-600 font-semibold';
    elseif (stripos($pesan, 'di proses') !== false || stripos($pesan, 'proses') !== false) $colorClass = 'text-blue-700 font-medium';

    echo '<div class="bg-white border rounded p-4 flex justify-between items-start gap-4 hover:shadow-sm">';
    echo '<div>';
    echo '<div class="' . $colorClass . ' text-sm leading-relaxed">' . $pesan . '</div>';
    echo '<div class="text-xs text-gray-500 mt-1">(' . $waktu . ')</div>';
    echo '</div>';

    $labelClass = $isRead ? 'text-gray-500 bg-gray-100' : 'text-white bg-red-600';
    $labelText = $isRead ? 'Sudah dibaca' : 'Baru';
    echo '<div class="flex-shrink-0 flex items-center gap-2">';
    if ($id_notif !== 0) {
        echo '<button type="button" class="notif-delete-btn text-xs text-red-600 hover:underline" data-id="' . $id_notif . '">Hapus</button>';
    } else {
        echo '<span class="text-xs text-gray-400 italic">sementara</span>';
    }
    echo '<span class="px-2 py-1 text-xs rounded ' . $labelClass . '">' . $labelText . '</span>';
    echo '</div>';

    echo '</div>';
}
echo '</div>'; // .space-y-2
echo '</div>'; // .max-w-4xl

mysqli_close($conn);
exit; // ensure no trailing content is sent
?>
