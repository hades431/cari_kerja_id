<?php
include '../header.php';
include '../function/sesi_role_aktif.pelamar.php';
include 'delete_save.php';
$user_id = $_SESSION['user']['id'] ?? null;
if(isset($_SESSION['user'])){
$lowongan_simpan = tampil("SELECT 
        l.*, 
        p.nama_perusahaan,
        s.save_lowongan_id
    FROM save_lowongan s
    JOIN lowongan l ON s.lowongan_id = l.id_lowongan
    JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan
    WHERE s.user_id = '{$user_id}' AND l.status = 'aktif'
    ORDER BY s.save_lowongan_id DESC");
}
    if(isset($_POST["hapus_semua"])){
        $hapus_berhasil = hapus_semua_save();
        if($hapus_berhasil < 0){
            echo "<script>alert('Gagal menghapus semua lowongan tersimpan');</script>";
        } else {
            echo "<script>alert('Berhasil menghapus semua lowongan tersimpan');window.location='landing_page.php';</script>";
        } 
    }
function formatWaktuLalu($timestamp) {
    $waktu_lalu = new DateTime($timestamp);
    $sekarang = new DateTime();
    $selisih = $sekarang->diff($waktu_lalu);

    if ($selisih->y > 0) {
        return $selisih->y . ' tahun lalu';
    }
    if ($selisih->m > 0) {
        return $selisih->m . ' bulan lalu';
    }
    if ($selisih->d > 0) {
        if ($selisih->d == 1) {
            return 'Kemarin';
        }
        return $selisih->d . ' hari lalu';
    }
    if ($selisih->h > 0) {
        return $selisih->h . ' jam lalu';
    }
    if ($selisih->i > 0) {
        return $selisih->i . ' menit lalu';
    }
    if ($selisih->s > 0) {
        return $selisih->s . ' detik lalu';
    }
    return 'Baru saja';
}
$nama_user = isset($_SESSION['user']["nama"]) ? $_SESSION['user']["nama"] : null;
$data = tampil("SELECT 
    lowongan.*, 
    perusahaan.nama_perusahaan 
FROM lowongan 
JOIN perusahaan ON lowongan.id_perusahaan = perusahaan.id_perusahaan
WHERE perusahaan.paket IN ('gold', 'silver', 'bronze') AND lowongan.status = 'aktif'
ORDER BY FIELD(perusahaan.paket, 'gold', 'silver', 'bronze'), lowongan.tanggal_post DESC");
$jumlah_data_halaman = 4; // Number of articles per page
$jumlah_data = count(tampil("SELECT 
    lowongan.*, 
    perusahaan.nama_perusahaan 
FROM lowongan 
JOIN perusahaan ON lowongan.id_perusahaan = perusahaan.id_perusahaan
WHERE perusahaan.paket IN ('diamond') AND lowongan.status = 'aktif'
ORDER BY FIELD(perusahaan.paket, 'gold', 'silver', 'bronze'), lowongan.tanggal_post DESC"));
$jumlah_halaman = ceil($jumlah_data / $jumlah_data_halaman);
$halaman_aktif = (isset($_GET["halaman"])) ? (int)$_GET["halaman"] : 1;
$awal_halaman = ($jumlah_data_halaman * $halaman_aktif) - $jumlah_data_halaman;

$diamond = tampil("SELECT 
    lowongan.*, 
    perusahaan.nama_perusahaan 
FROM lowongan 
JOIN perusahaan ON lowongan.id_perusahaan = perusahaan.id_perusahaan
WHERE perusahaan.paket IN ('diamond') AND lowongan.status = 'aktif'
ORDER BY FIELD(perusahaan.paket, 'gold', 'silver', 'bronze'), lowongan.tanggal_post DESC
LIMIT $awal_halaman, $jumlah_data_halaman
");
if($_SERVER['REQUEST_METHOD'] == 'POST'){
    $data = cari($_POST);
    $diamond = cari_diamond($_POST);
}
?>



<!-- Notifikasi Berhasil Login -->
<?php if ($nama_user): ?>
<div id="login-success-alert"
    class="fixed top-6 left-1/2 transform -translate-x-1/2 z-50 bg-green-100 border border-green-400 text-green-800 px-6 py-4 rounded-lg shadow-lg flex items-center gap-3 transition">
    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
    </svg>
    <div>
        <div class="font-bold">Berhasil Login!</div>
        <div>Selamat datang, <span class="font-semibold"><?= htmlspecialchars($nama_user) ?></span> di CariKerjaID.
        </div>
    </div>
    <button onclick="document.getElementById('login-success-alert').style.display='none'"
        class="ml-4 text-xl text-green-700 hover:text-green-900">&times;</button>
</div>
<script>
setTimeout(function() {
    var alert = document.getElementById('login-success-alert');
    if (alert) alert.style.display = 'none';
}, 4000);
</script>
<?php endif; ?>


<section class="bg-[#e6eef5] py-8 px-4 relative overflow-visible">
    <div class="max-w-7xl mx-auto flex flex-col items-center">

        <h1 class="text-4xl md:text-5xl font-semibold text-center text-[#23395d] mb-2 leading-tight">
            Cari Kerja <span class="font-bold text-[#00646A]">Bandung</span>
        </h1>

        <div class="text-xl md:text-2xl text-center text-[#23395d] mb-6 font-normal">
            Temukan loker Bandung terbaru bulan November 2025 dengan mudah di CariKerjaID.
            <button type="button" id="toggle-info-btn"
                class="ml-2 text-[#23395d] text-xl md:text-2xl font-normal hover:underline transition bg-transparent p-0 border-0 align-baseline"
                onclick="toggleInfoCard()">
                Selengkapnya
            </button>
        </div>



        <div id="info-card"
            class="bg-white rounded-xl shadow-md p-6 max-w-xl w-full mt-[-40px] z-20 relative hidden transition-all duration-300 scale-95 opacity-0 mx-auto">
            <div class="text-lg text-gray-800 leading-relaxed">
                <span class="font-semibold">CariKerjaID</span> adalah platform informasi <a href="#"
                    class="text-[#00646A] underline">lowongan kerja Bandung</a>.<br>
                lowongan kerja yang dirancang untuk memudahkan pencari kerja
                menemukan peluang sesuai minat, keterampilan, dan lokasi. Kami berkomitmen menjadi penghubung antara
                perusahaan dan talenta terbaik, dengan menghadirkan informasi lowongan yang terbaru, terpercaya, dan
                relevan.

                Melalui CariKerjaID, pencari kerja bisa dengan mudah menelusuri berbagai kategori pekerjaan,
                sementara perusahaan dapat menemukan kandidat potensial dengan cepat dan tepat.

                Visi kami adalah membantu mempercepat proses rekrutmen dan membuka akses karier yang lebih luas bagi
                semua orang.
                Misi kami adalah menyediakan informasi lowongan kerja yang akurat, user-friendly, serta mendukung
                pencari kerja dan perusahaan untuk berkembang bersama.
            </div>
        </div>
        <script>
        function toggleInfoCard() {
            const card = document.getElementById('info-card');
            const btn = document.getElementById('toggle-info-btn');
            const isHidden = card.classList.contains('hidden');
            if (isHidden) {
                card.classList.remove('hidden');
                setTimeout(() => {
                    card.classList.remove('scale-95', 'opacity-0');
                    card.classList.add('scale-100', 'opacity-100');
                }, 10);
                btn.textContent = 'Minimalkan';
            } else {
                card.classList.remove('scale-100', 'opacity-100');
                card.classList.add('scale-95', 'opacity-0');
                setTimeout(() => {
                    card.classList.add('hidden');
                }, 300);
                btn.textContent = 'Selengkapnya';
            }
        }
        </script>


        <!-- END: Large horizontal searchbar (baru) -->

    </div>
</section>
<script>
// Toggle pengalaman pills
(function() {
    const pills = document.querySelectorAll('.exp-pill');
    const input = document.getElementById('pengalaman-input');

    function clearActive() {
        pills.forEach(p => {
            p.classList.remove('bg-[#00646A]', 'text-white', 'border-[#00646A]');
        });
    }
    pills.forEach(p => {
        p.addEventListener('click', function() {
            const val = this.getAttribute('data-value');
            clearActive();
            this.classList.add('bg-[#00646A]', 'text-white', 'border-[#00646A]');
            if (input) input.value = val;
        });
    });
    // jika server-side sudah memberi nilai, aktifkan pill yang sesuai
    const serverVal = "<?php echo isset($_POST['pengalaman']) ? addslashes($_POST['pengalaman']) : '' ?>";
    if (serverVal && pills.length) {
        pills.forEach(p => {
            if (p.getAttribute('data-value') === serverVal) {
                p.classList.add('bg-[#00646A]', 'text-white', 'border-[#00646A]');
            }
        });
    }
})();
</script>
<section class="py-6 px-4 relative">
    <div class="relative max-w-[90rem] mx-auto overflow-hidden">
        <!-- Previous Button -->
        <?php if($halaman_aktif > 1): ?>
        <a href="?halaman=<?php echo $halaman_aktif - 1 ?>"
            class="absolute left-4 top-1/2 -translate-y-1/2 z-10 bg-white/80 backdrop-blur rounded-full p-3 shadow-lg hover:bg-white hover:scale-110 transition-all duration-300 ease-out group">
            <i
                class="fas fa-chevron-left text-[#00646A] text-xl transition-transform duration-300 group-hover:-translate-x-1"></i>
        </a>
        <?php endif; ?>

        <!-- Next Button -->
        <?php if($halaman_aktif < $jumlah_halaman): ?>
        <a href="?halaman=<?php echo $halaman_aktif + 1 ?>"
            class="absolute right-4 top-1/2 -translate-y-1/2 z-10 bg-white/80 backdrop-blur rounded-full p-3 shadow-lg hover:bg-white hover:scale-110 transition-all duration-300 ease-out group">
            <i
                class="fas fa-chevron-right text-[#00646A] text-xl transition-transform duration-300 group-hover:translate-x-1"></i>
        </a>
        <?php endif; ?>

        <!-- Cards Container with smooth transition -->
        <div class="px-16 transition-all duration-500 ease-out">
            <div class="flex flex-wrap gap-4 justify-center">
                <?php foreach($diamond as $index => $row): ?>
                <a href="card.php?id=<?php echo $row['id_lowongan'] ?>"
                    class="bg-white rounded shadow p-4 w-64 hover:shadow-lg hover:scale-105 transition cursor-pointer block">
                    <!-- Banner Preview -->
                    <?php
$bannerUrl = '../img/no-image.png'; 

if (!empty($row["banner"])) {
    $banner = $row["banner"];
    
    // Jika hanya filename → tambah folder
    if (strpos($banner, '/') === false) {
        $bannerUrl = '../uploads/banners/' . $banner;
    } else {
        // Jika sudah ada path lengkap
        $bannerUrl = '../' . $banner;
    }
}
?>
                    <div class="bg-gray-300 h-40 mb-3 rounded overflow-hidden">

                        <img src="<?= htmlspecialchars($bannerUrl) ?>" alt="Banner" class="w-full h-full object-cover"
                            onerror="this.src='../assets/images/default-banner.png'">
                    </div>

                    <h3 class="text-lg font-semibold text-[#23395d]"><?php echo htmlspecialchars($row["judul"]) ?></h3>
                    <p class="text-sm text-gray-500"><?php echo htmlspecialchars($row["nama_perusahaan"]) ?></p>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-2">
                        <i class="fa fa-graduation-cap"></i>
                        <?php echo strtoupper(str_replace(',', ' - ', $row["pendidikan"])) ?>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-1">
                        <i class="fa fa-briefcase"></i>
                        <?php echo ucfirst(str_replace(',', ' - ', $row['pengalaman'] . " Pengalaman")); ?>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-1">
                        <i class="fa fa-map-marker-alt"></i>
                        <?php echo htmlspecialchars($row["lokasi"]) ?>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-1">
                        <i class="fa fa-money-bill"></i>
                        <?php echo 'Rp ' . number_format($row['gaji'], 0, ',', '.') ?>
                    </div>
                    <div class="flex items-center gap-2 text-sm text-gray-500 mt-1">
                        <i class="fa fa-clock"></i>
                        <?php 
                        $tanggal = date('Y-m-d', strtotime($row["created_at"]));
                        echo $tanggal ?>
                    </div>
                </a>
                <?php endforeach; ?>
            </div>
        </div>

        <!-- Optional: Small page indicator -->
        <?php if($jumlah_halaman > 1): ?>
        <div class="flex justify-center items-center gap-2 mt-4">
            <?php for($i = 1; $i <= $jumlah_halaman; $i++): ?>
            <span
                class="h-2 w-2 rounded-full <?php echo $i == $halaman_aktif ? 'bg-[#00646A]' : 'bg-gray-300' ?>"></span>
            <?php endfor; ?>
        </div>
        <?php endif; ?>
    </div>
</section>


<section class="flex flex-col md:flex-row gap-6 px-4">
    <div class="flex-1 flex flex-col gap-6">
        <?php foreach($data as $row): ?>
        <a href="card.php?id=<?php echo $row['id_lowongan'] ?>"
            class="w-full max-w-3xl bg-white rounded-2xl shadow p-6 hover:shadow-lg transition-transform duration-200 ease-out transform hover:-translate-y-2 mx-auto block">
            <div class="flex items-start gap-6">
                <!-- Banner thumbnail on the left -->
                <?php if (!empty($row['banner'])): ?>
                <div class="flex-shrink-0">
                    <img src="<?php echo htmlspecialchars('../'.$row['banner']) ?>" alt="Banner"
                        class="w-24 h-24 object-cover rounded shadow" />
                </div>
                <?php else: ?>
                <div
                    class="flex-shrink-0 w-24 h-24 bg-gradient-to-br from-teal-400 to-teal-600 rounded flex items-center justify-center text-white text-3xl">
                    💼
                </div>
                <?php endif; ?>

                <div class="flex-1">
                    <div class="flex justify-between items-start">
                        <div class="text-sm text-gray-400">dibutuhkan</div>
                        <div class="text-sm text-gray-400 flex items-center gap-2">
                            <i class="fa fa-clock"></i>
                            <?php 
                            $tanggal = date('Y-m-d', strtotime($row["created_at"])); 
                            echo $tanggal ?>
                        </div>
                    </div>

                    <h3 class="text-2xl md:text-3xl font-bold text-[#23395d] mt-1 mb-1">
                        <?php echo htmlspecialchars($row['posisi'] ?? $row['judul']) ?>
                    </h3>

                    <div class="flex items-center gap-4 mb-3">
                        <div class="flex items-center gap-2 text-[#23395d]">
                            <i class="fa fa-building"></i>
                            <span class="font-medium"><?php echo htmlspecialchars($row['nama_perusahaan']) ?></span>
                        </div>
                        <div class="ml-auto text-sm text-gray-500 flex items-center gap-2">
                            <i class="fa fa-money-bill"></i>
                            <span><?php echo 'Rp ' . number_format($row['gaji'], 0, ',', '.') ?></span>
                        </div>
                    </div>

                    <div class="border-t my-2"></div>

                    <div class="flex flex-wrap gap-4 text-gray-600 text-base items-center mt-2">
                        <span class="flex items-center gap-2">
                            <i class="fa fa-graduation-cap"></i>
                            <?php echo strtoupper(str_replace(',', '-', $row["pendidikan"])) ?>
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fa fa-briefcase"></i>
                            <?php echo ucfirst(str_replace(',', ' - ', $row['pengalaman'] . " Pengalaman")); ?>
                        </span>
                        <span class="flex items-center gap-2">
                            <i class="fa fa-map-marker-alt"></i>
                            <?php echo htmlspecialchars($row['lokasi']) ?>
                        </span>
                    </div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>

    <aside class="bg-white rounded shadow p-4 w-full md:w-80">
        <form method="post" class="flex flex-col gap-4">
            <input autocomplete="off" name="search" type="text"
                class="border rounded-xl px-4 py-3 w-full text-lg font-semibold placeholder-gray-400 shadow-sm focus:outline-none focus:border-[#00646A]"
                placeholder="Bidang..." />
            <div class="flex gap-3">
                <select name="lokasi"
                    class="bg-white rounded-xl px-4 py-3 w-1/2 text-gray-700 text-base font-semibold border-2 focus:border-[#00646A] transition">
                    <option>Lokasi</option>
                    <option value="baleendah">Baleendah</option>
                    <option value="banjaran">Banjaran</option>
                    <option value="bojongsoang">Bojongsoang</option>
                    <option value="cileunyi">Cileunyi</option>
                    <option value="dayeuhkolot">Dayeuhkolot</option>
                    <option value="Kab.Bandung">Kab.Bandung</option>
                </select>

                <select name="pendidikan"
                    class="bg-white rounded-xl px-4 py-3 w-1/2 text-gray-700 text-base font-semibold border-2 focus:border-[#00646A] transition">
                    <option>Pendidikan</option>
                    <option value="sma">SMA/SMK</option>
                    <option value="d3">D3/D4</option>
                    <option value="s1">S1</option>
                    <option value="s2">S2</option>
                </select>
            </div>
            <select name="pengalaman"
                class="bg-white rounded-xl px-4 py-3 w-full text-gray-700 text-base font-semibold border-2 focus:border-[#00646A] transition">
                <option>Pengalaman</option>
                <option value="tanpa">Tanpa Pengalaman</option>
                <option value="1-4">1-4 Tahun</option>
                <option value=">4">4 Tahun Lebih</option>
            </select>
            <button type="submit"
                class="flex items-center justify-center gap-2 bg-[#00646A] text-white rounded-xl px-4 py-3 w-full text-lg font-semibold shadow">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" fill="none" />
                    <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" />
                </svg>
                Cari
            </button>
            <hr class="my-2" />
            <div class="flex justify-center">
                <button type="button" id="open-simpan-modal"
                    class="group flex items-center justify-center gap-2 border rounded-xl px-4 py-3 w-2/3 text-[#23395d] text-lg font-semibold bg-white hover:bg-[#00646A] hover:text-white transition">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5 text-[#23395d] group-hover:text-white transition" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <polygon
                            points="12,17.27 18.18,21 16.54,13.97 22,9.24 14.81,8.63 12,2 9.19,8.63 2,9.24 7.46,13.97 5.82,21"
                            stroke="currentColor" stroke-width="2" fill="none" />
                    </svg>
                    Save
                </button>
            </div>
        </form>
    </aside>
</section>


<!-- Improved Save Modal -->
<div id="simpan-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 hidden">
    <div class="bg-white rounded-2xl shadow-xl max-w-2xl w-full p-6 relative mx-4">
        <button id="simpan-modal-close"
            class="absolute top-4 right-4 text-2xl text-gray-400 hover:text-gray-700 font-bold focus:outline-none">&times;</button>

        <div class="flex items-center justify-between mb-4">
            <div>
                <h3 class="text-2xl font-semibold text-[#00646A]">Lowongan Tersimpan</h3>
                <p id="simpan-count" class="text-sm text-gray-500 mt-1">
                    <?php echo (isset($lowongan_simpan) && count($lowongan_simpan) > 0) ? count($lowongan_simpan) . " item" : "Belum ada lowongan tersimpan"; ?>
                </p>
            </div>
            <form action="" method="post">
                <button name="hapus_semua" id="hapus-semua-btn"
                    class="text-sm bg-red-50 text-red-700 border border-red-200 px-3 py-2 rounded hover:bg-red-100 transition disabled:opacity-60 mr-4"
                    <?php echo (isset($lowongan_simpan) && count($lowongan_simpan) > 0) ? '' : 'disabled'; ?>>
                    Hapus Semua
                </button>
            </form>
        </div>

        <div id="simpan-list" class="max-h-72 overflow-y-auto space-y-3 pr-2">
            <?php if(isset($lowongan_simpan) && count($lowongan_simpan) > 0): ?>
            <?php foreach($lowongan_simpan as $index): ?>
            <div class="flex items-center gap-4 rounded-lg p-3 border hover:shadow-sm transition"
                data-id="<?php echo $index['save_lowongan_id']; ?>">
                <?php if(!empty($index['banner'])): ?>
                <img src="../<?php echo htmlspecialchars($index['banner']) ?>" alt="Banner"
                    class="w-16 h-12 object-cover rounded">
                <?php else: ?>
                <img src="../img/no-image.png" alt="Banner" class="w-16 h-12 object-cover rounded">
                <?php endif; ?>

                <div class="flex-1">
                    <a href="card.php?id=<?php echo $index['id_lowongan'] ?>"
                        class="block text-sm font-semibold text-[#23395d] hover:underline">
                        <?php echo htmlspecialchars($index['judul'] ?? $index['posisi'] ?? '-'); ?>
                    </a>
                    <div class="text-xs text-gray-500 mt-1">
                        <?php echo htmlspecialchars($index['nama_perusahaan']); ?> &middot;
                        <?php echo htmlspecialchars($index['lokasi'] ?? '-'); ?>
                    </div>
                </div>

                <div class="flex flex-row items-center gap-2">
                    <a href="hapus.php?id_save=<?php echo $index["save_lowongan_id"] ?>"
                        class="remove-simpan-btn text-xs text-red-600 border border-red-100 bg-red-50 px-2 py-1 rounded hover:bg-red-100 transition">
                        Hapus
                    </a>
                    <a href="card.php?id=<?php echo $index['id_lowongan'] ?>"
                        class="text-xs text-[#00646A] hover:underline">Lihat</a>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div id="simpan-empty" class="text-center text-gray-500 py-8">

                <div class="text-lg font-medium">Belum ada lowongan yang disimpan</div>
                <div class="text-sm mt-2">Simpan lowongan untuk melihatnya nanti.</div>
            </div>
            <?php endif; ?>
        </div>

        <div class="mt-5 flex justify-end gap-3">
            <button id="simpan-modal-close-cta"
                class="px-4 py-2 rounded bg-[#00646A] text-white hover:bg-black transition">Tutup</button>
        </div>
    </div>
</div>

<script>
(function() {
    const openBtn = document.getElementById('open-simpan-modal');
    const modal = document.getElementById('simpan-modal');
    const closeBtn = document.getElementById('simpan-modal-close');
    const closeCta = document.getElementById('simpan-modal-close-cta');
    const list = document.getElementById('simpan-list');
    const countEl = document.getElementById('simpan-count');

    function updateCount() {
        const items = list.querySelectorAll('[data-id]');
        if (items.length === 0) {
            countEl.textContent = 'Belum ada lowongan tersimpan';
            hapusSemuaBtn.setAttribute('disabled', 'disabled');
            // show empty UI if present
            const empty = document.getElementById('simpan-empty');
            if (!empty) {
                const emptyHtml =
                    '<div id="simpan-empty" class="text-center text-gray-500 py-8"><svg xmlns="http://www.w3.org/2000/svg" class="inline w-12 h-12 mb-3 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 7h18M5 7v12a1 1 0 001 1h12a1 1 0 001-1V7M10 11v6M14 11v6" /></svg><div class="text-lg font-medium">Belum ada lowongan yang disimpan</div><div class="text-sm mt-2">Simpan lowongan untuk melihatnya nanti.</div></div>';
                list.innerHTML = emptyHtml;
            }
        } else {
            countEl.textContent = items.length + ' item';
            hapusSemuaBtn.removeAttribute('disabled');
            const empty = document.getElementById('simpan-empty');
            if (empty) empty.remove();
        }
    }

    openBtn && openBtn.addEventListener('click', function() {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    });

    function closeModal() {
        modal.classList.add('hidden');
        document.body.style.overflow = '';
    }

    closeBtn && closeBtn.addEventListener('click', closeModal);
    closeCta && closeCta.addEventListener('click', closeModal);

    // close on backdrop click (but not when clicking inside content)
    modal && modal.addEventListener('click', function(e) {
        if (e.target === modal) closeModal();
    });

    // delegate remove buttons
    list && list.addEventListener('click', function(e) {
        if (e.target && e.target.classList.contains('remove-simpan-btn')) {
            const item = e.target.closest('[data-id]');
            if (!item) return;
            // Optionally: send fetch to server to delete saved item by id
            // const id = item.getAttribute('data-id');
            // fetch('/path/to/delete', { method: 'POST', body: new URLSearchParams({ id }) });

            item.remove();
            updateCount();
        }
    });

    hapusSemuaBtn && hapusSemuaBtn.addEventListener('click', function() {
        if (!confirm('Hapus semua lowongan tersimpan? Tindakan ini tidak dapat dibatalkan.')) return;

        // remove all items client-side
        const items = list.querySelectorAll('[data-id]');
        items.forEach(i => i.remove());
        updateCount();
    });

    // initial count update
    updateCount();
})();
</script>


<?php include '../footer.php'; ?>