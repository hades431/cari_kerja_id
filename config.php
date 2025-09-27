<?php
// config.php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "lowongan_kerja";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}

/**
 * Ambil jumlah lowongan milik perusahaan
 */
function getJumlahLowongan($id_perusahaan) {
    global $conn;
    $sql = "SELECT COUNT(*) as total FROM lowongan WHERE id_perusahaan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_perusahaan);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    return $res['total'] ?? 0;
}

/**
 * Ambil jumlah pelamar untuk perusahaan
 */
function getJumlahPelamar($id_perusahaan) {
    global $conn;
    $sql = "SELECT COUNT(*) as total 
            FROM lamaran l 
            JOIN lowongan lw ON l.id_lowongan = lw.id 
            WHERE lw.id_perusahaan = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_perusahaan);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    return $res['total'] ?? 0;
}

/**
 * Ambil jumlah pelamar berdasarkan status
 */
function getJumlahPelamarByStatus($id_perusahaan, $status) {
    global $conn;
    $sql = "SELECT COUNT(*) as total 
            FROM lamaran l 
            JOIN lowongan lw ON l.id_lowongan = lw.id 
            WHERE lw.id_perusahaan = ? AND l.status = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("is", $id_perusahaan, $status);
    $stmt->execute();
    $res = $stmt->get_result()->fetch_assoc();
    return $res['total'] ?? 0;
}

/**
 * Ambil daftar lowongan perusahaan
 */
function getLowonganPerusahaan($id_perusahaan) {
    global $conn;
    $sql = "SELECT * FROM lowongan WHERE id_perusahaan = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_perusahaan);
    $stmt->execute();
    $res = $stmt->get_result();

    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}

/**
 * Ambil daftar pelamar untuk perusahaan
 */
function getPelamarPerusahaan($id_perusahaan) {
    global $conn;
    $sql = "SELECT p.nama_lengkap, p.email, l.status, lw.judul AS lowongan, l.tanggal_lamaran
            FROM lamaran l
            JOIN pelamar_kerja p ON l.id_pelamar = p.id
            JOIN lowongan lw ON l.id_lowongan = lw.id
            WHERE lw.id_perusahaan = ?
            ORDER BY l.tanggal_lamaran DESC";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_perusahaan);
    $stmt->execute();
    $res = $stmt->get_result();

    $data = [];
    while ($row = $res->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}
