<?php
include __DIR__ . "/../config.php";
// Ambil data perusahaan (contoh: dari session atau id login)
$id_perusahaan = 1; // Ganti dengan id perusahaan yang login
$data = [];
$res = $conn->query("SELECT * FROM perusahaan WHERE id_perusahaan='$id_perusahaan' LIMIT 1");
if ($res && $res->num_rows > 0) {
    $data = $res->fetch_assoc();
}

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email_perusahaan'];
    $telepon = $_POST['no_telepon'];
    $deskripsi = $_POST['deskripsi'];
}
    // Logo upload (opsional)
   $logo = $data['logo'] ?? '';
if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
    $target = "../img/" . basename($_FILES['logo']['name']);
    if (move_uploaded_file($_FILES['logo']['tmp_name'], $target)) {
        $logo = $target;
    }
}

  $sql = "UPDATE perusahaan SET
    nama_perusahaan='$nama_perusahaan',
    alamat='$alamat',
    email_perusahaan='$email',
    no_telepon='$telepon',
    deskripsi='$deskripsi',
    logo='$logo'
    WHERE id_perusahaan='$id_perusahaan'";

if ($conn->query($sql) === TRUE) {
    header("Location: profile_perusahaan.php?success=1");
    exit;
} else {
    echo "Error: " . $conn->error;
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil Perusahaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
      /* Cropper preview style */
      #preview-crop {
        width: 120px;
        height: 120px;
        border-radius: 9999px;
        object-fit: cover;
        border: 2px solid #009fa3;
        margin-bottom: 10px;
        display: none;
      }
    </style>
</head>
<body class="bg-gray-100">
<div class="max-w-xl mx-auto mt-10 bg-white p-8 rounded-xl shadow">
    <h1 class="text-2xl font-bold mb-6 text-[#009fa3]">Edit Profil Perusahaan</h1>
    <?php if (isset($_GET['success'])): ?>
        <div class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg font-semibold">
            Profil berhasil diperbarui!
        </div>
    <?php endif; ?>
    <form method="POST" enctype="multipart/form-data" class="space-y-5" id="form-edit-profile">
        <div>
            <label class="block font-semibold mb-1">Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" value="<?= htmlspecialchars($data['nama_perusahaan'] ?? '') ?>" class="w-full p-3 border rounded-lg" required>
        </div>
        <div>
            <label class="block font-semibold mb-1">Alamat</label>
            <input type="text" name="alamat" value="<?= htmlspecialchars($data['alamat'] ?? '') ?>" class="w-full p-3 border rounded-lg" required>
        </div>
        <div>
            <label class="block font-semibold mb-1">Email</label>
            <input type="email" name="email_perusahaan" value="<?= htmlspecialchars($data['email'] ?? '') ?>" class="w-full p-3 border rounded-lg" required>
        </div>
        <div>
            <label class="block font-semibold mb-1">Telepon</label>
            <input type="text" name="telepon" value="<?= htmlspecialchars($data['telepon'] ?? '') ?>" class="w-full p-3 border rounded-lg" required>
        </div>
        <div>
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="w-full p-3 border rounded-lg" required><?= htmlspecialchars($data['deskripsi'] ?? '') ?></textarea>
        </div>
        <div>
            <label class="block font-semibold mb-1">Logo Perusahaan</label>
            <div>
                <img id="preview-crop" src="<?= !empty($data['logo']) ? htmlspecialchars($data['logo']) : '' ?>" alt="Preview Logo">
            </div>
            <input type="file" name="logo" accept="image/*" class="w-full" id="logo-input">
            <div id="crop-info" class="text-sm text-gray-500 mt-2 hidden">Pastikan foto berbentuk bulat dan ukuran proporsional. Crop preview di bawah.</div>
        </div>
        <div class="flex justify-between mt-6">
            <a href="profile_perusahaan.php" class="px-6 py-2 bg-gray-300 text-gray-800 rounded-lg font-semibold hover:bg-gray-400">Kembali</a>
            <button type="submit" class="px-6 py-2 bg-[#009fa3] text-white rounded-lg font-bold hover:bg-[#00b6b9]">Simpan</button>
        </div>
    </form>
</div>
<script>
document.getElementById('logo-input').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const preview = document.getElementById('preview-crop');
    const info = document.getElementById('crop-info');
    if (file) {
        const reader = new FileReader();
        reader.onload = function(ev) {
            preview.src = ev.target.result;
            preview.style.display = 'block';
            info.classList.remove('hidden');
            alert('Pastikan foto yang diupload berbentuk bulat dan proporsional. Jika belum, crop/resize terlebih dahulu sebelum upload.');
        };
        reader.readAsDataURL(file);
    } else {
        preview.style.display = 'none';
        info.classList.add('hidden');
    }
});
</script>
</body>
</html>
