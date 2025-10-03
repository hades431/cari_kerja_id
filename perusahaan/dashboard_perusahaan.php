<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'perusahaan') {
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
// Aktivitas terbaru
$aktivitasTerbaru = [];
$res = $conn->query("SELECT * FROM aktivitas ORDER BY tanggal DESC LIMIT 5");
if ($res) {
    while ($row = $res->fetch_assoc()) {
        $aktivitasTerbaru[] = $row;
    }
}

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

// Ambil pelamar yang melamar ke perusahaan ini
$pelamar_perusahaan = [];
$res_pelamar_kerja = $conn->query("
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
        <a href="../perusahaan/profile_perusahaan.php" class="w-20 h-20 bg-gray-200 rounded-full overflow-hidden block">
          <img src="<?= htmlspecialchars($logo_perusahaan) ?>" alt="Logo Perusahaan" class="w-full h-full object-cover">
        </a>
        <h2 class="mt-3 text-lg font-semibold"><?= htmlspecialchars($nama_perusahaan) ?></h2>
      </div>
      <!-- Menu -->
      <nav class="mt-6 space-y-2 px-4">
        <a href="dashboard_perusahaan.php" class="block py-2 px-4 rounded-lg hover:bg-[#006b68] transition">Dashboard</a>
        <a href="../perusahaan/daftar_pelamar.php" class="block py-2 px-4 rounded-lg hover:bg-[#006b68] transition">Daftar Pelamar</a>
        <a href="../perusahaan/form_pasang_lowongan.php" class="block py-2 px-4 rounded-lg hover:bg-[#006b68] transition">Pasang Lowongan</a>
        <a href="../landing/landing_page.php" class="block py-2 px-4 rounded-lg bg-gray-200 text-[#00797a] font-semibold hover:bg-gray-300 transition mt-4">Kembali</a>
        <form action="../logout.php" method="post" class="mt-2">
          <button type="submit" class="w-full py-2 px-4 rounded-lg bg-red-500 hover:bg-red-600 transition font-semibold">Logout</button>
        </form>
      </nav>
    </div>
    <div class="p-4 text-sm text-center text-[#b2e3e5]">© 2025 Carikerja.id</div>
  </aside>

  <!-- Content: beri margin-left agar tidak tertutup sidebar -->
  <main class="flex-1 p-8 overflow-y-auto bg-gray-100 ml-64" style="min-height:calc(100vh - 68px)">
    <!-- Hapus <h1>Dashboard</h1> di sini -->
    <!-- Statistik -->
 <div class="grid grid-cols-2 gap-6 mb-8">
      <div class="bg-[#00646A] text-white p-6 rounded-lg shadow">
        <div class="text-lg mb-2">Total Lowongan</div>
        <div class="text-4xl font-bold"><?= $jmlLowongan ?></div>
      </div>
      <div class="bg-[#00646A] text-white p-6 rounded-lg shadow">
        <div class="text-lg mb-2">Total Pelamar</div>
        <div class="text-4xl font-bold"><?= $jmlpelamar ?></div>
      </div>
    </div>


            <!-- Aktivitas Terbaru -->
            <div class="bg-white p-4 rounded-lg shadow mb-8">
                <h2 class="text-lg font-semibold mb-4">Aktivitas Terbaru</h2>
                <ul class="space-y-2">
                    <?php if (!empty($aktivitasTerbaru)): ?>
                    <?php foreach ($aktivitasTerbaru as $a): ?>
                    <li class="flex justify-between"><span><?= isset($a['icon']) ? $a['icon'] : '' ?>
                            <?= $a['pesan'] ?></span><span class="text-gray-500 text-sm"><?= $a['tanggal'] ?></span>
                    </li>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <li class="text-gray-400">Belum ada aktivitas</li>
                    <?php endif; ?>
                </ul>
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
                                <th class="px-4 py-2 text-left">Logo</th>
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
                                    <?php if(!empty($l['logo'])): ?>
                                    <img src="../<?= htmlspecialchars($l['logo']) ?>" alt="Logo"
                                        class="w-16 h-16 object-cover rounded">
                                    <?php else: ?>
                                    -
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

            <!-- Card Pelamar untuk perusahaan ini -->
    <div class="bg-white p-6 rounded-2xl shadow mb-8">
        <h2 class="text-xl font-bold text-[#00646A] mb-4">Pelamar ke Perusahaan Anda</h2>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-[#00646A] text-white">
                    <tr>
                        <th class="px-4 py-2 text-left">Nama Lengkap</th>
                        <th class="px-4 py-2 text-left">Email</th>
                        <th class="px-4 py-2 text-left">Tanggal Lamar</th>
                        <th class="px-4 py-2 text-left">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <?php if(!empty($pelamar_perusahaan)): ?>
                        <?php foreach($pelamar_perusahaan as $p): ?>
                        <tr>
                            <td class="px-4 py-2"><?= htmlspecialchars($p['nama_lengkap']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($p['email']) ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($p['tgl_lamar'] ?? '-') ?></td>
                            <td class="px-4 py-2"><?= htmlspecialchars($p['status_lamaran'] ?? '-') ?></td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center px-4 py-6 text-gray-400">Belum ada pelamar untuk perusahaan Anda.</td>
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


    </div>
</body>

</html>