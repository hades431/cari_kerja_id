<?php

$judul_halaman = "Info & Tips Kerja";
include '../header.php';
$data = tampil("SELECT artikel.*, user.username, user.email
FROM artikel
JOIN user ON artikel.id_user = user.id_user")

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
            <input type="text" placeholder="Cari artikel..."
                class="w-full rounded-lg p-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#00646A] mb-8" />
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <?php foreach($data as $row) : ?>
                <div class="bg-white rounded-xl shadow-md p-6 flex flex-col justify-between hover:shadow-xl transition-shadow duration-200">
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
                <button class="bg-white hover:bg-[#e6eef5] text-[#00646A] font-semibold px-4 py-2 rounded shadow transition-colors duration-150 border border-[#00646A]">1</button>
                <!-- Tambahkan tombol pagination lain jika diperlukan -->
            </div>
        </div>
    </div>
</section>

<?php
include '../footer.php';
?>


