<?php
session_start();
include '../../function/logic.php';

$jumlahLoker       = 0;
$jumlahPerusahaan  = 0;
$jumlahUser        = 0;
$jumlahArtikel     = count(getArtikelList());
$lowonganTerbaru   = [
    ["posisi" => "Host Live", "perusahaan" => "PT. Figma", "tanggal" => "2025-08-01"],
    ["posisi" => "UI Designer", "perusahaan" => "PT. OpenAI", "tanggal" => "2025-08-05"]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Dashboard Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#222] min-h-screen">
    <div class="flex min-h-screen">
<aside class="bg-teal-800 w-64 flex flex-col min-h-screen shadow-lg">
  <div class="px-4 py-6 flex flex-col items-center gap-2">
    <img src="../../img/logo2.png" alt="Logo" class="w-48 object-contain" />
  </div>
  <nav class="flex-1 flex flex-col gap-1 px-2 mt-4">
    <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition text-white bg-teal-900">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3" /></svg>
      <span>Dashboard</span>
    </a>
    <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition text-teal-100 hover:bg-teal-900 hover:text-white">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M4 6h16M4 12h16M4 18h16" /></svg>
      <span>Lowongan Kerja</span>
    </a>
    <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition text-teal-100 hover:bg-teal-900 hover:text-white">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 21v-4a4 4 0 014-4h10a4 4 0 014 4v4" /><circle cx="12" cy="7" r="4" /></svg>
      <span>Perusahaan</span>
    </a>
    <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition text-teal-100 hover:bg-teal-900 hover:text-white">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4" /><path d="M5.5 21v-2a4.5 4.5 0 019 0v2" /></svg>
      <span>Pelamar</span>
    </a>
    <a href="../tips_kerja/tips_kerja_artikel.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition text-teal-100 hover:bg-teal-900 hover:text-white">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" /><path d="M16 2v4M8 2v4M3 10h18" /></svg>
      <span>Artikel & Tips</span>
    </a>
    <a href="../logout.php" onclick="return confirm('Yakin mau logout?')" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition text-teal-100 hover:bg-red-700 hover:text-white mt-auto mb-6">
      <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7" /><rect x="3" y="4" width="4" height="16" rx="2" /></svg>
      <span>Logout</span>
    </a>
  </nav>
</aside>

<!-- Main Content -->
<div class="flex-1 flex flex-col bg-white min-h-screen">
  <!-- Header -->
  <header class="bg-teal-800 flex items-center justify-between px-12 py-4 text-white shadow">
    <h2 class="text-2xl font-bold tracking-wide">Dashboard Admin</h2>
    <div class="flex items-center gap-3">
      <span class="text-lg font-medium"><?= htmlspecialchars($_SESSION['nama_admin'] ?? 'Admin'); ?></span>
      <img src="../../img/beauty.png" alt="Admin" class="w-10 h-10 rounded-full border-2 border-white shadow-md">
    </div>
  </header>

  <!-- Main -->
  <main class="p-8">
    <h3 class="text-xl font-bold mb-6">Statistik / Ringkasan</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
      <div class="bg-gradient-to-br from-teal-50 to-white shadow rounded-xl flex flex-col items-center justify-center p-6 cursor-pointer transform transition hover:scale-105 hover:shadow-lg active:scale-95">
        <svg class="w-12 h-12 mb-3 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3" /></svg>
        <p class="text-3xl font-bold text-teal-700"><?= $jumlahLoker ?></p>
        <p class="text-gray-600 mt-1">Lowongan Tersedia</p>
      </div>
      <div class="bg-gradient-to-br from-teal-50 to-white shadow rounded-xl flex flex-col items-center justify-center p-6 cursor-pointer transform transition hover:scale-105 hover:shadow-lg active:scale-95">
        <svg class="w-12 h-12 mb-3 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 21v-4a4 4 0 014-4h10a4 4 0 014 4v4" /><circle cx="12" cy="7" r="4" /></svg>
        <p class="text-3xl font-bold text-teal-700"><?= $jumlahPerusahaan ?></p>
        <p class="text-gray-600 mt-1">Perusahaan Terdaftar</p>
      </div>
      <div class="bg-gradient-to-br from-teal-50 to-white shadow rounded-xl flex flex-col items-center justify-center p-6 cursor-pointer transform transition hover:scale-105 hover:shadow-lg active:scale-95">
        <svg class="w-12 h-12 mb-3 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4" /><path d="M5.5 21v-2a4.5 4.5 0 019 0v2" /></svg>
        <p class="text-3xl font-bold text-teal-700"><?= $jumlahUser ?></p>
        <p class="text-gray-600 mt-1">User</p>
      </div>
      <div class="bg-gradient-to-br from-teal-50 to-white shadow rounded-xl flex flex-col items-center justify-center p-6 cursor-pointer transform transition hover:scale-105 hover:shadow-lg active:scale-95">
        <svg class="w-12 h-12 mb-3 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" /><path d="M16 2v4M8 2v4M3 10h18" /></svg>
        <p class="text-3xl font-bold text-teal-700"><?= $jumlahArtikel ?></p>
        <p class="text-gray-600 mt-1">Artikel & Tips</p>
      </div>
    </div>

<div class="mt-8 space-y-6">

    <!-- Aktivitas Terbaru -->
    <div class="bg-white shadow rounded-2xl p-5">
        <h2 class="font-semibold text-lg mb-3">Aktivitas Terbaru</h2>
        <div class="space-y-3">
            <div class="p-4 bg-gray-50 rounded-xl shadow-sm text-sm text-gray-700">👤 User baru mendaftar: <span class="font-medium">andi123</span></div>
            <div class="p-4 bg-gray-50 rounded-xl shadow-sm text-sm text-gray-700">🏢 PT. Figma menambahkan lowongan</div>
            <div class="p-4 bg-gray-50 rounded-xl shadow-sm text-sm text-gray-700">📝 Artikel baru dipublikasikan: <span class="font-medium">Tips Wawancara</span></div>
        </div>
    </div>

    <!-- Statistik Bulanan -->
    <div class="bg-white shadow rounded-2xl p-5">
        <h2 class="font-semibold text-lg mb-3">Statistik Bulanan</h2>
        <div class="space-y-4">
            <div>
                <p class="text-sm font-medium">User</p>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-teal-600 h-2.5 rounded-full" style="width: 70%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">70 user bulan ini</p>
            </div>
            <div>
                <p class="text-sm font-medium">Lowongan</p>
                <div class="w-full bg-gray-200 rounded-full h-2.5">
                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 40%"></div>
                </div>
                <p class="text-xs text-gray-500 mt-1">40 lowongan bulan ini</p>
            </div>
        </div>
    </div>

    <!-- Perusahaan Baru -->
    <div class="bg-white shadow rounded-2xl p-5">
        <h2 class="font-semibold text-lg mb-3">Perusahaan Baru</h2>
        <div class="space-y-3">
            <div class="p-4 bg-gray-50 rounded-xl shadow-sm text-sm text-gray-700">🏢 PT. OpenAI - 10/08/2025</div>
            <div class="p-4 bg-gray-50 rounded-xl shadow-sm text-sm text-gray-700">🏢 PT. Figma - 08/08/2025</div>
            <div class="p-4 bg-gray-50 rounded-xl shadow-sm text-sm text-gray-700">🏢 PT. Tailwind - 02/08/2025</div>
        </div>
    </div>

    <!-- Artikel Terbaru -->
    <div class="bg-white shadow rounded-2xl p-5">
        <h2 class="font-semibold text-lg mb-3">Artikel & Tips Terbaru</h2>
        <div class="space-y-3">
            <div class="p-4 bg-gray-50 rounded-xl shadow-sm flex justify-between items-center text-sm text-gray-700">
                <span>📄 <a href="#" class="text-blue-600 hover:underline">Cara Membuat CV ATS</a></span>
                <span class="text-gray-400 text-xs">05/08/2025</span>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl shadow-sm flex justify-between items-center text-sm text-gray-700">
                <span>📄 <a href="#" class="text-blue-600 hover:underline">Tips Interview Online</a></span>
                <span class="text-gray-400 text-xs">01/08/2025</span>
            </div>
        </div>
    </div>

    <!-- Notifikasi -->
    <div class="bg-white shadow rounded-2xl p-5">
        <h2 class="font-semibold text-lg mb-3">Notifikasi</h2>
        <div class="space-y-3">
            <div class="p-4 bg-gray-50 rounded-xl shadow-sm flex justify-between items-center text-sm text-gray-700">
                <span>⚠️ 2 lowongan menunggu verifikasi</span>
                <button class="text-xs text-blue-600 hover:underline">Lihat</button>
            </div>
            <div class="p-4 bg-gray-50 rounded-xl shadow-sm flex justify-between items-center text-sm text-gray-700">
                <span>📌 3 user belum melengkapi profil</span>
                <button class="text-xs text-blue-600 hover:underline">Detail</button>
            </div>
        </div>
    </div>

</div>
</body>
</html>
