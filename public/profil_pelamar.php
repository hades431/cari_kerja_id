<?php
$judul_halaman = "Profil Pelamar";
$hide_header_profile = true; // tambahkan ini
include '../header.php';


// Tidak perlu session_start() lagi karena sudah di header.php
if (!isset($_SESSION['user']['id'])) {
    header('Location: ../login/login.php');
    exit;
}

$id_user = $_SESSION['user']['id'];

// Ambil data profil pelamar dari function logic
$pelamar = getProfilPelamarByUserId($id_user);

// Data default jika belum ada
$nama = $pelamar['nama_lengkap'] ?? $_SESSION['user']['nama'] ?? 'Nama Pelamar';
$email = $pelamar['email'] ?? $_SESSION['user']['email'] ?? 'email@pelamar.com';
$telepon = $pelamar['no_hp'] ?? '-';
$alamat = $pelamar['alamat'] ?? '-';
$deskripsi = $pelamar['deskripsi'] ?? 'Belum ada deskripsi.';
$jabatan = $pelamar['jabatan'] ?? '-';
$cv = $pelamar['cv'] ?? '';
$foto = $pelamar['foto'] ?? '';
if (!$foto) {
    $foto = "https://ui-avatars.com/api/?name=" . urlencode($nama) . "&background=2563eb&color=fff&size=128";
    $foto_link = $foto;
} else {
    $foto_link = "../" . htmlspecialchars($foto);
    $foto = $foto_link;
}

// Pengalaman Kerja (dari JSON)
$pengalaman = [];
if (!empty($pelamar['pengalaman'])) {
    $pengalaman = json_decode($pelamar['pengalaman'], true);
}

// Keahlian (dari string ke array)
$keahlian = [];
if (!empty($pelamar['keahlian'])) {
    $keahlian = array_map('trim', explode(',', $pelamar['keahlian']));
}
?>
<!-- Button Kembali -->
<div class="max-w-4xl mt-4 px-4 flex justify-start">
    <a href="../landing/landing_page.php"
        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition mb-4">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>
<!-- Layout profil -->
<div class="max-w-4xl mx-auto flex flex-col md:flex-row items-start gap-8 px-4">
    <!-- Foto profil kiri -->
    <div class="flex-shrink-0 flex flex-col items-center w-full md:w-56">
        <a href="<?= htmlspecialchars($foto_link) ?>" target="_blank" title="Lihat Foto Profil">
            <img src="<?= htmlspecialchars($foto) ?>"
                class="w-36 h-36 rounded-full border-4 border-white shadow-lg object-cover bg-white hover:opacity-80 transition" alt="Foto Profil">
        </a>
    </div>
    <!-- Card utama kanan -->
    <div class="flex-1 bg-white rounded-xl shadow-lg p-8 md:mt-0">
        <div class="flex flex-col items-start">
            <h2 class="text-2xl font-bold text-gray-800"><?= htmlspecialchars($nama) ?></h2>
            <div class="text-[#00646A] font-medium mt-1"><?= htmlspecialchars($jabatan) ?></div>
            <div class="flex flex-col sm:flex-row gap-3 mt-3 text-gray-500 text-sm">
                <span><i class="fas fa-envelope mr-1"></i> <?= htmlspecialchars($email) ?></span>
                <span><i class="fas fa-phone mr-1"></i> <?= htmlspecialchars($telepon) ?></span>
                <span><i class="fas fa-map-marker-alt mr-1"></i> <?= htmlspecialchars($alamat) ?></span>
            </div>
        </div>
        <!-- Section Ringkasan -->
        <div class="mt-10">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Deskripsi</h3>
<div class="bg-gray-100 rounded p-4 text-gray-700"
     style="white-space: pre-line; word-wrap: break-word; overflow-wrap: break-word; word-break: break-all;">
    <?= nl2br(htmlspecialchars($deskripsi)) ?>
</div>
        </div>
        <!-- Section Pengalaman -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Pengalaman Kerja</h3>
            <div class="space-y-4">
                <?php if (!empty($pengalaman['jabatan'])): ?>
                    <?php
                    $count = count($pengalaman['jabatan']);
                    for ($i = 0; $i < $count; $i++):
                        $jab = $pengalaman['jabatan'][$i] ?? '';
                        $perusahaan = $pengalaman['perusahaan'][$i] ?? '';
                        $tahun = $pengalaman['tahun'][$i] ?? '';
                        if (trim($jab) === '' && trim($perusahaan) === '' && trim($tahun) === '') continue;
                    ?>
                    <div>
                        <div class="font-medium text-gray-800">
                            <?= htmlspecialchars($jab) ?>
                            <?php if ($perusahaan): ?>
                                <span class="text-gray-400 font-normal">@ <?= htmlspecialchars($perusahaan) ?></span>
                            <?php endif; ?>
                        </div>
                        <?php if ($tahun): ?>
                            <div class="text-xs text-gray-500 mb-1"><?= htmlspecialchars($tahun) ?></div>
                        <?php endif; ?>
                    </div>
                    <?php endfor; ?>
                <?php else: ?>
                    <div class="text-gray-500 text-sm">Belum ada pengalaman kerja.</div>
                <?php endif; ?>
            </div>
        </div>
        <!-- Section Keahlian -->
        <div class="mt-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Keahlian</h3>
            <div class="flex flex-wrap gap-3">
                <?php if (!empty($keahlian)): ?>
                    <?php foreach ($keahlian as $k): ?>
                        <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm"><?= htmlspecialchars($k) ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="text-gray-500 text-sm">Belum ada keahlian.</span>
                <?php endif; ?>
            </div>
            <div class="flex justify-end mt-8 w-full gap-2">
                <a href="edit_profil.php"
                    class="px-6 py-2 bg-[#00646A] text-white rounded-full shadow hover:bg-teal-800 transition">
                    Edit
                </a>
                <a href="logout.php" class="px-6 py-2 bg-red-500 text-white rounded-full shadow hover:bg-red-600 transition flex items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            </div>
        </div>
        <!-- Section CV -->
        <div class="mt-10">
            <h3 class="text-lg font-semibold text-gray-700 mb-2">Curriculum Vitae (CV)</h3>
            <div class="bg-gray-100 rounded p-4 flex flex-col sm:flex-row items-center gap-4">
                <div class="flex items-center gap-2">
                    <i class="fas fa-file-pdf text-red-500 text-2xl"></i>
                    <span class="text-gray-700 text-sm"><?= $cv ? htmlspecialchars($cv) : 'Belum upload CV' ?></span>
                </div>
                <?php if ($cv): ?>
                <div class="flex gap-2 mt-2 sm:mt-0">
                    <a href="../uploads/<?= htmlspecialchars($cv) ?>" class="text-[#00646A] hover:underline flex items-center gap-1" download>
                        <i class="fas fa-download"></i> Download
                    </a>
                    <a href="../uploads/<?= htmlspecialchars($cv) ?>" class="text-blue-600 hover:underline flex items-center gap-1" target="_blank">
                        <i class="fas fa-eye"></i> Lihat
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<!-- Font Awesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</body>
</html>