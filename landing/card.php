<?php


$judul_halaman = "Detail Card";
include '../header.php';
if(isset($_SESSION['user'])){
$id_user = $_SESSION['user']['id'];
}
$id = $_GET['id'] ?? 0;
$sql = "SELECT l.*, p.nama_perusahaan, p.alamat, p.logo 
        FROM lowongan AS l
        LEFT JOIN perusahaan AS p ON l.id_perusahaan = p.id_perusahaan
        WHERE l.id_lowongan = $id";

$data = tampil($sql);

?>

<div class="max-w-3xl mx-auto mt-10 mb-10">
    <a href="landing_page.php"
        class="mb-4 inline-flex items-center gap-2 bg-[#00646A] text-white font-semibold px-6 py-2 rounded-full shadow hover:bg-[#0d7c82] transition">
        <i class="fa fa-arrow-left"></i>
        <span>Kembali</span>
    </a>
    <section class="bg-white rounded-xl shadow-lg p-8">
        <div class="flex justify-between items-start">
            <div>
                <?php if(isset($_GET["error"])): ?>
                <div class="text-red-500 mb-4"><?php echo $_GET["error"] ?></div>
                <?php endif ?>
                <div class="text-2xl font-semibold text-[#00646A]"><?php echo $data[0]["nama_perusahaan"] ?></div>
                <div class="text-[#7b8ca0] text-base mb-2">membuka lowongan</div>
                <div class="text-3xl md:text-4xl font-bold text-[#00646A] leading-tight mb-4">
                    <?php echo $data[0]["posisi"] ?>
                </div>
            </div>
            <div>
                <img src="<?php echo $data[0]["banner"] ?>" alt="montir"
                    class="w-40 h-24 rounded-lg object-cover border" />
            </div>
        </div>
        <hr class="my-4">
        <div class="text-[#23395d] text-lg mb-4">
            <?php echo $data[0]["deskripsi"] ?>
            </ul>
        </div>
        <hr class="my-4">
        <div>
            <div class="text-2xl font-bold text-[#00646A] mb-4">Ringkasan</div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-y-2 gap-x-8 text-[#23395d] text-base">
                <div class="flex items-center gap-2">
                    <span class="text-xl"><i class="fa fa-graduation-cap"></i></span>
                    <span>Pendidikan</span>
                    <span class="ml-2 text-[#7b8ca0]">: <?php echo $data[0]["pendidikan"] ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xl"><i class="fa fa-briefcase"></i></span>
                    <span>Pengalaman</span>
                    <span class="ml-2 text-[#7b8ca0]">:
                        <?php echo str_replace(',', ' - ', $data[0]["pengalaman"]  . " Tahun"); ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xl"><i class="fa fa-venus"></i></span>
                    <span>Gender</span>
                    <span class="ml-2 text-[#7b8ca0]">: <?php echo $data[0]["gender"] ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xl"><i class="fa fa-money-bill"></i></span>
                    <span>Besaran Gaji</span>
                    <span class="ml-2 text-[#7b8ca0]">: <?php echo $data[0]["gaji"] ?></span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xl"><i class="fa fa-map-marker-alt"></i></span>
                    <span>Lokasi Kerja</span>
                    <span class="ml-2 text-[#7b8ca0]">: <?php echo $data[0]["lokasi"] ?></span>
                </div>
            </div>
        </div>
        <div class="flex gap-4 mt-4">
            <button
                class="flex items-center gap-2 bg-[#00646A] text-white font-semibold px-8 py-3 rounded-lg shadow hover:bg-[#0d7c82] transition">
                <i class="fa fa-paper-plane"></i> Lamar
            </button>
            <a href="save.php?id=<?php echo $data[0]["id_lowongan"] ?>"
                class="flex items-center gap-2 border-2 border-[#d1d5db] text-[#23395d] font-semibold px-8 py-3 rounded-lg bg-white hover:bg-gray-100 transition">
                <span class="text-yellow-400"><i class="fa fa-star"></i></span>
                Simpan
            </a>
        </div>
    </section>
</div>

<?php include '../footer.php'; ?>