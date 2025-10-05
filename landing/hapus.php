<?php 
$id = $_GET["id"];
function hapus_save($id) {
    global $conn;
    $query = "DELETE FROM save_lowongan WHERE save_lowongan_id = $id";
    mysqli_query($conn, $query);
    return mysqli_affected_rows($conn);
}
?>