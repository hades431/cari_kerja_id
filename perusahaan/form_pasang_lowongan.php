<?php
include __DIR__ . "/../config.php";

// ID perusahaan statis
$id_perusahaan = 1; 
$nama_perusahaan = "Contoh Perusahaan";

if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $posisi_pekerjaan = $_POST['posisi_pekerjaan'];
    $deskripsi        = $_POST['deskripsi'];
    $batas_lamaran    = $_POST['batas_tanggal_lamaran'];
    $pengalaman       = isset($_POST['pengalaman']) ? implode(",", $_POST['pengalaman']) : "";
    $pendidikan       = isset($_POST['pendidikan']) ? implode(",", $_POST['pendidikan']) : "";
    $gender           = isset($_POST['gender']) ? implode(",", $_POST['gender']) : "";
    $lokasi           = $_POST['lokasi_kerja'];
    $gaji             = $_POST['besaran_gaji'];
    $tanggal_post     = date('Y-m-d');

    $logo = "";
    if(isset($_FILES['logo']) && $_FILES['logo']['error'] === 0){
        $ext = pathinfo($_FILES['logo']['name'], PATHINFO_EXTENSION);
        $logo_dir = "../uploads/";
        if(!is_dir($logo_dir)) mkdir($logo_dir, 0777, true);
        $logo = "uploads/".uniqid().".".$ext;
        move_uploaded_file($_FILES['logo']['tmp_name'], "../".$logo);
    }

    $sql = "INSERT INTO lowongan 
        (id_perusahaan,nama_perusahaan,posisi_pekerjaan,deskripsi,gaji,lokasi,gender,pengalaman,pendidikan,tanggal_post,batas_lamaran,logo)
        VALUES
        ('$id_perusahaan','$nama_perusahaan','$posisi_pekerjaan','$deskripsi','$gaji','$lokasi','$gender','$pengalaman','$pendidikan','$tanggal_post','$batas_lamaran','$logo')";

    if(mysqli_query($conn,$sql)){
        echo "<script>alert('Lowongan berhasil disimpan!');window.location.href='dashboard_perusahaan.php';</script>";
        exit;
    } else {
        $error_msg = mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<title>Form Pasang Lowongan</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
    <div class="max-w-2xl mx-auto mt-12 bg-white p-8 rounded-2xl shadow-lg border">
        <h1 class="text-2xl font-bold text-[#00646A] mb-6 text-center">Form Pasang Lowongan</h1>
        <?php if(isset($error_msg)) echo "<p class='text-red-600 mb-4'>$error_msg</p>"; ?>
        <form method="POST" enctype="multipart/form-data" class="space-y-6">
            <!-- Nama Perusahaan (readonly) -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Nama Perusahaan</label>
                <input type="text" value="<?= htmlspecialchars($nama_perusahaan) ?>" readonly class="w-full p-3 border rounded-lg bg-gray-100 cursor-not-allowed">
            </div>
            <!-- Posisi Pekerjaan -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Posisi Pekerjaan</label>
                <input type="text" name="posisi_pekerjaan" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>
            <!-- Deskripsi Lowongan -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi Lowongan</label>
                <textarea name="deskripsi" rows="5" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500"></textarea>
            </div>
            <!-- Batas Tanggal Lamaran -->
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Batas Tanggal Lamaran</label>
                <input type="date" name="batas_tanggal_lamaran" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>
            <!-- Pengalaman -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Pengalaman (maks 2)</label>
                <div class="flex gap-4 flex-wrap">
                    <?php for($i=0;$i<=4;$i++): ?>
                        <label class="flex items-center gap-2">
                            <input type="checkbox" name="pengalaman[]" value="<?= $i ?>" class="pengalaman-checkbox text-teal-600 focus:ring-teal-500">
                            <?= $i ?> Tahun
                        </label>
                    <?php endfor; ?>
                </div>
            </div>
            <!-- Pendidikan -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Pendidikan Minimal</label>
                <div class="flex gap-4 flex-wrap">
                <?php
                $pendidikan_arr = ['sma'=>'SMA/SMK','d3'=>'D3','s1'=>'S1','s2'=>'S2'];
                foreach($pendidikan_arr as $key=>$val): ?>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="pendidikan[]" value="<?= $key ?>" class="text-teal-600 focus:ring-teal-500">
                        <?= $val ?>
                    </label>
                <?php endforeach; ?>
                </div>
            </div>
            <!-- Gender -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Jenis Kelamin</label>
                <div class="flex gap-4">
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="gender[]" value="pria" class="text-teal-600 focus:ring-teal-500"> Pria
                    </label>
                    <label class="flex items-center gap-2">
                        <input type="checkbox" name="gender[]" value="wanita" class="text-teal-600 focus:ring-teal-500"> Wanita
                    </label>
                </div>
            </div>
            <!-- Lokasi & Gaji -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Lokasi Kerja</label>
                    <input type="text" name="lokasi_kerja" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
                <div>
                    <label class="block text-gray-700 font-semibold mb-1">Besaran Gaji</label>
                    <input type="text" name="besaran_gaji" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500">
                </div>
            </div>
            <!-- Logo -->
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Banner Perusahaan</label>
                <input type="file" name="logo" accept="image/*" class="w-full border p-3 rounded-lg bg-gray-50 cursor-pointer">
            </div>
            <!-- Tombol -->
            <div class="flex justify-between pt-4">
                <a href="dashboard_perusahaan.php" class="px-6 py-3 bg-gray-300 text-gray-800 rounded-lg font-semibold shadow hover:bg-gray-400 transition">Kembali</a>
                <button type="submit" class="px-6 py-3 bg-[#00797a] text-white rounded-lg font-bold shadow hover:bg-[#00646A] transition">Simpan Lowongan</button>
            </div>
        </form>
    </div>
    <!-- Footer -->
    <footer class="mt-10 bg-[#00646A] py-6 text-center text-white rounded-b-2xl">
        <div class="font-bold text-lg">CariKerja.id</div>
        <p class="text-sm">© 2025 CariKerja.id | All Rights Reserved</p>
    </footer>
    <script>
    // Batasi pengalaman max 2
    const pengalamanCheckboxes = document.querySelectorAll('.pengalaman-checkbox');
    pengalamanCheckboxes.forEach(cb => {
        cb.addEventListener('change', function() {
            let checked = Array.from(pengalamanCheckboxes).filter(x => x.checked);
            if(checked.length > 2) this.checked = false;
        });
    });
    </script>
</body>
</html>
             