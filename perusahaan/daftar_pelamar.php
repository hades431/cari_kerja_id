<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'Perusahaan') {
    header('Location: ../login/login.php');
    exit;
}

include '../header.php';

$koneksi = new mysqli("localhost", "root", "", "lowongan_kerja");

if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// Ambil id_user dari session perusahaan (pastikan session set saat login)
$user_id = $_SESSION['id_user'] ?? 0;

// Ambil data perusahaan yang terkait dengan user yang login
$id_perusahaan = 0;
$logo_perusahaan = '';
$nama_perusahaan = 'Perusahaan';

$stmt = $koneksi->prepare("SELECT id_perusahaan, logo, nama_perusahaan FROM perusahaan WHERE id_user = ? LIMIT 1");
if ($stmt) {
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $row = $res->fetch_assoc()) {
        $id_perusahaan = (int)$row['id_perusahaan'];
        $logo_perusahaan = $row['logo'] ?: '';
        // jika logo disimpan path relatif tanpa ../, sesuaikan tampilan
        if (!empty($logo_perusahaan) && strpos($logo_perusahaan, 'uploads/') === 0) {
            $logo_perusahaan = '../' . $logo_perusahaan;
        }
        $nama_perusahaan = $row['nama_perusahaan'] ?: $nama_perusahaan;
    }
    $stmt->close();
}

$q = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : "";

// Ambil pelamar yang melamar ke perusahaan ini saja (filter berdasarkan id_perusahaan dari session)
$pelamar_perusahaan = [];

if ($id_perusahaan > 0) {
    // sanitasi pencarian simple
    $q_esc = $koneksi->real_escape_string($q);

    $sql = "
        SELECT 
            lam.id_lamaran,
            pk.id_pelamar,
            pk.nama_lengkap,
            pk.no_hp,
            pk.cv,
            u.email,
            l.posisi AS jabatan,
            lam.status_lamaran,
            lam.tanggal_lamar
        FROM lamaran lam
        JOIN pelamar_kerja pk ON lam.id_pelamar = pk.id_pelamar
        JOIN user u ON pk.id_user = u.id_user
        JOIN lowongan l ON lam.id_lowongan = l.id_lowongan
        WHERE l.id_perusahaan = $id_perusahaan
    ";

    if (!empty($q_esc)) {
        $sql .= " AND LOWER(l.posisi) LIKE '%$q_esc%'";
    }

    $sql .= " ORDER BY lam.tanggal_lamar DESC";

    $res_pelamar_kerja = $koneksi->query($sql);

    if ($res_pelamar_kerja) {
        while ($row = $res_pelamar_kerja->fetch_assoc()) {
            $pelamar_perusahaan[] = $row;
        }
    }
} else {
    // jika perusahaan belum lengkap/tidak ditemukan, kosongkan list
    $pelamar_perusahaan = [];
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
        <aside class="fixed top-[68px] left-0 w-64 bg-[#00646A] text-white flex flex-col h-[calc(100vh-68px)] z-10">
            <div class="flex-1 flex flex-col justify-start">
                <div class="flex flex-col items-center py-6">
                    <a href="../perusahaan/profile_perusahaan.php"
                        class="w-20 h-20 bg-gray-200 rounded-full overflow-hidden block">
                        <img src="<?= htmlspecialchars($logo_perusahaan) ?>" alt="Logo Perusahaan"
                            class="w-full h-full object-cover">
                    </a>
                    <h2 class="mt-3 text-lg font-semibold"><?= htmlspecialchars($nama_perusahaan) ?></h2>
                </div>

                <!-- Menu -->
                <nav class="mt-6 space-y-2 px-4">
                    <a href="dashboard_perusahaan.php"
                        class="block py-2 px-4 rounded-lg hover:bg-[#006b68] transition">Dashboard</a>
                    <a href="../perusahaan/daftar_pelamar.php"
                        class="block py-2 px-4 rounded-lg hover:bg-[#006b68] transition">Daftar Pelamar</a>
                    <a href="../perusahaan/form_pasang_lowongan.php"
                        class="block py-2 px-4 rounded-lg hover:bg-[#006b68] transition">Pasang Lowongan</a>
                    <a href="../landing/landing_page.php"
                        class="block py-2 px-4 rounded-lg bg-white text-[#00797a] font-semibold hover:bg-gray-100 transition mt-4">Kembali</a>

                    <form action="../logout.php" method="post" class="mt-2">
                        <button type="submit"
                            class="w-full py-2 px-4 rounded-lg bg-red-500 hover:bg-red-600 transition font-semibold">Logout</button>
                    </form>
                </nav>
            </div>

            <div class="p-4 text-sm text-center text-white/70">© 2025 Carikerja.id</div>
        </aside>


        <!-- Main Content -->
        <main class="flex-1 p-8 ml-64">
            <!-- Hapus header profile bar di sini jika ada, hanya tampilkan judul -->
            <h2 class="text-2xl font-bold text-[#00646A] mb-6">Daftar Pelamar</h2>

            <!-- Search -->
            <form method="GET" class="flex justify-start mb-6 w-full sm:w-1/3">
                <div class="flex w-full shadow rounded-lg overflow-hidden">
                    <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Cari posisi..."
                        class="px-3 py-2 w-full focus:outline-none">
                    <button type="submit" class="bg-[#00646A] text-white px-4 hover:bg-[#00646A]">
                        🔍
                    </button>
                </div>
            </form>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow overflow-x-auto">
                <table class="w-full border-collapse min-w-[900px]">
                    <thead class="bg-[#00646A] text-white">
                        <tr>
                            <th class="p-3 text-left">Nama</th>
                            <th class="p-3 text-left">Email</th>
                            <th class="p-3 text-left">No HP</th>
                            <th class="p-3 text-left">CV</th>
                            <th class="p-3 text-left">Status</th>
                            <th class="p-3 text-left">Tanggal</th>
                            <th class="p-3 text-left"></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if (count($pelamar_perusahaan) > 0): ?>
                        <?php foreach ($pelamar_perusahaan as $p): ?>
                        <tr class="border-b hover:bg-gray-50">
                            <td class="p-3"><?= htmlspecialchars($p['nama_lengkap']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($p['email']) ?></td>
                            <td class="p-3"><?= htmlspecialchars($p['no_hp']) ?></td>
                            <td class="p-3 text-center">
                                <?php if (!empty($p['cv'])): ?>
                                <a href="../uploads/<?= htmlspecialchars($p['cv']) ?>" target="_blank"
                                    class="text-blue-600 hover:underline">
                                    Lihat CV
                                </a>
                                <?php else: ?>
                                <span class="text-gray-500">Tidak ada CV</span>
                                <?php endif; ?>
                            </td>

                            <!-- Status (form removed) -->
                            <td class="p-3"><?= htmlspecialchars($p['status_lamaran']) ?></td>

                            <td class="p-3"><?= htmlspecialchars(date("d/m/Y", strtotime($p['tanggal_lamar']))) ?></td>
                            <td class="p-3">
                                <a href="view_pelamar.php?id=<?= urlencode($p['id_pelamar']) ?>"
                                   class="inline-block px-3 py-1 bg-[#00646A] text-white rounded hover:opacity-90">Lihat Profil</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="7" class="text-center p-4 text-gray-500">Tidak ada data pelamar</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>

</html>