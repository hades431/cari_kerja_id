<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "lowongan_kerja");

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$id_user = $_SESSION['id_user'] ?? null;
if (!$id_user) {
    header("Location: login_pelamar.php");
    exit;
}

$id_pelamar = null;
$get_pelamar = mysqli_query($conn, "SELECT id_pelamar FROM pelamar_kerja WHERE id_user='" . mysqli_real_escape_string($conn, $id_user) . "' LIMIT 1");
if ($get_pelamar && mysqli_num_rows($get_pelamar) > 0) {
    $row = mysqli_fetch_assoc($get_pelamar);
    $id_pelamar = $row['id_pelamar'];

    $_SESSION['id_pelamar'] = $id_pelamar;
} else {
    $ins = mysqli_query($conn, "INSERT INTO pelamar_kerja (id_user) VALUES ('" . mysqli_real_escape_string($conn, $id_user) . "')");
    if ($ins) {
        $id_pelamar = mysqli_insert_id($conn);
        $_SESSION['id_pelamar'] = $id_pelamar;
    } else {
        header("Location: lengkapi_profil_pelamar.php");
        exit;
    }
}


$id_lowongan = $_POST['id_lowongan'] ?? null;
if (!$id_lowongan) {
    die("Error: ID lowongan tidak ditemukan.");
}


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


$query = "INSERT INTO lamaran (id_lowongan, id_pelamar, tanggal_lamar, status_lamaran)
          VALUES ('$id_lowongan', '$id_pelamar', '$tanggal_lamar', 'di proses')";
$result = mysqli_query($conn, $query);

if ($result) {
    header("Location: riwayat_lamaran.php");
    exit;
} else {
    echo "Gagal menyimpan lamaran: " . mysqli_error($conn);
}
?>