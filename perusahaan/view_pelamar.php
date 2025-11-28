<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'Perusahaan') {
    header('Location: ../login/login.php');
    exit;
}

include '../header.php';

$koneksi = new mysqli("localhost", "root", "", "lowongan_kerja");
if ($koneksi->connect_error) {
    die("Koneksi gagal: " . $koneksi->connect_error);
}

// ambil id_user perusahaan
$user_id = $_SESSION['id_user'] ?? 0;
$id_perusahaan = 0;
$stmt = $koneksi->prepare("SELECT id_perusahaan FROM perusahaan WHERE id_user = ? LIMIT 1");
if ($stmt) {
    $stmt->bind_param('i', $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res && $row = $res->fetch_assoc()) {
        $id_perusahaan = (int)$row['id_perusahaan'];
    }
    $stmt->close();
}

$id_pelamar = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($id_pelamar <= 0 || $id_perusahaan <= 0) {
    echo "Data tidak valid.";
    exit;
}

// pastikan pelamar pernah melamar ke salah satu lowongan milik perusahaan ini
$stmt = $koneksi->prepare("
    SELECT COUNT(*) AS cnt
    FROM lamaran lam
    JOIN lowongan l ON lam.id_lowongan = l.id_lowongan
    WHERE lam.id_pelamar = ? AND l.id_perusahaan = ?
");
$stmt->bind_param('ii', $id_pelamar, $id_perusahaan);
$stmt->execute();
$res = $stmt->get_result();
$allow = false;
if ($res && $r = $res->fetch_assoc()) {
    $allow = ($r['cnt'] > 0);
}
$stmt->close();

if (!$allow) {
    echo "Anda tidak memiliki izin untuk melihat profil pelamar ini.";
    exit;
}

// ambil data pelamar
$stmt = $koneksi->prepare("
    SELECT pk.*, u.email
    FROM pelamar_kerja pk
    LEFT JOIN user u ON pk.id_user = u.id_user
    WHERE pk.id_pelamar = ? LIMIT 1
");
$stmt->bind_param('i', $id_pelamar);
$stmt->execute();
$res = $stmt->get_result();
$pelamar = $res ? $res->fetch_assoc() : null;
$stmt->close();

if (!$pelamar) {
    echo "Profil pelamar tidak ditemukan.";
    exit;
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

// Ambil daftar lamaran pelamar untuk perusahaan ini
// GANTI: ambil hanya 1 (terbaru) agar hanya tampil satu kontrol ubah status per profil
$lamaran = null;
$stmt = $koneksi->prepare("
    SELECT lam.id_lamaran, l.posisi, lam.tanggal_lamar, lam.status_lamaran
    FROM lamaran lam
    JOIN lowongan l ON lam.id_lowongan = l.id_lowongan
    WHERE lam.id_pelamar = ? AND l.id_perusahaan = ?
    ORDER BY lam.tanggal_lamar DESC
    LIMIT 1
");
if ($stmt) {
    $stmt->bind_param('ii', $id_pelamar, $id_perusahaan);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($res) {
        $lamaran = $res->fetch_assoc();
    }
    $stmt->close();
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Profil Pelamar</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
    .badge-proses {
        background-color: #bfdbfe;
        color: #1e3a8a;
    }

    .badge-terima {
        background-color: #bbf7d0;
        color: #065f46;
    }

    .badge-tolak {
        background-color: #fecaca;
        color: #7f1d1d;
    }
    </style>
</head>

<body class="bg-gray-100">

    <div class="max-w-5xl mx-auto py-10 px-4">
        <div class="max-w-4xl mt-4 px-4 flex justify-start">
            <a href="daftar_pelamar.php"
                class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition mb-4">
                <i class="fas fa-arrow-left mr-2"></i> Kembali
            </a>
        </div>

        <div class="bg-white rounded-2xl shadow-lg overflow-hidden">
            <div class="flex flex-col md:flex-row items-start md:items-center p-8 gap-8">

                <!-- Foto profil -->
                <div class="flex-shrink-0 w-full md:w-1/3 flex justify-center">
                    <img src="../<?= htmlspecialchars($pelamar['foto'] ?? 'assets/default-profile.png'); ?>"
                        alt="Foto Pelamar"
                        class="w-40 h-40 rounded-full border-4 border-[#00646A] shadow-md object-cover bg-white">
                </div>

                <!-- Informasi dasar -->
                <div class="flex-1">
                    <h2 class="text-2xl font-bold text-gray-800">
                        <?= htmlspecialchars($pelamar['nama_lengkap'] ?? '-'); ?></h2>
                    <p class="text-[#00646A] font-medium"><?= htmlspecialchars($pelamar['pendidikan'] ?? ''); ?></p>
                    <div class="mt-3 flex flex-col sm:flex-row sm:flex-wrap gap-3 text-sm text-gray-600">
                        <div><i
                                class="fa-solid fa-envelope mr-1 text-[#00646A]"></i><?= htmlspecialchars($pelamar['email'] ?? $pelamar['email_user'] ?? '-'); ?>
                        </div>
                        <div><i
                                class="fa-solid fa-phone mr-1 text-[#00646A]"></i><?= htmlspecialchars($pelamar['no_hp'] ?? '-'); ?>
                        </div>
                        <div><i
                                class="fa-solid fa-map-marker-alt mr-1 text-[#00646A]"></i><?= htmlspecialchars($pelamar['alamat'] ?? '-'); ?>
                        </div>
                    </div>
                </div>
            </div>

            <hr class="border-gray-200">

            <!-- Detail -->
            <div class="p-8 space-y-8">

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Keahlian</h3>

                    <!-- Keahlian Wajib -->
                    <div class="mb-4">
                        <div class="font-semibold text-sm text-gray-600 mb-2">Keahlian Wajib</div>
                        <?php if (!empty($keahlian_wajib)): ?>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($keahlian_wajib as $skill): ?>
                            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                <?= htmlspecialchars($skill); ?>
                            </span>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <p class="text-gray-500 text-sm">Belum ada keahlian wajib.</p>
                        <?php endif; ?>
                    </div>

                    <!-- Keahlian Tambahan -->
                    <div>
                        <div class="font-semibold text-sm text-gray-600 mb-2">Keahlian Tambahan</div>
                        <?php if (!empty($keahlian_tambahan)): ?>
                        <div class="flex flex-wrap gap-2">
                            <?php foreach ($keahlian_tambahan as $skill): ?>
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm">
                                <?= htmlspecialchars($skill); ?>
                            </span>
                            <?php endforeach; ?>
                        </div>
                        <?php else: ?>
                        <p class="text-gray-500 text-sm">Belum ada keahlian tambahan.</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Pengalaman Kerja</h3>
                    <?php
                        $exp_raw = trim($pelamar['pengalaman'] ?? '');
                        
                        if ($exp_raw === '') {
                            echo '<p class="text-gray-500 text-sm">Belum ada pengalaman kerja.</p>';
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
                                    echo '<p class="text-gray-500 text-sm">Belum ada pengalaman kerja.</p>';
                                }
                            } else {
                                // Fallback: tampilkan sebagai text biasa
                                echo '<div class="bg-gray-50 p-4 rounded text-gray-700 whitespace-pre-wrap">' . htmlspecialchars($exp_raw) . '</div>';
                            }
                        }
                    ?>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-gray-800 mb-2">Curriculum Vitae (CV)</h3>
                    <?php
        $cv_rel = trim($pelamar['cv'] ?? '');
        if ($cv_rel === '') {
            echo '<p class="text-gray-500 text-sm">Belum upload CV.</p>';
        } else {
            // candidate server paths
            $candidates = [
                __DIR__ . '/../' . $cv_rel,
                __DIR__ . '/../uploads/cv/' . basename($cv_rel),
                __DIR__ . '/../uploads/' . basename($cv_rel),
            ];
            $found = '';
            foreach ($candidates as $p) {
                if (file_exists($p)) { $found = $p; break; }
            }

            // Build web URL for the found file or fallback to original stored value
            if ($found) {
                $webPath = str_replace('\\', '/', substr($found, strlen(__DIR__ . '/../')));
                $cv_url = '../' . ltrim($webPath, '/');
            } else {
                $cv_url = (strpos($cv_rel, '../') === 0) ? $cv_rel : '../' . ltrim($cv_rel, '/');
            }

            echo '<div class="bg-gray-50 p-4 rounded">';
            echo '<div class="flex items-center justify-between mb-3">';
            echo '<div class="flex items-center gap-2 text-gray-700"><i class="fa-solid fa-file text-red-500 text-2xl"></i><span>' . htmlspecialchars(basename($cv_rel)) . '</span></div>';
            // Only show links; do NOT embed/preview file
            echo '<div class="flex gap-3">';
            echo '<a href="' . htmlspecialchars($cv_url) . '" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline"><i class="fa-solid fa-eye"></i> Buka</a>';
            echo '<a href="' . htmlspecialchars($cv_url) . '" download class="text-[#00646A] hover:underline"><i class="fa-solid fa-download"></i> Download</a>';
            echo '</div></div>';
            echo '</div>';
        }
        ?>
                </div>

                <!-- Tampilkan satu kontrol ubah status (latest lamaran) -->
                <?php if (!empty($lamaran)) { ?>
                <div class="bg-white rounded-lg shadow p-4">
                    <h3 class="text-md font-semibold text-gray-800 mb-3">Ubah Status Lamaran
                        <?= htmlspecialchars($lamaran['posisi']); ?></h3>
                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="text-sm text-gray-600">
                            Dikirim: <?= htmlspecialchars(date("d/m/Y", strtotime($lamaran['tanggal_lamar']))); ?>
                        </div>

                        <div class="flex items-center gap-3">
                            <div>
                                <?php
                $s = $lamaran['status_lamaran'];
                if ($s === 'di proses') {
                  echo '<span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700">Di Proses</span>';
                } elseif ($s === 'di terima') {
                  echo '<span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700">Di Terima</span>';
                } elseif ($s === 'di tolak') {
                  echo '<span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-700">Di Tolak</span>';
                } else {
                  echo '<span class="text-sm text-gray-600">' . htmlspecialchars($s) . '</span>';
                }
              ?>
                            </div>

                            <form method="post" action="update_status.php" class="flex items-center gap-2">
                                <input type="hidden" name="lamaran_id" value="<?= (int)$lamaran['id_lamaran']; ?>">
                                <input type="hidden" name="id_pelamar" value="<?= (int)$id_pelamar; ?>">
                                <input type="hidden" name="redirect"
                                    value="view_pelamar.php?id=<?= (int)$id_pelamar; ?>">
                                <select name="status" class="px-3 py-2 border rounded text-sm">
                                    <?php
                  $opts = ['di proses','di terima','di tolak'];
                  foreach ($opts as $opt) {
                      $sel = ($lamaran['status_lamaran'] === $opt) ? 'selected' : '';
                      echo '<option value="' . htmlspecialchars($opt) . '" ' . $sel . '>' . ucfirst(htmlspecialchars($opt)) . '</option>';
                  }
                ?>
                                </select>
                                <button type="submit"
                                    class="px-4 py-2 bg-[#00646A] text-white rounded text-sm">Simpan</button>
                            </form>
                        </div>

                    </div>
                </div>
                <?php } else { ?>
                <div class="text-gray-500">Belum ada lamaran terkait perusahaan Anda untuk pelamar ini.</div>
                <?php } ?>

            </div>
        </div>
    </div>

</body>

</html>