<?php
session_start();
include __DIR__ . "/../config.php";
// Ambil data perusahaan (contoh: dari session atau id login)
$id_perusahaan = $_SESSION["user"]["id"]; // Ganti dengan id perusahaan yang login
$data = [];
$res = $conn->query("SELECT * FROM perusahaan WHERE id_user='$id_perusahaan' LIMIT 1");
if ($res && $res->num_rows > 0) {
    $data = $res->fetch_assoc();
}

// === baru: tentukan logo_url untuk preview agar "disini" jelas ===
$existingLogo = $data['logo'] ?? '';
$logo_url = '';
if (!empty($existingLogo)) {
    if (preg_match('/^(https?:\/\/|\/|data:)/i', $existingLogo)) {
        $logo_url = $existingLogo;
    } else {
        // cek beberapa lokasi kemungkinan file
        $candidates = [
            __DIR__ . '/' . $existingLogo => $existingLogo,
            __DIR__ . '/../' . $existingLogo => '../' . $existingLogo,
            __DIR__ . '/img/' . basename($existingLogo) => 'img/' . basename($existingLogo),
            __DIR__ . '/../img/' . basename($existingLogo) => '../img/' . basename($existingLogo),
        ];
        foreach ($candidates as $path => $url) {
            if (file_exists($path)) {
                $logo_url = $url;
                break;
            }
        }
    }
}
// === end baru ===

// Proses update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_perusahaan = $_POST['nama_perusahaan'];
    $alamat = $_POST['alamat'];
    $email = $_POST['email_perusahaan'];
    $telepon = $_POST['telepon'];
    $website = $_POST['website'];
    $deskripsi = $_POST['deskripsi'];

    // Logo upload (opsional)
    $logo = $data['logo'] ?? '';
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $target = "../img/" . basename($_FILES['logo']['name']);
            if (!empty($logo) && file_exists($logo)) {
                unlink($logo);
            }
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target)) {
            $logo = $target;
        }
    }

    // Jalankan UPDATE
    $sql = "UPDATE perusahaan SET
        nama_perusahaan='$nama_perusahaan',
        alamat='$alamat',
        email_perusahaan='$email',
        no_telepon='$telepon',
        website='$website',
        deskripsi='$deskripsi',
        logo='$logo'
        WHERE id_user='$id_perusahaan'";

    if ($conn->query($sql) === TRUE) {
        header("Location: profile_perusahaan.php?success=1");
        exit;
    } else {
        echo "Error: " . $conn->error;
        exit;
    }
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
            <input type="email" name="email_perusahaan" value="<?= htmlspecialchars($data['email_perusahaan'] ?? '') ?>" class="w-full p-3 border rounded-lg" required>
        </div>
        <div>
            <label class="block font-semibold mb-1">Telepon</label>
            <input type="number" name="telepon" value="<?= htmlspecialchars($data['no_telepon'] ?? '') ?>" class="w-full p-3 border rounded-lg" required>
        </div>
        <div>
            <label class="block font-semibold mb-1">Website</label>
            <input type="text" name="website" value="<?= htmlspecialchars($data['website'] ?? '') ?>" class="w-full p-3 border rounded-lg">
        </div>
        <div>
            <label class="block font-semibold mb-1">Deskripsi</label>
            <textarea name="deskripsi" rows="4" class="w-full p-3 border rounded-lg" ><?= htmlspecialchars($data['deskripsi'] ?? '') ?></textarea>
        </div>
        <div>
            <label class="block font-semibold mb-1">Logo Perusahaan</label>
            <div>
                <img id="preview-crop" src="<?= !empty($logo_url) ? htmlspecialchars($logo_url) : '' ?>" alt="Preview Logo" <?= !empty($logo_url) ? 'style="display:block;"' : '' ?> >
            </div>
            <input type="file" name="logo" accept="image/*" class="w-full" id="logo-input">
            <div id="crop-info" class="text-sm text-gray-500 mt-2 <?= !empty($logo_url) ? '' : 'hidden' ?>">
                Disini maksudnya: area preview di atas akan menampilkan logo yang sudah ada atau yang baru dipilih. Pastikan foto berbentuk bulat dan proporsional; crop/resize sebelum upload jika perlu.
            </div>
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
            // non-blocking penjelasan: "disini" = preview area di atas
            info.textContent = 'Disini maksudnya: preview menunjukkan gambar yang akan diupload. Jika perlu, crop/resize sebelum submit.';
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
