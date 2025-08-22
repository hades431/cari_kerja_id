<?php 
$server = "localhost";
$username = "root";
$password = "";
$database = "lowongan_kerja";
$conn = mysqli_connect($server, $username, $password, $database);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

function profilPelamar($nik) {
    global $conn;

    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $email = htmlspecialchars($_POST['email']);
    $no_hp = htmlspecialchars($_POST['no_hp']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $cv = upload();


    // masukkan data ke database dengan penanganan error
    $query = "INSERT INTO pengaduan VALUES ('','$nama_lengkap','$email','$no_hp','$alamat','$deskripsi','$cv','proses')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

function getTipsKerjaList() {
    $conn = new mysqli("localhost", "root", "", "lowongan_kerja");
    if ($conn->connect_error) {
        return [];
    }
    $sql = "SELECT id, judul, tanggal FROM tips_kerja ORDER BY tanggal DESC";
    $data = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $data[] = $row;
        }
    }
    $conn->close();
    return $data;
}


?>