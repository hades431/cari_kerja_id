<?php
include '../../function/logic.php';

$id = $_GET['id'] ?? '';

if (!$id) {
    die("ID perusahaan tidak ditemukan!");
}

$sql = "SELECT * FROM perusahaan WHERE id_perusahaan = '$id'";
$result = mysqli_query($conn, $sql);

if (mysqli_num_rows($result) == 0) {
    die("Data perusahaan tidak ditemukan!");
}

$data = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Detail Perusahaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen">

<div class="max-w-3xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">

    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-700">Detail Perusahaan</h2>

        <a href="acc.php"
           class="px-4 py-2 bg-teal-600 text-white rounded-lg shadow hover:bg-teal-700">
            Kembali
        </a>
    </div>

    <div class="flex items-center gap-6 mb-6">
        <div class="w-32 h-32 bg-gray-200 rounded-xl overflow-hidden">
            <?php if (!empty($data['logo'])): ?>
                <img src="../../uploads/logo_perusahaan/<?= $data['logo'] ?>" class="w-full h-full object-cover">
            <?php else: ?>
                <img src="../../img/default_company.png" class="w-full h-full object-cover">
            <?php endif; ?>
        </div>

        <div>
            <h3 class="text-xl font-bold text-gray-800"><?= htmlspecialchars($data['nama_perusahaan']); ?></h3>
            <p class="text-gray-600"><?= htmlspecialchars($data['email_perusahaan']); ?></p>
        </div>
    </div>

    <div class="grid grid-cols-2 gap-6">

        <div>
            <p class="text-gray-500 text-sm">Alamat</p>
            <p class="text-gray-800 font-medium mb-4">
                <?= htmlspecialchars($data['alamat'] ?: '-'); ?>
            </p>

            <p class="text-gray-500 text-sm">No Telepon</p>
            <p class="text-gray-800 font-medium mb-4">
                <?= htmlspecialchars($data['no_telepon'] ?: '-'); ?>
            </p>
        </div>

        <div class="col-span-2">
            <p class="text-gray-500 text-sm">Deskripsi Perusahaan</p>
            <p class="text-gray-800 leading-relaxed bg-gray-50 p-4 rounded-lg border">
                <?= nl2br(htmlspecialchars($data['deskripsi'] ?: 'Tidak ada deskripsi.')); ?>
            </p>
        </div>

    </div>
</div>

</body>
</html>
