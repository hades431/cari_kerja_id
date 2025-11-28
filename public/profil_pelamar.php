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

// Pisahkan keahlian menjadi wajib dan tambahan
$required_predefined = ['HTML','CSS','JavaScript','PHP','MySQL'];
$additional_predefined = ['React','Node.js','UI/UX','Python'];

$keahlian_wajib = [];
$keahlian_tambahan = [];

foreach ($keahlian as $k) {
    if (in_array($k, $required_predefined)) {
        $keahlian_wajib[] = $k;
    } elseif (in_array($k, $additional_predefined)) {
        $keahlian_tambahan[] = $k;
    } else {
        // keahlian custom masuk ke tambahan
        $keahlian_tambahan[] = $k;
    }
}
?>
<!-- Button Kembali -->
<div class="max-w-4xl mt-4 px-4 flex justify-start">
    <a href="../landing/landing_page.php"
        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition mb-4">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

<!-- Tabs Card Profil -->
<div class="max-w-4xl mx-auto mt-6 mb-6 flex justify-center">
    <div class="flex rounded-full overflow-hidden w-fit shadow" style="background:#00646A;">
        <a href="profil_pelamar.php"
            class="px-8 py-2 font-semibold text-white <?= basename($_SERVER['PHP_SELF']) == 'profil_pelamar.php' ? 'bg-[#00646A]' : 'bg-[#024B4F] hover:bg-[#00646A]' ?> focus:outline-none inline-block text-center">
            Profil
        </a>
        <a href="riwayat_lamaran.php"
            class="px-8 py-2 font-semibold text-white <?= basename($_SERVER['PHP_SELF']) == 'riwayat_lamaran.php' ? 'bg-[#00646A]' : 'bg-[#024B4F] hover:bg-[#00646A]' ?> focus:outline-none inline-block text-center">
            Riwayat Lamaran
        </a>
    </div>

</div>

<!-- Card Profil -->
<div id="card-profil" class="max-w-4xl mx-auto flex flex-col md:flex-row items-start gap-8 px-4">
    <!-- Foto profil kiri -->
    <div class="flex-shrink-0 flex flex-col items-center w-full md:w-56">
        <a href="<?= htmlspecialchars($foto_link) ?>" target="_blank" title="Lihat Foto Profil">
            <img src="<?= htmlspecialchars($foto) ?>"
                class="w-36 h-36 rounded-full border-4 border-white shadow-lg object-cover bg-white hover:opacity-80 transition"
                alt="Foto Profil">
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
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Keahlian</h3>

            <!-- Keahlian Wajib -->
            <div class="mb-6">
                <div class="font-semibold text-sm text-gray-600 mb-2">Keahlian Wajib</div>
                <div class="flex flex-wrap gap-3">
                    <?php if (!empty($keahlian_wajib)): ?>
                    <?php foreach ($keahlian_wajib as $k): ?>
                    <span
                        class="bg-green-100 text-green-700 px-4 py-1 rounded-full text-sm font-medium"><?= htmlspecialchars($k) ?></span>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <span class="text-gray-500 text-sm">Belum ada keahlian wajib.</span>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Keahlian Tambahan -->
            <div>
                <div class="font-semibold text-sm text-gray-600 mb-2">Keahlian Tambahan</div>
                <div class="flex flex-wrap gap-3">
                    <?php if (!empty($keahlian_tambahan)): ?>
                    <?php foreach ($keahlian_tambahan as $k): ?>
                    <span
                        class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm"><?= htmlspecialchars($k) ?></span>
                    <?php endforeach; ?>
                    <?php else: ?>
                    <span class="text-gray-500 text-sm">Belum ada keahlian tambahan.</span>
                    <?php endif; ?>
                </div>
            </div>

            <div class="flex justify-end mt-8 w-full gap-2">
                <a href="edit_profil.php"
                    class="px-6 py-2 bg-[#00646A] text-white rounded-full shadow hover:bg-teal-800 transition">
                    Edit
                </a>
                <!-- Ganti link logout dengan tombol yang memunculkan modal -->
                <button type="button" onclick="openLogoutModal()"
                    class="px-6 py-2 bg-red-500 text-white rounded-full shadow hover:bg-red-600 transition flex items-center gap-2">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </button>
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
                    <a href="../uploads/<?= htmlspecialchars($cv) ?>"
                        class="text-[#00646A] hover:underline flex items-center gap-1" download>
                        <i class="fas fa-download"></i> Download
                    </a>
                    <a href="../uploads/<?= htmlspecialchars($cv) ?>"
                        class="text-blue-600 hover:underline flex items-center gap-1" target="_blank">
                        <i class="fas fa-eye"></i> Lihat
                    </a>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Card Riwayat Lamaran -->
<div id="card-riwayat" class="max-w-4xl mx-auto px-4" style="display:none;">
    <div class="bg-white rounded-xl shadow-lg p-8">
        <h3 class="text-xl font-bold text-[#00646A] mb-4">Riwayat Lamaran</h3>
        <div class="text-gray-500 text-sm">
            Belum ada riwayat lamaran.
            <!-- Nanti isi dengan data lamaran dari database -->
        </div>
    </div>
</div>

<!-- Font Awesome CDN for icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<script>
const tabProfil = document.getElementById('tab-profil');
const tabRiwayat = document.getElementById('tab-riwayat');
const cardProfil = document.getElementById('card-profil');
const cardRiwayat = document.getElementById('card-riwayat');

tabProfil.addEventListener('click', function() {
    tabProfil.classList.add('bg-[#00646A]');
    tabProfil.classList.remove('bg-[#024B4F]');
    tabRiwayat.classList.remove('bg-[#00646A]');
    tabRiwayat.classList.add('bg-[#024B4F]');
    cardProfil.style.display = '';
    cardRiwayat.style.display = 'none';
});

tabRiwayat.addEventListener('click', function() {
    tabRiwayat.classList.add('bg-[#00646A]');
    tabRiwayat.classList.remove('bg-[#024B4F]');
    tabProfil.classList.remove('bg-[#00646A]');
    tabProfil.classList.add('bg-[#024B4F]');
    cardProfil.style.display = 'none';
    cardRiwayat.style.display = '';
});

function openLogoutModal() {
    document.getElementById('logout-modal').classList.remove('hidden');
}

function closeLogoutModal() {
    document.getElementById('logout-modal').classList.add('hidden');
}
</script>

<!-- Modal Logout -->
<div id="logout-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-md w-full text-center relative">
        <button onclick="closeLogoutModal()"
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
        <h2 class="text-2xl font-bold text-[#00646A] mb-2">Konfirmasi Logout</h2>
        <p class="text-gray-500 mb-6">Apakah Anda yakin ingin logout?</p>
        <div class="flex justify-center gap-4">
            <button onclick="closeLogoutModal()"
                class="border border-gray-400 px-6 py-2 rounded text-gray-700 hover:bg-gray-100 font-semibold">Batal</button>
            <button onclick="window.location.href='logout.php'"
                class="border border-red-600 text-red-700 px-6 py-2 rounded hover:bg-red-50 font-semibold">Logout</button>
        </div>
    </div>
</div>
</body>

</html>