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

    header('Content-Type: application/json');
    echo json_encode(['count' => $cnt]);
    mysqli_close($conn);
    exit;
}

// HTML: mark unread as read, then fetch recent notifications (so they remain visible but marked as read)

// get unread ids (optional, not strictly needed but kept for logic)
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

// mark unread as read (so they will be shown as "Sudah dibaca")
if (!empty($unread_ids)) {
    $mark = mysqli_prepare($conn, "UPDATE notifikasi_lamaran SET is_read = 1 WHERE id_pelamar = ? AND is_read = 0");
    if ($mark) {
        mysqli_stmt_bind_param($mark, "i", $id_pelamar);
        mysqli_stmt_execute($mark);
        mysqli_stmt_close($mark);
    }
}

// fetch recent notifications (including read ones), limit to last 50
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

// render HTML fragment
echo '<div class="max-w-4xl mb-4">';

if (empty($notifications)) {
    echo '<div class="bg-white p-4 rounded shadow text-sm text-gray-600">Belum ada notifikasi.</div>';
    echo '</div>';
    mysqli_close($conn);
    exit;
}

// header summary: count unread before marking (we computed $unread_ids)
$unreadCount = count($unread_ids);
echo '<div class="mb-3 text-sm">';
if ($unreadCount > 0) {
    echo '<span class="text-[#00797a] font-medium">Pesan Belum Dibaca: ' . $unreadCount . '</span>';
}
echo '</div>';

// list notifications
echo '<div class="space-y-2">';
foreach ($notifications as $n) {
    $pesan = htmlspecialchars($n['pesan']);
    $waktu = htmlspecialchars($n['created_at']);
    $isRead = (int)($n['is_read'] ?? 0);

    // color heuristics
    $colorClass = 'text-gray-800';
    if (stripos($pesan, 'diterima') !== false || stripos($pesan, 'terima') !== false) $colorClass = 'text-[#00797a] font-semibold';
    elseif (stripos($pesan, 'ditolak') !== false || stripos($pesan, 'tolak') !== false) $colorClass = 'text-red-600 font-semibold';
    elseif (stripos($pesan, 'di proses') !== false || stripos($pesan, 'proses') !== false) $colorClass = 'text-blue-700 font-medium';

    echo '<div class="bg-white border rounded p-4 flex justify-between items-start gap-4 hover:shadow-sm">';
    echo '<div>';
    echo '<div class="' . $colorClass . ' text-sm leading-relaxed">' . $pesan . '</div>';
    echo '<div class="text-xs text-gray-500 mt-1">(' . $waktu . ')</div>';
    echo '</div>';
    // status label: "Sudah dibaca" if is_read, else "Baru"
    $labelClass = $isRead ? 'text-gray-500 bg-gray-100' : 'text-white bg-red-600';
    $labelText = $isRead ? 'Sudah dibaca' : 'Baru';
    echo '<div class="flex-shrink-0"><span class="px-2 py-1 text-xs rounded ' . $labelClass . '">' . $labelText . '</span></div>';
    echo '</div>';
}
echo '</div>'; // .space-y-2
echo '</div>'; // .max-w-4xl

mysqli_close($conn);
?>
          <?= $unreadCount > 0 ? 'text-[#00797a]' : 'text-gray-500' ?>">
          <?= $unreadCount > 0 
              ? "Pesan Belum Dibaca: {$unreadCount}" 
              : "Semua pesan sudah dibaca ✅"; ?>
        </span>
      </div>

      <div class="p-6">
        <?php if (!empty($notifications)): ?>
          <div class="divide-y divide-gray-100">
            <?php foreach ($notifications as $row): 
                $text = $row['pesan'] ?? 'Notifikasi baru';
                $time = $row['tanggal'] ?? '';
                $status = strtolower($row['status'] ?? '') === 'belum dibaca';

                // Warna teks halus sesuai isi pesan
                $colorClass = 'text-gray-800';
                if (stripos($text, 'diterima') !== false) $colorClass = 'text-[#00797a] font-semibold';
                elseif (stripos($text, 'ditolak') !== false) $colorClass = 'text-red-600 font-semibold';
                elseif (stripos($text, 'diproses') !== false) $colorClass = 'text-blue-700 font-medium';
                elseif (stripos($text, 'menunggu') !== false) $colorClass = 'text-amber-700 font-medium';
            ?>
            
            <div class="flex items-start gap-4 py-5 px-3 <?= $status ? 'bg-gray-50' : 'bg-white' ?> hover:bg-gray-100 transition rounded-lg">
              
              <!-- Titik status -->
              <div class="flex-shrink-0 mt-2">
                <div class="<?= $status ? 'bg-[#00797a]' : 'bg-gray-300' ?> w-3 h-3 rounded-full"></div>
              </div>

              <!-- Isi notifikasi -->
              <div class="flex-1">
                <p class="<?= $colorClass ?> leading-relaxed text-[15px]">
                  <?= htmlspecialchars($text); ?>
                </p>
                <?php if ($time): ?>
                  <p class="text-sm text-gray-500 mt-1 flex items-center gap-1">
                    <i data-lucide="clock" class="w-4 h-4 text-gray-400"></i>
                    <?= htmlspecialchars($time); ?>
                  </p>
                <?php endif; ?>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div class="text-gray-600 text-center py-16 flex flex-col items-center">
            <i data-lucide="bell-off" class="w-10 h-10 text-gray-400 mb-3"></i>
            <p class="text-lg font-medium">Belum ada notifikasi.</p>
            <p class="text-sm text-gray-500 mt-1">Notifikasi akan muncul setelah perusahaan memperbarui status lamaran Anda.</p>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </main>

  <script>
    lucide.createIcons();
  </script>

</body>
</html>
</body>
</html>
