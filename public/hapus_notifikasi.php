<?php
session_start();
header('Content-Type: application/json');

$id_pelamar = $_SESSION['id_pelamar'] ?? null;
if (!$id_pelamar) {
    http_response_code(401);
    echo json_encode(['success' => false, 'message' => 'Unauthorized']);
    exit;
}

$input_id = isset($_POST['id_notifikasi']) ? (int)$_POST['id_notifikasi'] : 0;
if ($input_id <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid id']);
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "lowongan_kerja");
if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'DB connection failed']);
    exit;
}

// verify notification belongs to this pelamar
$stmt = mysqli_prepare($conn, "SELECT id_notifikasi FROM notifikasi_lamaran WHERE id_notifikasi = ? AND id_pelamar = ? LIMIT 1");
if ($stmt) {
    mysqli_stmt_bind_param($stmt, "ii", $input_id, $id_pelamar);
    mysqli_stmt_execute($stmt);
    $res = mysqli_stmt_get_result($stmt);
    $found = $res && mysqli_num_rows($res) > 0;
    mysqli_stmt_close($stmt);
} else {
    $found = false;
}

if (!$found) {
    http_response_code(403);
    echo json_encode(['success' => false, 'message' => 'Not found or forbidden']);
    mysqli_close($conn);
    exit;
}

// delete notification
$del = mysqli_prepare($conn, "DELETE FROM notifikasi_lamaran WHERE id_notifikasi = ? AND id_pelamar = ? LIMIT 1");
if ($del) {
    mysqli_stmt_bind_param($del, "ii", $input_id, $id_pelamar);
    mysqli_stmt_execute($del);
    $ok = mysqli_stmt_affected_rows($del) > 0;
    mysqli_stmt_close($del);
} else {
    $ok = false;
}

mysqli_close($conn);

if ($ok) {
    echo json_encode(['success' => true]);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Delete failed']);
}
?>
