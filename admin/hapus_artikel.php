<?php
session_start();
include '../function/logic.php'; // sudah ada koneksi $conn di sini kan?

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); // amankan input

    // Ambil data artikel untuk cek apakah ada gambar
    $result = mysqli_query($conn, "SELECT gambar FROM artikel WHERE id='$id'");
    $artikel = mysqli_fetch_assoc($result);

    if ($artikel) {
        // Hapus record dari database
        $delete = mysqli_query($conn, "DELETE FROM artikel WHERE id='$id'");

        if ($delete) {
            // Jika ada gambar, hapus file-nya juga
            if (!empty($artikel['gambar'])) {
                $filePath = "../img/" . $artikel['gambar'];
                if (file_exists($filePath)) {
                    unlink($filePath);
                }
            }

            $_SESSION['success'] = "Artikel berhasil dihapus ✅";
        } else {
            $_SESSION['error'] = "Gagal menghapus artikel ❌";
        }
    } else {
        $_SESSION['error'] = "Artikel tidak ditemukan!";
    }
}

// Balik lagi ke halaman daftar artikel
header("Location: tips_kerja_artikel.php");
exit;
?>
