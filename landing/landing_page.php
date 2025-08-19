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
            <img src="logo.png" alt="Logo" class="px-6 py-2 rounded w-64 h-30 object-contain">
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
            <div class="bg-white px-6 py-2 rounded w-48 text-center font-semibold mb-2 md:mb-0">Logo</div>
            <div class="flex gap-4">
                <div class="flex flex-col gap-1">
                    <div class="h-3 bg-gray-300 rounded w-24"></div>
                    <div class="h-3 bg-gray-300 rounded w-32"></div>
                </div>
                <div>
                    <div class="text-xs mb-1">Our social media</div>
                    <div class="flex gap-2">
                        <span class="w-5 h-5 bg-gray-400 rounded-full inline-block"></span>
                        <span class="w-5 h-5 bg-gray-400 rounded-full inline-block"></span>
                        <span class="w-5 h-5 bg-gray-400 rounded-full inline-block"></span>
                        <span class="w-5 h-5 bg-gray-400 rounded-full inline-block"></span>
                    </div>
                </div>
            </div>
        </div>
    </footer>
</body>
</html>