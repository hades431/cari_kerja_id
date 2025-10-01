<?php
if($_SESSION["status_akun"] !== "aktif" || $_SESSION["role"] !== "admin"){
  header("Location: ../../login/login.php");
  exit;
}