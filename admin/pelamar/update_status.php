<?php
include '../../function/logic.php';


$conn = mysqli_connect("localhost", "root", "", "lowongan_kerja");

$id = $_GET['id'];
$status = $_GET['status'];

$sql = "UPDATE user SET status_akun='$status' WHERE id_user=$id";
mysqli_query($conn, $sql);

header("Location: pelamar.php");
exit;
?>
