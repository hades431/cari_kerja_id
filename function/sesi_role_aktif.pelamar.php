<?php
if($_SESSION["status_akun"] !== "aktif"){
  session_destroy();
  header("Location: ../login/login.php?pesan=0");
  exit;
}