<?php
session_start();
include '../function/logic.php'; 

if (!isset($_GET['id'])) {
    header("Location: tips_kerja_artikel.php");
    exit;
}

$id = intval($_GET['id']);
$result = mysqli_query($conn, "SELECT * FROM artikel WHERE id='$id'");
$artikel = mysqli_fetch_assoc($result);

if (!$artikel) {
    $_SESSION['error'] = "Artikel tidak ditemukan!";
    header("Location: tips_kerja_artikel.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lihat Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center px-4 py-8">
    <div class="max-w-3xl w-full bg-white rounded-xl shadow-lg p-8 border border-gray-200">
        <h1 class="text-3xl font-bold text-gray-800 mb-4">
            <?= htmlspecialchars($artikel['judul']); ?>
        </h1>
        <p class="text-gray-500 text-sm mb-6">
            Diposting pada: <?= date('d-m-Y', strtotime($artikel['tanggal'])); ?>
        </p>
        <?php if (!empty($artikel['gambar'])): ?>
            <img src="../uploads/<?= htmlspecialchars($artikel['gambar']); ?>" 
                 alt="Gambar Artikel" 
                 class="w-full max-h-96 object-cover rounded-lg mb-6 shadow">
        <?php endif; ?>
        <div class="prose max-w-none text-gray-700 leading-relaxed mb-6">
            <?= nl2br(htmlspecialchars($artikel['isi'])); ?>
        </div>
        <div class="flex justify-end">
            <a href="tips_kerja_artikel.php" 
               class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2 rounded-lg shadow-md transition-all duration-200">
               ← Kembali
            </a>
        </div>
    </div>
</body>
</html>
