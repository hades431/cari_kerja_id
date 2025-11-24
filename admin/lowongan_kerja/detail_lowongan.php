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

<body class="bg-gray-100 py-12">

    <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl p-8">

        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Detail Lowongan</h1>

            <a href="lowongan_kerja.php" 
               class="px-4 py-2 bg-teal-600 text-white rounded-lg shadow hover:bg-teal-700 transition">
                  Kembali
            </a>
        </div>

        <div class="space-y-6">

            <div>
                <p class="text-gray-500 text-sm">Nama Perusahaan</p>
                <p class="text-xl font-semibold text-gray-900">
                    <?= htmlspecialchars($data['nama_perusahaan']) ?>
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Posisi / Lowongan</p>
                <p class="text-xl font-semibold text-gray-900">
                    <?= htmlspecialchars($data['posisi']) ?>
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Deskripsi Pekerjaan</p>
                <div class="bg-gray-50 p-4 rounded-lg border text-gray-700 leading-relaxed">
                    <?= nl2br(htmlspecialchars($data['deskripsi'])) ?>
                </div>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Lokasi Kerja</p>
                <p class="text-lg font-medium text-gray-900">
                    📍 <?= htmlspecialchars($data['lokasi']) ?>
                </p>
            </div>

            <div>
                <p class="text-gray-500 text-sm">Gaji</p>
                <p class="text-xl font-bold text-green-600">
                    Rp <?= number_format($data['gaji'], 0, ',', '.') ?>
                </p>
            </div>

        </div>

    </div>

</body>
</html>
