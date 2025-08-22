<?php
session_start();
include '../function/logic.php';
if(!isset($_SESSION["login"])){
    header("Location: tampilan awal.php");
    exit;
}
$tipsList = getTipsKerjaList();
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
        <!-- Sidebar -->
        <aside class="bg-teal-800 w-72 flex flex-col">
            <div class="bg-gray-300 text-center py-10 text-xl font-semibold">Logo</div>
            <nav class="flex-1 flex flex-col gap-4 px-6 py-8">
                <a href="#" class="bg-gray-300 rounded px-4 py-2 text-left font-medium">Dashboard</a>
                <a href="#" class="bg-gray-300 rounded px-4 py-2 text-left font-medium">Daftar Lowongan</a>
                <a href="#" class="bg-gray-300 rounded px-4 py-2 text-left font-medium">Daftar Perusahaan</a>
                <a href="#" class="bg-gray-300 rounded px-4 py-2 text-left font-medium">Daftar User</a>
                <a href="#" class="bg-white rounded px-4 py-2 text-left font-medium">Info, Tips, & Artikel</a>
            </nav>
        </aside>
        <!-- Main Content -->
        <main class="flex-1 flex flex-col bg-white">
            <!-- Header -->
            <header class="bg-teal-800 flex items-center justify-between px-12 py-4">
                <div class="text-xl font-medium text-black">Info, Tips & Artikel</div>
                <div class="text-lg font-medium text-black">Admin</div>
            </header>
            <!-- Content -->
            <div class="flex-1 p-8 bg-gray-100">
                <div class="flex items-center gap-4 mb-4">
                    <button class="bg-gray-400 text-white px-6 py-2 rounded-full font-semibold text-lg shadow" type="button">+ Tambah Artikel</button>
                    <input type="text" class="bg-white border rounded px-4 py-2 w-64" placeholder="Cari artikel...">
                    <button class="bg-gray-200 px-3 py-2 rounded"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" fill="none"/><line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></button>
                    <button class="bg-gray-200 px-3 py-2 rounded"><svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path d="M3 6h18M6 10h12M9 14h6" stroke="currentColor" stroke-width="2" stroke-linecap="round"/></svg></button>
                </div>
                <div class="bg-gray-300 rounded-xl p-4 overflow-x-auto">
                    <table class="w-full text-center">
                        <thead>
                            <tr>
                                <th class="font-bold text-base py-2">No</th>
                                <th class="font-bold text-base py-2">Judul Artikel</th>
                                <th class="font-bold text-base py-2">Tanggal Posting</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($tipsList) > 0): ?>
                                <?php foreach ($tipsList as $i => $row): ?>
                                    <tr class="border-t border-gray-400">
                                        <td class="py-2"><?php echo $i+1; ?>.</td>
                                        <td class="py-2 text-left"><?php echo htmlspecialchars($row['judul']); ?></td>
                                        <td class="py-2"><?php echo date('j F Y', strtotime($row['tanggal'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" class="py-4 text-gray-600">Belum ada artikel.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>
