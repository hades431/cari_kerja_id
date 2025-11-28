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

// Pisahkan keahlian menjadi wajib dan tambahan
$required_predefined = ['HTML','CSS','JavaScript','PHP','MySQL','Laravel','Git'];
$additional_predefined = ['React','Node.js','UI/UX','Python'];

$keahlian_wajib = [];
$keahlian_tambahan = [];

if (!empty($pelamar['keahlian'])) {
    $skills = array_map('trim', explode(',', $pelamar['keahlian']));
    foreach ($skills as $skill) {
        if (in_array($skill, $required_predefined)) {
            $keahlian_wajib[] = $skill;
        } elseif (in_array($skill, $additional_predefined)) {
            $keahlian_tambahan[] = $skill;
        } else {
            // keahlian custom masuk ke tambahan
            $keahlian_tambahan[] = $skill;
        }
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
        <a href="pelamar.php" class="px-4 py-2 bg-teal-600 text-white rounded-lg shadow hover:bg-teal-700">
            Kembali
        </a>

        <?php if ($pelamar): ?>
        <div class="flex flex-col items-center text-center mb-8">
            <img src="<?= htmlspecialchars($fotoSrc) ?>" alt="Foto Pelamar"
                class="w-32 h-32 rounded-full object-cover border-4 border-teal-600 shadow-md mb-4">
            <h2 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($pelamar['nama_lengkap']); ?></h2>
            <p class="text-teal-700 font-medium mb-2"><?= htmlspecialchars($pelamar['jabatan'] ?? ''); ?></p>
            <div class="flex flex-wrap justify-center gap-4 text-gray-600 text-sm">
                <div class="flex items-center gap-2"><i
                        class='bx bx-envelope'></i><?= htmlspecialchars($pelamar['email']); ?></div>
                <div class="flex items-center gap-2"><i
                        class='bx bx-phone'></i><?= htmlspecialchars($pelamar['no_hp'] ?? '-'); ?></div>
                <div class="flex items-center gap-2"><i
                        class='bx bx-map'></i><?= htmlspecialchars($pelamar['alamat'] ?? '-'); ?></div>
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
                $exp_raw = trim($pelamar['pengalaman'] ?? '');
                
                if ($exp_raw === '') {
                    echo '<p class="text-gray-500 italic">Belum ada pengalaman kerja.</p>';
                } else {
                    // Coba parse sebagai JSON
                    $exp_data = json_decode($exp_raw, true);
                    
                    if (json_last_error() === JSON_ERROR_NONE && is_array($exp_data)) {
                        // Format JSON
                        $jabatan_list = $exp_data['jabatan'] ?? [];
                        $perusahaan_list = $exp_data['perusahaan'] ?? [];
                        $tahun_list = $exp_data['tahun'] ?? [];
                        
                        $count = max(count($jabatan_list), count($perusahaan_list), count($tahun_list));
                        
                        if ($count > 0) {
                            echo '<div class="space-y-3">';
                            for ($i = 0; $i < $count; $i++) {
                                $jab = isset($jabatan_list[$i]) ? trim($jabatan_list[$i]) : '';
                                $perusahaan = isset($perusahaan_list[$i]) ? trim($perusahaan_list[$i]) : '';
                                $tahun = isset($tahun_list[$i]) ? trim($tahun_list[$i]) : '';
                                
                                // Skip jika semua kosong
                                if ($jab === '' && $perusahaan === '' && $tahun === '') continue;
                                
                                echo '<div class="bg-gray-50 p-4 rounded-lg border border-gray-200">';
                                
                                if ($jab !== '') {
                                    echo '<div class="font-semibold text-gray-800">' . htmlspecialchars($jab) . '</div>';
                                }
                                
                                if ($perusahaan !== '') {
                                    echo '<div class="text-sm text-gray-600 mt-1">' . htmlspecialchars($perusahaan) . '</div>';
                                }
                                
                                if ($tahun !== '') {
                                    echo '<div class="text-xs text-gray-500 mt-2">' . htmlspecialchars($tahun) . '</div>';
                                }
                                
                                echo '</div>';
                            }
                            echo '</div>';
                        } else {
                            echo '<p class="text-gray-500 italic">Belum ada pengalaman kerja.</p>';
                        }
                    } else {
                        // Fallback: tampilkan sebagai text biasa
                        echo '<div class="bg-gray-50 p-4 rounded text-gray-700 whitespace-pre-wrap">' . htmlspecialchars($exp_raw) . '</div>';
                    }
                }
            ?>
        </div>


        <div class="mb-8">
            <h3 class="text-lg font-semibold text-gray-800 mb-3">Keahlian</h3>

            <!-- Keahlian Wajib -->
            <div class="mb-4">
                <div class="font-semibold text-sm text-gray-600 mb-2">Keahlian Wajib</div>
                <?php if (!empty($keahlian_wajib)): ?>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($keahlian_wajib as $skill): ?>
                    <span class="inline-block bg-green-100 text-green-700 text-sm px-3 py-1 rounded-full font-medium">
                        <?= htmlspecialchars($skill); ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p class="text-gray-500 italic text-sm">Belum menambahkan keahlian wajib.</p>
                <?php endif; ?>
            </div>

            <!-- Keahlian Tambahan -->
            <div>
                <div class="font-semibold text-sm text-gray-600 mb-2">Keahlian Tambahan</div>
                <?php if (!empty($keahlian_tambahan)): ?>
                <div class="flex flex-wrap gap-2">
                    <?php foreach ($keahlian_tambahan as $skill): ?>
                    <span class="inline-block bg-blue-100 text-blue-700 text-sm px-3 py-1 rounded-full">
                        <?= htmlspecialchars($skill); ?>
                    </span>
                    <?php endforeach; ?>
                </div>
                <?php else: ?>
                <p class="text-gray-500 italic text-sm">Belum menambahkan keahlian tambahan.</p>
                <?php endif; ?>
            </div>
        </div>

        <?php else: ?>
        <div class="text-center py-10 text-gray-600 italic">
            Data pelamar tidak ditemukan.
        </div>
        <?php endif; ?>
    </div>
</body>

</html>