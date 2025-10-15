<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "lowongan_kerja");
if (!$conn) {
    die("Koneksi DB gagal: " . mysqli_connect_error());
}


$id_lowongan = isset($_GET['id_lowongan']) ? (int) $_GET['id_lowongan'] : 0;
if ($id_lowongan <= 0) {
   
    header("Location: ../landing/landing_page.php");
    exit;
}


$sql = "SELECT l.*, p.nama_perusahaan 
        FROM lowongan l
        LEFT JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan
        WHERE l.id_lowongan = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_lowongan);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$lowongan = mysqli_fetch_assoc($res);


if (!$lowongan) {
    header("Location: ../landing/landing_page.php?error=lowongan_tidak_ditemukan");
    exit;
}


$company_name = $lowongan['nama_perusahaan'] ?? ($lowongan['company_name'] ?? 'Perusahaan');
$position_name = $lowongan['posisi_pekerjaan'] ?? $lowongan['posisi'] ?? $lowongan['title'] ?? 'Posisi';


$id_user = $_SESSION['id_user'] ?? null;
if (!$id_user) {
   
    $id_user = 1;
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lamar Lowongan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .brand-green { color: #00646A; }
    .brand-green-bg { background-color: #00646A; }
    .brand-green-focus:focus {
      outline: none;
      border-color: #00646A;
      box-shadow: 0 0 0 2px rgba(0,100,106,0.3);
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Wrapper -->
  <div class="max-w-2xl mx-auto mt-10">

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-lg p-8">

      <!-- Header -->
      <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold brand-green">Formulir Lamaran</h2>
        <p class="text-gray-500">Lengkapi data berikut untuk melamar pekerjaan.</p>
      </div>

      <!-- Ringkasan Lowongan -->
  <div class="bg-gray-50 p-4 rounded-lg border mb-6">
  <h3 class="text-lg font-bold brand-green"><?= htmlspecialchars($company_name) ?></h3>
  <p class="text-gray-600">Posisi: <span class="font-medium"><?= htmlspecialchars($position_name) ?></span></p>
  <p class="text-gray-600">Lokasi: <span class="font-medium"><?= htmlspecialchars($lowongan['lokasi'] ?? '-') ?></span></p>
  <p class="text-gray-600">Gaji: <span class="font-medium"><?= htmlspecialchars($lowongan['gaji'] ?? '-') ?></span></p>
</div>



      <!-- Form -->
    <form action="/cari_kerja_id/public/proses_lamaran.php" method="POST" enctype="multipart/form-data" class="space-y-5" onsubmit="console.log('id_lowongan:', document.querySelector('[name=id_lowongan]').value);">
    <input type="hidden" name="id_lowongan" value="<?= $id_lowongan ?>">


        <!-- Nama -->
        <div>
          <label class="block font-medium text-gray-700 mb-1">Nama Lengkap</label>
          <input type="text" name="nama_pelamar" required placeholder="Masukkan nama lengkap"
            class="w-full border rounded-lg px-3 py-2 brand-green-focus">
        </div>

        <!-- Email -->
        <div>
          <label class="block font-medium text-gray-700 mb-1">Email</label>
          <input type="email" name="email" required placeholder="contoh@email.com"
            class="w-full border rounded-lg px-3 py-2 brand-green-focus">
        </div>

        <!-- No HP -->
        <div>
          <label class="block font-medium text-gray-700 mb-1">Nomor HP</label>
          <input type="text" name="no_hp" required placeholder="08xxxxxxxxxx"
            class="w-full border rounded-lg px-3 py-2 brand-green-focus">
        </div>

        <!-- Upload CV -->
        <div>
          <label class="block font-medium text-gray-700 mb-1">Upload CV</label>
          <input type="file" name="cv" required accept=".pdf,.doc,.docx"
  class="w-full border rounded-lg px-3 py-2">

          <p class="text-sm text-gray-500 mt-1">* Format PDF/DOC, maksimal 2MB</p>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end items-center gap-4 mt-6">
  <a href="../landing/card.php?id=<?= $id_lowongan; ?>"
     class="border border-gray-300 text-gray-700 px-5 py-2 rounded-md hover:bg-gray-100 transition">
     Kembali
  </a>
  <button type="submit"
     class="bg-[#00646A] text-white px-6 py-2 rounded-md text-sm font-medium hover:bg-[#0d7c82] transition">
     Lamar Sekarang
  </button>
</div>

      </form>
    </div>
  </div>

</body>
</html>