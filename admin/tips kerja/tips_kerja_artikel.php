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
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-teal-800 w-64 flex flex-col min-h-screen shadow-lg relative" style="border-right:1px solid #79797aff;">
            <div class="px-4 py-6 flex flex-col items-center gap-2">
                <img src="../../img/logo2.png" alt="Logo" class="w-60 h-18 object-contain mb-0" />
            </div>
            <nav class="flex-1 flex flex-col gap-1 px-2 py-2">
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all mb-1
                    <?php echo $menuAktif['dashboard'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>">
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all
                    <?php echo $menuAktif['lowongan'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>">
                    <span>Lowongan Kerja</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all
                    <?php echo $menuAktif['perusahaan'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>">
                    <span>Perusahaan</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all
                    <?php echo $menuAktif['pelamar'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>">
                    <span>Pelamar</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all
                    <?php echo $menuAktif['artikel'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>">
                    <span>Artikel & Tips</span>
                </a>
                <!-- Logout -->
                <a href="../logout.php" 
                   class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all mt-auto
                   <?php echo $menuAktif['logout'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>"
                   onclick="return confirm('Yakin mau logout?')">
                    <span>Logout</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div id="main-content" class="flex-1 flex flex-col bg-white min-h-screen" style="border-left:1px solid #0b5f39ff;">
            <header class="bg-teal-800 flex items-center justify-between px-12 py-4 relative" style="border-bottom:1px solid #ffffff;">
                <div class="text-xl font-medium ml-10 text-white">Info, Tips & Artikel</div>
                <div class="flex items-center gap-3 text-white">
                    <span class="text-lg font-medium"><?= htmlspecialchars($_SESSION['nama_admin'] ?? 'Admin'); ?></span>
                    <img src="../../img/beauty.png" alt="Admin" class="w-10 h-10 rounded-full border border-white shadow">
                </div>
            </header>

            <div class="flex-1 p-8 bg-gray-100">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-gray-700">Daftar Artikel & Tips</h2>
                    <a href="tambah_artikel.php" 
                       class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg font-semibold text-base shadow-md transition-all duration-200">
                       + Tambah Artikel
                    </a>
                </div>

                <!-- Form Cari -->
                <form method="get" class="flex items-center gap-3 mb-6">
                    <div class="relative w-72">
                        <input type="text" name="search" value="<?= htmlspecialchars($keyword) ?>"
                            class="bg-white border border-gray-300 rounded-lg pl-10 pr-4 py-2 w-full focus:ring-2 focus:ring-teal-500 focus:outline-none shadow-sm"
                            placeholder="Cari artikel...">
                    </div>
                    <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg">Cari</button>
                </form>

                <!-- Tabel Artikel -->
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
                                                <img src="../../uploads/<?= htmlspecialchars($row['gambar']); ?>" 
                                                     alt="Gambar Artikel" 
                                                     class="w-16 h-16 object-cover rounded-lg border">
                                            <?php else: ?>
                                                <span class="text-gray-400 italic">Tidak ada</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-4 py-3"><?= htmlspecialchars($row['judul']); ?></td>
                                        <td class="px-4 py-3"><?= date('d-m-Y', strtotime($row['tanggal'])); ?></td>
                                        <td class="px-4 py-3">
                                            <a href="lihat_artikel.php?id=<?= $row['id']; ?>" 
                                               class="bg-teal-600 hover:bg-teal-700 text-white px-3 py-1 rounded-lg text-sm">Lihat</a>
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <a href="edit_artikel.php?id=<?= $row['id'] ?>" 
                                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm">Edit</a>
                                        </td>
                                        <td class="px-4 py-2 text-center">
                                            <a href="hapus_artikel.php?id=<?= $row['id'] ?>" 
                                               onclick="return confirm('Yakin ingin menghapus artikel ini?')"
                                               class="bg-red-600 hover:bg-red-700 text-white px-3 py-1 rounded-md text-sm">Hapus</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7" class="px-4 py-6 text-center text-gray-500 italic">
                                        Artikel tidak ditemukan.
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <footer class="bg-teal-800 px-12 py-4 text-center text-white" style="border-top:1px solid #e5e7eb;">
                &copy; <?= date('Y') ?> CariKerja.ID - All rights reserved.
            </footer>
        </div>
    </div>
</body>
</html>
