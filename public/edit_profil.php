<?php
session_start();
require_once '../function/logic.php';

$id_user = $_SESSION['user']['id'];
// Ambil data profil user dari database
$pelamar = getProfilPelamarByUserId($id_user);

// Insert data pelamar jika belum ada
if (!$pelamar) {
    // Minimal insert id_user, field lain bisa NULL/default
    $conn = mysqli_connect("localhost","root","","lowongan_kerja");
    $stmt = $conn->prepare("INSERT INTO pelamar_kerja (id_user) VALUES (?)");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->close();
    // Ambil ulang data pelamar
    $pelamar = getProfilPelamarByUserId($id_user);
}

if (isset($_POST['submit'])) {
    // Filter hanya field yang diisi/diedit
    $data_update = [];
    foreach ($_POST as $key => $value) {
        if ($key === 'submit') continue;
        // Untuk array (misal pengalaman, keahlian), cek jika ada isian
        if (is_array($value)) {
            $filtered = array_filter($value, function($v) {
                return trim($v) !== '';
            });
            if (!empty($filtered)) {
                $data_update[$key] = $filtered;
            }
        } else {
            if (trim($value) !== '') {
                $data_update[$key] = $value;
            }
        }
    }
    // Cek file upload
    $files_update = [];
    foreach ($_FILES as $key => $file) {
        if (isset($file['name']) && $file['name'] !== '') {
            $files_update[$key] = $file;
        }
    }
    // Tetap lakukan update walaupun hanya satu field yang diisi
    if (!empty($data_update) || !empty($files_update)) {
        if (updateProfilPelamar($id_user, $data_update, $files_update) > 0) {
            echo "<script>
                    alert('Berhasil edit profil');
                    document.location.href = 'profil_pelamar.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal edit profil');
                  </script>";
        }
    } else {
        echo "<script>
                alert('Tidak ada perubahan yang disimpan');
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - CariKerja.id</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#00646A] min-h-screen">
    <div class="max-w-2xl mx-auto mt-12 bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Profil</h2>
        <form action="#" method="post" enctype="multipart/form-data" class="space-y-5">
            <!-- Foto Profil -->
            <div class="flex flex-col items-center">
                <img src="<?= isset($pelamar['foto']) && $pelamar['foto'] ? '../' . htmlspecialchars($pelamar['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($pelamar['nama_lengkap'] ?? 'Nama Pelamar') . '&background=2563eb&color=fff&size=128' ?>"
                     class="w-24 h-24 rounded-full border-2 border-gray-200 object-cover mb-2" alt="Foto Profil">
                <label class="block">
                    <span class="sr-only">Pilih Foto Profil</span>
                    <input type="file" name="foto" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100
                    "/>
                </label>
            </div>
            <!-- Nama -->
            <div>
                <label for="nama_lengkap" class="block text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($pelamar['nama_lengkap'] ?? '') ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Nama Lengkap">
            </div>
            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($pelamar['email'] ?? '') ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Email">
            </div>
            <!-- Telepon -->
            <div>
                <label for="telepon" class="block text-gray-700 mb-1">Telepon</label>
                <input type="text" name="telepon" value="<?= htmlspecialchars($pelamar['no_hp'] ?? '') ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Nomor Telepon">
            </div>
            <!-- Jabatan -->
            <div>
                <label for="jabatan" class="block text-gray-700 mb-1">Kemampuan Bidang</label>
                <input type="text" name="jabatan" value="<?= htmlspecialchars($pelamar['jabatan'] ?? '') ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Contoh: UI/UX Designer">
            </div>
            <!-- Lokasi -->
            <div>
                <label for="alamat" class="block text-gray-700 mb-1">Alamat</label>
                <input type="text" name="alamat" value="<?= htmlspecialchars($pelamar['alamat'] ?? '') ?>" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Contoh: Bandung, Indonesia">
            </div>
            <!-- Deskripsi Profil -->
            <div>
                <label for="deskripsi" class="block text-gray-700 mb-1">Deskripsi Profil</label>
                <textarea name="deskripsi" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Ceritakan tentang diri Anda..."><?= htmlspecialchars($pelamar['deskripsi'] ?? '') ?></textarea>
            </div>
            <!-- Pengalaman Kerja -->
            <div>
                <label class="block text-gray-700 mb-1">Pengalaman Kerja</label>
                <div class="space-y-3">
                    <div class="flex flex-col md:flex-row gap-2">
                        <input type="text" name="pengalaman_jabatan[]" class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Jabatan/Posisi">
                        <input type="text" name="pengalaman_perusahaan[]" class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Perusahaan">
                        <input type="text" name="pengalaman_tahun[]" class="md:w-40 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Tahun">
                    </div>
                    <!-- Tambah pengalaman lain dengan menambah input di sisi backend/JS jika perlu -->
                </div>
                <p class="text-xs text-gray-400 mt-1">* Tambahkan lebih banyak pengalaman dengan mengisi baris baru.</p>
            </div>
            <!-- Keahlian -->
            <div>
                <label class="block text-gray-700 mb-1">Keahlian</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="UI Design" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">UI Design</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="UX Research" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">UX Research</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Figma" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Figma</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Adobe XD" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Adobe XD</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Prototyping" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Prototyping</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Teamwork" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Teamwork</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="HTML/CSS" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">HTML/CSS</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Javascript" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Javascript</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Komunikasi" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Komunikasi</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Manajemen Proyek" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Manajemen Proyek</span>
                    </label>
                    <!-- Tambahkan opsi lain sesuai kebutuhan -->
                </div>
                <p class="text-xs text-gray-400 mt-1">* Pilih satu atau lebih keahlian yang kamu miliki.</p>
            </div>
            <!-- Upload CV -->
            <div>
                <label for="cv" class="block text-gray-700 mb-1">Upload CV (PDF, maks 2MB)</label>
                <input type="file" name="cv" accept=".pdf" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100
                "/>
                <p class="text-xs text-gray-400 mt-1">* Format file PDF. Maksimal ukuran 2MB.</p>
            </div>
            <!-- Tombol Simpan dan Kembali -->
            <div class="flex justify-end gap-2">
                <a href="profil_pelamar.php" class="bg-gray-300 text-gray-700 px-6 py-2 rounded-full shadow hover:bg-gray-400 transition">Kembali</a>
                <button type="submit" name="submit" class="bg-[#00646A] text-white px-6 py-2 rounded-full shadow hover:bg-teal-800 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>
