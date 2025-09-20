<?php
session_start();
include '../../function/logic.php';

$menuAktif = menu_aktif('artikel');
$keyword = $_GET['search'] ?? '';

$tipsList = []; 
if ($keyword) {
    $tipsList = searchArtikel($keyword);
} else {
    $tipsList = getArtikelList();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Tips Kerja Artikel</title>
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
          <?= $menuAktif['riwayat transaksi'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
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

    <div class="flex-1 flex flex-col bg-white min-h-screen">
      <header class="bg-teal-800 flex items-center justify-between px-12 py-4 text-white shadow">
        <h2 class="text-2xl font-bold tracking-wide">Artikel Tips kerja</h2>
        <div class="flex items-center gap-4">
          <span class="text-lg font-medium"><?= htmlspecialchars($_SESSION['nama_admin'] ?? 'Admin'); ?></span>
          <img src="../../img/beauty.png" alt="Admin" class="w-10 h-10 rounded-full border-2 border-white shadow-md">
        </div>
      </header>

      <div class="flex-1 p-8 bg-gray-100">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-2xl font-bold text-gray-700">Daftar Artikel & Tips</h2>
          <a href="tambah_artikel.php" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold text-base shadow-md transition-all duration-200">+ Tambah Artikel</a>
        </div>

        <form method="get" class="flex items-center gap-3 mb-6">
          <div class="relative w-72">
            <input type="text" name="search" value="<?= htmlspecialchars($keyword) ?>" class="bg-white border border-gray-300 rounded-lg pl-10 pr-4 py-2 w-full focus:ring-2 focus:ring-teal-500 focus:outline-none shadow-sm" placeholder="Cari artikel...">
          </div>
          <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg">Cari</button>
        </form>

        <div class="bg-white rounded-xl shadow-md overflow-hidden">
          <table class="w-full text-left border-collapse">
            <thead class="bg-teal-600 text-white">
              <tr>
                <th class="px-4 py-3">No</th>
                <th class="px-4 py-3">Foto</th>
                <th class="px-4 py-3">Judul Artikel</th>
                <th class="px-4 py-3">Tanggal Posting</th>
                <th class="px-4 py-3">Aksi</th>
                <th class="px-4 py-3">Edit</th>
                <th class="px-4 py-3">Hapus</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php if (count($tipsList) > 0): ?>
                <?php foreach ($tipsList as $i => $row): ?>
                  <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3"><?= $i+1 ?>.</td>
                    <td class="px-4 py-3">
                      <?php if (!empty($row['gambar'])): ?>
                        <img src="../../uploads/<?= htmlspecialchars($row['gambar']); ?>" alt="Gambar Artikel" class="w-16 h-16 object-cover rounded-lg border">
                      <?php else: ?>
                        <span class="text-gray-400 italic">Tidak ada</span>
                      <?php endif; ?>
                    </td>
                    <td class="px-4 py-3"><?= htmlspecialchars($row['judul']); ?></td>
                    <td class="px-4 py-3"><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                    <td class="px-4 py-3">
                      <a href="lihat_artikel.php?id=<?= $row['id']; ?>" class="bg-teal-600 hover:bg-teal-700 text-white px-3 py-1 rounded-lg text-sm">Lihat</a>
                    </td>
                    <td class="px-4 py-2 text-center">
                      <a href="edit_artikel.php?id=<?= $row['id'] ?>" class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm">Edit</a>
                    </td>
                    <td class="px-4 py-2 text-center">
                      <a href="hapus_artikel.php?id=<?= $row['id'] ?>" onclick="return confirm('Yakin ingin menghapus artikel ini?')" class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm">Hapus</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="7" class="px-4 py-6 text-center text-gray-500 italic">Artikel tidak ditemukan.</td>
                </tr>
              <?php endif; ?>
            </tbody>
          </table>
        </div>
      </div>

      <footer class="bg-gray-100 text-center py-4 text-sm text-gray-600 border-t">
        <p>&copy; <?= date("Y"); ?> CariKerjaID. All rights reserved.</p>
      </footer>
    </div>
  </div>
</body>
</html>