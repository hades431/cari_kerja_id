<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

include '../../function/logic.php'; 
include '../../function/sesi_role_aktif_admin.php';

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID artikel tidak ditemukan!");
}

$query = "SELECT * FROM artikel WHERE id = ?";
$stmt = mysqli_prepare($conn, $query);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);
$artikel = mysqli_fetch_assoc($result);

if (!$artikel) {
    die("Artikel tidak ditemukan!");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $judul = $_POST['judul'];
    $isi   = $_POST['isi'];
    $query = "UPDATE artikel SET judul = ?, isi = ?";


    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../../uploads/";
        $fileName = time() . "_" . basename($_FILES["gambar"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
            $query .= ", gambar = ?";
            $gambarBaru = $fileName;
        }
    }

    $query .= " WHERE id = ?";
      if (isset($gambarBaru)) {
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "sssi", $judul, $isi, $gambarBaru, $id);
    } else {
        $stmt = mysqli_prepare($conn, $query);
        mysqli_stmt_bind_param($stmt, "ssi", $judul, $isi, $id);
    }

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['success'] = "Artikel berhasil diperbarui!";
        header("Location: tips_kerja_artikel.php");
        exit;
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white shadow-lg rounded-lg p-8 w-[600px]">
        <h2 class="text-2xl font-bold mb-6 text-gray-700">Edit Artikel</h2>
        <form method="post" enctype="multipart/form-data" class="space-y-4">
            <div>
                <label class="block text-sm font-medium mb-1">Judul Artikel</label>
                <input type="text" name="judul" value="<?= htmlspecialchars($artikel['judul']); ?>"
                       class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Isi Artikel</label>
                <textarea name="isi" rows="6"
                          class="w-full border px-4 py-2 rounded-lg focus:ring-2 focus:ring-teal-500"><?= htmlspecialchars($artikel['isi']); ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium mb-1">Gambar (opsional)</label>
                <?php if (!empty($artikel['gambar'])): ?>
                    <img src="../../uploads/<?= htmlspecialchars($artikel['gambar']); ?>" alt="Gambar Artikel" class="w-32 h-32 object-cover mb-2 rounded-lg border">
                <?php endif; ?>
                <input type="file" name="gambar" class="block w-full text-sm text-gray-500">
            </div>
            <div class="flex justify-end gap-3">
                <a href="tips_kerja_artikel.php" class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">Batal</a>
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
