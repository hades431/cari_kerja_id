<?php
session_start();
include '../header.php';

$koneksi = new mysqli("localhost", "root", "", "lowongan_kerja");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil data profil perusahaan untuk sidebar
$email_user = $_SESSION['email'];
$id_perusahaan = tampil("SELECT*FROM perusahaan where id_user = $user_id")[0]['id_perusahaan'] ?? 0;
$logo_perusahaan = tampil("SELECT*FROM perusahaan WHERE id_perusahaan = $id_perusahaan")[0]["logo"];
$nama_perusahaan = 'Perusahaan';


$res_perusahaan = $koneksi->query("SELECT id_perusahaan, logo, nama_perusahaan FROM perusahaan WHERE email_perusahaan = '$email_user' LIMIT 1");
if ($res_perusahaan && $row = $res_perusahaan->fetch_assoc()) {
    $id_perusahaan = $row['id_perusahaan'];
    if (!empty($row['logo'])) {
        $logo_perusahaan = (strpos($row['logo'], 'uploads/') === 0) ? '../'.$row['logo'] : $row['logo'];
    }
    $nama_perusahaan = $row['nama_perusahaan'];
}

$q = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : "";

// Ambil pelamar yang melamar ke perusahaan ini saja
$pelamar_perusahaan = [];
$res_pelamar_kerja = $koneksi->query("
    SELECT p.*, u.username, u.email, u.role, l.id_perusahaan 
    FROM pelamar_kerja p
    JOIN user u ON p.id_user = u.id_user
    JOIN lowongan l ON p.id_pelamar = l.id_lowongan
    WHERE l.id_perusahaan = $id_perusahaan
    ORDER BY p.no_hp DESC
");
if ($res_pelamar_kerja) {
    while ($row = $res_pelamar_kerja->fetch_assoc()) {
        $pelamar_perusahaan[] = $row;
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
 <aside class="w-64 bg-[#00646A] text-white flex flex-col justify-between min-h-screen">
    <div>
        <div class="flex flex-col items-center py-6">
            <a href="../perusahaan/profile_perusahaan.php?id=<?= htmlspecialchars($id_perusahaan) ?>" class="w-20 h-20 rounded-full overflow-hidden border-2 border-white shadow-lg flex items-center justify-center">
                <img src="<?= htmlspecialchars($logo_perusahaan) ?>" alt="Logo Perusahaan" class="w-20 h-20 object-cover">
            </a>
            <h2 class="mt-3 text-lg font-semibold text-center"><?= htmlspecialchars($nama_perusahaan) ?></h2>
        </div>

        <!-- Menu -->
        <nav class="mt-6 space-y-2 px-4">
            <a href="dashboard_perusahaan.php" class="block py-2 px-4 rounded-lg hover:bg-[#006b68] transition">Dashboard</a>
            <a href="../perusahaan/daftar_pelamar.php" class="block py-2 px-4 rounded-lg hover:bg-[#006b68] transition">Daftar Pelamar</a>
            <a href="../perusahaan/form_pasang_lowongan.php" class="block py-2 px-4 rounded-lg hover:bg-[#006b68] transition">Pasang Lowongan</a>
            <a href="../landing/landing_page.php" class="block py-2 px-4 rounded-lg bg-white text-[#00797a] font-semibold hover:bg-gray-100 transition mt-4">Kembali</a>

            <form action="../logout.php" method="post" class="mt-2">
                <button type="submit" class="w-full py-2 px-4 rounded-lg bg-red-500 hover:bg-red-600 transition font-semibold">Logout</button>
            </form>
        </nav>
    </div>

    <div class="p-4 text-sm text-center text-white/70">© 2025 Carikerja.id</div>
</aside>


    <!-- Main Content -->
    <main class="flex-1 p-8">
        <!-- Hapus header profile bar di sini jika ada, hanya tampilkan judul -->
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
            class="bg-[#00646A] text-white px-4 hover:bg-[#00646A]"
        >
            🔍
        </button>
    </div>
</form>

<!-- Table -->
<div class="bg-white rounded-lg shadow overflow-x-auto">
    <table class="w-full border-collapse min-w-[800px]">
        <thead class="bg-[#00646A] text-white">
            <tr>
                <th class="p-3 text-left">Nama</th>
                <th class="p-3 text-left">Email</th>
                <th class="p-3 text-left">Posisi</th>
                <th class="p-3 text-left">No HP</th>
                <th class="p-3 text-left">CV</th>
            </tr>
        </thead>
        <tbody>

                    <?php if (count($pelamar_perusahaan) > 0): ?>
                        <?php foreach ($pelamar_perusahaan as $p): ?>
                            <tr class="border-b hover:bg-gray-50">
                                <td class="p-3"><?= htmlspecialchars($p['nama_lengkap']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($p['email']) ?></td>
                                <td class="p-3"><?= htmlspecialchars($p['jabatan']) ?></td>
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
