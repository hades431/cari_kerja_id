<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'Perusahaan') {
    header('Location: ../login/login.php');
    exit;
}

include __DIR__ . "/../config.php"; // koneksi database
include '../header.php';

// Ambil data perusahaan berdasarkan email user yang login
$email_user = $_SESSION['email'];
$nama_perusahaan = 'Perusahaan';

// Perbaiki query: kolom email di database adalah email_perusahaan
$res_perusahaan = $conn->query("SELECT id_perusahaan, logo, nama_perusahaan FROM perusahaan WHERE email_perusahaan = '$email_user' LIMIT 1");
if ($res_perusahaan && $row = $res_perusahaan->fetch_assoc()) {
    // Set id_perusahaan ke session jika belum ada
    if (!isset($_SESSION['id_perusahaan'])) {
        $_SESSION['id_perusahaan'] = $row['id_perusahaan'];
    }
    if (!empty($row['logo'])) {
        $logo_perusahaan = (strpos($row['logo'], 'uploads/') === 0) ? '../'.$row['logo'] : $row['logo'];
    }
    $nama_perusahaan = $row['nama_perusahaan'];
}

$user_id =  $_SESSION["user"]["id"];
$id_perusahaan_arr = tampil("SELECT*FROM perusahaan where id_user = $user_id");
$id_perusahaan = isset($id_perusahaan_arr[0]['id_perusahaan']) ? $id_perusahaan_arr[0]['id_perusahaan'] : 0;

$logo_perusahaan_arr = tampil("SELECT*FROM perusahaan WHERE id_perusahaan = $id_perusahaan");
$logo_perusahaan = isset($logo_perusahaan_arr[0]["logo"]) ? $logo_perusahaan_arr[0]["logo"] : "";

// Statistik
$jmlLowongan    = $conn->query("SELECT COUNT(*) FROM lowongan where id_perusahaan = $id_perusahaan")->fetch_row()[0];
$jmlPerusahaan  = $conn->query("SELECT COUNT(*) FROM perusahaan")->fetch_row()[0];
// Ubah query pelamar: hanya pelamar ke perusahaan ini
$jmlpelamar = $conn->query("SELECT COUNT(*) 
    FROM pelamar_kerja pk
    JOIN lowongan l ON pk.id_pelamar = l.id_lowongan
    WHERE l.id_perusahaan = $id_perusahaan
")->fetch_row()[0];

// Query untuk lamaran diterima dan ditolak
$jmlDiterima = $conn->query("SELECT COUNT(*) FROM pelamar_kerja pk
    JOIN lowongan l ON pk.id_lowongan = l.id_lowongan
    WHERE l.id_perusahaan = $id_perusahaan AND pk.status = 'diterima'
")->fetch_row()[0];

$jmlDitolak = $conn->query("SELECT COUNT(*) FROM pelamar_kerja pk
    JOIN lowongan l ON pk.id_lowongan = l.id_lowongan
    WHERE l.id_perusahaan = $id_perusahaan AND pk.status = 'ditolak'
")->fetch_row()[0];

// Lowongan saya
$lowongan_saya = [];
// var_dump($user_id);die;
$tampil = tampil("SELECT*FROM perusahaan WHERE id_user = $user_id")[0]["id_perusahaan"] ?? false;

if(!$tampil){
    include '../perusahaan/belumpilihpaket.php';
  echo ""; die;
  
}
$res = $conn->query("SELECT * FROM lowongan WHERE id_perusahaan = $tampil ORDER BY tanggal_post DESC");
if($res){
    while($row = $res->fetch_assoc()){
        $lowongan_saya[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Perusahaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#00646A] h-screen">
    <!-- Header fixed di atas -->
    <header class="fixed top-0 left-0 w-full bg-[#00646A] text-white py-5 px-8 text-2xl font-bold shadow z-20">
        Dashboard
    </header>
    <!-- Container utama dengan padding top sesuai tinggi header -->
    <div class="flex h-screen" style="padding-top:68px">
        <!-- Sidebar: gunakan fixed dan top sama dengan header agar menempel -->
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
                       class="sidebar-link always-white block py-2 px-4 rounded-lg transition text-white font-semibold flex items-center gap-2"
                       data-key="dashboard_perusahaan.php" aria-current="page">
                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12h18M3 6h18M3 18h18"></path></svg>
                        <span>Dashboard</span>
                    </a>
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
                <div id="logout-modal"
                    class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden">
                    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-md w-full text-center relative">
                        <button onclick="closeLogoutModal()"
                            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
                        <h2 class="text-2xl font-bold text-[#00646A] mb-2">Konfirmasi Logout</h2>
                        <p class="text-gray-500 mb-6">Apakah Anda yakin ingin logout?</p>
                        <div class="flex justify-center gap-4">
                            <button onclick="closeLogoutModal()"
                                class="border border-gray-400 px-6 py-2 rounded text-gray-700 hover:bg-gray-100 font-semibold">Batal</button>
                            <!-- Tambahkan id untuk tombol konfirmasi -->
                            <button id="confirm-logout"
                                class="border border-red-600 text-red-700 px-6 py-2 rounded hover:bg-red-50 font-semibold">Logout</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="p-4 text-sm text-center text-[#b2e3e5]">© 2025 Carikerja.id</div>
        </aside>

        <!-- Content: beri margin-left agar tidak tertutup sidebar -->
        <main class="flex-1 p-8 overflow-y-auto bg-gray-100 ml-64" style="min-height:calc(100vh - 68px)">
            <!-- Hapus <h1>Dashboard</h1> di sini -->
            <!-- Statistik -->
            <div class="grid grid-cols-4 gap-6 mb-8">
                <div class="bg-[#00646A] text-white p-6 rounded-lg shadow">
                    <div class="text-lg mb-2">Total Lowongan</div>
                    <div class="text-4xl font-bold"><?= $jmlLowongan ?></div>
                </div>
                <div class="bg-[#00646A] text-white p-6 rounded-lg shadow">
                    <div class="text-lg mb-2">Total Pelamar</div>
                    <div class="text-4xl font-bold"><?= $jmlpelamar ?></div>
                </div>
                <div class="bg-green-600 text-white p-6 rounded-lg shadow">
                    <div class="text-lg mb-2">Total Diterima</div>
                    <div class="text-4xl font-bold"><?= $jmlDiterima ?></div>
                </div>
                <div class="bg-red-600 text-white p-6 rounded-lg shadow">
                    <div class="text-lg mb-2">Total Ditolak</div>
                    <div class="text-4xl font-bold"><?= $jmlDitolak ?></div>
                </div>
            </div>

            <!-- Lowongan Saya -->
            <div class="bg-white p-6 rounded-2xl shadow mb-8">
                <h2 class="text-xl font-bold text-[#00646A] mb-4">Lowongan Saya</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-[#00646A] text-white">
                            <tr>
                                <th class="px-4 py-2 text-left">Posisi</th>
                                <th class="px-4 py-2 text-left">Batas Lamaran</th>
                                <th class="px-4 py-2 text-left">Gaji</th>
                                <th class="px-4 py-2 text-left">Lokasi</th>
                                <th class="px-4 py-2 text-left">Banner</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php if(!empty($lowongan_saya)): ?>
                            <?php foreach($lowongan_saya as $l): ?>
                            <tr>
                                <td class="px-4 py-2"><?= htmlspecialchars($l['judul']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($l['batas_lamaran']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($l['gaji']) ?></td>
                                <td class="px-4 py-2"><?= htmlspecialchars($l['lokasi']) ?></td>
                                <td class="px-4 py-2">
                                    <?php if(!empty($l['banner'])): ?>
                                    <img src="../<?= htmlspecialchars($l['banner']) ?>" alt="Banner"
                                        class="max-h-16 max-w-32 object-cover rounded cursor-pointer hover:shadow-lg transition" 
                                        onclick="showBannerModal('<?= htmlspecialchars($l['banner']) ?>')">
                                    <?php else: ?>
                                    <span class="text-gray-400 text-sm">Tidak ada banner</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center px-4 py-6 text-gray-400">Belum ada lowongan</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- Notifikasi -->
            <div class="bg-white p-4 rounded-lg shadow">
                <h2 class="text-lg font-semibold mb-4">Notifikasi</h2>
                <ul class="space-y-2">
                    <?php if (!empty($notifikasi)): ?>
                    <?php foreach ($notifikasi as $n): ?>
                    <li class="flex justify-between"><span><?= isset($n['icon']) ? $n['icon'] : '' ?>
                            <?= $n['pesan'] ?></span><a href="<?= $n['link'] ?>"
                            class="text-blue-500"><?= $n['aksi'] ?></a></li>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <li class="text-gray-400">Tidak ada notifikasi</li>
                    <?php endif; ?>
                </ul>
            </div>

            <!-- Banner Modal -->
            <div id="banner-modal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
                <div class="bg-white rounded-lg shadow-lg p-4 max-w-2xl w-full relative">
                    <button onclick="closeBannerModal()" class="absolute top-2 right-2 text-gray-400 hover:text-gray-600 text-2xl">&times;</button>
                    <img id="banner-modal-img" src="" alt="Banner" class="w-full rounded">
                </div>
            </div>

    </div>

</body>

</html>
<script>
function openLogoutModal() {
    document.getElementById('logout-modal').classList.remove('hidden');
}

function closeLogoutModal() {
    document.getElementById('logout-modal').classList.add('hidden');
}

function showBannerModal(bannerSrc) {
    document.getElementById('banner-modal-img').src = bannerSrc;
    document.getElementById('banner-modal').classList.remove('hidden');
}

function closeBannerModal() {
    document.getElementById('banner-modal').classList.add('hidden');
}

document.addEventListener('DOMContentLoaded', function() {
    var btn = document.getElementById('logout-btn');
    if (btn) btn.addEventListener('click', openLogoutModal);

    var confirmBtn = document.getElementById('confirm-logout');
    if (confirmBtn) confirmBtn.addEventListener('click', function() {
        // Redirect ke logout script (sesuaikan path)
        window.location.href = '../logout.php';
    });

    // Handle sidebar active state. Links with class 'always-white' tetap putih.
    function setActiveKey(key) {
        var links = document.querySelectorAll('.sidebar-link');
        links.forEach(function(link) {
            if (link.classList.contains('always-white')) {
                // pastikan selalu putih
                link.classList.add('bg-white','text-[#00646A]','shadow-sm');
                link.classList.remove('text-white','hover:bg-[#006b68]');
                return;
            }
            if (link.dataset.key === key || link.getAttribute('href') === key) {
                link.classList.remove('text-white','hover:bg-[#006b68]');
                link.classList.add('bg-white','text-[#00646A]','shadow-sm');
            } else {
                link.classList.remove('bg-white','text-[#00646A]','shadow-sm');
                if (!link.classList.contains('text-white')) link.classList.add('text-white');
            }
        });
        try { localStorage.setItem('activeSidebar', key); } catch(e){}
    }

    var sidebarLinks = document.querySelectorAll('.sidebar-link');
    sidebarLinks.forEach(function(link) {
        link.addEventListener('click', function(e) {
            var key = this.dataset.key || this.getAttribute('href');
            // Jangan set active jika link ini diberi kelas always-white
            if (!this.classList.contains('always-white')) {
                setActiveKey(key);
            }
            // biarkan navigasi normal terjadi (jika menuju halaman lain)
        });
    });

    // Restore active dari localStorage jika ada (abaikan jika saved = 'kembali')
    var saved = null;
    try { saved = localStorage.getItem('activeSidebar'); } catch(e){}
    if (saved && saved !== 'kembali') {
        setActiveKey(saved);
    } else {
        // default: cocokkan file di URL dengan href link non-always-white
        var path = window.location.pathname.split('/').pop();
        if (path) {
            var matched = Array.from(sidebarLinks).find(function(l){
                if (l.classList.contains('always-white')) return false;
                var hrefFilename = l.getAttribute('href').split('/').pop();
                return hrefFilename === path;
            });
            if (matched) {
                setActiveKey(matched.dataset.key || matched.getAttribute('href'));
            }
        }
    }

    // optional: tutup modal saat tekan Escape
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            closeLogoutModal();
            closeBannerModal();
        }
    });
});
</script>