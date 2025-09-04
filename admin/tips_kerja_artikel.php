<?php
session_start();
include '../function/logic.php';


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
    <title>tips kerja artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#222] min-h-screen">
    <div class="flex min-h-screen">
        <aside id="sidebar" class="bg-teal-800 w-64 flex flex-col min-h-screen shadow-lg relative" style="border-right:1px solid #79797aff;">
            <div class="px-4 py-6 flex flex-col items-center gap-2">
                <img src="../img/logo2.png" alt="Logo" class="w-60 h-18 object-contain mb-0" />
                <div class="text-white text-xl font-bold tracking-wide mb-0 mt-2 flex flex-col items-center"></div>
            </div>
            <nav class="flex-1 flex flex-col gap-1 px-2 py-2">
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all mb-1
                    <?php echo $menuAktif['dashboard'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8v-10h-8v10zm0-18v6h8V3h-8z" stroke="currentColor"/></svg>
                    <span>Dashboard</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all
                    <?php echo $menuAktif['lowongan'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2" /><circle cx="9" cy="7" r="4" /><path d="M23 21v-2a4 4 0 00-3-3.87" /><path d="M16 3.13a4 4 0 010 7.75" /></svg>
                    <span>Lowongan Kerja</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all
                    <?php echo $menuAktif['perusahaan'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 21v-4a4 4 0 014-4h10a4 4 0 014 4v4" /><circle cx="12" cy="7" r="4" /></svg>
                    <span>Perusahaan</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all
                    <?php echo $menuAktif['pelamar'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><circle cx="12" cy="7" r="4" /><path d="M5.5 21v-2a4.5 4.5 0 019 0v2" /></svg>
                    <span>Pelamar</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all
                    <?php echo $menuAktif['artikel'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2" /><path d="M16 2v4M8 2v4M3 10h18" /></svg>
                    <span>Artikel & Tips</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all mt-auto
                    <?php echo $menuAktif['logout'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 16l4-4m0 0l-4-4m4 4H7" /><rect x="3" y="4" width="4" height="16" rx="2" /></svg>
                    <span>Logout</span>
                </a>
            </nav>
        </aside>
        <div id="main-content" class="flex-1 flex flex-col bg-white min-h-screen" style="border-left:1px solid #0b5f39ff;">
            <header class="bg-teal-800 flex items-center justify-between px-12 py-4 rounded-tr-none relative" style="border-bottom:1px solid #ffffffff;">
                <div class="text-xl font-medium ml-10 text-white">Info, Tips & Artikel</div>
                <div class="flex items-center gap-3 text-white">
                    <span class="text-lg font-medium"> <?= htmlspecialchars($_SESSION['nama_admin'] ?? 'Admin'); ?></span>
                    <img src="../img/beauty.png" alt="Admin" class="w-10 h-10 rounded-full border border-white shadow">
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
                <form method="get" class="flex items-center gap-3 mb-6">
                    <div class="relative w-72">
                        <input type="text" name="search" value="<?= htmlspecialchars($keyword) ?>"
                            class="bg-white border border-gray-300 rounded-lg pl-10 pr-4 py-2 w-full focus:ring-2 focus:ring-teal-500 focus:outline-none shadow-sm"
                            placeholder="Cari artikel...">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-3 top-2.5 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2"/>
                            <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg">Cari</button>
                </form>
                <div class="bg-white rounded-xl shadow-md overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead class="bg-teal-600 text-white">
            <tr>
                <th class="font-semibold text-sm px-4 py-3">No</th>
                <th class="font-semibold text-sm px-4 py-3">Foto</th>
                <th class="font-semibold text-sm px-4 py-3">Judul Artikel</th>
                <th class="font-semibold text-sm px-4 py-3">Tanggal Posting</th>
                <th class="font-semibold text-sm px-4 py-3">Aksi</th>
                <th class="font-semibold text-sm px-4 py-3">Edit</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            <?php if (count($tipsList) > 0): ?>
                <?php foreach ($tipsList as $i => $row): ?>
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-4 py-3 text-gray-700"><?= $i+1 ?>.</td>
                        <td class="px-4 py-3">
                            <?php if (!empty($row['gambar'])): ?>
                                <img src="../uploads/<?= htmlspecialchars($row['gambar']); ?>" 
                                     alt="Gambar Artikel" 
                                     class="w-16 h-16 object-cover rounded-lg border">
                            <?php else: ?>
                                <span class="text-gray-400 italic">Tidak ada</span>
                            <?php endif; ?>
                        </td>
                        <td class="px-4 py-3 text-gray-800 font-medium">
                            <?= htmlspecialchars($row['judul']); ?>
                        </td>
                        <td class="px-4 py-3 text-gray-600">
                            <?= date('j F Y', strtotime($row['tanggal'])); ?>
                        </td>
                        <td class="px-4 py-3">
                            <a href="detail_artikel.php?id=<?= $row['id']; ?>" 
                               class="bg-teal-600 hover:bg-teal-700 text-white px-3 py-1 rounded-lg text-sm shadow">
                               Lihat Artikel
                            </a>
                        </td>
                        <td class="px-4 py-2 text-center">
                            <a href="edit_artikel.php?id=<?= $row['id'] ?>" 
                                class="bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded-md text-sm ml-2">Edit</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5" class="px-4 py-6 text-center text-gray-500 italic">
                        Artikel tidak ditemukan.
                    </td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

            </div>
            <footer class="bg-teal-800 flex items-center justify-between px-12 py-4 rounded-tr-none" style="border-top:1px solid #e5e7eb;">
                <div class="text-sm text-center w-full text-white">&copy; <?= date('Y') ?> CariKerja.ID - All rights reserved.</div>
            </footer>
        </div>
    </div>
</body>
</html>
