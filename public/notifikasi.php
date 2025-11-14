<?php
session_start();
include '../header.php';


// koneksi
$conn = mysqli_connect("localhost", "root", "", "lowongan_kerja");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// ambil id dari session
$id_user = isset($_SESSION['id_user']) ? (int)$_SESSION['id_user'] : null;

// ambil data notifikasi dari tabel notifikasi_lamaran
$notifications = [];
if ($id_user) {
    $stmt = $conn->prepare("SELECT * FROM notifikasi_lamaran WHERE id_user = ? ORDER BY id_notifikasi DESC LIMIT 10");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $res = $stmt->get_result();
    while ($row = $res->fetch_assoc()) {
        $notifications[] = $row;
    }
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifikasi Lamaran</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/lucide-icons@latest/dist/umd/lucide.js"></script>
</head>
<body class="bg-white font-sans min-h-screen">

  <!-- Header Putih -->
  <header class="bg-white border-b border-gray-200 py-4 shadow-sm">
    <div class="max-w-5xl mx-auto px-6 flex justify-between items-center">
      <h1 class="text-2xl font-bold tracking-wide flex items-center gap-2 text-[#00797a]">
        <i data-lucide="bell" class="w-6 h-6 text-[#00797a]"></i>
        Notifikasi Lamaran
      </h1>
      <a href="../public/riwayat_lamaran.php"
        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition mb-4">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
    </div>
  </header>

    <!-- Konten -->
  <main class="max-w-6xl mx-auto mt-10 px-8">
    <div class="bg-white shadow-sm rounded-xl overflow-hidden border border-gray-200">
      <!-- Header tabel -->
      <div class="bg-gray-50 border-b border-gray-200 px-6 py-4 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <i data-lucide="inbox" class="w-5 h-5 text-[#00797a]"></i>
          <h2 class="text-lg font-semibold text-gray-800">Daftar Notifikasi</h2>
        </div>

        <?php  
          $unreadCount = 0;
          if (!empty($notifications)) {
              foreach ($notifications as $n) {
                  if (strtolower($n['status']) === 'belum dibaca') $unreadCount++;
              }
          }
        ?>

        <span class="text-sm font-medium 
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
