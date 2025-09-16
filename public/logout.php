<?php
session_start();
// Hapus semua session
session_unset();
session_destroy();
// Redirect ke landing page
header('Location: ../landing/landing_page.php');
exit;
