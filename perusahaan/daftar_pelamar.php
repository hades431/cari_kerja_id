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

$user_id = $_SESSION['id_user'] ?? 0;

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
        if (!empty($logo_perusahaan) && strpos($logo_perusahaan, 'uploads/') === 0) {
            $logo_perusahaan = '../' . $logo_perusahaan;
        }
        $nama_perusahaan = $row['nama_perusahaan'] ?: $nama_perusahaan;
    }
    $stmt->close();
}

$q = isset($_GET['q']) ? strtolower(trim($_GET['q'])) : "";

$pelamar_perusahaan = [];

if ($id_perusahaan > 0) {
   
    $q_esc = $koneksi->real_escape_string($q);

    $sql = "
        SELECT 
            lam.id_lamaran,
            lam.id_pelamar AS lam_id_pelamar,
            pk.id_pelamar AS id_pelamar,
            COALESCE(NULLIF(pk.nama_lengkap, ''), NULLIF(u.username, ''), NULLIF(u.email, ''), '-') AS nama_lengkap,
            u.email,
            l.posisi AS posisi,
            lam.status_lamaran,
            lam.tanggal_lamar
        FROM lamaran lam
        LEFT JOIN pelamar_kerja pk ON (lam.id_pelamar = pk.id_pelamar OR lam.id_pelamar = pk.id_user)
        LEFT JOIN user u ON COALESCE(pk.id_user, lam.id_pelamar) = u.id_user
        LEFT JOIN lowongan l ON lam.id_lowongan = l.id_lowongan
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
    $pelamar_perusahaan = [];
}

$count_new_pelamar = 0;
foreach ($pelamar_perusahaan as $tmp_p) {
    if (!empty($tmp_p['status_lamaran']) && stripos(trim($tmp_p['status_lamaran']), 'baru') !== false) {
        $count_new_pelamar++;
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
                       class="block py-2 px-4 rounded-lg hover:bg-[#006b68] transition">
                        <span>Dashboard</span>
                    </a>

                    <a href="daftar_pelamar.php"
                       class="sidebar-link block py-2 px-4 rounded-lg transition bg-white text-[#00797a] font-semibold border-l-4 border-yellow-400"
                       data-key="daftar_pelamar.php" aria-current="page">
                        <span class="inline-flex items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="#00797a" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 11h14M12 11v6"></path></svg>
                            <span>Daftar Pelamar</span>
                        </span>

                        <?php if (!empty($count_new_pelamar) && $count_new_pelamar > 0): ?>
                            <span class="ml-3 inline-flex items-center justify-center px-2 py-0.5 text-xs font-medium bg-red-500 text-white rounded-full"><?= htmlspecialchars($count_new_pelamar) ?></span>
                        <?php endif; ?>
                  </a>

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
                            <th class="p-3 text-left">Posisi</th>
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
                            <td class="p-3"><?= htmlspecialchars($p['posisi'] ?? '-') ?></td>
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
                            <td colspan="6" class="text-center p-4 text-gray-500">Tidak ada data pelamar</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>

</html>
