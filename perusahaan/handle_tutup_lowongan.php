<?php
session_start();
if (!isset($_SESSION['login']) || $_SESSION['role'] !== 'Perusahaan') {
    header('Location: ../login/login.php');
    exit;
}

include __DIR__ . "/../config.php";

if (!isset($_GET['id']) || !isset($_GET['action'])) {
    header('Location: dashboard_perusahaan.php');
    exit;
}

$id_lowongan = intval($_GET['id']);
$action = $_GET['action'];
$user_id = $_SESSION["user"]["id"];

// Verifikasi bahwa lowongan milik perusahaan user yang login
$verify = $conn->query("SELECT l.id_lowongan FROM lowongan l 
                        JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan 
                        WHERE l.id_lowongan = $id_lowongan AND p.id_user = $user_id");

if (!$verify || $verify->num_rows === 0) {
    header('Location: dashboard_perusahaan.php');
    exit;
}

if ($action === 'close') {
    $conn->query("UPDATE lowongan SET status = 'ditutup' WHERE id_lowongan = $id_lowongan");
} elseif ($action === 'reopen') {
    $conn->query("UPDATE lowongan SET status = 'aktif' WHERE id_lowongan = $id_lowongan");
}

header('Location: dashboard_perusahaan.php');
exit;
?>
