<?php
session_start();
header('Content-Type: application/json; charset=utf-8');

$id_pelamar = $_SESSION['id_pelamar'] ?? null;
if (!$id_pelamar) {
    http_response_code(403);
    echo json_encode(['success' => false, 'error' => 'Tidak terautentikasi']);
    exit;
}

$id_notifikasi = isset($_POST['id_notifikasi']) ? (int)$_POST['id_notifikasi'] : 0;
if ($id_notifikasi <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'error' => 'ID notifikasi tidak valid']);
    exit;
}

$conn = mysqli_connect("localhost", "root", "", "lowongan_kerja");
if (!$conn) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Koneksi DB gagal']);
    exit;
}

// Hapus hanya jika notifikasi milik pelamar ini
$stmt = mysqli_prepare($conn, "DELETE FROM notifikasi_lamaran WHERE id_notifikasi = ? AND id_pelamar = ? LIMIT 1");
if (!$stmt) {
    mysqli_close($conn);
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Gagal menyiapkan query']);
    exit;
}
mysqli_stmt_bind_param($stmt, "ii", $id_notifikasi, $id_pelamar);
mysqli_stmt_execute($stmt);
$affected = mysqli_stmt_affected_rows($stmt);
mysqli_stmt_close($stmt);
mysqli_close($conn);

if ($affected > 0) {
    echo json_encode(['success' => true]);
} else {
    // mungkin tidak ditemukan / bukan milik pelamar
    http_response_code(404);
    echo json_encode(['success' => false, 'error' => 'Notifikasi tidak ditemukan atau bukan milik Anda']);
}
?>
