<?php
$judul_halaman = "Menunggu Verifikasi Admin";
include '../header.php';
?>
<div class="max-w-lg mx-auto mt-20 bg-white p-8 rounded-lg border border-gray-200 shadow-lg text-center">
    <h2 class="text-2xl font-bold mb-4 text-yellow-600">Pendaftaran Berhasil!</h2>
    <p class="mb-4">Data perusahaan Anda telah berhasil dikirim.<br>
    Silakan menunggu proses verifikasi oleh admin sebelum akun perusahaan Anda aktif.</p>
    <p class="mb-6 text-gray-600">Anda akan mendapatkan notifikasi melalui email jika sudah diverifikasi.</p>
    <a href="../login/login.php" class="inline-block bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
        Kembali ke Login
    </a>
</div>
<?php include '../footer.php'; ?>
