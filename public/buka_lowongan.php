<?php

$judul_halaman = "Buka Lowongan Kerja";
include '../header.php';
?>

<!-- Headline Section -->
<section class="bg-white py-6 shadow-md">
    <div class="max-w-4xl mx-auto px-8">
        <h2 class="text-2xl font-bold text-[#00646A] mb-2 text-center">Buka Lowongan Kerja dengan Mudah</h2>
        <p class="text-gray-700 text-center">Pilih paket terbaik untuk perusahaan Anda dan temukan kandidat
            berkualitas dengan cepat.</p>
    </div>
</section>
<main class="flex-grow flex items-center justify-center">
    <div class="w-full max-w-4xl px-8">
        <h1 class="text-3xl font-extrabold text-center mb-10 text-[#00646A] tracking-wide drop-shadow">Paket Buka
            Lowongan</h1>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-x-12 gap-y-8">
            <!-- Card 1: Bronze -->
            <div class="bg-gradient-to-br from-[#cd7f32]/30 to-white rounded-2xl shadow-lg p-8 flex flex-col items-center h-auto min-h-[26rem] transition-transform hover:scale-105 hover:shadow-2xl border-2"
                style="border-color:#cd7f32;">
                <div class="mb-4">
                    <!-- Bronze Icon Image -->
                    <img src="../img/bronze.png" alt="Bronze" class="h-16 w-16 object-contain" />
                </div>
                <h2 class="text-xl font-bold mb-2" style="color:#cd7f32;">Paket Bronze</h2>
                <ul class="text-gray-600 text-left mb-4 list-disc list-inside">
                    <li>Dapat memposting 1 lowongan kerja</li>
                    <li>Durasi tayang 15 hari</li>
                    <li>Posisi lowongan hanya tampil di halaman list (tidak di-highlight)</li>
                    <li>Akses ke dashboard perusahaan (edit & kelola lowongan)</li>
                    <li>Notifikasi email untuk setiap lamaran yang masuk</li>
                </ul>
                <div class="text-lg font-semibold text-[#cd7f32] mb-2">Rp25.000</div>
                <a href="../public/form_buka_lowongan.php?paket=bronze" class="mt-auto"
                    style="background-color:#cd7f32;color:white;padding:0.5rem 1.5rem;border-radius:0.5rem;font-weight:600;">
                    Pilih Paket
                </a>


            </div>
            <!-- Card 2: Silver -->
            <div class="bg-gradient-to-br from-[#C0C0C0]/40 to-white rounded-2xl shadow-lg p-8 flex flex-col items-center h-auto min-h-[26rem] transition-transform hover:scale-105 hover:shadow-2xl border-2"
                style="border-color:#C0C0C0;">
                <div class="mb-4">
                    <!-- Silver Icon Image -->
                    <img src="../img/silver.png" alt="Silver" class="h-16 w-16 object-contain" />
                </div>
                <h2 class="text-xl font-bold mb-2" style="color:#888;">Paket Silver</h2>
                <ul class="text-gray-600 text-left mb-4 list-disc list-inside">
                    <li>Dapat memposting 3 lowongan kerja</li>
                    <li>Durasi tayang 30 hari</li>
                    <li>Highlight listing (lowongan lebih menonjol di daftar list)</li>
                    <li>Logo perusahaan tampil di listing</li>
                    <li>Fitur filter pelamar (misalnya berdasarkan pendidikan/skill dasar)</li>
                    <li>Akses ke dashboard perusahaan (edit & kelola lowongan)</li>
                    <li>Notifikasi via email & dashboard</li>
                </ul>
                <div class="text-lg font-semibold text-[#C0C0C0] mb-2">Rp50.000</div>
                <a href="../public/form_buka_lowongan.php?paket=silver" class="mt-auto"
                    style="background-color:#C0C0C0;color:white;padding:0.5rem 1.5rem;border-radius:0.5rem;font-weight:600;">
                    Pilih Paket
                </a>

            </div>
            <!-- Card 3: Gold -->
            <div class="bg-gradient-to-br from-[#FFD700]/40 to-white rounded-2xl shadow-lg p-8 flex flex-col items-center h-auto min-h-[26rem] transition-transform hover:scale-105 hover:shadow-2xl border-2"
                style="border-color:#FFD700;">
                <div class="mb-4">
                    <!-- Gold Icon Image -->
                    <img src="../img/gold.png" alt="Gold" class="h-16 w-16 object-contain" />
                </div>
                <h2 class="text-xl font-bold mb-2" style="color:#FFD700;">Paket Gold</h2>
                <ul class="text-gray-600 text-left mb-4 list-disc list-inside">
                    <li>Dapat memposting 7 lowongan kerja</li>
                    <li>Durasi tayang 45 hari</li>
                    <li>Lowongan tampil di posisi atas (priority list)</li>
                    <li>Logo dan profil perusahaan tampil di halaman khusus</li>
                    <li>Fitur filter pelamar (misalnya berdasarkan pendidikan/skill dasar)</li>
                    <li>Akses ke dashboard perusahaan (edit & kelola lowongan)</li>
                    <li>Publikasi di semua platform media sosial (Story)</li>
                    <li>Notifikasi via email & dashboard</li>
                </ul>
                <div class="text-lg font-semibold text-[#FFD700] mb-2">Rp75.000</div>
                <a href="../public/form_buka_lowongan.php?paket=gold" class="mt-auto"
                    style="background-color:#FFD700;color:#333;padding:0.5rem 1.5rem;border-radius:0.5rem;font-weight:600;">
                    Pilih Paket
                </a>

            </div>
            <!-- Card 4: Diamond -->
            <div class="bg-gradient-to-br from-[#00BFFF]/60 to-white rounded-2xl shadow-lg p-8 flex flex-col items-center h-auto min-h-[26rem] transition-transform hover:scale-105 hover:shadow-2xl border-2"
                style="border-color:#00BFFF;">
                <div class="mb-4">
                    <!-- Diamond Icon Image -->
                    <img src="../img/diamond.png" alt="Diamond" class="h-16 w-16 object-contain" />
                </div>
                <h2 class="text-xl font-bold mb-2" style="color:#00BFFF;">Paket Diamond</h2>
                <ul class="text-gray-600 text-left mb-4 list-disc list-inside">
                    <li>unlimited posting lowongan kerja</li>
                    <li>Durasi tayang 60 hari</li>
                    <li>Lowongan tampil di top priority (paling atas di homepage)</li>
                    <li>Logo dan profil perusahaan tampil di halaman khusus</li>
                    <li>Fitur filter pelamar (misalnya berdasarkan pendidikan/skill dasar)</li>
                    <li>Profil perusahaan premium (banner, link website, dll)</li>
                    <li>Akses ke dashboard perusahaan (edit & kelola lowongan)</li>
                    <li>Publikasi di semua platform media sosial (Story & Postingan)</li>
                    <li>Notifikasi via email & dashboard</li>
                </ul>
                <div class="text-lg font-semibold text-[#00BFFF] mb-2">Rp100.000</div>
                <a href="../public/form_buka_lowongan.php?paket=diamond" class="mt-auto"
                    style="background-color:#00BFFF;color:#fff;padding:0.5rem 1.5rem;border-radius:0.5rem;font-weight:600;">
                    Pilih Paket
                </a>

            </div>
        </div>
    </div>
</main>
<hr class="border-t border-gray-300 my-0 mt-10">

<?php
include '../footer.php';
?>
</body>

</html>