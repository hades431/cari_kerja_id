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

// Tentukan MIME type
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $filepath);
finfo_close($finfo);
if (!$mime) $mime = 'application/octet-stream';

// Tampilkan inline (browser akan mencoba menampilkan PDF/preview)
header('Content-Type: ' . $mime);
header('Content-Disposition: inline; filename="' . $filename . '"');
header('Content-Length: ' . filesize($filepath));
header('Accept-Ranges: bytes');

readfile($filepath);
exit;
?>
