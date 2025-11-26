<?php

$judul_halaman = "Info & Tips Kerja";
include '../header.php';
$jumlah_data_halaman = 6; // Number of articles per page
$jumlah_data = count(tampil("SELECT * FROM artikel"));
$jumlah_halaman = ceil($jumlah_data / $jumlah_data_halaman);
$halaman_aktif = (isset($_GET["halaman"])) ? (int)$_GET["halaman"] : 1;
$awal_halaman = ($jumlah_data_halaman * $halaman_aktif) - $jumlah_data_halaman;

$data = tampil("SELECT artikel.*, user.username, user.email
FROM artikel
JOIN user ON artikel.id_user = user.id_user
LIMIT $awal_halaman, $jumlah_data_halaman");
if(isset($_POST['keyword'])) {
    $keyword = $_POST['keyword'];
    $data = tampil("SELECT artikel.*, user.username, user.email
    FROM artikel
    JOIN user ON artikel.id_user = user.id_user
    WHERE artikel.judul LIKE '%$keyword%' OR artikel.isi LIKE '%$keyword%'
    LIMIT $awal_halaman, $jumlah_data_halaman");
}
?>

<section class="bg-[#e6eef5] py-8 px-4 relative overflow-visible">
    <div class="max-w-7xl mx-auto flex flex-col items-center">
        <h1 class="text-4xl md:text-5xl font-semibold text-center text-[#23395d] mb-2 leading-tight">
            Artikel <span class="font-bold text-[#00646A]">Cari Kerja</span>
        </h1>
        <p class="text-lg text-[#23395d] mb-6 text-center max-w-2xl">
            Temukan berbagai info dan tips kerja terbaru untuk mendukung karir Anda.
        </p>
        <div class="w-full max-w-5xl mx-auto">
            <form action="" method="post">
                <?php //aqil ganteng ?>
                <input name="keyword" type="text" placeholder="Cari artikel..."
                    class="w-full rounded-lg p-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#00646A] mb-8" />
            </form>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach($data as $row) : ?>
                <div
                    class="bg-white rounded-xl shadow-md p-6 flex flex-col justify-between hover:shadow-xl transition-shadow duration-200">
                    <div class="flex justify-between items-center mb-2">
                        <span class="text-xs text-gray-500">
                            <?php
                                echo !empty($row['tanggal']) ? date('d M Y', strtotime($row['tanggal'])) : '14 hari lalu';
                            ?>
                        </span>
                    </div>
                    <h2 class="text-2xl font-bold text-[#23395d] mb-2"><?php echo $row['judul'] ?></h2>
                    <p class="text-gray-600 mb-4">
                        <?php echo !empty($row['isi']) ? substr(strip_tags($row['isi']),0,60).'...' : 'Deskripsi artikel belum tersedia.'; ?>
                    </p>
                    <div class="flex items-center justify-between mt-auto pt-2">
                        <div class="flex items-center space-x-2">
                        </div>
                        <a href="detail_artikel.php?id=<?php echo $row['id'] ?>"
                            class="text-[#00646A] text-sm font-semibold hover:underline flex items-center gap-1">
                            Read more <span class="ml-1">&#8594;</span>
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
            <div class="flex justify-center space-x-2 pt-8">
                <?php for($i = 1; $i <= $jumlah_halaman; $i++) : ?>
                <a href="?halaman=<?php echo $i ?>"
                    class="bg-white hover:bg-[#e6eef5] text-[#00646A] font-semibold px-4 py-2 rounded shadow transition-colors duration-150 border border-[#00646A] <?php echo $i === $halaman_aktif ? 'bg-[#00646A] text-black' : '' ?>">
                    <?php echo $i ?>
                </a>
                <?php endfor; ?>
            </div>
        </div>
    </div>
</section>

<?php
include '../footer.php';
?>