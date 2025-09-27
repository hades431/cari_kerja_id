<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'perusahaan') {
    header('Location: ../login/login.php');
    exit;
}

include __DIR__ . "/../config.php"; // koneksi database
include '../header.php';
// Statistik
$jmlLowongan    = $conn->query("SELECT COUNT(*) FROM lowongan")->fetch_row()[0];
$jmlPerusahaan  = $conn->query("SELECT COUNT(*) FROM perusahaan")->fetch_row()[0];
$jmlUser        = $conn->query("SELECT COUNT(*) FROM user")->fetch_row()[0];
$jmlArtikel     = $conn->query("SELECT COUNT(*) FROM artikel")->fetch_row()[0];

// Aktivitas terbaru
$aktivitasTerbaru = [];
$res = $conn->query("SELECT * FROM aktivitas ORDER BY tanggal DESC LIMIT 5");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $aktivitasTerbaru[] = $row;
    }
}

// Artikel terbaru
$artikelTerbaru = [];
$res = $conn->query("SELECT * FROM artikel ORDER BY created_at DESC LIMIT 5");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $artikelTerbaru[] = $row;
    }
}

// Perusahaan baru
$perusahaanBaru = [];
$res = $conn->query("SELECT * FROM perusahaan ORDER BY created_at DESC LIMIT 5");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $perusahaanBaru[] = $row;
    }
}

// Notifikasi
$notifikasi = [];
$res = $conn->query("SELECT * FROM notifikasi ORDER BY id DESC LIMIT 5");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $notifikasi[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Perusahaan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="flex h-screen">
  <!-- Sidebar -->
  <aside class="w-64 bg-[#009fa3] text-white flex flex-col justify-between">
    <!-- Top Section -->
    <div>
      <div class="flex flex-col items-center py-6">
        <a href="../perusahaan/profile_perusahaan.php" class="w-20 h-20 bg-gray-200 rounded-full overflow-hidden block">
          <img src="https://via.placeholder.com/150" alt="Logo Perusahaan" class="w-full h-full object-cover">
        </a>
        <h2 class="mt-3 text-lg font-semibold">Perusahaan</h2>
      </div>
      <!-- Menu -->
      <nav class="mt-6 space-y-2 px-4">
        <a href="dashboard_perusahaan.php" 
           class="block py-2 px-4 rounded-lg hover:bg-[#00b6b9] transition">
          Dashboard
        </a>
        <a href="../perusahaan/daftar_pelamar.php" 
           class="block py-2 px-4 rounded-lg hover:bg-[#00b6b9] transition">
          Daftar Pelamar
        </a>
        <a href="../perusahaan/form_pasang_lowongan.php" 
           class="block py-2 px-4 rounded-lg hover:bg-[#00b6b9] transition">
          Pasang Lowongan
        </a>
        <!-- Button Kembali -->
        <a href="../landing/landing_page.php" 
           class="block py-2 px-4 rounded-lg bg-gray-200 text-[#009fa3] font-semibold hover:bg-gray-300 transition mt-4">
          Kembali
        </a>
        <!-- Button Logout -->
        <form action="../logout.php" method="post" class="mt-2">
          <button type="submit" class="w-full py-2 px-4 rounded-lg bg-red-500 hover:bg-red-600 transition font-semibold">
            Logout
          </button>
        </form>
      </nav>
    </div>
    <!-- Footer -->
    <div class="p-4 text-sm text-center text-[#b2e3e5]">
      © 2025 Carikerja.id
    </div>
  </aside>

  <!-- Content -->
  <main class="flex-1 bg-gray-100 p-8">
    <h1 class="text-2xl font-bold text-[#009fa3] mb-6">Dashboard</h1>
    <!-- Statistik -->
    <div class="grid grid-cols-4 gap-4 mb-8">
      <div class="bg-[#009fa3] text-white p-4 rounded-lg shadow">
        <div>Total Lowongan</div>
        <div class="text-3xl font-bold"><?= $jmlLowongan ?></div>
      </div>
      <div class="bg-[#009fa3] text-white p-4 rounded-lg shadow">
        <div>Total Perusahaan</div>
        <div class="text-3xl font-bold"><?= $jmlPerusahaan ?></div>
      </div>
      <div class="bg-[#009fa3] text-white p-4 rounded-lg shadow">
        <div>Total User</div>
        <div class="text-3xl font-bold"><?= $jmlUser ?></div>
      </div>
      <div class="bg-[#009fa3] text-white p-4 rounded-lg shadow">
        <div>Total Artikel</div>
        <div class="text-3xl font-bold"><?= $jmlArtikel ?></div>
      </div>
    </div>

    <!-- Aktivitas Terbaru -->
    <div class="bg-white p-4 rounded-lg shadow mb-8">
      <h2 class="text-lg font-semibold mb-4">Aktivitas Terbaru</h2>
      <ul class="space-y-2">
        <?php if (!empty($aktivitasTerbaru)): ?>
          <?php foreach ($aktivitasTerbaru as $a): ?>
            <li class="flex justify-between">
              <span><?= isset($a['icon']) ? $a['icon'] : '' ?> <?= $a['pesan'] ?></span>
              <span class="text-gray-500 text-sm"><?= $a['tanggal'] ?></span>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li class="text-gray-400">Belum ada aktivitas</li>
        <?php endif; ?>
      </ul>
    </div>

    <!-- Artikel Terbaru -->
    <div class="bg-white p-4 rounded-lg shadow mb-8">
      <h2 class="text-lg font-semibold mb-4">Artikel Terbaru</h2>
      <ul class="list-disc pl-5">
        <?php foreach ($artikelTerbaru as $art): ?>
          <li><?= $art['judul'] ?> <span class="text-gray-500 text-sm">(<?= $art['created_at'] ?>)</span></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Perusahaan Baru -->
    <div class="bg-white p-4 rounded-lg shadow mb-8">
      <h2 class="text-lg font-semibold mb-4">Perusahaan Baru</h2>
      <ul class="list-disc pl-5">
        <?php foreach ($perusahaanBaru as $p): ?>
          <li><?= $p['nama_perusahaan'] ?> <span class="text-gray-500 text-sm">(<?= $p['created_at'] ?>)</span></li>
        <?php endforeach; ?>
      </ul>
    </div>

    <!-- Notifikasi -->
    <div class="bg-white p-4 rounded-lg shadow">
      <h2 class="text-lg font-semibold mb-4">Notifikasi</h2>
      <ul class="space-y-2">
        <?php if (!empty($notifikasi)): ?>
          <?php foreach ($notifikasi as $n): ?>
            <li class="flex justify-between">
              <span><?= isset($n['icon']) ? $n['icon'] : '' ?> <?= $n['pesan'] ?></span>
              <a href="<?= $n['link'] ?>" class="text-blue-500"><?= $n['aksi'] ?></a>
            </li>
          <?php endforeach; ?>
        <?php else: ?>
          <li class="text-gray-400">Tidak ada notifikasi</li>
        <?php endif; ?>
      </ul>
    </div>
  </main>
</div>
</body>
</html>