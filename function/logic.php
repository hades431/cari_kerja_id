<?php 

$koneksi = mysqli_connect("localhost","root","","lowongan_kerja");

if (mysqli_connect_errno()){

echo "Koneksi database gagal : " . mysqli_connect_error(); 
}



?>