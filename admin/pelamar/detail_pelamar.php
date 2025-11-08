<?php
include '../../function/logic.php';

if (!isset($_GET['id'])) {
    header("Location: detail_pelamar.php");
    exit;
}

$id = intval($_GET['id']);
$query = mysqli_query($conn, "SELECT * FROM pelamar_kerja WHERE id='$id'");
$pelamar = mysqli_fetch_assoc($query);

if (!$pelamar) {
    $_SESSION['error'] = "Data pelamar tidak ditemukan!";
    header("Location: detail_pelamar.php");
    exit;
}


// ambil pengalaman kerja
$pengalaman = mysqli_query($conn, "SELECT * FROM pengalaman_kerja WHERE id_pelamar='$id'");

// ambil keahlian
$keahlian = mysqli_query($conn, "SELECT * FROM keahlian WHERE id_pelamar='$id'");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Pelamar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen px-6 py-10">

    <div class="max-w-4xl mx-auto bg-white rounded-lg shadow-md p-6">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Detail Pelamar</h2>

        <div class="grid grid-cols-2 gap-4">
            <p><span class="font-semibold">Nama:</span> <?= htmlspecialchars($pelamar['nama_lengkap']); ?></p>
            <p><span class="font-semibold">Email:</span> <?= htmlspecialchars($pelamar['email']); ?></p>
            <p><span class="font-semibold">No. HP:</span> <?= htmlspecialchars($pelamar['no_hp']); ?></p>
            <p><span class="font-semibold">Alamat:</span> <?= htmlspecialchars($pelamar['alamat']); ?></p>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold text-lg">Deskripsi Diri</h3>
            <p class="text-gray-700"><?= nl2br(htmlspecialchars($pelamar['deskripsi'] ?? 'Belum ada deskripsi.')); ?></p>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold text-lg">Pengalaman Kerja</h3>
            <?php if (mysqli_num_rows($pengalaman) > 0): ?>
                <ul class="list-disc ml-5">
                    <?php while ($exp = mysqli_fetch_assoc($pengalaman)): ?>
                        <li><?= htmlspecialchars($exp['nama_perusahaan']); ?> - <?= htmlspecialchars($exp['jabatan']); ?> (<?= $exp['tahun_mulai']; ?> - <?= $exp['tahun_selesai']; ?>)</li>
                    <?php endwhile; ?>
                </ul>
            <?php else: ?>
                <p class="text-gray-600">Belum ada pengalaman kerja.</p>
            <?php endif; ?>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold text-lg">Keahlian</h3>
            <?php if (mysqli_num_rows($keahlian) > 0): ?>
                <div class="flex flex-wrap gap-2">
                    <?php while ($skill = mysqli_fetch_assoc($keahlian)): ?>
                        <span class="bg-teal-100 text-teal-800 px-3 py-1 rounded-full"><?= htmlspecialchars($skill['nama_keahlian']); ?></span>
                    <?php endwhile; ?>
                </div>
            <?php else: ?>
                <p class="text-gray-600">Belum ada keahlian.</p>
            <?php endif; ?>
        </div>

        <div class="mt-6">
            <h3 class="font-semibold text-lg">Curriculum Vitae (CV)</h3>
            <?php if (!empty($pelamar['cv'])): ?>
                <a href="../../uploads/<?= htmlspecialchars($pelamar['cv']); ?>" target="_blank" class="text-blue-600 hover:underline">Lihat CV</a>
            <?php else: ?>
                <p class="text-gray-600">Belum upload CV.</p>
            <?php endif; ?>
        </div>

        <div class="mt-8 text-right">
            <a href="detail_pelamar.php" class="bg-gray-300 hover:bg-gray-400 text-gray-800 px-4 py-2 rounded">Kembali</a>
        </div>
    </div>

</body>
</html>
