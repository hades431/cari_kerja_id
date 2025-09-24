<?php
session_start();
include '../../function/logic.php';

$menuAktif = menu_aktif('lowongan');
$keyword = $_GET['search'] ?? '';
$lowongan = getLowonganList($keyword);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Lowongan Kerja</title>
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

        <a href="../logout.php" onclick="return confirm('Yakin mau logout?')" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['logout'] ? 'bg-red-700 text-white' : 'text-teal-100 hover:bg-red-700 hover:text-white' ?> mt-auto">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 16l4-4m0 0l-4-4m4 4H7" />
            <rect x="3" y="4" width="4" height="16" rx="2" />
          </svg>
          <span>Logout</span>
        </a>
      </nav>
    </aside>

    <div class="flex-1 flex flex-col bg-gray-100 min-h-screen">
      <header class="bg-teal-800 flex items-center justify-between px-12 py-4 text-white shadow">
        <h2 class="text-2xl font-bold tracking-wide">Daftar Lowongan</h2>
        <div class="flex items-center gap-3">
          <span class="text-lg font-medium"><?= htmlspecialchars($_SESSION['nama_admin'] ?? 'Admin'); ?></span>
          <img src="../../img/beauty.png" alt="Admin" class="w-10 h-10 rounded-full border-2 border-white shadow-md">
        </div>
      </header>

      <div class="p-6 mt-6">

        <form method="GET" class="mb-4 flex gap-2">
          <input 
            type="text" 
            name="search" 
            placeholder="Cari perusahaan..." 
            value="<?= htmlspecialchars($keyword) ?>" 
            class="px-4 py-2 w-1/3 rounded-lg border border-gray-300 
                  focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:outline-none"
          />

          <button class="px-4 py-2 bg-teal-700 text-white rounded-lg hover:bg-teal-800">
            Cari
          </button>
        </form>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
          <table class="min-w-full">
            <thead class="bg-gradient-to-r from-teal-600 to-teal-800 text-white">
              <tr>
                <th class="px-6 py-4 text-left">No</th>
                <th class="px-6 py-4 text-left">Nama Perusahaan</th>
                <th class="px-6 py-4 text-left">Lokasi</th>
                <th class="px-6 py-4 text-left">Posisi</th>
                <th class="px-6 py-4 text-left">Tanggal Posting</th>
                <th class="px-6 py-4 text-left">Batas Tanggal</th>
                <th class="px-6 py-4 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($lowongan)) : ?>
                <tr>
                  <td colspan="7" class="py-10 text-center text-gray-500 italic">
                    Belum ada lowongan yang tersedia.
                  </td>
                </tr>
              <?php else: ?>
                <?php foreach ($lowongan as $i => $row) : ?>
                  <tr class="border-b last:border-0 hover:bg-gray-50">
                    <td class="px-6 py-4"><?= $i + 1 ?></td>
                    <td class="px-6 py-4 font-medium text-gray-800"><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($row['lokasi']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($row['judul']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($row['tanggal_post']) ?></td>
                    <td class="px-6 py-4"><?= htmlspecialchars($row['batas_lamaran']) ?></td>
                    <td class="px-6 py-4 text-center">
                      <a href="detail_lowongan.php?id=<?= $row['id_lowongan'] ?>"
                         class="inline-block px-3 py-1 bg-green-500 text-white rounded-md text-sm hover:bg-green-600">
                        Detail
                      </a>
                      <a href="hapus_lowongan.php?id=<?= $row['id_lowongan'] ?>"
                         onclick="return confirm('Yakin hapus lowongan ini?')"
                         class="inline-block ml-2 px-3 py-1 bg-red-500 text-white rounded-md text-sm hover:bg-red-600">
                        Hapus
                      </a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
