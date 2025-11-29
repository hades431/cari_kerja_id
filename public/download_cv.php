<?php
session_start();
if (!isset($_SESSION['user']['id'])) {
    header('Location: ../login/login.php');
    exit;
}

if (empty($_GET['file'])) {
    http_response_code(400);
    echo 'File tidak ditentukan.';
    exit;
}

$filename = basename($_GET['file']);
$uploads_dir = realpath(__DIR__ . '/../uploads');
$filepath = realpath($uploads_dir . DIRECTORY_SEPARATOR . $filename);

if (!$filepath || strpos($filepath, $uploads_dir) !== 0 || !is_file($filepath)) {
    http_response_code(404);
    echo 'File tidak ditemukan.';
    exit;
}

$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $filepath);
finfo_close($finfo);
if (!$mime) $mime = 'application/octet-stream';

header('Content-Description: File Transfer');
header('Content-Type: ' . $mime);
header('Content-Disposition: attachment; filename="' . $filename . '"');
header('Content-Length: ' . filesize($filepath));
header('Pragma: public');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');

readfile($filepath);
exit;
?>
