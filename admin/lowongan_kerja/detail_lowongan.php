<?php
session_start();
include '../../function/logic.php';
include '../../function/sesi_role_aktif_admin.php';

if (!isset($_GET['id'])) {
    header("Location: lowongan_kerja.php?pesan=ID tidak ditemukan");
    exit;
}

$id = intval($_GET['id']);
$data = getLowonganById($id);

if (!$data) {
    header("Location: lowongan_kerja.php?pesan=Data tidak ditemukan");
    exit;
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Lowongan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 py-10">

    <div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">Detail Lowongan</h1>

        <div class="space-y-4">

            <div>
                <p class="text-gray-500">Nama Perusahaan</p>
                <p class="text-lg font-semibold text-gray-900">
                    <?= htmlspecialchars($data['nama_perusahaan']) ?>
                </p>
            </div>

            <div>
                <p class="text-gray-500">Lowongan</p>
                <p class="text-lg font-semibold text-gray-900">
                    <?= htmlspecialchars($data['posisi']) ?>
                </p>
            </div>

            <div>
                <p class="text-gray-500">Deskripsi Lowongan</p>
                <p class="text-gray-800 leading-relaxed">
                    <?= nl2br(htmlspecialchars($data['deskripsi'])) ?>
                </p>
            </div>

            <div>
                <p class="text-gray-500">Lokasi Kerja</p>
                <p class="text-lg font-semibold text-gray-900">
                    <?= htmlspecialchars($data['lokasi']) ?>
                </p>
            </div>

            <div>
                <p class="text-gray-500">Gaji</p>
                <p class="text-lg font-semibold text-green-700">
                    <?= htmlspecialchars($data['gaji']) ?>
                </p>
            </div>

        </div>

        <div class="mt-8 flex justify-between">
            <a href="lowongan_kerja.php"
               class="px-4 py-2 bg-gray-500 text-white rounded hover:bg-gray-600">
                Kembali
            </a>
        </div>

    </div>

</body>
</html>
