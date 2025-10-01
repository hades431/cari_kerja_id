<?php
session_start();
include __DIR__ . "/../config.php"; // koneksi database
include '../function/logic.php';
// Pastikan perusahaan login
if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'perusahaan'){
    header("Location: ../login/login.php");
    exit;
}
$tes = $_SESSION["user"]["id"];
$id_user = tampil("SELECT*FROM perusahaan WHERE id_user = $tes")[0];
$id_perusahaan = $id_user["id_perusahaan"] ?? 0; // fallback jika belum ada
$nama_perusahaan = $_SESSION['nama_perusahaan'] ?? 'Contoh Perusahaaan';

// Proses form
if($_SERVER['REQUEST_METHOD'] === 'POST'){
    $posisi_pekerjaan = $_POST['posisi_pekerjaan'];
    $deskripsi        = $_POST['deskripsi'];
    $batas_lamaran    = $_POST['batas_tanggal_lamaran'];
    $pengalaman       = isset($_POST['pengalaman']) ? implode(",", $_POST['pengalaman']) : "";
    $pendidikan       = isset($_POST['pendidikan']) ? implode(",", $_POST['pendidikan']) : "";
    $gender           = $_POST['gender'] ?? '';
    $lokasi           = $_POST['lokasi_kerja'];
    // Sanitasi gaji: hapus koma dan karakter bukan angka (termasuk titik jika tidak diinginkan)
    $gaji_raw         = $_POST['besaran_gaji'] ?? '';
    $gaji             = preg_replace('/[^\d]/', '', $gaji_raw);
    $tanggal_post     = date('Y-m-d');
    $logo = "";
    if (isset($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $target = "../img/" . basename($_FILES['logo']['name']);
            if (!empty($logo) && file_exists($logo)) {
                unlink($logo);
            }
        if (move_uploaded_file($_FILES['logo']['tmp_name'], $target)) {
            $logo = $target;
        }
    }

    // Upload logo/banner

    // SQL INSERT
    $sql = "INSERT INTO lowongan 
        (id_perusahaan,judul,posisi,deskripsi,pengalaman,pendidikan,gender,gaji,lokasi,tanggal_post,batas_lamaran,banner)
        VALUES
        ('$id_perusahaan','$posisi_pekerjaan','$posisi_pekerjaan','$deskripsi','$pengalaman','$pendidikan','$gender','$gaji','$lokasi','$tanggal_post','$batas_lamaran','$logo')";

    if(mysqli_query($conn,$sql)){
        echo "<script>
                alert('Lowongan berhasil disimpan!');
                window.location.href='dashboard_perusahaan.php';
              </script>";
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
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Form Pasang Lowongan</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

<header class="bg-[#00646A] text-white py-4 text-center text-xl font-bold shadow">
  Form Pasang Lowongan
</header>

<div class="max-w-4xl mx-auto mt-8 bg-white p-8 rounded-2xl shadow-lg border">
    <?php if(isset($error_msg)) echo "<p class='text-red-600 mb-4'>$error_msg</p>"; ?>
    <form method="POST" enctype="multipart/form-data" class="space-y-6" id="lowonganForm">

        <div>
            <!-- tambahkan name pada hidden supaya tersedia di POST jika diperlukan -->
            <input type="hidden" name="id_perusahaan" value="<?php echo $id_user["id_perusahaan"] ?>">
            <label class="block text-gray-700 font-semibold mb-2">Nama Perusahaan</label>
            <input type="text" name="nama_perusahaan" value="<?= htmlspecialchars($id_user["nama_perusahaan"]) ?>" readonly class="w-full p-3 border rounded-lg bg-gray-100 cursor-not-allowed">
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Posisi Pekerjaan</label>
            <input type="text" name="posisi_pekerjaan" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500">
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Deskripsi Lowongan</label>
            <textarea name="deskripsi" rows="5" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500"></textarea>
        </div>

        <div>
            <label class="block text-gray-700 font-semibold mb-2">Batas Tanggal Lamaran</label>
            <input type="date" name="batas_tanggal_lamaran" required class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500">
        </div>

        <!-- Pengalaman -->
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Pengalaman (maks 2)</label>
            <div class="flex gap-4">
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
            <?php
            $pendidikan_arr = ['sma'=>'SMA/SMK','d3'=>'Diploma (D3)','s1'=>'Sarjana (S1)','s2'=>'Magister (S2)'];
            foreach($pendidikan_arr as $key=>$val): ?>
                <label class="flex items-center gap-2 mr-4">
                    <input type="checkbox" name="pendidikan[]" value="<?= $key ?>" class="pendidikan-checkbox text-teal-600 focus:ring-teal-500">
                    <?= $val ?>
                </label>
            <?php endforeach; ?>
        </div>

        <!-- Gender -->
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Jenis Kelamin</label>
            <label class="flex items-center gap-2 mr-4">
                <input type="radio" name="gender" value="pria" class="text-teal-600 focus:ring-teal-500"> Pria
            </label>
            <label class="flex items-center gap-2 mr-4">
                <input type="radio" name="gender" value="wanita" class="text-teal-600 focus:ring-teal-500"> Wanita
            </label>
            <label class="flex items-center gap-2">
                <input type="radio" name="gender" value="bebas" class="text-teal-600 focus:ring-teal-500"> Bebas (tanpa preferensi)
            </label>
        </div>

        <!-- Lokasi & Gaji -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Lokasi Kerja</label>
                <input type="text" name="lokasi_kerja" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Besaran Gaji</label>
                <!-- tambahkan id supaya JS bisa memformat, placeholder contoh, dan tetap pakai name untuk POST -->
                <input type="text" name="besaran_gaji" id="besaran_gaji" placeholder="0" class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>
        </div>

        <!-- Logo -->
        <div>
            <label class="block text-gray-700 font-semibold mb-1">Banner/Logo Perusahaan</label>
            <input type="file" name="logo" accept="image/*" class="w-full border p-3 rounded-lg bg-gray-50 cursor-pointer">
        </div>

        <div class="flex justify-between pt-4">
            <a href="dashboard_perusahaan.php" class="px-6 py-3 bg-gray-300 text-gray-800 rounded-lg font-semibold shadow hover:bg-gray-400 transition">Kembali</a>
            <button type="submit" class="px-6 py-3 bg-[#00797a] text-white rounded-lg font-bold shadow hover:bg-[#00646A] transition">Selanjutnya</button>
        </div>
    </form>
</div>

<script>
// Batasi pengalaman max 2
const pengalamanCheckboxes = document.querySelectorAll('.pengalaman-checkbox');
pengalamanCheckboxes.forEach(cb => {
    cb.addEventListener('change', function() {
        let checked = Array.from(pengalamanCheckboxes).filter(x => x.checked);
        if(checked.length > 2) this.checked = false;
    });
});

// Format besaran gaji dengan koma sebagai pemisah ribuan
const gajiInput = document.getElementById('besaran_gaji');
if(gajiInput){
    const formatNumber = (value) => {
        // ambil hanya digit
        const digits = value.replace(/[^\d]/g, '');
        if(digits === '') return '';
        return parseInt(digits, 10).toLocaleString('en-US');
    };

    gajiInput.addEventListener('input', (e) => {
        const caret = gajiInput.selectionStart;
        const oldLength = gajiInput.value.length;
        gajiInput.value = formatNumber(gajiInput.value);
        // sederhana: set caret di akhir (cukup untuk sebagian besar kasus)
        gajiInput.selectionStart = gajiInput.selectionEnd = gajiInput.value.length;
    });

    // sebelum submit, hapus koma agar server menerima angka bersih
    const form = document.getElementById('lowonganForm');
    form.addEventListener('submit', function(e){
        if(gajiInput.value){
            gajiInput.value = gajiInput.value.replace(/,/g, '');
        }
    });
}
</script>

</body>
</html>
