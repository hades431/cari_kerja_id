<?php
$judul_halaman = "Form Buka Lowongan";
include '../header.php';

// Koneksi database
$conn = mysqli_connect("localhost", "root", "", "lowongan_kerja");
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
    exit;
}
$id = $_SESSION["user"]["id"];

// Cek status verifikasi perusahaan
$cek_perusahaan = mysqli_query($conn, "SELECT verifikasi FROM perusahaan WHERE id_user = $id ORDER BY id_perusahaan DESC LIMIT 1");
if ($cek_perusahaan && mysqli_num_rows($cek_perusahaan) > 0) {
    $row = mysqli_fetch_assoc($cek_perusahaan);
    if ($row['verifikasi'] !== 'acc') {
        header('Location: menunggu_verifikasi.php');
        exit;
    }
}

// Tangkap paket dari query string
$paket = isset($_GET['paket']) ? $_GET['paket'] : '';

// Mapping harga paket
$harga_paket = [
    'bronze' => 25000,
    'silver' => 50000,
    'gold' => 75000,
    'diamond' => 100000,
];

$harga = isset($harga_paket[$paket]) ? $harga_paket[$paket] : 0;

// Proses form jika disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nama_perusahaan = $_POST['nama_perusahaan'] ?? '';
    $alamat_perusahaan = $_POST['alamat_perusahaan'] ?? '';
    $email_perusahaan = $_POST['email_perusahaan'] ?? '';
    $telepon_perusahaan = $_POST['telepon_perusahaan'] ?? '';
    $website_perusahaan = $_POST['website_perusahaan'] ?? '';
    $paket = $_POST['paket'] ?? '';
    $metode_pembayaran = $_POST['metode_pembayaran'] ?? ''; // ambil dari form
    $bukti_pembayaran = '';

    // Upload bukti pembayaran jika ada
    if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = '../uploads/';
        if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
        $fileName = uniqid() . '_' . basename($_FILES['bukti_pembayaran']['name']);
        $targetFilePath = $uploadDir . $fileName;
        if (move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $targetFilePath)) {
            $bukti_pembayaran = 'uploads/' . $fileName;
        }
    }

    // Simpan ke database
    $sql = "INSERT INTO perusahaan 
        (nama_perusahaan, id_user ,alamat, email_perusahaan, no_telepon, website, bukti_pembayaran, deskripsi, paket, verifikasi, waktu) VALUES
        ('$nama_perusahaan', $id , '$alamat_perusahaan', '$email_perusahaan', '$telepon_perusahaan', '$website_perusahaan', '$bukti_pembayaran', '$deskripsi', '$paket', 'belum' , '15')";
    // Jangan update role user di sini, tunggu sampai verifikasi admin
    // $sql_user = "UPDATE user SET role = 'perusahaan' WHERE id_user = $id";
    // mysqli_query($conn, $sql_user);
    mysqli_query($conn, $sql);
    // Redirect ke halaman info menunggu verifikasi
    header('Location: ../public/menunggu_verifikasi.php');
    exit;

}
?>

<div class="max-w-screen-2xl mx-auto mt-10 mb-6 bg-white p-8 rounded-lg border border-gray-200 shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Form Pendaftaran Perusahaan</h2>
    <form action="" method="POST" enctype="multipart/form-data">

        <!-- Data Perusahaan -->
        <h4 class="text-lg font-semibold mt-4 mb-2">Data Perusahaan</h4>
        <div class="mb-4">
            <label for="nama_perusahaan" class="block mb-1 font-medium">Nama Perusahaan</label>
            <input type="text" id="nama_perusahaan" name="nama_perusahaan" class="w-full border rounded px-3 py-2"
                required>
        </div>
        <div class="mb-4">
            <label for="alamat_perusahaan" class="block mb-1 font-medium">Alamat Perusahaan</label>
            <textarea id="alamat_perusahaan" name="alamat_perusahaan" rows="2" class="w-full border rounded px-3 py-2"
                required></textarea>
        </div>
        <div class="mb-4">
            <label for="email_perusahaan" class="block mb-1 font-medium">Email Perusahaan</label>
            <input type="email" id="email_perusahaan" name="email_perusahaan" class="w-full border rounded px-3 py-2"
                required>
        </div>
        <div class="mb-4">
            <label for="telepon_perusahaan" class="block mb-1 font-medium">Telepon Perusahaan</label>
            <input type="number" id="telepon_perusahaan" name="telepon_perusahaan"
                class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="website_perusahaan" class="block mb-1 font-medium">Website Perusahaan (opsional)</label>
            <input type="text" id="website_perusahaan" name="website_perusahaan"
                class="w-full border rounded px-3 py-2">
        </div>

        <!-- Paket -->
        <h4 class="text-lg font-semibold mt-6 mb-2">Paket yang Dipilih</h4>
        <?php if ($paket && $harga > 0): ?>
        <input type="hidden" name="paket" value="<?= htmlspecialchars($paket) ?>">
        <div class="p-4 bg-blue-50 border border-blue-200 rounded text-blue-900 text-sm">
            <strong>Paket <?= ucfirst($paket) ?>:</strong>
            <div id="benefit-paket" class="mt-2"></div>
            <p class="mt-2 font-semibold">Harga: Rp<?= number_format($harga, 0, ',', '.') ?></p>
            <input type="hidden" name="harga" value="<?= $harga ?>">
        </div>
        <?php else: ?>
        <p class="text-red-600">Belum ada paket yang dipilih. Silakan kembali ke halaman paket.</p>
        <?php endif; ?>

        <!-- Metode Pembayaran -->
        <?php if ($paket && $harga > 0): ?>
        <div class="mb-6 mt-4">
            <label class="block mb-1 font-medium">Metode Pembayaran</label>
            <select name="metode_pembayaran" id="metode_pembayaran" class="w-full border rounded px-3 py-2" required>
                <option value="">-- Pilih Metode Pembayaran --</option>
                <option value="transfer_bank">Transfer Bank (BCA, BNI, Mandiri)</option>
                <option value="ewallet">E-Wallet (OVO, GoPay, Dana, ShopeePay)</option>
                <option value="qris">QRIS</option>
            </select>
        </div>

        <!-- Tutorial Pembayaran -->
        <div id="tutorial-pembayaran"
            class="hidden p-4 bg-green-50 border border-green-200 rounded text-sm text-green-900"></div>

        <!-- Upload Bukti Pembayaran -->
        <div class="mb-6 mt-4">
            <label for="bukti_pembayaran" class="block mb-1 font-medium">Upload Bukti Pembayaran</label>
            <input type="file" id="bukti_pembayaran" name="bukti_pembayaran" class="w-full border rounded px-3 py-2"
                accept="image/*,application/pdf" required>
            <p class="text-xs text-gray-500 mt-1">Format yang diperbolehkan: JPG, PNG, PDF (maks. 2MB)</p>
        </div>
        <?php endif; ?>

        <button type="submit"
            class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            Kirim Lowongan
        </button>
        <a href="buka_lowongan.php"
            class="block w-full mt-3 bg-gray-300 hover:bg-gray-400 text-black font-semibold py-2 px-4 rounded text-center transition">
            Kembali
        </a>
    </form>
</div>

<script>
const benefitData = {
    bronze: `<ul class="list-disc pl-5">
                    <li>Dapat memposting 1 lowongan kerja</li>
                    <li>Durasi tayang 15 hari</li>
                    <li>Posisi lowongan hanya tampil di halaman list</li>
                    <li>Akses ke dashboard perusahaan</li>
                    <li>Notifikasi email untuk setiap lamaran</li>
                </ul>`,
    silver: `<ul class="list-disc pl-5">
                    <li>Dapat memposting 3 lowongan kerja</li>
                    <li>Durasi tayang 30 hari</li>
                    <li>Highlight listing</li>
                    <li>Logo perusahaan tampil di listing</li>
                    <li>Fitur filter pelamar</li>
                    <li>Akses ke dashboard perusahaan</li>
                    <li>Notifikasi via email & dashboard</li>
                </ul>`,
    gold: `<ul class="list-disc pl-5">
                    <li>Dapat memposting 7 lowongan kerja</li>
                    <li>Durasi tayang 45 hari</li>
                    <li>Lowongan tampil di posisi atas</li>
                    <li>Logo & profil perusahaan tampil di halaman khusus</li>
                    <li>Fitur filter pelamar</li>
                    <li>Publikasi di media sosial</li>
                    <li>Notifikasi via email & dashboard</li>
                </ul>`,
    diamond: `<ul class="list-disc pl-5">
                    <li>Unlimited posting lowongan kerja</li>
                    <li>Durasi tayang 60 hari</li>
                    <li>Lowongan tampil di top priority</li>
                    <li>Profil perusahaan premium</li>
                    <li>Akses ke dashboard perusahaan</li>
                    <li>Publikasi di media sosial (Story & Postingan)</li>
                    <li>Notifikasi via email & dashboard</li>
                </ul>`
};

const selectedPaket = "<?= $paket ?>";
if (selectedPaket && benefitData[selectedPaket]) {
    document.getElementById('benefit-paket').innerHTML = benefitData[selectedPaket];
}

// Tutorial pembayaran
const tutorialPembayaran = {
    transfer_bank: `
            <strong>Tutorial Transfer Bank:</strong>
            <ol class="list-decimal pl-5">
                <li>Pilih menu Transfer di ATM / Mobile Banking</li>
                <li>Masukkan nomor rekening: <b>1234567890 (BCA a/n PT JobKu)</b></li>
                <li>Masukkan nominal sesuai harga paket</li>
                <li>Konfirmasi transfer</li>
                <li>Simpan bukti pembayaran lalu upload di form</li>
            </ol>
        `,
    ewallet: `
            <strong>Tutorial E-Wallet:</strong>
            <ol class="list-decimal pl-5">
                <li>Buka aplikasi OVO / GoPay / Dana / ShopeePay</li>
                <li>Pilih menu Transfer / Kirim</li>
                <li>Masukkan nomor tujuan: <b>0821-2843-6309 (PT Cari Kerja)</b></li>
                <li>Masukkan nominal sesuai harga paket</li>
                <li>Konfirmasi transfer</li>
                <li>Simpan bukti pembayaran lalu upload di form</li>
            </ol>
        `,
    qris: `
            <strong>Bayar dengan QRIS:</strong>
            <p>Scan kode QR di bawah ini menggunakan aplikasi e-wallet atau mobile banking Anda.</p>
            <div class="flex justify-center mt-2">
                <img src="../img/qiris.jpeg" alt="QRIS" class="w-48 h-48 border rounded shadow">
            </div>
            <p class="mt-2 text-sm">Setelah pembayaran berhasil, simpan bukti transfer lalu upload di form.</p>
        `
};

document.getElementById('metode_pembayaran')?.addEventListener('change', function() {
    const tutorialDiv = document.getElementById('tutorial-pembayaran');
    const metode = this.value;
    if (tutorialPembayaran[metode]) {
        tutorialDiv.innerHTML = tutorialPembayaran[metode];
        tutorialDiv.classList.remove('hidden');
    } else {
        tutorialDiv.innerHTML = '';
        tutorialDiv.classList.add('hidden');
    }
});
</script>
</body>
<?php
include '../footer.php';
?>

</html>