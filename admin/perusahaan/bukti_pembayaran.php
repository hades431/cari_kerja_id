<?php
include '../../function/logic.php';
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if (!$id) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo 'Bukti pembayaran tidak ditemukan.';
    exit;
}
$stmt = $conn->prepare("SELECT bukti_pembayaran FROM perusahaan WHERE id_perusahaan = ? LIMIT 1");
$stmt->bind_param('i', $id);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();
$raw = $row['bukti_pembayaran'] ?? '';
if (empty($raw)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo 'Bukti pembayaran tidak tersedia.';
    exit;
}
$raw = trim($raw);
if (preg_match('#^https?://#i', $raw)) {
    header('Location: ' . $raw);
    exit;
}
$clean = preg_replace('#^(\./|\.\./|/)+#', '', $raw);
if (strpos($clean, 'uploads/') !== 0) {
    $clean = 'uploads/' . $clean;
}
$projectRoot = realpath(__DIR__ . '/../../');
$fsPath = realpath(__DIR__ . '/../../' . $clean);
if (!$fsPath || strpos($fsPath, $projectRoot) !== 0 || !file_exists($fsPath)) {
    header($_SERVER['SERVER_PROTOCOL'] . ' 404 Not Found');
    echo 'File bukti pembayaran tidak ditemukan di server.';
    exit;
}
$mime = mime_content_type($fsPath) ?: 'application/octet-stream';
$inlineTypes = ['image/jpeg','image/png','image/gif','image/webp','image/svg+xml','application/pdf'];
if (in_array($mime, $inlineTypes)) {
    header('Content-Type: ' . $mime);
    header('Content-Length: ' . filesize($fsPath));
    readfile($fsPath);
    exit;
} else {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="' . basename($fsPath) . '"');
    header('Content-Length: ' . filesize($fsPath));
    readfile($fsPath);
    exit;
}
?>