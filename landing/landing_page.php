<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-[#00646A] p-4 flex flex-col gap-2">
        <div class="flex items-center justify-between">
            <img src="../foto/logo.png" alt="Logo" class="px-6 py-2 rounded w-64 h-30 object-contain">
        </div>
        <div class="flex justify-end gap-4 mt-2">
            <button class="bg-white px-4 py-1 rounded text-xs">Info & Tips Kerja</button>
            <button class="bg-white px-4 py-1 rounded text-xs">Login</button>
        </div>
    </header>

    <!-- Hero Section -->
    <section class="bg-gray-200 py-8 px-4">
        <div class="max-w-5xl mx-auto">
            <div class="bg-white p-4 rounded shadow mb-4">
                <h1 class="text-xl font-semibold">Headline</h1>
            </div>
            <div class="flex gap-4 justify-center mb-4">
                <button class="bg-white px-4 py-2 rounded shadow text-sm">Info Lowongan</button>
                <button class="bg-white px-4 py-2 rounded shadow text-sm">Buka Lowongan</button>
            </div>
            <!-- Search Box Start -->
            <div class="bg-[#00646A] rounded-[48px] px-8 py-12 flex flex-col items-center mb-8 w-full">
                <form class="w-full flex flex-col gap-8">
                    <div class="flex flex-col md:flex-row gap-8 w-full justify-center items-center">
                        <input type="text" placeholder="Nama perusahaan" class="bg-white rounded px-4 py-2 w-full md:w-[340px] text-gray-700" />
                        <select class="bg-white rounded px-4 py-2 w-full md:w-[340px] text-gray-700">
                            <option value="">Lulusan</option>
                            <option value="sma">SMA/SMK</option>
                            <option value="d3">D3</option>
                            <option value="s1">S1</option>
                            <option value="s2">S2</option>
                        </select>
                    </div>
                   <div class="flex flex-col md:flex-row gap-8 w-full justify-center items-center">
                        <button type="button" class="bg-white rounded-full px-6 py-2 text-gray-700 text-sm font-normal focus:bg-gray-200 transition">Tanpa pengalaman</button>
                        <button type="button" class="bg-white rounded-full px-6 py-2 text-gray-700 text-sm font-normal focus:bg-gray-200 transition">1-5 Tahun</button>
                        <button type="button" class="bg-white rounded-full px-6 py-2 text-gray-700 text-sm font-normal focus:bg-gray-200 transition">5 Tahun Lebih</button>
                        <div class="flex-1 flex justify-end mt-6 md:mt-0">
                            <button type="submit" class="flex items-center gap-2 bg-white rounded-[32px] px-10 py-4 text-xl font-normal shadow">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" fill="none"/>
                                    <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                                </svg>
                                Cari
                            </button>
                        </div>
                    </div>
                </form>
            </div>
            <!-- Search Box End -->
        </div>
    </section>

    <!-- Feature Cards -->
    <section class="py-6 px-4">
        <div class="flex flex-wrap gap-4 justify-center">
            <div class="bg-white rounded shadow p-4 w-64">
                <div class="bg-gray-300 h-24 mb-2 rounded"></div>
                <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                <div class="h-3 bg-gray-100 rounded w-1/2 mb-1"></div>
                <div class="h-3 bg-gray-100 rounded w-1/3"></div>
            </div>
            <div class="bg-white rounded shadow p-4 w-64">
                <div class="bg-gray-300 h-24 mb-2 rounded"></div>
                <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                <div class="h-3 bg-gray-100 rounded w-1/2 mb-1"></div>
                <div class="h-3 bg-gray-100 rounded w-1/3"></div>
            </div>
            <div class="bg-white rounded shadow p-4 w-64">
                <div class="bg-gray-300 h-24 mb-2 rounded"></div>
                <div class="h-4 bg-gray-200 rounded w-3/4 mb-2"></div>
                <div class="h-3 bg-gray-100 rounded w-1/2 mb-1"></div>
                <div class="h-3 bg-gray-100 rounded w-1/3"></div>
            </div>
        </div>
    </section>

    <!-- List Section -->
    <section class="flex flex-col md:flex-row gap-6 px-4">
        <div class="flex-1 flex flex-col gap-4">
            <?php for($i=0;$i<3;$i++): ?>
            <div class="bg-white rounded shadow flex p-4 gap-4 items-center">
                <div class="bg-gray-300 h-20 w-24 rounded"></div>
                <div class="flex-1">
                    <div class="h-4 bg-gray-200 rounded w-1/2 mb-2"></div>
                    <div class="h-3 bg-gray-100 rounded w-1/3 mb-1"></div>
                    <div class="h-3 bg-gray-100 rounded w-1/4 mb-1"></div>
                    <div class="flex gap-2 mt-2">
                        <div class="h-3 bg-gray-200 rounded w-12"></div>
                        <div class="h-3 bg-gray-200 rounded w-12"></div>
                    </div>
                </div>
            </div>
            <?php endfor; ?>
        </div>
        <!-- Sidebar -->
        <aside class="bg-white rounded shadow p-4 w-full md:w-80">
            <form class="flex flex-col gap-4">
                <input class="border rounded-xl px-4 py-3 w-full text-lg font-semibold placeholder-gray-400 shadow-sm focus:outline-none" placeholder="Searchbar..." />
                <div class="flex gap-3">
                    <select class="border rounded-xl px-4 py-3 w-1/2 font-semibold shadow-sm focus:outline-none">
                        <option>Lokasi</option>
                        <option value="bandung">Bandung</option>
                        <option value="baleendah">Baleendah</option>
                        <!-- ...opsi lokasi lain... -->
                    </select>
                    <select class="border rounded-xl px-4 py-3 w-1/2 font-semibold shadow-sm focus:outline-none">
                        <option>Pendidikan</option>
                        <option value="sma">SMA/SMK</option>
                        <option value="d3">D3</option>
                        <option value="s1">S1</option>
                        <option value="s2">S2</option>  
                        <!-- ...opsi pendidikan lain... -->
                    </select>
                </div>
                <button type="submit" class="flex items-center justify-center gap-2 bg-[#00646A] text-white rounded-xl px-4 py-3 w-full text-lg font-semibold shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <circle cx="11" cy="11" r="7" stroke="currentColor" stroke-width="2" fill="none"/>
                        <line x1="16.5" y1="16.5" x2="21" y2="21" stroke="currentColor" stroke-width="2" stroke-linecap="round"/>
                    </svg>
                    Cari
                </button>
                <hr class="my-2" />
                <div class="flex justify-center"> <!-- Tambahkan wrapper flex untuk memusatkan -->
                    <button type="button" class="flex items-center justify-center gap-2 border rounded-xl px-4 py-3 w-2/3 text-[#23395d] text-lg font-semibold bg-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#23395d]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <polygon points="12,17.27 18.18,21 16.54,13.97 22,9.24 14.81,8.63 12,2 9.19,8.63 2,9.24 7.46,13.97 5.82,21" stroke="currentColor" stroke-width="2" fill="none"/>
                        </svg>
                        Save
                    </button>   
                </div>
            </form>
        </aside>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-200 mt-auto py-6 px-4">
        <div class="max-w-4xl mx-auto flex flex-col md:flex-row justify-between items-center gap-4">
            <img src="../foto/logo.png" class="bg-[#00646A] px-6 py-2 rounded w-64 h-20 object-contain">
            <div class="flex gap-4">
                <div class="flex flex-col gap-1">
                <div>
                    <div class="text-xs mb-2">Our social media:</div>
                    <div class="flex items-center gap-6">
                        <a class="text-gray-700 hover:text-orange-600" aria-label="Visit TrendyMinds Instagram" href="" target="_blank"><svg
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-8">
            <path fill="currentColor"
                d="M224.1 141c-63.6 0-114.9 51.3-114.9 114.9s51.3 114.9 114.9 114.9S339 319.5 339 255.9 287.7 141 224.1 141zm0 189.6c-41.1 0-74.7-33.5-74.7-74.7s33.5-74.7 74.7-74.7 74.7 33.5 74.7 74.7-33.6 74.7-74.7 74.7zm146.4-194.3c0 14.9-12 26.8-26.8 26.8-14.9 0-26.8-12-26.8-26.8s12-26.8 26.8-26.8 26.8 12 26.8 26.8zm76.1 27.2c-1.7-35.9-9.9-67.7-36.2-93.9-26.2-26.2-58-34.4-93.9-36.2-37-2.1-147.9-2.1-184.9 0-35.8 1.7-67.6 9.9-93.9 36.1s-34.4 58-36.2 93.9c-2.1 37-2.1 147.9 0 184.9 1.7 35.9 9.9 67.7 36.2 93.9s58 34.4 93.9 36.2c37 2.1 147.9 2.1 184.9 0 35.9-1.7 67.7-9.9 93.9-36.2 26.2-26.2 34.4-58 36.2-93.9 2.1-37 2.1-147.8 0-184.8zM398.8 388c-7.8 19.6-22.9 34.7-42.6 42.6-29.5 11.7-99.5 9-132.1 9s-102.7 2.6-132.1-9c-19.6-7.8-34.7-22.9-42.6-42.6-11.7-29.5-9-99.5-9-132.1s-2.6-102.7 9-132.1c7.8-19.6 22.9-34.7 42.6-42.6 29.5-11.7 99.5-9 132.1-9s102.7-2.6 132.1 9c19.6 7.8 34.7 22.9 42.6 42.6 11.7 29.5 9 99.5 9 132.1s2.7 102.7-9 132.1z">
            </path>
        </svg>
    </a>
                        <a class="text-gray-700 hover:text-orange-600" aria-label="Visit TrendyMinds Twitter" href="" target="_blank"><svg
            class="h-8" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
            <path fill="currentColor"
                d="M459.37 151.716c.325 4.548.325 9.097.325 13.645 0 138.72-105.583 298.558-298.558 298.558-59.452 0-114.68-17.219-161.137-47.106 8.447.974 16.568 1.299 25.34 1.299 49.055 0 94.213-16.568 130.274-44.832-46.132-.975-84.792-31.188-98.112-72.772 6.498.974 12.995 1.624 19.818 1.624 9.421 0 18.843-1.3 27.614-3.573-48.081-9.747-84.143-51.98-84.143-102.985v-1.299c13.969 7.797 30.214 12.67 47.431 13.319-28.264-18.843-46.781-51.005-46.781-87.391 0-19.492 5.197-37.36 14.294-52.954 51.655 63.675 129.3 105.258 216.365 109.807-1.624-7.797-2.599-15.918-2.599-24.04 0-57.828 46.782-104.934 104.934-104.934 30.213 0 57.502 12.67 76.67 33.137 23.715-4.548 46.456-13.32 66.599-25.34-7.798 24.366-24.366 44.833-46.132 57.827 21.117-2.273 41.584-8.122 60.426-16.243-14.292 20.791-32.161 39.308-52.628 54.253z">
            </path>
        </svg>
    </a>
                        <a class="text-gray-700 hover:text-orange-600" aria-label="Visit TrendyMinds Facebook" href="" target="_blank"><svg
            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512" class="h-8">
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