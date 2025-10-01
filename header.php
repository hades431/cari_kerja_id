<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$is_logged_in = isset($_SESSION['pelamar_kerja']) || isset($_SESSION['user']);
$is_dashboard_perusahaan = basename($_SERVER['PHP_SELF']) === 'dashboard_perusahaan.php';
$is_tai = basename($_SERVER['PHP_SELF']) === "daftar_pelamar.php";
$is_tai2 = basename($_SERVER['PHP_SELF']) === "profile_perusahaan.php";

$foto_default = '../img/default_profile.png'; // pastikan file ini ada

$nama_lengkap = 'Nama Pengguna';
$foto_profil = $foto_default;

if ($is_logged_in) {
    // Ambil data dari session pelamar_kerja jika ada
    if (isset($_SESSION['pelamar_kerja'])) {
        $nama_lengkap = $_SESSION['pelamar_kerja']['nama_lengkap'] ?: ($_SESSION['user']['email'] ?? 'Nama Pengguna');
        $foto_profil = $_SESSION['pelamar_kerja']['foto'] ?: $foto_default;
        // Jika path sudah mengandung 'uploads/', tambahkan '../' di depannya
        if (strpos($foto_profil, 'uploads/') === 0) {
            $foto_profil = '../' . $foto_profil;
        }
    }
    // Jika hanya user, ambil data dari database pelamar_kerja
    elseif (isset($_SESSION['user'])) {
        require_once '../function/logic.php';
        $user_id = $_SESSION['user']['id'] ?? null;
        $nama_lengkap = $_SESSION['user']['email'] ?? 'Nama Pengguna';
        if ($user_id) {
            $query = mysqli_query($conn, "SELECT nama_lengkap, foto FROM pelamar_kerja WHERE id_user='$user_id' LIMIT 1");
            if ($row = mysqli_fetch_assoc($query)) {
                $nama_lengkap = $row['nama_lengkap'] ?: $nama_lengkap;
                $foto_profil = $row['foto'] ? (strpos($row['foto'], 'uploads/') === 0 ? '../'.$row['foto'] : $row['foto']) : $foto_default;
            }
        }
    }
}

if (!isset($_SESSION['user'])){
    require_once '../function/logic.php';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul_halaman ?? 'Cari Kerja ID' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-[#00646A] px-4 py-3 flex flex-col gap-1">
        <div class="flex flex-row items-center justify-between">
            <a href="../landing/landing_page.php"><img src="../img/carikerja.png" alt="Logo"
                    class="px-2 py-0 rounded w-48 h-20 object-contain"></a>

            <div class="flex flex-col items-end gap-1">
                <!-- Profil -->
                <?php if ($is_logged_in && !$is_tai2 && !$is_dashboard_perusahaan && !$is_tai && $nama_lengkap !== 'Nama Pengguna'): ?>
                    <?php
                        $profil_link = '../public/profil_pelamar.php';
                        if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'perusahaan') {
                            $profil_link = '../perusahaan/dashboard_perusahaan.php';
                        }
                    ?>
                    <a href="<?= $profil_link ?>" class="flex items-center gap-2 mb-0 hover:opacity-80 transition">
                        <img src="<?= htmlspecialchars($foto_profil) ?>" alt="Profil"
                            class="w-10 h-10 rounded-full border-2 border-white shadow object-cover"
                            onerror="this.onerror=null;this.src='<?= $foto_default ?>';">
                        <span class="text-white font-semibold">
                            <?= htmlspecialchars($nama_lengkap) ?>
                        </span>
                    </a>
                <?php endif; ?>
                <div class="flex gap-3 mt-2">
                    <a href="../tips kerja/info_tips_kerja.php" class="bg-green-500 max-w-max hover:bg-[#024629] active:bg-green-700 
                      text-white px-6 py-2 rounded-full font-bold shadow transition">
                        Info & Tips Kerja
                    </a>
                    <a href="../public/buka_lowongan.php" class="bg-yellow-500 max-w-max hover:bg-yellow-600 active:bg-yellow-700 
                      text-black px-6 py-2 rounded-full font-bold shadow transition">
                        Buka Lowongan
                    </a>
                    <?php if (!isset($_SESSION['user'])): ?>
                        <a href="../login/login.php" class="bg-green-500 max-w-max hover:bg-[#024629] active:bg-green-700 
                      text-white px-6 py-2 rounded-full font-bold shadow transition">
                            Login
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </header>