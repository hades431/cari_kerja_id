<?php
session_start();
include '../../function/logic.php';

// Pastikan ID ada
if (!isset($_GET['id'])) {
    header("Location: lowongan_kerja.php?pesan=ID tidak ditemukan");
    exit;
}

$id = intval($_GET['id']); // aman dari injection

// Hapus dari tabel yang benar
$query = "DELETE FROM lowongan WHERE id_lowongan = $id";

if (mysqli_query($conn, $query)) {
    header("Location: lowongan_kerja.php?pesan=Berhasil menghapus");
} else {
    header("Location: lowongan_kerja.php?pesan=Gagal menghapus: " . mysqli_error($conn));
}
exit;
?>
