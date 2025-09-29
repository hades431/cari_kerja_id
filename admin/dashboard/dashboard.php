<?php
session_start();
include '../../function/logic.php';
$menuAktif = menu_aktif('dashboard');

$jumlahLoker      = getJumlahLoker();
$jumlahPerusahaan = getJumlahPerusahaan();
$jumlahUser       = getJumlahUser();
$jumlahArtikel    = getJumlahArtikel();

$aktivitas   = getAktivitasTerbaru();
$statistik   = getStatistikBulanan();
$perusahaan  = getPerusahaanBaru();
$artikel     = getArtikelTerbaru();
$notifikasi  = getNotifikasi();
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
    <aside class="bg-gradient-to-b from-teal-700 to-teal-900 w-64 flex flex-col shadow-xl">
      <div class="px-4 py-6 flex flex-col items-center gap-2">
        <img src="../../img/carikerja.png" alt="Logo" class="w-40 object-contain" />
      </div>
      <nav class="flex-1 flex flex-col gap-1 px-2 mt-4">
        <a href="../dashboard/dashboard.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['dashboard'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 21V10" />
            <path d="M9 21V3" />
            <path d="M15 21v-6" />
            <path d="M20 21v-4" />
          </svg>
          <span>Dashboard</span>
        </a>

        <a href="../pelamar/pelamar.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['pelamar'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="7" r="4" />
            <path d="M6 21v-2a6 6 0 1112 0v2" />
          </svg> 
          <span>User</span>
        </a>

        <a href="../perusahaan/perusahaan.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['perusahaan'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M9 8h6m-6 4h6m-6 4h6M4 21V4a1 1 0 011-1h6a1 1 0 011 1v17m6 0V8a1 1 0 011-1h2a1 1 0 011 1v13" />
          </svg>
          <span>Perusahaan</span>
        </a>  

        <a href="../transaksi/riwayat_transaksi.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['transaksi'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6M9 11h6M9 15h4M4 3h16v18l-2-2-2 2-2-2-2 2-2-2-2 2-2-2-2 2V3z" />
          </svg>
          <span>Riwayat Transaksi</span>
        </a>

        <a href="../lowongan_kerja/lowongan_kerja.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['lowongan'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V7l-6-6H7a2 2 0 00-2 2v16a2 2 0 002 2z" />
            <circle cx="15" cy="15" r="3" />
            <path d="M18 18l3 3" />
          </svg>
          <span>Lowongan Kerja</span>
        </a>

        <a href="../tips_kerja/tips_kerja_artikel.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['artikel'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="4" width="18" height="18" rx="2" />
            <path d="M16 2v4M8 2v4M3 10h18" />
          </svg>
          <span>Artikel & Tips</span>
        </a>

        <a href="../../public/logout.php" onclick="return confirm('Yakin mau logout?')" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['logout'] ? 'bg-red-700 text-white' : 'text-teal-100 hover:bg-red-700 hover:text-white' ?> mt-auto">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 16l4-4m0 0l-4-4m4 4H7" />
            <rect x="3" y="4" width="4" height="16" rx="2" />
          </svg>
          <span>Logout</span>
        </a>
      </nav>
    </aside>

    <div class="flex-1 flex flex-col bg-white min-h-screen">
      <header class="bg-teal-800 flex items-center justify-between px-12 py-4 text-white shadow">
        <h2 class="text-2xl font-bold tracking-wide">Dashboard Admin</h2>
      </header>

      <main class="p-8 flex-1 space-y-10">

        <h3 class="text-xl font-bold mb-6 text-gray-700">Statistik Ringkasan</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-white shadow-lg rounded-2xl flex flex-col items-center justify-center p-6 hover:shadow-xl hover:-translate-y-1 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-3 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V7l-6-6H7a2 2 0 00-2 2v16a2 2 0 002 2z" />
            <circle cx="15" cy="15" r="3" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18l3 3" />
          </svg>
            <p class="text-3xl font-bold text-teal-700"><?= $jumlahLoker ?></p>
            <p class="text-gray-600 mt-1">Lowongan Tersedia</p>
          </div>

          <div class="bg-white shadow-lg rounded-2xl flex flex-col items-center justify-center p-6 hover:shadow-xl hover:-translate-y-1 transition">
            <svg class="w-12 h-12 mb-3 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M9 8h6m-6 4h6m-6 4h6M4 21V4a1 1 0 011-1h6a1 1 0 011 1v17m6 0V8a1 1 0 011-1h2a1 1 0 011 1v13" />
            </svg>
            <p class="text-3xl font-bold text-teal-700"><?= $jumlahPerusahaan ?></p>
            <p class="text-gray-600 mt-1">Perusahaan Terdaftar</p>
          </div>

          <div class="bg-white shadow-lg rounded-2xl flex flex-col items-center justify-center p-6 hover:shadow-xl hover:-translate-y-1 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-3 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 20v-2a6 6 0 1112 0v2" />
            </svg>
            <p class="text-3xl font-bold text-teal-700"><?= $jumlahUser ?></p>
            <p class="text-gray-600 mt-1">User</p>
          </div>


          <div class="bg-white shadow-lg rounded-2xl flex flex-col items-center justify-center p-6 hover:shadow-xl hover:-translate-y-1 transition">
            <svg class="w-12 h-12 mb-3 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <rect x="3" y="4" width="18" height="18" rx="2" />
              <path d="M16 2v4M8 2v4M3 10h18" />
            </svg>
            <p class="text-3xl font-bold text-teal-700"><?= $jumlahArtikel ?></p>
            <p class="text-gray-600 mt-1">Artikel & Tips</p>
          </div>
        </div>

        <div class="bg-white shadow rounded-2xl p-5">
          <h2 class="font-semibold text-lg mb-3">Statistik Bulanan</h2>
          <div class="space-y-4">
            <div>
              <p class="text-sm font-medium">User</p>
              <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-teal-600 h-2.5 rounded-full" style="width: <?= $statistik['user'] ?>%"></div>
              </div>
              <p class="text-xs text-gray-500 mt-1"><?= $statistik['user'] ?> user bulan ini</p>
            </div>

            <div>
              <p class="text-sm font-medium">Lowongan</p>
              <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: <?= $statistik['lowongan'] ?>%"></div>
              </div>
              <p class="text-xs text-gray-500 mt-1"><?= $statistik['lowongan'] ?> lowongan bulan ini</p>
            </div>
          </div>
        </div>

        <div class="bg-white shadow rounded-2xl p-5">
          <h2 class="font-semibold text-lg mb-3">Notifikasi</h2>
          <div class="space-y-3">
            <?php if (!empty($notifikasi)): ?>
              <?php foreach ($notifikasi as $n): ?>
                <div class="p-4 bg-gray-50 rounded-xl shadow-sm flex justify-between items-center text-sm text-gray-700">
                  <span><?= $n['icon'] ?> <?= $n['pesan'] ?></span>
                  <a href="<?= $n['link'] ?>" class="text-xs text-blue-600 hover:underline"><?= $n['aksi'] ?></a>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <p class="text-sm text-gray-500">Tidak ada notifikasi</p>
            <?php endif; ?>
          </div>
        </div>

        <div class="bg-white shadow rounded-2xl p-5">
          <h2 class="font-semibold text-lg mb-3">Aktivitas Terbaru</h2>
          <div class="space-y-3">
            <?php foreach($aktivitas as $a): ?>
              <div class="p-4 bg-gray-50 rounded-xl shadow-sm text-sm text-gray-700">
                <?= $a['icon'] ?> <?= $a['pesan'] ?> - <span class="text-xs text-gray-400"><?= date("d/m/Y", strtotime($a['tanggal'])) ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="bg-white shadow rounded-2xl p-5">
          <h2 class="font-semibold text-lg mb-3">Perusahaan Baru</h2>
          <div class="space-y-3">
            <?php foreach($perusahaan as $p): ?>
              <div class="p-4 bg-gray-50 rounded-xl shadow-sm text-sm text-gray-700">
                🏢 <?= $p['nama_perusahaan'] ?> - <?= date("d/m/Y", strtotime($p['created_at'])) ?>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="bg-white shadow rounded-2xl p-5">
          <h2 class="font-semibold text-lg mb-3">Artikel & Tips Terbaru</h2>
          <div class="space-y-3">
            <?php foreach($artikel as $art): ?>
              <div class="p-4 bg-gray-50 rounded-xl shadow-sm flex justify-between items-center text-sm text-gray-700">
                <span>📄 <a href="../../admin/tips_kerja/lihat_artikel.php?= $art['id'] ?>" class="text-blue-600 hover:underline"><?= $art['judul'] ?></a></span>
                <span class="text-gray-400 text-xs"><?= date("d/m/Y", strtotime($art['created_at'])) ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

      </main>

      <footer class="bg-gray-100 text-center py-4 text-sm text-gray-600 border-t">
        <p>&copy; <?= date("Y"); ?> CariKerjaID. All rights reserved.</p>
      </footer>
    </div>
  </div>
</body>
</html>