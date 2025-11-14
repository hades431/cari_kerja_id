<?php
session_start();
include __DIR__ . "/../config.php"; // koneksi database
include '../function/logic.php';
// Pastikan perusahaan login
if(!isset($_SESSION['login']) || $_SESSION['role'] !== 'perusahaan'){
    header("Location: ../login/login.php");
    exit;
}

// Ambil perusahaan & paket
$user_id = $_SESSION["user"]["id"];
$id_perusahaan = 0;
$durasi_hari = 7; // default
$max_lowongan = 1; // default
$nama_perusahaan = 'Perusahaan';
$logo_perusahaan = '';

// Cek apakah tabel paket ada sebelum melakukan JOIN
$hasPaketTable = false;
$result = $conn->query("SHOW TABLES LIKE 'paket'");
if ($result && $result->num_rows > 0) {
    $hasPaketTable = true;
}

if ($hasPaketTable) {
    $stmt = $conn->prepare("SELECT p.id_perusahaan, p.nama_perusahaan, p.logo, p.paket_id, pk.durasi_hari, pk.max_lowongan 
                            FROM perusahaan p 
                            LEFT JOIN paket pk ON p.paket_id = pk.id_paket
                            WHERE p.id_user = ? LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $id_perusahaan = (int)$row['id_perusahaan'];
        $nama_perusahaan = $row['nama_perusahaan'] ?? $nama_perusahaan;
        $logo_perusahaan = $row['logo'] ?? $logo_perusahaan;
        $durasi_hari = (int)($row['durasi_hari'] ?? $durasi_hari);
        $max_lowongan = (int)($row['max_lowongan'] ?? $max_lowongan);
    }
    $stmt->close();
} else {
    // Jika tabel paket tidak ada, ambil data perusahaan tanpa paket dan gunakan default
    $stmt = $conn->prepare("SELECT id_perusahaan, nama_perusahaan, logo FROM perusahaan WHERE id_user = ? LIMIT 1");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $res = $stmt->get_result();
    if ($row = $res->fetch_assoc()) {
        $id_perusahaan = (int)$row['id_perusahaan'];
        $nama_perusahaan = $row['nama_perusahaan'] ?? $nama_perusahaan;
        $logo_perusahaan = $row['logo'] ?? $logo_perusahaan;
    }
    $stmt->close();
    // opsional: beri pesan agar admin membuat tabel paket
    $paket_notice = "Tabel 'paket' tidak ditemukan. Menggunakan nilai paket default. Silakan tambahkan tabel paket jika ingin mengelola durasi/kuota paket.";
}

// Hitung lowongan aktif perusahaan saat ini (batas_lamaran >= today)
$active_count = 0;
if ($id_perusahaan) {
    $stmt = $conn->prepare("SELECT COUNT(*) FROM lowongan WHERE id_perusahaan = ? AND (batas_lamaran IS NULL OR DATE(batas_lamaran) >= CURDATE())");
    $stmt->bind_param("i", $id_perusahaan);
    $stmt->execute();
    $stmt->bind_result($active_count);
    $stmt->fetch();
    $stmt->close();
}

// Pesan untuk user
$message = '';
$error = '';

// Proses submit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Pastikan masih boleh membuat lowongan sesuai paket
    if ($max_lowongan > 0 && $active_count >= $max_lowongan) {
        $error = "Kuota lowongan Anda sudah penuh untuk paket saat ini (maks: $max_lowongan). Silakan upgrade paket atau tunggu lowongan berakhir.";
    } else {
        $judul = trim($_POST['judul'] ?? '');
        $deskripsi = trim($_POST['deskripsi'] ?? '');
        $lokasi = trim($_POST['lokasi'] ?? '');
        $gaji = trim($_POST['gaji'] ?? '');
        // Validasi sederhana
        if ($judul === '' || $deskripsi === '') {
            $error = "Judul dan deskripsi wajib diisi.";
        } else {
            // Hitung batas_lamaran berdasarkan durasi paket
            $tanggal_post = date('Y-m-d');
            $batas_lamaran = date('Y-m-d', strtotime("+{$durasi_hari} days", strtotime($tanggal_post)));
            // Simpan ke DB (prepared)
            $stmt = $conn->prepare("INSERT INTO lowongan (id_perusahaan, judul, deskripsi, lokasi, gaji, tanggal_post, batas_lamaran) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("issssss", $id_perusahaan, $judul, $deskripsi, $lokasi, $gaji, $tanggal_post, $batas_lamaran);
            if ($stmt->execute()) {
                $message = "Lowongan berhasil dipasang. Berlaku sampai: $batas_lamaran";
                // update active_count karena berhasil menambah lowongan
                $active_count++;
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
            <p>Kuota lowongan paket: <strong><?= htmlspecialchars($max_lowongan) ?></strong></p>
            <p>Lowongan aktif saat ini: <strong><?= htmlspecialchars($active_count) ?></strong></p>
        </div>

        <form method="POST" enctype="multipart/form-data" class="space-y-6" id="lowonganForm">

            <div>
                <!-- gunakan variabel yang benar: id_perusahaan dan nama_perusahaan -->
                <input type="hidden" name="id_perusahaan" value="<?php echo htmlspecialchars($id_perusahaan); ?>">
                <label class="block text-gray-700 font-semibold mb-2">Nama Perusahaan</label>
                <input type="text" name="nama_perusahaan" value="<?= htmlspecialchars($nama_perusahaan) ?>"
                    readonly class="w-full p-3 border rounded-lg bg-gray-100 cursor-not-allowed">
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
                <label class="block text-gray-700 font-semibold mb-2">Lokasi Kerja</label>
                <input type="text" name="lokasi" required
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-teal-500">
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
                    class="px-6 py-3 bg-[#00797a] text-white rounded-lg font-bold shadow hover:bg-[#00646A] transition">Pasang Lowongan</button>
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
    </script>

</body>

</html>