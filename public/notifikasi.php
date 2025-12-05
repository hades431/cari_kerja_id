<?php
session_start();

$id_pelamar = $_SESSION['id_pelamar'] ?? null;
if (!$id_pelamar) {
    http_response_code(204);
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "lowongan_kerja");
if (!$conn) {
    http_response_code(500);
    echo "Koneksi gagal";
    exit;
}


if (isset($_GET['count']) && $_GET['count'] == '1') {

    $stmt = mysqli_prepare($conn, "
        SELECT COUNT(*) AS cnt
        FROM notifikasi_lamaran
        WHERE id_pelamar = ? AND is_read = 0
    ");
    mysqli_stmt_bind_param($stmt, "i", $id_pelamar);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $cnt = ($res && $r = mysqli_fetch_assoc($res)) ? (int)$r['cnt'] : 0;
    mysqli_stmt_close($stmt);

    header('Content-Type: application/json');
    echo json_encode(['count' => $cnt]);
    mysqli_close($conn);
    exit;
}


$unread_ids = [];
$st = mysqli_prepare($conn, "
    SELECT id_notifikasi FROM notifikasi_lamaran
    WHERE id_pelamar = ? AND is_read = 0
");
mysqli_stmt_bind_param($st, "i", $id_pelamar);
mysqli_stmt_execute($st);
$res = mysqli_stmt_get_result($st);
while ($r = mysqli_fetch_assoc($res)) $unread_ids[] = (int)$r['id_notifikasi'];
mysqli_stmt_close($st);

if (!empty($unread_ids)) {
    $st = mysqli_prepare($conn, "
        UPDATE notifikasi_lamaran
        SET is_read = 1
        WHERE id_pelamar = ? AND is_read = 0
    ");
    mysqli_stmt_bind_param($st, "i", $id_pelamar);
    mysqli_stmt_execute($st);
    mysqli_stmt_close($st);
}

$notifications = [];
$st = mysqli_prepare($conn, "
    SELECT id_notifikasi, pesan, is_read, created_at
    FROM notifikasi_lamaran
    WHERE id_pelamar = ?
    ORDER BY created_at DESC
    LIMIT 50
");
mysqli_stmt_bind_param($st, "i", $id_pelamar);
mysqli_stmt_execute($st);
$res = mysqli_stmt_get_result($st);
while ($row = mysqli_fetch_assoc($res)) {
    $notifications[] = $row;
}
mysqli_stmt_close($st);

$seen = [];
$unique = [];
foreach ($notifications as $n) {
    $norm = strtolower(trim(preg_replace('/\s+/', ' ', $n['pesan'])));
    if (!isset($seen[$norm])) {
        $seen[$norm] = true;
        $unique[] = $n;
    }
}
$notifications = $unique;


header('Content-Type: text/html; charset=utf-8');

echo '<div class="max-w-4xl mb-4">';

if (empty($notifications)) {
    echo '
        <div class="bg-white rounded p-6 text-center text-gray-600">
            <div class="text-lg font-medium mb-2">Belum ada notifikasi.</div>
            <div class="text-sm">Notifikasi akan muncul setelah perusahaan memperbarui status lamaran Anda.</div>
        </div>';
    echo '</div>';
    mysqli_close($conn);
    exit;
}

echo '<div class="mb-3 text-sm">';
echo '<span class="text-[#00797a] font-medium">Pesan Belum Dibaca: ' . count($unread_ids) . '</span>';
echo '</div>';

echo '<div class="space-y-2">';

foreach ($notifications as $n) {
    $id = (int)$n['id_notifikasi'];
    $pesan = htmlspecialchars($n['pesan']);
    $waktu = htmlspecialchars($n['created_at']);
    $isRead = (int)$n['is_read'];

    // warna berdasarkan status
    $color = 'text-gray-800';
    if (stripos($pesan, 'diterima') !== false) $color = 'text-[#00797a] font-semibold';
    elseif (stripos($pesan, 'ditolak') !== false) $color = 'text-red-600 font-semibold';
    elseif (stripos($pesan, 'proses') !== false) $color = 'text-blue-700 font-medium';

    $labelClass = $isRead ? 'text-gray-500 bg-gray-100' : 'text-white bg-red-600';
    $labelText = $isRead ? 'Sudah dibaca' : 'Baru';

    echo '
    <div class="bg-white border rounded p-4 flex justify-between items-start gap-4 hover:shadow-sm">
        <div>
            <div class="' . $color . ' text-sm leading-relaxed">' . $pesan . '</div>
            <div class="text-xs text-gray-500 mt-1">(' . $waktu . ')</div>
        </div>
        <div class="flex-shrink-0 flex items-center gap-2">
            <button class="notif-delete-btn text-xs text-red-600 hover:underline" data-id="' . $id . '">Hapus</button>
            <span class="px-2 py-1 text-xs rounded ' . $labelClass . '">' . $labelText . '</span>
        </div>
    </div>';
}

echo '</div></div>';

mysqli_close($conn);
exit;
?>
