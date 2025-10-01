<?php
session_start();
include '../../function/logic.php'; 
include '../../function/sesi_role_aktif_admin.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']); 
    $result = mysqli_query($conn, "SELECT gambar FROM artikel WHERE id='$id'");
    $artikel = mysqli_fetch_assoc($result);

    if ($artikel) {
        $delete = mysqli_query($conn, "DELETE FROM artikel WHERE id='$id'");

        if ($delete) {
            if (!empty($artikel['gambar'])) {
                $filePath = "../../img/" . $artikel['gambar'];
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
header("Location: tips_kerja_artikel.php");
exit;
?>
