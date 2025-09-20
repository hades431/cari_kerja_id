<?php
include '../function/logic.php';

function register($data){
    global $conn;
$username = $_POST['username'];
$email = $_POST['email'];
$password = $_POST['password'];
$result = mysqli_query($conn,"SELECT*FROM user WHERE email = '$email' ");
$konfirm = $_POST['konfirmasi_password'];
if($password != $konfirm){
            echo "<script>alert('Password dan Confirm Password tidak sama!');</script>";
    return false;
}
if(mysqli_num_rows($result) > 0){
    echo "<script>alert('email sudah di pakai');</script>";
    return false;
}
if($password <= 7){
    header("location: ../login/register.php?error=password");
    return false;
}
$passwordhash = password_hash($password,PASSWORD_DEFAULT);
$query_insert = "INSERT INTO user (username,email,password,role,status_akun) VALUES('$username','$email','$passwordhash','pelamar','aktif')";
mysqli_query($conn,$query_insert);
return mysqli_affected_rows($conn);
}

?>