<?php

$judul_halaman = "Landing Page";
include '../header.php';
include '../function/sesi_role_aktif.pelamar.php';
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
ORDER BY lowongan.tanggal_post DESC");
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
            Temukan loker Bandung terbaru bulan Oktober 2025 dengan mudah di CariKerjaID.
            <button type="button" id="toggle-info-btn"
                class="ml-2 text-[#23395d] text-xl md:text-2xl font-normal hover:underline transition bg-transparent p-0 border-0 align-baseline"
                onclick="toggleInfoCard()">
                Selengkapnya
            </button>
        </div>

        <div
            class="bg-[#00646A] rounded-[48px] px-8 py-12 flex flex-col items-center mb-8 w-full max-w-4xl shadow-lg z-10 relative">
            <form class="w-full flex flex-col gap-8">
                <div class="flex flex-col md:flex-row gap-6 w-full justify-center items-center">
                    <input type="text" placeholder="Search..."
                        class="bg-white rounded-xl px-4 py-3 w-full md:w-[340px] text-gray-700 text-base font-semibold border-2 border-[#00646A] focus:ring-2 focus:ring-[#00646A] focus:border-[#00646A] transition">
                    <select
                        class="bg-white rounded-xl px-4 py-3 w-full md:w-[340px] text-gray-700 text-base font-semibold border-2 border-[#00646A] focus:ring-2 focus:ring-[#00646A] focus:border-[#00646A] transition">
                        <option value="">Lulusan</option>
                        <option value="sma">SMA/SMK</option>
                        <option value="d3">D3/D4</option>
                        <option value="s1">S1</option>
                        <option value="s2">S2</option>
                    </select>
                </div>
                <div class="flex flex-col md:flex-row gap-8 w-full justify-center items-center justify-center">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="tanpa-pengalaman" name="tanpa_pengalaman"
                            class="accent-[#00646A] w-5 h-5 rounded-full">
                        <label for="tanpa-pengalaman" class="text-white text-sm font-normal">Tanpa pengalaman</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="satu-lima-tahun" name="satu_lima_tahun"
                            class="accent-[#00646A] w-5 h-5 rounded-full">
                        <label for="satu-lima-tahun" class="text-white text-sm font-normal">1-5 Tahun</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="lima-lebih-tahun" name="lima_lebih_tahun"
                            class="accent-[#00646A] w-5 h-5 rounded-full">
                        <label for="lima-lebih-tahun" class="text-white text-sm font-normal">5 Tahun Lebih</label>
                    </div>
                    <div class="flex-1 flex justify-end mt-6 md:mt-0">
                        <button type="submit"
                            class="flex items-center gap-2 bg-white rounded-[32px] px-10 py-4 text-xl font-normal shadow">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-black" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" fill="none" />
                                <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" />
                            </svg>
                            Cari
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div id="info-card"
            class="bg-white rounded-3xl shadow-lg p-8 max-w-2xl w-full mt-[-40px] z-20 relative hidden transition-all duration-300 scale-95 opacity-0">
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
                gi
            }
        }
        </script>
    </div>
</section>


<section class="py-6 px-4">
    <div class="flex flex-wrap gap-4 justify-center">
        <a href="card.php"
            class="bg-white rounded shadow p-4 w-64 hover:shadow-lg hover:scale-105 transition cursor-pointer block">
            <div class="bg-gray-300 h-24 mb-2 rounded"
                style="background-image: url('../img/images.jpg'); background-size: cover; background-position: center;">
            </div>
            <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
        </a>
        <a href="detail_artikel.php?id=2"
            class="bg-white rounded shadow p-4 w-64 hover:shadow-lg hover:scale-105 transition cursor-pointer block">
            <div class="bg-gray-300 h-24 mb-2 rounded"
                style="background-image: url('../img/montir.jpg'); background-size: cover; background-position: center;">
            </div>
            <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
        </a>
        <a href="detail_artikel.php?id=3"
            class="bg-white rounded shadow p-4 w-64 hover:shadow-lg hover:scale-105 transition cursor-pointer block">
            <div class="bg-gray-300 h-24 mb-2 rounded"
                style="background-image: url('../img/barber.jpg'); background-size: cover; background-position: center;">
            </div>
        </a>
    </div>
</section>


<section class="flex flex-col md:flex-row gap-6 px-4">
    <?php foreach($data as $row):  ?>
    <div class="flex-1 flex flex-col gap-4">
        <a href="card.php?id=<?php echo $row["id_lowongan"] ?>"
            class="flex bg-white rounded-2xl shadow p-4 hover:shadow-lg hover:scale-[1.01] transition cursor-pointer items-center max-w-2xl">
            <div class="relative flex-shrink-0">
                <img src="<?php echo $row["banner"] ?>" alt="Arka Corp"
                    class="w-20 h-20 object-contain rounded-lg bg-white border" />
                <span
                    class="absolute -top-2 -left-2 text-white text-lg rounded-tr-lg rounded-bl-lg px-2 py-1 flex items-center">
                    <i class="fa fa-thumbs-up"></i>
                </span>
            </div>
            <div class="flex-1 ml-6">
                <div class="flex justify-between items-center">
                    <span class="text-gray-400 text-base font-medium">Dibutuhkan</span>
                    <span class="flex items-center gap-1 text-gray-400 text-sm">
                        <i class="fa fa-clock"></i>
                        <?php echo formatWaktuLalu($row["created_at"]) ?>
                    </span>
                </div>
                <div class="text-2xl font-bold text-[#23395d] leading-tight mb-1"><?php echo $row["posisi"] ?></div>
                <div class="flex items-center gap-2 text-[#23395d] mb-1">
                    <i class="fa fa-building"></i>
                    <span class="font-medium"><?php echo $row["nama_perusahaan"] ?></span>
                    <i class="fa fa-money-bill text-gray-400 ml-3"></i>
                </div>
                <div class="border-b my-2"></div>
                <div class="flex flex-wrap gap-4 text-gray-600 text-base items-center">
                    <span class="flex items-center gap-1">
                        <i class="fa fa-graduation-cap"></i>
                        <?php echo $row["pendidikan"] ?>
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="fa fa-briefcase"></i>
                        <?php echo str_replace(',', ' - ', $row["pengalaman"]  . " Tahun"); ?>
                    </span>
                    <span class="flex items-center gap-1">
                        <i class="fa fa-map-marker-alt"></i>
                        <?php echo $row["lokasi"] ?>
                    </span>
                </div>
            </div>
        </a>
    </div>
    <?php endforeach; ?>


    <aside class="bg-white rounded shadow p-4 w-full md:w-80">
        <form class="flex flex-col gap-4">
            <input
                class="border rounded-xl px-4 py-3 w-full text-lg font-semibold placeholder-gray-400 shadow-sm focus:outline-none focus:border-[#00646A]"
                placeholder="Searchbar..." />
            <div class="flex gap-3">
                <select
                    class="bg-white rounded-xl px-4 py-3 w-1/2 text-gray-700 text-base font-semibold border-2 focus:border-[#00646A] transition">
                    <option>Lokasi</option>
                    <option value="bandung">Kab.Bandung</option>
                    <option value="baleendah">Kota Bandung</option>
                    <option value="cimahi">Cimahi</option>
                    <option value="cileunyi">Bandung Barat</option>
                    <option value="cicalengka">Sumedang</option>
                </select>

                <select
                    class="bg-white rounded-xl px-4 py-3 w-1/2 text-gray-700 text-base font-semibold border-2 focus:border-[#00646A] transition">
                    <option>Pendidikan</option>
                    <option value="sma">SMA/SMK</option>
                    <option value="d3">D3/D4</option>
                    <option value="s1">S1</option>
                    <option value="s2">S2</option>
                </select>
            </div>
            <select
                class="bg-white rounded-xl px-4 py-3 w-full text-gray-700 text-base font-semibold border-2 focus:border-[#00646A] transition">
                <option>Pengalaman</option>
                <option value="tanpa">Tanpa Pengalaman</option>
                <option value="1-5">1-5 Tahun</option>
                <option value=">5">5 Tahun Lebih</option>
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


<div id="simpan-modal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-30 hidden">
    <div class="bg-white rounded-2xl shadow-xl max-w-lg w-full p-8 relative">
        <button onclick="closeSimpanModal()"
            class="absolute top-4 right-4 text-2xl text-gray-400 hover:text-gray-700 font-bold focus:outline-none">&times;</button>
        <div class="text-2xl md:text-3xl font-semibold text-center text-[#00646A] mb-2">
            <span class="font-bold">Lowongan</span> Tersimpan
        </div>
        <div class="text-center text-gray-500 text-lg mb-10">
            <em>Belum ada lowongan yang disimpan</em>
        </div>
        <div class="flex justify-center">
            <button
                class="border border-[#b03a2e] text-[#b03a2e] px-6 py-2 rounded-lg hover:bg-[#f9ebea] transition font-medium">
                Hapus Semua
            </button>
        </div>
    </div>
</div>
<script>
document.getElementById('open-simpan-modal').onclick = function() {
    document.getElementById('simpan-modal').classList.remove('hidden');
};

function closeSimpanModal() {
    document.getElementById('simpan-modal').classList.add('hidden');
}
</script>


<?php include '../footer.php'; ?>