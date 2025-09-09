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
   <div id="sidebar" class="bg-[#00888a] text-white flex flex-col items-center py-10 px-0 shadow-lg w-64 min-h-screen relative">
        <div class="flex flex-col items-center w-full flex-1">
            <div class="bg-white rounded-full w-24 h-24 flex items-center justify-center mb-4 border-4 border-white/30 shadow-lg">
                <img src="../img/barber.jpg" alt="Logo Perusahaan" title="Logo Perusahaan" class="w-20 h-20 rounded-full object-cover">
            </div>
            <div class="text-lg font-bold text-white mb-8 text-center">Perusahaan</div>
            <div class="flex flex-col gap-4 w-full px-6">
                <a href="../dashboard/dashboard_perusahaan.php" class="w-full py-3 rounded-lg bg-white text-[#00888a] font-semibold text-left pl-6 hover:bg-[#009fa3] hover:text-white transition">Dashboard</a>
                <a href="../perusahaan/daftar_pelamar.php" class="w-full py-3 rounded-lg bg-white text-[#00888a] font-semibold text-left pl-6 hover:bg-[#009fa3] hover:text-white transition">Daftar Pelamar</a>
                <a href="../perusahaan/form_pasang_lowongan.php" class="w-full py-3 rounded-lg bg-white text-[#00888a] font-semibold text-left pl-6 hover:bg-[#009fa3] hover:text-white transition">Pasang Lowongan</a>
            </div>
        </div>  
        <div class="absolute bottom-6 left-0 w-full px-6 text-base text-white/70 text-center font-semibold">© 2025 Carikerja.id</div>
    </div>



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
