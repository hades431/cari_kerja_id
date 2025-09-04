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
                <button class="mt-auto"
                    style="background-color:#cd7f32;color:white;padding:0.5rem 1.5rem;border-radius:0.5rem;font-weight:600;">Pilih
                    Paket</button>
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
                <button class="mt-auto"
                    style="background-color:#C0C0C0;color:white;padding:0.5rem 1.5rem;border-radius:0.5rem;font-weight:600;">Pilih
                    Paket</button>
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
                <button class="mt-auto"
                    style="background-color:#FFD700;color:#333;padding:0.5rem 1.5rem;border-radius:0.5rem;font-weight:600;">Pilih
                    Paket</button>
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
                <button class="mt-auto"
                    style="background-color:#00BFFF;color:#fff;padding:0.5rem 1.5rem;border-radius:0.5rem;font-weight:600;">Pilih
                    Paket</button>
            </div>
        </div>
    </div>
</main>
<hr class="border-t border-gray-300 my-0 mt-10">
<footer class="bg-[#e6eef5] mt-auto py-6 px-4">
    <div class="max-w-4xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
        <img src="../img/logo2.png" class="bg-[#00646A] px-6 py-2 rounded w-64 h-20 object-contain">
        <div class="flex gap-4">
            <div class="flex flex-col gap-1">
                <div>
                    <div class="text-xs mb-2">Our social media:</div>
                    <div class="flex items-center gap-6">
                        <a class="text-gray-700 hover:text-orange-600" aria-label="Visit TrendyMinds Instagram" href=""
                            target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-8">
                                <path fill="currentColor"
                                    d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                                </path>
                            </svg>
                        </a>
                        <a class="text-gray-700 hover:text-orange-600" aria-label="Visit TrendyMinds Twitter" href=""
                            target="_blank"><svg class="h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                                <path fill="currentColor"
                                    d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z">
                                </path>
                            </svg>
                        </a>
                        <a class="text-gray-700 hover:text-orange-600" aria-label="Visit TrendyMinds Facebook" href=""
                            target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="h-8">
                                <path fill="currentColor"
                                    d="m279.14 288 14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
</footer>
</body>

</html>