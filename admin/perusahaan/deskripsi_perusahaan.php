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

$logoSrc = '../../img/default_company.png';
if (!empty($data['logo'])) {
    $logoVal = trim($data['logo']);
    if (preg_match('#^https?://#i', $logoVal)) {
        $logoSrc = $logoVal;
    } else {
        $clean = preg_replace('#^(\./|\.\./|/)+#', '', $logoVal);
        $base = basename($clean);
        $candidates = [
            $clean,
            'uploads/'.$clean,
            'uploads/logo_perusahaan/'.$clean,
            'uploads/logo/'.$clean,
            'uploads/'.$base,
            'uploads/logo_perusahaan/'.$base,
            'uploads/logo/'.$base
        ];
        $projectRoot = realpath(__DIR__ . '/../../');
        foreach ($candidates as $cand) {
            $full = realpath(__DIR__ . '/../../' . $cand);
            if ($full && strpos($full, $projectRoot) === 0 && file_exists($full)) {
                $logoSrc = '../../' . $cand;
                break;
            }
        }
    }
}
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
            <img src="<?= htmlspecialchars($logoSrc) ?>" class="w-full h-full object-cover" alt="Logo <?= htmlspecialchars($data['nama_perusahaan']) ?>">
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
