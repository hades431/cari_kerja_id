<?php 
include '../function/logic.php';
$id = (int) $_GET["id_save"];
    $query = "DELETE FROM save_lowongan WHERE save_lowongan_id = $id";
    mysqli_query($conn, $query);
    header("LOCATION: landing_page.php?sukses=berhasil");
?>