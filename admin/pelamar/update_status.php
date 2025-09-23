<?php
include '../../function/logic.php';
$conn = koneksi();
$id = $_GET['id'];
$status = $_GET['status'];
$sql = "UPDATE users SET status='$status' WHERE id=$id";
mysqli_query($conn, $sql);
header("Location: pelamar.php");
exit;