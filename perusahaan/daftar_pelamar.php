<?php

$koneksi = new mysqli("localhost", "root", "", "lowongan_kerja");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

$q = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : "";

if ($q === "") {
    $sql = "SELECT * FROM pelamar_kerja";
} else {
    $sql = "SELECT * FROM pelamar_kerja WHERE LOWER(posisi) LIKE '%$q%'";
}

$result = $koneksi->query($sql);

$pelamar = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $pelamar[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelamar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="w-64 bg-[#00797a] text-white p-6 flex flex-col">
        <div class="flex flex-col items-center mb-10">
            <div class="w-20 h-20 bg-white rounded-full mb-3"></div>
            <h1 class="text-lg font-bold">Perusahaan</h1>
        </div>

        <nav class="flex flex-col space-y-3">
    <!-- Dashboard -->
    <a href="../dashboard/dashboard_perusahaan.php" 
       class="px-4 py-2 rounded-lg bg-white text-[#00646A] hover:bg-[#00949A] hover:text-white flex items-center">
         <span class="ml-2">Dashboard</span>
    </a>

    <!-- Daftar Pelamar -->
    <a href="daftar_pelamar.php" 
       class="px-4 py-2 rounded-lg bg-white text-[#00646A] hover:bg-[#00949A] hover:text-white flex items-center">
         <span class="ml-2">Daftar Pelamar</span>
    </a>

    <!-- Pasang Lowongan -->
    <a href="../perusahaan/form_pasang_lowongan.php" 
       class="px-4 py-2 rounded-lg bg-white text-[#00646A] hover:bg-[#00949A] hover:text-white flex items-center">
         <span class="ml-2">Pasang Lowongan</span>
    </a>
</nav>


        <div class="mt-auto pt-6 text-center text-sm opacity-75">
            © 2025 Carikerja.id
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 p-8">
        <h2 class="text-2xl font-bold text-[#00646A] mb-6">Daftar Pelamar</h2>

        <!-- Search -->
        <form method="GET" class="flex justify-start mb-6 w-full sm:w-1/3">
            <div class="flex w-full shadow rounded-lg overflow-hidden">
                <input 
                    type="text" 
                    name="q" 
                    value="<?= htmlspecialchars($q) ?>" 
                    placeholder="Cari posisi..." 
                    class="px-3 py-2 w-full focus:outline-none"
                >
                <button 
                    type="submit" 
                    class="bg-[#00646A] text-white px-4 hover:bg-[#004F52]"
                >
                    🔍
                </button>
            </div>
        </form>

        <!-- Table -->
        <div class="bg-white rounded-lg shadow overflow-x-auto">
            <table class="w-full border-collapse min-w-[800px]">
                <thead class="bg-[#00949A] text-white">
                    <tr>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Email</th>
                        <th class="p-3 text-left">Posisi</th>
                        <th class="p-3 text-left">No HP</th>
                        <th class="p-3 text-left">CV</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (count($pelamar) > 0): ?>
                        <?php foreach ($pelamar as $p): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3"><?= htmlspecialchars($p['nama_lengkap']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($p['email']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($p['posisi']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($p['no_hp']) ?></td>
                                <td class="p-3 text-center">
                                    <?php if (!empty($p['cv'])): ?>
                                        <a href="../uploads/<?= htmlspecialchars($p['cv']) ?>" 
                                           target="_blank" 
                                           class="text-blue-600 hover:underline">
                                           Lihat CV
                                        </a>
                                    <?php else: ?>
                                        <span class="text-gray-500">Tidak ada CV</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="5" class="text-center p-4 text-gray-500">Tidak ada data pelamar</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </main>
</div>

</body>
</html>
