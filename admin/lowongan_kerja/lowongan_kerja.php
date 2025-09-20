<?php
session_start();
include '../../function/logic.php';
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lowongan kerja</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f3f4f6] min-h-screen font-sans">
  <div class="flex min-h-screen">

    <aside class="bg-gradient-to-b from-teal-700 to-teal-900 w-64 flex flex-col shadow-xl">
      <div class="px-4 py-6 flex flex-col items-center gap-2">
        <img src="../../img/carikerja.png" alt="Logo" class="w-48 object-contain" />
      </div>
      <nav class="flex-1 flex flex-col gap-1 px-2 mt-4">
        <a href="../dashboard/dashboard.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition text-white bg-teal-900">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 21V10" />
            <path d="M9 21V3" />
            <path d="M15 21v-6" />
            <path d="M20 21v-4" />
          </svg>
          <span>Dashboard</span>
        </a>
        <a href="../pelamar/pelamar.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition text-teal-100 hover:bg-teal-900 hover:text-white">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4" />
            <path d="M6 21v-2a6 6 0 1112 0v2" />
          </svg>
          <span>User</span>
        </a>
        <a href="../perusahaan/perusahaan.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition text-teal-100 hover:bg-teal-900 hover:text-white">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M9 8h6m-6 4h6m-6 4h6M4 21V4a1 1 0 011-1h6a1 1 0 011 1v17m6 0V8a1 1 0 011-1h2a1 1 0 011 1v13" />
          </svg>
          <span>Perusahaan</span>
        </a>
        <a href="../transaksi/riwayat_transaksi.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition text-teal-100 hover:bg-teal-900 hover:text-white">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6M9 11h6M9 15h4M4 3h16v18l-2-2-2 2-2-2-2 2-2-2-2 2-2-2-2 2V3z" />
          </svg>
          <span>Riwayat Transaksi</span>
        </a>
        <a href="../lowongan_kerja/lowongan_kerja.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition text-teal-100 hover:bg-teal-900 hover:text-white">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V7l-6-6H7a2 2 0 00-2 2v16a2 2 0 002 2z" /><circle cx="15" cy="15" r="3" />
            <path d="M18 18l3 3" />
          </svg>
          <span>Lowongan Kerja</span>
        </a>
        <a href="../tips_kerja/tips_kerja_artikel.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition text-teal-100 hover:bg-teal-900 hover:text-white">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" />
            <path d="M16 2v4M8 2v4M3 10h18" />
          </svg>
          <span>Artikel & Tips</span>
        </a>
        <a href="../logout.php" onclick="return confirm('Yakin mau logout?')" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition text-teal-100 hover:bg-red-700 hover:text-white mt-auto">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 16l4-4m0 0l-4-4m4 4H7" /> <rect x="3" y="4" width="4" height="16" rx="2" />
          </svg>
          <span>Logout</span>
        </a>
      </nav>
    </aside>

<div class="flex-1 flex flex-col bg-white min-h-screen">
  <header class="bg-teal-800 flex items-center justify-between px-12 py-4 text-white shadow">
    <h2 class="text-2xl font-bold tracking-wide">Daftar Lowongan</h2>
    <div class="flex items-center gap-3">
      <span class="text-lg font-medium"><?= htmlspecialchars($_SESSION['nama_admin'] ?? 'Admin'); ?></span>
      <img src="../../img/beauty.png" alt="Admin" class="w-10 h-10 rounded-full border-2 border-white shadow-md">
    </div>
  </header>

  <footer class="bg-gray-100 text-center py-4 text-sm text-gray-600 border-t">
        <p>&copy; <?= date("Y"); ?> CariKerjaID. All rights reserved.</p>
      </footer>
    </div>
  </div>
</body>
</html>
