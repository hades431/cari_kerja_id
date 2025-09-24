<?php

$judul_halaman = "Info & Tips Kerja";
include '../header.php';
$data = tampil("SELECT * FROM artikel")




?>

<section class="bg-[#e6eef5] py-8 px-4 relative overflow-visible">
    <div class="max-w-7xl mx-auto flex flex-col items-center">

        <h1 class="text-4xl md:text-5xl font-semibold text-center text-[#23395d] mb-2 leading-tight">
            Artikel <span class="font-bold text-[#00646A]">Cari Kerja</span>
        </h1>
</section>


<section class="flex justify-center"></section>
<div class="bg-[#00646A] rounded-xl border-4 w-full max-w-xl p-4 flex flex-col space-y-6 mx-auto mt-8">

    <div>
        <input type="text" placeholder="Search..."
            class="w-full rounded-lg p-2 text-gray-700 focus:outline-none focus:ring-2 focus:ring-black" />
    </div>

    <?php
    foreach($data as $row) :
    ?>

    <div class="flex flex-col space-y-2">
        <h2 class="text-center text-white font-semibold"><?php echo $row['judul'] ?></h2>
        <div class="bg-gray-300 h-32 rounded-md flex items-center justify-center text-gray-700"><img src="../img/logo.png" alt="logo"></div>
        <div class="border-b border-white"></div>
        <div class="border-b border-white"></div>
        <div class="border-b border-white"></div>
    </div>
    <?php endforeach; ?>


    <div class="flex justify-center space-x-2 pt-4">
        <button class="bg-white hover:bg-gray-400 text-[#00646A] font-semibold px-3 py-1 rounded">1</button>
    </div>
</div>

<?php
include '../footer.php';
?>


