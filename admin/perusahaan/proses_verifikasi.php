<?php
include '../../function/logic.php';

if (isset($_POST['aksi']) && isset($_POST['id'])) {
    $id = $_POST['id'];
    $aksi = $_POST['aksi'] === 'setujui' ? 'aktif' : 'ditolak';
    $update = "UPDATE perusahaan SET status='$aksi' WHERE id='$id'";
    mysqli_query($conn, $update);
    header("Location: perusahaan_menunggu.php");
    exit;
}

verifikasiPerusahaan($id, $aksi);

?>