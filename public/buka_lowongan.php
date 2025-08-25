<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buka Lowongan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-200 flex flex-col min-h-screen">
    <header class="bg-[#00646A] p-4 flex flex-col gap-2">
        <div class="flex items-center justify-between">
            <img src="../img/logo2.png" alt="Logo" class="px-6 py-2 rounded w-64 h-30 object-contain">
        </div>
        <div class="flex justify-end gap-4 mt-2">
            <button class="bg-white px-4 py-1 rounded text-xs">Info & Tips Kerja</button>
            <button class="bg-white px-4 py-1 rounded text-xs">Login</button>
        </div>
    </header>
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
                <div class="bg-gradient-to-br from-[#cd7f32]/30 to-white rounded-2xl shadow-lg p-8 flex flex-col items-center h-64 transition-transform hover:scale-105 hover:shadow-2xl border-2"
                    style="border-color:#cd7f32;">
                    <div class="bg-[#cd7f32] text-white rounded-full p-3 mb-4">
                        <!-- Bronze Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="#cd7f32" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <circle cx="12" cy="12" r="10" fill="#cd7f32" />
                            <path stroke="#fff" stroke-width="2"
                                d="M12 8c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2zm0 2c-2.21 0-4 1.79-4 4v2h8v-2c0-2.21-1.79-4-4-4z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold mb-2" style="color:#cd7f32;">Paket Bronze</h2>
                    <p class="text-gray-600 text-center mb-4">Cocok untuk perusahaan kecil, posting 1 lowongan selama 30
                        hari.</p>
                    <button class="mt-auto"
                        style="background-color:#cd7f32;color:white;padding:0.5rem 1.5rem;border-radius:0.5rem;font-weight:600;">Pilih
                        Paket</button>
                </div>
                <!-- Card 2: Silver -->
                <div class="bg-gradient-to-br from-[#C0C0C0]/40 to-white rounded-2xl shadow-lg p-8 flex flex-col items-center h-64 transition-transform hover:scale-105 hover:shadow-2xl border-2"
                    style="border-color:#C0C0C0;">
                    <div class="bg-[#C0C0C0] text-white rounded-full p-3 mb-4">
                        <!-- Silver Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="#C0C0C0" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <circle cx="12" cy="12" r="10" fill="#C0C0C0" />
                            <path stroke="#fff" stroke-width="2"
                                d="M17 9V7a5 5 0 00-10 0v2a2 2 0 00-2 2v7a2 2 0 002 2h12a2 2 0 002-2v-7a2 2 0 00-2-2z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold mb-2" style="color:#888;">Paket Silver</h2>
                    <p class="text-gray-600 text-center mb-4">Posting hingga 3 lowongan sekaligus, tampil lebih
                        menonjol.</p>
                    <button class="mt-auto"
                        style="background-color:#C0C0C0;color:white;padding:0.5rem 1.5rem;border-radius:0.5rem;font-weight:600;">Pilih
                        Paket</button>
                </div>
                <!-- Card 3: Gold -->
                <div class="bg-gradient-to-br from-[#FFD700]/40 to-white rounded-2xl shadow-lg p-8 flex flex-col items-center h-64 transition-transform hover:scale-105 hover:shadow-2xl border-2"
                    style="border-color:#FFD700;">
                    <div class="bg-[#FFD700] text-white rounded-full p-3 mb-4">
                        <!-- Gold Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="#FFD700" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <circle cx="12" cy="12" r="10" fill="#FFD700" />
                            <path stroke="#fff" stroke-width="2"
                                d="M13 16h-1v-4h-1m4 0h-1v4h-1m-4 0h-1v-4h-1m4 0h-1v4h-1" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold mb-2" style="color:#FFD700;">Paket Gold</h2>
                    <p class="text-gray-600 text-center mb-4">Posting hingga 10 lowongan, prioritas pencarian &
                        highlight.</p>
                    <button class="mt-auto"
                        style="background-color:#FFD700;color:#333;padding:0.5rem 1.5rem;border-radius:0.5rem;font-weight:600;">Pilih
                        Paket</button>
                </div>
                <!-- Card 4: Diamond -->
                <div class="bg-gradient-to-br from-[#00BFFF]/60 to-white rounded-2xl shadow-lg p-8 flex flex-col items-center h-64 transition-transform hover:scale-105 hover:shadow-2xl border-2"
                    style="border-color:#00BFFF;">
                    <div class="bg-[#00BFFF] text-white rounded-full p-3 mb-4">
                        <!-- Diamond Icon -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="#00BFFF" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <polygon points="12,2 22,9 17,22 7,22 2,9" fill="#00BFFF" />
                            <path stroke="#fff" stroke-width="2" d="M12 2 L22 9 L17 22 L7 22 L2 9 Z" />
                        </svg>
                    </div>
                    <h2 class="text-xl font-bold mb-2" style="color:#00BFFF;">Paket Diamond</h2>
                    <p class="text-gray-600 text-center mb-4">Posting tanpa batas, branding perusahaan, support premium
                        & fitur eksklusif.</p>
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
                            <a class="text-gray-700 hover:text-orange-600" aria-label="Visit TrendyMinds Instagram"
                                href="" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"
                                    class="h-8">
                                    <path fill="currentColor"
                                        d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
                                    </path>
                                </svg>
                            </a>
                            <a class="text-gray-700 hover:text-orange-600" aria-label="Visit TrendyMinds Twitter"
                                href="" target="_blank"><svg class="h-8" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 512 512">
                                    <path fill="currentColor"
                                        d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z">
                                    </path>
                                </svg>
                            </a>
                            <a class="text-gray-700 hover:text-orange-600" aria-label="Visit TrendyMinds Facebook"
                                href="" target="_blank"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512"
                                    class="h-8">
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