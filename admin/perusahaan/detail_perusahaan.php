<?php
session_start();
include '../../function/logic.php';

if (!isset($_GET['id'])) {
    die("Perusahaan tidak ditemukan.");
}
$id = $_GET['id'];

$query = "SELECT * FROM perusahaan WHERE id='$id'";
$result = mysqli_query($conn, $query);
$data = mysqli_fetch_assoc($result);

if (!$data) {
    die("Data perusahaan tidak ada.");
}

$data = getPerusahaanById($_GET['id']);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Perusahaan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-4">
    <h3>Detail Perusahaan</h3>
    <div class="card mt-3">
        <div class="card-body">
            <h5 class="card-title"><?= $data['nama_perusahaan'] ?></h5>
            <p><strong>Email:</strong> <?= $data['email'] ?></p>
            <p><strong>Tanggal Daftar:</strong> <?= $data['tanggal_daftar'] ?></p>
            <p><strong>Deskripsi:</strong> <?= $data['deskripsi'] ?></p>

            <hr>
            <h5>Syarat & Ketentuan</h5>
            <p>
                Dengan mendaftar di platform ini, perusahaan menyatakan setuju untuk mengikuti
                syarat & ketentuan yang berlaku, termasuk kewajiban pembayaran, keaslian data,
                serta kepatuhan terhadap regulasi yang berlaku.
            </p>
        </div>
    </div>
    <a href="perusahaan_menunggu.php" class="btn btn-secondary mt-3">Kembali</a>
</div>
</body>
</html>