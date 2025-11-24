<?php
session_start();
include '../../function/logic.php';
include '../../function/sesi_role_aktif_admin.php';

if (!isset($_POST['id']) || !isset($_POST['role'])) {
    header("Location: pelamar.php?pesan=Role gagal diperbarui");
    exit;
}

$id = intval($_POST['id']);
$role = mysqli_real_escape_string($conn, $_POST['role']);

$query = "UPDATE user SET role='$role' WHERE id_user=$id";

if (mysqli_query($conn, $query)) {
    header("Location: pelamar.php?pesan=Role berhasil diubah");
} else {
    header("Location: pelamar.php?pesan=Gagal mengubah role");
}
exit;
?>
