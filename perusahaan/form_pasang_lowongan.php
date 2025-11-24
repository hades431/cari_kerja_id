<?php
session_start();

include __DIR__ . "/../config.php"; // koneksi database
include '../function/logic.php';
include '../function/check_exp.php';
// Pastikan perusahaan login
if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'Perusahaan'){
    header("Location: ../login/login.php");
    exit;
}

// Ambil perusahaan & paket


$user_id = $_SESSION["user"]["id"];
$id_perusahaan = $_SESSION['user']['id_perusahaan'] ?? null;
$paket = tampil("SELECT*FROM perusahaan WHERE id_perusahaan=$id_perusahaan")[0]['paket'] ?? 'default';
if($paket == 'diamond'){
    $durasi_hari = 60;
}elseif($paket == 'gold'){
    $durasi_hari = 45;
}elseif($paket == 'silver'){
    $durasi_hari = 30;
}else{
    $durasi_hari = 15; // default
}

$max_lowongan = tampil("SELECT*FROM perusahaan WHERE id_perusahaan=$id_perusahaan")[0]["Lowogan_post"]; // default

$nama_perusahaan = tampil("SELECT nama_perusahaan FROM perusahaan WHERE id_user=$user_id")[0]['nama_perusahaan'] ?? 'Perusahaan Anda';
$status = tampil("SELECT verifikasi FROM perusahaan WHERE id_user=$user_id")[0]['verifikasi'] ?? 'Perusahaan Anda';
$logo_perusahaan = '';
$paket_notice = ''; // Inisialisasi variabel sebelum digunakan

// Cek apakah tabel paket ada sebelum melakukan JOIN
$hasPaketTable = false;
$result = $conn->query("SHOW TABLES LIKE 'paket'");
if ($result && $result->num_rows > 0) {
    $hasPaketTable = true;
}

// Cek apakah kolom paket_id ada di tabel perusahaan
$hasPaketIdColumn = false;
$columnCheck = $conn->query("SHOW COLUMNS FROM perusahaan LIKE 'paket_id'");
if ($columnCheck && $columnCheck->num_rows > 0) {
    $hasPaketIdColumn = true;
}


// Hitung lowongan aktif perusahaan saat ini (batas_lamaran >= today)
if ($id_perusahaan) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM lowongan WHERE id_perusahaan = ? AND (batas_lamaran IS NULL OR DATE(batas_lamaran) >= CURDATE())");
    $stmt->bind_param("i", $id_perusahaan);
    $stmt->execute();
    $stmt->bind_result($active_count);
    $stmt->fetch();
    $stmt->close();
}

// Ambil tanggal Expire paket perusahaan dan hitung sisa hari
$expire_raw = tampil("SELECT Expire FROM perusahaan WHERE id_perusahaan=$id_perusahaan")[0]['Expire'] ?? null;
$expire_formatted = null;
$expire_iso = null;
$days_left = null;
if ($expire_raw && $expire_raw !== '0000-00-00') {
    try {
        $expire_dt = new DateTime($expire_raw);
        $now = new DateTime();
        $interval = $now->diff($expire_dt);
        // %r%a memberi tanda kalau negatif (sudah lewat)
        $days_left = (int)$interval->format('%r%a');
        $expire_formatted = $expire_dt->format('Y-m-d H:i:s');
        // format ISO untuk JS (eksplicit timezone lokal server)
        $expire_iso = $expire_dt->format(DateTime::ATOM);
    } catch (Exception $e) {
        $expire_formatted = null;
        $expire_iso = null;
        $days_left = null;
    }
}

// Pesan untuk user
$message = '';
$error = '';

// Proses submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan masih boleh membuat lowongan sesuai paket
       $cek = tampil("SELECT*FROM perusahaan WHERE id_perusahaan=$id_perusahaan")[0];
    if ($cek['Lowogan_post'] <= 0 || $cek["verifikasi"] == "expire") {
        $error = "Kuota lowongan Anda sudah penuh untuk paket saat ini (maks: $max_lowongan). Silakan upgrade paket atau tunggu lowongan berakhir.";
    } else {
        $judul = trim($_POST['judul'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $lokasi = trim($_POST['lokasi'] ?? '');
        $gaji = trim($_POST['gaji'] ?? '');
        $pengalaman = trim($_POST['pengalaman'] ?? '');
        $gender = trim($_POST['gender'] ?? '');
        $pendidikan = isset($_POST['pendidikan']) ? implode(',', $_POST['pendidikan']) : '';
        // Validasi sederhana
        if ($judul === '' || $deskripsi === '') {
            $error = "Judul dan deskripsi wajib diisi.";
        } else {
            // Hitung batas_lamaran berdasarkan durasi paket
            $tanggal_post = date('Y-m-d H:i:s');
            $batas_lamaran = date('Y-m-d', strtotime("+{$durasi_hari} days", strtotime($tanggal_post)));
            // Simpan ke DB (prepared)
           $stmt = $conn->prepare("INSERT INTO lowongan (id_perusahaan, judul, posisi, deskripsi, pengalaman, pendidikan, gender, gaji, lokasi, tanggal_post, batas_lamaran) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
+            // urutan variabel harus sesuai kolom: id_perusahaan (i), lalu 10 string (s)
+            $stmt->bind_param("issssssssss", $id_perusahaan, $judul, $judul, $deskripsi, $pengalaman, $pendidikan, $gender, $gaji, $lokasi, $tanggal_post, $batas_lamaran);
            if ($stmt->execute()) {
            $stmt2 = $conn->prepare("UPDATE perusahaan SET Lowogan_post = Lowogan_post - 1 WHERE id_perusahaan = ?");
            $stmt2->bind_param("i", $id_perusahaan);
            $stmt2->execute();
                $message = "Lowongan berhasil dipasang. Berlaku sampai: $batas_lamaran";
                // update active_count karena berhasil menambah lowongan
                header("Location: dashboard_perusahaan.php");
                exit;
                
            } else {
                $error = "Terjadi kesalahan saat menyimpan: " . $stmt->error;
            }
            $stmt->close();
        }
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
        <?php if(!empty($paket_notice)): ?>
        <div class='bg-yellow-100 text-yellow-800 p-3 rounded mb-4'><?= htmlspecialchars($paket_notice) ?></div>
        <?php endif; ?>
        <?php if(isset($error) && $error): echo "<div class='bg-red-100 text-red-700 p-3 rounded mb-4'>".htmlspecialchars($error)."</div>"; endif; ?>
        <?php if(isset($message) && $message): echo "<div class='bg-green-100 text-green-700 p-3 rounded mb-4'>".htmlspecialchars($message)."</div>"; endif; ?>

        <div class="mb-4">
            <p>Paket saat ini: <strong><?= htmlspecialchars($nama_perusahaan) ?></strong></p>
            <p>Durasi lowongan paket: <strong><?= htmlspecialchars($durasi_hari) ?> hari</strong></p>
            <p>Kuota lowongan paket: <strong><?= $max_lowongan ?></strong></p>
            <p>status: <strong><?= $status == "expire" ? "kadaluarsa" : "aktif"; ?></strong></p>
            <p>Lowongan aktif saat ini: <strong><?= htmlspecialchars($active_count) ?></strong></p>
            <p>Expire paket: <strong id="expire_date"><?= htmlspecialchars($expire_formatted ?? '-') ?></strong></p>
        </div>

        <form method="POST" enctype="multipart/form-data" class="space-y-6" id="lowonganForm">

            <div>
                <!-- gunakan variabel yang benar: id_perusahaan dan nama_perusahaan -->
                <input type="hidden" name="id_perusahaan" value="<?php echo htmlspecialchars($id_perusahaan); ?>">
                <label class="block text-gray-700 font-semibold mb-2">Nama Perusahaan</label>
                <input type="text" name="nama_perusahaan" value="<?= htmlspecialchars($nama_perusahaan) ?>" readonly
                    class="w-full p-3 border rounded-lg bg-gray-100 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Judul Lowongan</label>
                <input type="text" autocomplete="off" name="judul" required
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Deskripsi Lowongan</label>
                <textarea name="deskripsi" rows="5" required
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500"></textarea>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Pengalaman</label>
                <div class="flex gap-4">
                    <select name="pengalaman"
                        class="bg-white rounded-xl px-4 py-3 w-full text-gray-700 text-base font-semibold border-2 focus:border-[#00646A] transition">
                        <option>Tahun</option>
                        <option value="tanpa">Tanpa Pengalaman</option>
                        <option value="1-4">1-4 Tahun</option>
                        <option value=">4">4 Tahun Lebih</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-2">Lokasi Kerja</label>
                <input type="text" name="lokasi" required
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Pendidikan Minimal</label>
                <?php
            $pendidikan_arr = ['sma'=>'SMA/SMK','d3'=>'Diploma (D3)','s1'=>'Sarjana (S1)','s2'=>'Magister (S2)'];
            foreach($pendidikan_arr as $key=>$val): ?>
                <label class="flex items-center gap-2 mr-4">
                    <input type="checkbox" name="pendidikan[]" value="<?= $key ?>"
                        class="pendidikan-checkbox text-teal-600 focus:ring-teal-500">
                    <?= $val ?>
                </label>
                <?php endforeach; ?>
            </div>
            <div>
                <label class="block text-gray-700 font-semibold mb-1">Jenis Kelamin</label>
                <label class="flex items-center gap-2 mr-4">
                    <input type="radio" name="gender" value="pria" class="text-teal-600 focus:ring-teal-500"> Pria
                </label>
                <label class="flex items-center gap-2 mr-4">
                    <input type="radio" name="gender" value="wanita" class="text-teal-600 focus:ring-teal-500"> Wanita
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="gender" value="bebas" class="text-teal-600 focus:ring-teal-500"> Bebas
                    (tanpa preferensi)
                </label>
            </div>

            <div>
                <label class="block text-gray-700 font-semibold mb-2">Besaran Gaji</label>
                <!-- tambahkan id supaya JS bisa memformat, placeholder contoh, dan tetap pakai name untuk POST -->
                <input type="text" name="gaji" id="besaran_gaji" placeholder="0"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500">
            </div>

            <div class="flex justify-between pt-4">
                <a href="dashboard_perusahaan.php"
                    class="px-6 py-3 bg-gray-300 text-gray-800 rounded-lg font-semibold shadow hover:bg-gray-400 transition">Kembali</a>
                <button type="submit"
                    class="px-6 py-3 bg-[#00797a] text-white rounded-lg font-bold shadow hover:bg-[#00646A] transition">Pasang
                    Lowongan</button>
            </div>
        </form>
    </div>

    <script>
    // Format besaran gaji dengan koma sebagai pemisah ribuan
    const gajiInput = document.getElementById('besaran_gaji');
    if (gajiInput) {
        const formatNumber = (value) => {
            // ambil hanya digit
            const digits = value.replace(/[^\d]/g, '');
            if (digits === '') return '';
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
        form.addEventListener('submit', function(e) {
            if (gajiInput.value) {
                gajiInput.value = gajiInput.value.replace(/,/g, '');
            }
        });
    }

    // Hitung mundur live berdasarkan tanggal Expire dari server (jika ada)
    (function(){
        const expireIso = <?= json_encode($expire_iso) ?>; // iso string atau null
        if (!expireIso) return;
        const target = new Date(expireIso).getTime();
        const timerEl = document.getElementById('countdown_timer');
        const daysLeftEl = document.getElementById('days_left');

        const update = () => {
            const now = Date.now();
            let diff = target - now;
            if (diff <= 0) {
                timerEl.textContent = "Kadaluarsa";
                if (daysLeftEl) daysLeftEl.textContent = "Sudah kadaluarsa";
                clearInterval(intervalId);
                return;
            }
            const days = Math.floor(diff / (1000*60*60*24));
            diff -= days * (1000*60*60*24);
            const hours = Math.floor(diff / (1000*60*60)); diff -= hours * (1000*60*60);
            const minutes = Math.floor(diff / (1000*60)); diff -= minutes * (1000*60);
            const seconds = Math.floor(diff / 1000);
            // tampilkan "Nh HH:MM:SS"
            timerEl.textContent = (days>0? days + " hari " : "") + String(hours).padStart(2,'0') + ":" + String(minutes).padStart(2,'0') + ":" + String(seconds).padStart(2,'0');
            if (daysLeftEl) daysLeftEl.textContent = days + ' hari';
        };
        update();
        const intervalId = setInterval(update, 1000);
    })();
    </script>

</body>

</html>