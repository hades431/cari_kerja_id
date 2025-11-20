<?php
$id_perushaan = $_SESSION['user']['id_perusahaan'];
$exp  = tampil("SELECT*FROM perusahaan WHERE id_perusahaan=$id_perushaan")[0];
if(date('Y-m-d') >= $exp["Expire"] && $exp["verifikasi"] != "expire"){
    echo "expired";
    $sql = "UPDATE perusahaan SET verifikasi='expire', Lowogan_post=0 WHERE id_perusahaan=$exp[id_perusahaan]";
    $sql_hapus_lowongan = "DELETE FROM lowongan WHERE id_perusahaan=$exp[id_perusahaan]";
    mysqli_query($conn, $sql);
    mysqli_query($conn, $sql_hapus_lowongan);
    header("LOCATION: ../perusahaan/expire.php");
}