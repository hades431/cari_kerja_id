<?php


$judul_halaman = "Detail Card";
include '../header.php'; ?>

<section class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg p-8 mt-10 mb-10">
    <div class="flex justify-between items-start">
        <div>
            <div class="text-2xl font-semibold text-[#00646A]">J's Garage</div>
            <div class="text-[#7b8ca0] text-base mb-2">membuka lowongan</div>
            <div class="text-3xl md:text-4xl font-bold text-[#00646A] leading-tight mb-4">
                Montir
            </div>
        </div>
        <div>
            <img src="../img/montir.jpg"
                alt="montir" class="w-40 h-24 rounded-lg object-cover border" />
        </div>
    </div>
    <hr class="my-4">
    <div class="text-[#23395d] text-lg mb-4">
        J's Garage (<span class="text-[#00646A]">@jgarage</span>) bergerak di bidang Bengkel Mobil dan Motor, saat ini membuka lowongan untuk posisi sebagai:
        <ul class="list-disc ml-6 mt-2">
            <li>Montir</li>
            <li>Sales Associate Parttimer</li>
            <li>Merchandise Analyst</li>
        </ul>
    </div>
    <hr class="my-4">
    <div>
        <div class="text-2xl font-bold text-[#00646A] mb-4">Ringkasan</div>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-y-2 gap-x-8 text-[#23395d] text-base">
            <div class="flex items-center gap-2">
                <span class="text-xl"><i class="fa fa-graduation-cap"></i></span>
                <span>Pendidikan</span>
                <span class="ml-2 text-[#7b8ca0]">: SMA / SMK, D1 - D3, S1 / D4, S1</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xl"><i class="fa fa-briefcase"></i></span>
                <span>Pengalaman</span>
                <span class="ml-2 text-[#7b8ca0]">: 0 - 2 Tahun</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xl"><i class="fa fa-venus"></i></span>
                <span>Gender</span>
                <span class="ml-2 text-[#7b8ca0]">: Pria & Wanita</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xl"><i class="fa fa-money-bill"></i></span>
                <span>Besaran Gaji</span>
                <span class="ml-2 text-[#7b8ca0]">: Kompetitif</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xl"><i class="fa fa-map-marker-alt"></i></span>
                <span>Lokasi Kerja</span>
                <span class="ml-2 text-[#7b8ca0]">: Kota Bandung, Jawa Barat</span>
            </div>
        </div>
    </div>
    <div class="flex gap-4 mt-4">
        <button class="flex items-center gap-2 bg-[#23395d] text-white font-semibold px-8 py-3 rounded-lg shadow hover:bg-[#00646A] transition">
            <i class="fa fa-paper-plane"></i> Lamar
        </button>
        <button class="flex items-center gap-2 border-2 border-[#d1d5db] text-[#23395d] font-semibold px-8 py-3 rounded-lg bg-white hover:bg-gray-100 transition">
            <i class="fa fa-star"></i> Simpan
        </button>
        <button class="flex items-center gap-2 border-2 border-[#d1d5db] text-[#23395d] font-semibold px-8 py-3 rounded-lg bg-white hover:bg-gray-100 transition">
            <i class="fa fa-share-alt"></i> Bagikan
        </button>
    </div>
</section>

<?php include '../footer.php'; ?>