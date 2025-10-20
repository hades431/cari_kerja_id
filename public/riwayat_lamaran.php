<?php
session_start();
include '../header.php';

if (!isset($_SESSION['id_pelamar'])) {
    $_SESSION['id_pelamar'] = 1; 
}

$id_pelamar = $_SESSION['id_pelamar'];



$conn = mysqli_connect("localhost", "root", "", "lowongan_kerja");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


$where = "WHERE lam.id_pelamar = $id_pelamar";
if (!empty($_GET['status'])) {
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    $where .= " AND lam.status_lamaran = '$status'";
}
$order = "ORDER BY lam.tanggal_lamar DESC";
if (!empty($_GET['sort']) && $_GET['sort'] == "lama") {
    $order = "ORDER BY lam.tanggal_lamar ASC";
}


$sql = "SELECT 
            p.nama_perusahaan AS perusahaan,
            l.posisi AS posisi,
            lam.tanggal_lamar AS tanggal,
            lam.status_lamaran AS status
        FROM lamaran lam
        JOIN lowongan l ON lam.id_lowongan = l.id_lowongan
        JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan
        $where
        $order";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$filtered = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $filtered[] = $row;
    }
}

// tentukan URL profil pelamar (cek keberadaan file, fallback ke beranda)
$profile_file = __DIR__ . '/profil_pelamar.php';
if (file_exists($profile_file)) {
    $profile_url = 'profil_pelamar.php';
} else {
    $profile_url = '../'; // fallback jika file profil tidak ada
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Lamaran</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .primary { background-color: #00797a; }
    .primary-text { color: #00797a; }
    .primary-border { border-color: #00797a; }
  </style>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Container Full Width dengan Padding -->
  <div class="w-full px-6 mt-10">
    <h1 class="text-3xl font-bold mb-6 primary-text">📄 Riwayat Lamaran</h1>

    <!-- Tombol kembali ke profil pelamar -->
    <!-- Button Kembali -->
<div class="max-w-4xl mt-4 px-4 flex justify-start">
    <a href="../public/profil_pelamar.php"
        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition mb-4">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

    <!-- Filter Form -->
    <form method="GET" class="flex flex-wrap gap-3 mb-6">
      <select name="status" class="px-4 py-2 border rounded-lg primary-border">
        <option value="">Semua Status</option>
       <option value="di proses">Di Proses</option>
<option value="di terima">Di Terima</option>
<option value="di tolak">Di Tolak</option>

      </select>

      <select name="sort" class="px-4 py-2 border rounded-lg primary-border">
        <option value="baru" <?= (($_GET['sort'] ?? '')=="baru")?"selected":""; ?>>Terbaru</option>
        <option value="lama" <?= (($_GET['sort'] ?? '')=="lama")?"selected":""; ?>>Terlama</option>
      </select>

      <button type="submit" class="primary text-white px-4 py-2 rounded-lg hover:opacity-90">Filter</button>
    </form>

    <!-- Tabel Riwayat -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <table class="w-full border-collapse">
        <thead class="primary text-white">
          <tr>
            <th class="py-3 px-4 text-left">Perusahaan</th>
            <th class="py-3 px-4 text-left">Posisi</th>
            <th class="py-3 px-4 text-left">Tanggal </th>
            <th class="py-3 px-4 text-left">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($filtered)): ?>
            <?php foreach($filtered as $r): ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4"><?= $r["perusahaan"]; ?></td>
                <td class="py-3 px-4"><?= $r["posisi"]; ?></td>
                <td class="py-3 px-4"><?= $r["tanggal"]; ?></td>
                <td class="py-3 px-4">
                  <?php if($r["status"] == "di proses"): ?>
    <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700"><?= ucfirst($r["status"]); ?></span>
<?php elseif($r["status"] == "di terima"): ?>
    <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700"><?= ucfirst($r["status"]); ?></span>
<?php elseif($r["status"] == "di tolak"): ?>
    <span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-700"><?= ucfirst($r["status"]); ?></span>
<?php endif; ?>

                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada riwayat ditemukan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
