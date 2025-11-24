<?php
session_start();
include '../../function/logic.php';
include '../../function/sesi_role_aktif_admin.php';

if (!isset($_GET['id'])) {
    header("Location: pelamar.php");
    exit;
}

$id_user = intval($_GET['id']);

$query = mysqli_prepare($conn, "SELECT * FROM pelamar_kerja WHERE id_user = ?");
mysqli_stmt_bind_param($query, "i", $id_user);
mysqli_stmt_execute($query);
$result = mysqli_stmt_get_result($query);
$pelamar = mysqli_fetch_assoc($result);


$fotoSrc = '../../img/default_pp.png';
if (!empty($pelamar['foto'])) {
    $fotoVal = $pelamar['foto'];
    if (preg_match('/^(https?:)?\\/\\//', $fotoVal) || strpos($fotoVal, '/') === 0) {
        $fotoSrc = $fotoVal;
    } elseif (strpos($fotoVal, 'uploads/') === 0) {
        $fotoSrc = '../../' . $fotoVal;
    } else {
        $fotoSrc = '../../uploads/pelamar/' . $fotoVal;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Detail Pelamar</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 min-h-screen flex justify-center items-start py-10">

  <div class="bg-white shadow-xl rounded-2xl w-full max-w-3xl p-10">
    <a href="pelamar.php" class="text-teal-700 hover:underline inline-block mb-6">← Kembali</a>

    <?php if ($pelamar): ?>
      <div class="flex flex-col items-center text-center mb-8">
        <img 
          src="<?= htmlspecialchars($fotoSrc) ?>" 
          alt="Foto Pelamar" 
          class="w-32 h-32 rounded-full object-cover border-4 border-teal-600 shadow-md mb-4"
        >
        <h2 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($pelamar['nama_lengkap']); ?></h2>
        <p class="text-teal-700 font-medium mb-2"><?= htmlspecialchars($pelamar['jabatan'] ?? ''); ?></p>
        <div class="flex flex-wrap justify-center gap-4 text-gray-600 text-sm">
          <div class="flex items-center gap-2"><i class='bx bx-envelope'></i><?= htmlspecialchars($pelamar['email']); ?></div>
          <div class="flex items-center gap-2"><i class='bx bx-phone'></i><?= htmlspecialchars($pelamar['no_hp'] ?? '-'); ?></div>
          <div class="flex items-center gap-2"><i class='bx bx-map'></i><?= htmlspecialchars($pelamar['alamat'] ?? '-'); ?></div>
        </div>
      </div>

      <div class="mb-6">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Deskripsi</h3>
        <div class="bg-gray-100 p-4 rounded-lg text-gray-700 leading-relaxed">
          <?= nl2br(htmlspecialchars($pelamar['deskripsi'] ?? '-')); ?>
        </div>
      </div>

  
        <div class="mb-6">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Pengalaman Kerja</h3>

            <?php  
                
                $exp = json_decode($pelamar['pengalaman'], true);

                $jabatan = "-";
                $perusahaan = "-";
                $tahun = "-";

                if (json_last_error() === JSON_ERROR_NONE) {
                    $jabatan = isset($exp['jabatan'][0]) ? $exp['jabatan'][0] : "-";
                    $perusahaan = isset($exp['perusahaan'][0]) ? $exp['perusahaan'][0] : "-";
                    $tahun = isset($exp['tahun'][0]) ? $exp['tahun'][0] : "-";
                } else {
                    $jabatan = $pelamar['pengalaman'] ?: "-";
                    $perusahaan = $pelamar['tempat_kerja'] ?: "-";
                    $tahun = $pelamar['tahun_pengalaman'] ?: "-";
                }
            ?>

            <?php if ($jabatan != "-" || $perusahaan != "-" || $tahun != "-"): ?>
            
            <div class="bg-white border border-gray-300 shadow-sm rounded-xl p-5">

                <div class="flex mb-3">
                    <span class="w-32 font-semibold text-gray-700"> Jabatan</span>
                    <span class="mr-2">:</span>
                    <span class="text-gray-600"><?= htmlspecialchars($jabatan) ?></span>
                </div>

                <div class="flex mb-3">
                    <span class="w-32 font-semibold text-gray-700"> Perusahaan</span>
                    <span class="mr-2">:</span>
                    <span class="text-gray-600"><?= htmlspecialchars($perusahaan) ?></span>
                </div>

                <div class="flex mb-1">
                    <span class="w-32 font-semibold text-gray-700"> Tahun</span>
                    <span class="mr-2">:</span>
                    <span class="text-gray-600"><?= htmlspecialchars($tahun) ?></span>
                </div>

            </div>

            <?php else: ?>
                <p class="text-gray-500 italic">Belum ada pengalaman kerja.</p>
            <?php endif; ?>
        </div>


      <div class="mb-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-2">Keahlian</h3>
        <?php if (!empty($pelamar['keahlian'])): ?>
          <?php 
            $skills = explode(',', $pelamar['keahlian']);
            foreach ($skills as $skill): 
          ?>
            <span class="inline-block bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full mr-2 mb-2">
              <?= htmlspecialchars(trim($skill)); ?>
            </span>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="text-gray-500 italic">Belum menambahkan keahlian.</p>
        <?php endif; ?>
      </div>

    <?php else: ?>
      <div class="text-center py-10 text-gray-600 italic">
        Data pelamar tidak ditemukan.
      </div>
    <?php endif; ?>
  </div>
</body>
</html>
