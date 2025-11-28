<?php
session_start();
include "../function/logic.php";
if(!isset($_SESSION["user"])){
    header("LOCATION: ../login/login.php?error=Silahkan login terlebih dahulu");
    exit;
}
$id_lowongan = $_GET["id"];
$id_user = (int) $_SESSION["user"]["id"];
$stmt = $conn->prepare("SELECT 1 FROM save_lowongan WHERE user_id = ? AND lowongan_id = ? LIMIT 1");
$stmt->bind_param("ii", $id_user, $id_lowongan);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->close();
    header("LOCATION: card.php?id=$id_lowongan&error=Anda sudah menyimpan lowongan ini");
    exit;
}
$stmt->close();
$sql = "INSERT INTO save_lowongan (user_id,lowongan_id) VALUES ($id_user,$id_lowongan)";
mysqli_query($conn,$sql);
if(mysqli_affected_rows($conn) > 0){
    echo"<script>alert('Lowongan berhasil disimpan');window.location='landing_page.php'</script>";
    exit;
} else {
    echo"<script>alert('Gagal menyimpan lowongan');</script>";
    exit;
}