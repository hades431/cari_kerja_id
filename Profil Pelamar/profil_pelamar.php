<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Profil Pelamar - CariKerja.id</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-gray-50 min-h-screen">
    <!-- Header dengan background -->
    <div class="bg-[#00646A] h-48 w-full"></div>
    <!-- Layout profil -->
    <div class="max-w-4xl mx-auto -mt-20 flex flex-col md:flex-row items-start gap-8 px-4">
        <!-- Foto profil kiri -->
        <div class="flex-shrink-0 flex flex-col items-center w-full md:w-56">
            <img src="https://ui-avatars.com/api/?name=Nama+Pelamar&background=2563eb&color=fff&size=128"
                 class="w-36 h-36 rounded-full border-4 border-white shadow-lg object-cover bg-white" alt="Foto Profil">
        </div>
        <!-- Card utama kanan -->
        <div class="flex-1 bg-white rounded-xl shadow-lg p-8 mt-6 md:mt-0">
            <div class="flex flex-col items-start">
                <h2 class="text-2xl font-bold text-gray-800">Nama Pelamar</h2>
                <div class="text-[#00646A] font-medium mt-1">UI/UX Designer</div>
                <div class="flex flex-col sm:flex-row gap-3 mt-3 text-gray-500 text-sm">
                    <span><i class="fas fa-envelope mr-1"></i> email@pelamar.com</span>
                    <span><i class="fas fa-phone mr-1"></i> 0812-3456-7890</span>
                    <span><i class="fas fa-map-marker-alt mr-1"></i> Bandung, Indonesia</span>
                </div>
                <button class="mt-5 px-6 py-2 bg-[#00646A] text-white rounded-full shadow hover:bg-teal-800 transition">Edit Profil</button>
            </div>
            <!-- Section Ringkasan -->
            <div class="mt-10">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Ringkasan</h3>
                <div class="bg-gray-100 rounded p-4 text-gray-700">
                    Seorang UI/UX Designer dengan pengalaman lebih dari 3 tahun di industri teknologi. Memiliki keahlian dalam desain antarmuka, prototyping, dan kolaborasi tim lintas fungsi.
                </div>
            </div>
            <!-- Section Pengalaman -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Pengalaman Kerja</h3>
                <div class="space-y-4">
                    <div>
                        <div class="font-medium text-gray-800"> <span class="text-gray-400 font-normal"></span></div>
                        <div class="text-xs text-gray-500 mb-1"></div>
                        <div class="text-gray-600 text-sm"></div>
                    </div>
                    <div>
                        <div class="font-medium text-gray-800">Graphic Designer <span class="text-gray-400 font-normal">@ CV Kreatif Studio</span></div>
                        <div class="text-xs text-gray-500 mb-1">Jul 2019 - Des 2020</div>
                        <div class="text-gray-600 text-sm">Membuat materi promosi digital dan cetak untuk berbagai klien.</div>
                    </div>
                </div>
            </div>
            <!-- Section Keahlian -->
            <div class="mt-8">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Keahlian</h3>
                <div class="flex flex-wrap gap-3">
                    <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm">UI Design</span>
                    <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm">UX Research</span>
                    <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm">Figma</span>
                    <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm">Adobe XD</span>
                    <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm">Prototyping</span>
                    <span class="bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm">Teamwork</span>
                </div>
            </div>
        </div>
    </div>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</body>
</html>
