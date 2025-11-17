<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'Perusahaan') {
    header('Location: ../login/login.php');
    exit;
}

$koneksi = new mysqli("localhost", "root", "", "lowongan_kerja");
if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$user_id = $_SESSION['id_user'] ?? 0;
$id_perusahaan = 0;
$stmt = mysqli_prepare($koneksi, "SELECT id_perusahaan FROM perusahaan WHERE id_user = ? LIMIT 1");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "i", $user_id);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    if ($res && $r = mysqli_fetch_assoc($res)) {
        $id_perusahaan = (int)$r['id_perusahaan'];
    }
    mysqli_stmt_close($stmt);
}

$lamaran_id = isset($_POST['lamaran_id']) ? (int)$_POST['lamaran_id'] : 0;
$status = isset($_POST['status']) ? trim($_POST['status']) : '';
$id_pelamar_post = isset($_POST['id_pelamar']) ? (int)$_POST['id_pelamar'] : 0;
$redirect = isset($_POST['redirect']) ? $_POST['redirect'] : 'daftar_pelamar.php';

$allowed = ['di proses','di terima','di tolak'];
if ($lamaran_id <= 0 || !in_array($status, $allowed, true) || $id_perusahaan <= 0) {
    header("Location: " . $redirect);
    exit;
}

// Pastikan lamaran milik lowongan perusahaan ini dan ambil detail untuk notifikasi, termasuk status saat ini
$stmt = mysqli_prepare($koneksi, "
    SELECT lam.id_pelamar, lam.status_lamaran, l.posisi, p.nama_perusahaan
    FROM lamaran lam
    JOIN lowongan l ON lam.id_lowongan = l.id_lowongan
    JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan
    WHERE lam.id_lamaran = ? AND l.id_perusahaan = ?
    LIMIT 1
");
mysqli_stmt_bind_param($stmt, "ii", $lamaran_id, $id_perusahaan);
mysqli_stmt_execute($stmt);
$res = mysqli_stmt_get_result($stmt);
$lam = $res ? mysqli_fetch_assoc($res) : null;
mysqli_stmt_close($stmt);

if (!$lam) {
    header("Location: " . $redirect);
    exit;
}

// validate that the lamaran belongs to the pelamar passed from the profile form
if ($id_pelamar_post <= 0 || (int)$lam['id_pelamar'] !== $id_pelamar_post) {
    header("Location: " . $redirect);
    exit;
}

// If status is unchanged, do nothing
$current_status = $lam['status_lamaran'] ?? '';
if ($current_status === $status) {
    header("Location: " . $redirect);
    exit;
}

// Update status (only when different)
$upd = mysqli_prepare($koneksi, "UPDATE lamaran SET status_lamaran = ? WHERE id_lamaran = ?");
if ($upd) {
    mysqli_stmt_bind_param($upd, "si", $status, $lamaran_id);
    mysqli_stmt_execute($upd);
    mysqli_stmt_close($upd);
}

// Buat tabel notifikasi jika belum ada (gunakan nama notifikasi_lamaran)
$create_sql = "
    CREATE TABLE IF NOT EXISTS notifikasi_lamaran (
        id_notifikasi INT AUTO_INCREMENT PRIMARY KEY,
        id_pelamar INT NOT NULL,
        id_lamaran INT NOT NULL,
        pesan TEXT NOT NULL,
        is_read TINYINT(1) NOT NULL DEFAULT 0,
        created_at DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
";
mysqli_query($koneksi, $create_sql);

// Pastikan kolom-kolom penting ada (jika tabel lama berbeda schema)
$required = [
    'id_pelamar'   => "INT NOT NULL",
    'id_lamaran'   => "INT NOT NULL",
    'pesan'        => "TEXT NOT NULL",
    'is_read'      => "TINYINT(1) NOT NULL DEFAULT 0",
    'created_at'   => "DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP"
];

foreach ($required as $col => $def) {
    $check = mysqli_query($koneksi, "SHOW COLUMNS FROM notifikasi_lamaran LIKE '" . mysqli_real_escape_string($koneksi, $col) . "'");
    if ($check && mysqli_num_rows($check) === 0) {
        // Add missing column; placing it at the end of the table
        $alter_sql = "ALTER TABLE notifikasi_lamaran ADD COLUMN `$col` $def";
        if (!mysqli_query($koneksi, $alter_sql)) {
            error_log("Gagal menambahkan kolom $col pada tabel notifikasi_lamaran: " . mysqli_error($koneksi));
        }
    }
}

// Insert notifikasi untuk pelamar (escaped) — only when status changed
$id_pelamar = (int)$lam['id_pelamar'];
$posisi = $lam['posisi'] ?? '';
$nama_perusahaan = $lam['nama_perusahaan'] ?? 'Perusahaan';
$pesan = "Lamaran Anda pada Perusahaan '" . $nama_perusahaan . "' telah " . $status . ".";

$pesan_esc = mysqli_real_escape_string($koneksi, $pesan);
$ins_sql = "INSERT INTO notifikasi_lamaran (id_pelamar, id_lamaran, pesan) VALUES ($id_pelamar, $lamaran_id, '$pesan_esc')";
if (!mysqli_query($koneksi, $ins_sql)) {
    error_log("Gagal insert notifikasi_lamaran: " . mysqli_error($koneksi));
}

header("Location: " . $redirect);
exit;
?>
