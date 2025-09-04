<?php
$judul_halaman = "Form Buka Lowongan";
include '../header.php';

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
?>

<div class="max-w-screen-2xl mx-auto mt-10 bg-white p-8 rounded-lg border border-gray-200 shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Form Pendaftaran Perusahaan</h2>
    <form action="proses_buka_lowongan.php" method="POST">

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
            <input type="text" id="telepon_perusahaan" name="telepon_perusahaan" class="w-full border rounded px-3 py-2"
                required>
        </div>
        <div class="mb-4">
            <label for="website_perusahaan" class="block mb-1 font-medium">Website Perusahaan (opsional)</label>
            <input type="url" id="website_perusahaan" name="website_perusahaan" class="w-full border rounded px-3 py-2">
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
                <select name="metode_pembayaran" class="w-full border rounded px-3 py-2" required>
                    <option value="">-- Pilih Metode Pembayaran --</option>
                    <option value="transfer_bank">Transfer Bank (BCA, BNI, Mandiri)</option>
                    <option value="ewallet">E-Wallet (OVO, GoPay, Dana, ShopeePay)</option>
                    <option value="qris">QRIS</option>
                </select>
            </div>
        <?php endif; ?>

        <button type="submit"
            class="mt-6 w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            Kirim Lowongan
        </button>
    </form>
</div>

<script>
    const benefitData = {
        bronze: `<ul class="list-disc pl-5">
                    <li>Dapat memposting 1 lowongan kerja</li>
                    <li>Durasi tayang 15 hari</li>
                    <li>Posisi lowongan hanya tampil di halaman list (tidak di-highlight)</li>
                    <li>Akses ke dashboard perusahaan (edit & kelola lowongan)</li>
                    <li>Notifikasi email untuk setiap lamaran yang masuk</li>
                </ul>`,
        silver: `<ul class="list-disc pl-5">
                    <li>Dapat memposting 3 lowongan kerja</li>
                    <li>Durasi tayang 30 hari</li>
                    <li>Highlight listing (lowongan lebih menonjol di daftar list)</li>
                    <li>Logo perusahaan tampil di listing</li>
                    <li>Fitur filter pelamar</li>
                    <li>Akses ke dashboard perusahaan</li>
                    <li>Notifikasi via email & dashboard</li>
                </ul>`,
        gold: `<ul class="list-disc pl-5">
                    <li>Dapat memposting 7 lowongan kerja</li>
                    <li>Durasi tayang 45 hari</li>
                    <li>Lowongan tampil di posisi atas (priority list)</li>
                    <li>Logo dan profil perusahaan tampil di halaman khusus</li>
                    <li>Fitur filter pelamar</li>
                    <li>Akses ke dashboard perusahaan</li>
                    <li>Publikasi di media sosial (Story)</li>
                    <li>Notifikasi via email & dashboard</li>
                </ul>`,
        diamond: `<ul class="list-disc pl-5">
                    <li>Unlimited posting lowongan kerja</li>
                    <li>Durasi tayang 60 hari</li>
                    <li>Lowongan tampil di top priority</li>
                    <li>Logo dan profil perusahaan tampil di halaman khusus</li>
                    <li>Fitur filter pelamar</li>
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
</script>
</body>

</html>