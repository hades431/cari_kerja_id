<?php
if($_SESSION["status_akun"] !== "aktif" || $_SESSION["role"] !== "Admin"){
  header("Location: ../../login/login.php");
  exit;
}