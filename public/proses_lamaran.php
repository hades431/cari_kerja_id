<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "lowongan_kerja");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Ambil id pelamar dari session / database (perbaikan)
$id_user = $_SESSION['id_user'] ?? null;

// jika tidak ada id_user dan tidak ada id_pelamar di session -> minta login
if (!$id_user && empty($_SESSION['id_pelamar'])) {
    header("Location: login_pelamar.php");
    exit;
}

// prioritas ambil dari session jika sudah ada
$id_pelamar = $_SESSION['id_pelamar'] ?? null;

if (!$id_pelamar && $id_user) {
    // gunakan prepared statement untuk mencari id_pelamar berdasarkan id_user
    $stmt = mysqli_prepare($conn, "SELECT id_pelamar FROM pelamar_kerja WHERE id_user = ? LIMIT 1");
    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'i', $id_user);
        mysqli_stmt_execute($stmt);
        mysqli_stmt_bind_result($stmt, $fetched_id_pelamar);
        if (mysqli_stmt_fetch($stmt)) {
            $id_pelamar = $fetched_id_pelamar;
            $_SESSION['id_pelamar'] = $id_pelamar; // simpan untuk reuse
        }
        mysqli_stmt_close($stmt);
    }
}

// Kalau masih belum ada id_pelamar, arahkan user untuk melengkapi profil pelamar
if (!$id_pelamar) {
    // ganti lokasi ini ke halaman profil pelamar atau pembuatan data pelamar sesuai aplikasi Anda
    header("Location: profil_pelamar.php?msg=lengkapi_profil");
    exit;
}

// Ambil id lowongan dari POST
$id_lowongan = $_POST['id_lowongan'] ?? null;
if (!$id_lowongan) {
    die("Error: ID lowongan tidak ditemukan.");
}

// Ambil data dari form
$nama_pelamar = $_POST['nama_pelamar'] ?? '';
$email = $_POST['email'] ?? '';
$no_hp = $_POST['no_hp'] ?? '';
$tanggal_lamar = date('Y-m-d');

// Upload CV
$cv_name = null;
if (isset($_FILES['cv']) && $_FILES['cv']['error'] == 0) {
    $cv_tmp = $_FILES['cv']['tmp_name'];
    $cv_name = time() . "_" . basename($_FILES['cv']['name']);
    $upload_path = "../uploads/cv/" . $cv_name;

    if (!is_dir("../uploads/cv")) {
        mkdir("../uploads/cv", 0777, true);
    }

    move_uploaded_file($cv_tmp, $upload_path);
}

// Insert data lamaran
$query = "INSERT INTO lamaran (id_lowongan, id_pelamar, tanggal_lamar, status_lamaran)
          VALUES ('$id_lowongan', '$id_pelamar', '$tanggal_lamar', 'di proses')";
$result = mysqli_query($conn, $query);

if ($result) {
    header("Location: lamaran_berhasil.php");
    exit;
} else {
    echo "Gagal menyimpan lamaran: " . mysqli_error($conn);
}
?>
