<?php

// Data untuk tabel/kotak
$kotakBiru = ["Kotak 1: Info", "Kotak 2: Laporan", "Kotak 3: Statistik"];
$kotakAbu = [
    "Kotak Besar: Detail Data",
    "Kotak Kecil: Catatan Tambahan"
];

// Gambar untuk sidebar (berganti setiap refresh halaman)
$gambarSidebar = [
    "c:\Users\Acer\Pictures\Screenshots\Screenshot (31).png",
    "c:\Users\Acer\Pictures\Screenshots\Screenshot (31).png",
    "c:\Users\Acer\Pictures\Screenshots\Screenshot (31).png"
];
$gambarAktif = $gambarSidebar[array_rand($gambarSidebar)];

// Contoh data statistik dashboard
$statistik = [
    "lowongan" => 12,
    "pelamar" => 87,
    "wawancara" => 5
];

// Contoh detail data
$detailData = [
    "Nama Perusahaan" => "PT. Sukses Selalu",
    "Alamat" => "Jl. Merdeka No. 123, Jakarta",
    "Email" => "info@suksesselalu.co.id",
    "Telepon" => "(021) 12345678",
    "Jumlah Karyawan" => 150
];

// Catatan tambahan
$catatan = [
    "Update profil perusahaan secara berkala.",
    "Cek pelamar baru setiap hari.",
    "Pastikan data lowongan selalu up-to-date."
];

// Data dummy untuk dashboard
$liveTickets = 23;
$unassignedTickets = 16;
$frt = 9; // First Response Time (menit)
$frtChange = "+1k"; // perubahan FRT
$withinSLA = 95;
$csat = 89;
$csatGauge = 84;

$topSolvers = [
    ["Reece Martin", 37],
    ["Robyn Mers", 34],
    ["Julia Smith", 27],
    ["Ebeneezer Grey", 24],
    ["Marlon Brown", 23],
    ["Heather Banks", 21]
];

$agentStatus = [
    ["Ash Monk", "Offline"],
    ["Danica Johnson", "Away"],
    ["Ebeneezer Grey", "Taking call"],
    ["Frank Massey", "Online"],
    ["Heather Banks", "Taking call"],
    ["Julia Smith", "Taking call"],
    ["Marlon Brown", "Taking call"],
    ["Olivia Houghton", "Taking call"],
    ["Peter Mitchell", "Taking call"],
    ["Reece Martin", "Taking call"],
    ["Robyn Mers", "Away"]
];

$feedback = [
    ["Thanks for exchanging my item so promptly", "an hour ago"],
    ["Super fast resolution, thank you!", "an hour ago"],
    ["Great service as always", "3 hours ago"],
    ["Helpful and efficient. Great service!", "4 hours ago"],
    ["Fast and efficient, thanks.", "2 days ago"]
];

// Data statistik utama
$dashboardStats = [
    [
        "title" => "Total pelamar mendaftar",
        "value" => "-",
        "subtitle" => "/ 90",
        "color" => "#00b6b9",
        "chart" => [100, 120, 90, 150, 110, 130, 120, 140],
        "key" => "pelamar"
    ],
    [
        "title" => "Total lowongan diberikan",
        "value" => "--",
        "subtitle" => "/ 90",
        "color" => "#00b6b9",
        "chart" => [90, 100, 110, 120, 110, 100, 120, 109],
        "key" => "lowongan"
    ],
    [
        "title" => "Jumlah pelamar yang diterima",
        "value" => "--",
        "subtitle" => "▲ 11364",
        "color" => "#f6a700",
        "chart" => [9000, 9500, 10000, 11000, 12000, 11500, 11460, 11364],
        "key" => "diterima"
    ],
    [
        "title" => "Jumlah pelamar ditolak",
        "value" => "--",
        "subtitle" => "",
        "color" => "#f36c21",
        "gauge" => true,
        "key" => "ditolak"
    ]
];

// Data chart bar
$barChartData = [
    ["label" => "Middle East", "value" => 200.28],
    ["label" => "Asia", "value" => 437.20],
    ["label" => "Sub-Saharan Africa", "value" => 159.42],
    ["label" => "North America", "value" => 263.33],
    ["label" => "Europe", "value" => 154.06],
    ["label" => "Central America", "value" => 205.70],
    ["label" => "Australia", "value" => 90.93]
];

// Data tabel
$topChannels = [
    ["10/18/2014", "Libya", 8446],
    ["11/7/2011", "Canada", 3018],
    ["10/31/2016", "Libya", 1517],
    ["4/10/2010", "Japan", 3322],
    ["8/16/2011", "Chad", 9845],
    ["12/14/2014", "Armenia", 9548],
    ["3/4/2015", "Eritrea", 2844],
    ["5/17/2012", "Montenegro", 7299],
    ["12/9/2015", "Jamaica", 2428],
    ["12/24/2013", "Fiji", 4800]
];

// Data pie chart
$pieChartData = [
    ["label" => "Type A", "value" => 32.2, "color" => "#00b6b9"],
    ["label" => "Type B", "value" => 24.2, "color" => "#f6a700"],
    ["label" => "Type C", "value" => 14.6, "color" => "#f36c21"],
    ["label" => "Type D", "value" => 25, "color" => "#00b6b9"],
    ["label" => "Type E", "value" => 3.2, "color" => "#a97cff"]
];

// Data scatter chart (dummy)
$salesActivity = [
    [5, 10, "#00b6b9"], [10, 20, "#f6a700"], [15, 8, "#f36c21"],
    [20, 25, "#00b6b9"], [25, 15, "#f6a700"], [30, 30, "#f36c21"]
];

// Data bar chart deals
$topDeals = [
    ["label" => "Deal 1", "value" => 3.5],
    ["label" => "Deal 2", "value" => 2.5],
    ["label" => "Deal 3", "value" => 1.5]
];
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Perusahaan</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .sidebar-transition {
            transition: width 0.3s;
        }
    </style>
</head>
<body class="bg-white text-gray-900">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <div id="sidebar" class="sidebar-transition group w-20 bg-gradient-to-b from-[#024629] to-[#01331e] text-white flex flex-col items-center p-7 shadow-lg overflow-x-hidden transition-all duration-300">
        <img src="<?php echo $gambarAktif; ?>" alt="Logo " class="sidebar-img w-12 h-12 rounded-full object-cover mb-8 border-4 border-white/20 transition-all duration-300">
        <a href="profil_pelamar.php" class="sidebar-btn w-full py-3 mb-2 rounded-lg bg-white text-[#024629] font-semibold hover:bg-purple-400 hover:text-white transition flex items-center justify-center">
            <span class="sidebar-label hidden">profile</span>
            <svg class="inline-block w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>
        </a>
        <button class="sidebar-btn w-full py-3 mb-2 rounded-lg bg-white text-[#024629] font-semibold hover:bg-purple-400 hover:text-white transition flex items-center justify-center">
            <span class="sidebar-label hidden">pengajuan</span>
            <svg class="inline-block w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M12 4v16m8-8H4"/></svg>
        </button>
        <a href="daftar_pelamar.php" class="sidebar-btn w-full py-3 mb-2 rounded-lg bg-white text-[#024629] font-semibold hover:bg-purple-400 hover:text-white transition flex items-center justify-center">
            <span class="sidebar-label hidden">Daftar Pelamar</span>
            <svg class="inline-block w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17 20h5v-2a4 4 0 0 0-3-3.87M9 20H4v-2a4 4 0 0 1 3-3.87M16 3.13a4 4 0 0 1 0 7.75M8 3.13a4 4 0 0 0 0 7.75"/></svg>
        </a>
    </div>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col gap-6 px-9 pt-9 bg-white">
        <!-- Stat Row -->
        <div class="flex gap-4 mb-4">
            <?php foreach ($dashboardStats as $stat): ?>
                <a href="stat_detail.php?stat=<?php echo urlencode($stat['key']); ?>" class="flex-1 rounded-xl bg-[#024629] text-white px-0 py-0 min-w-0 relative shadow transition transform hover:scale-105 hover:shadow-lg focus:outline-none" style="text-decoration:none;">
                    <div class="px-6 py-5 flex flex-col justify-between h-full">
                        <div class="text-base font-semibold mb-2 text-green-100"><?php echo $stat['title']; ?></div>
                        <div class="text-3xl font-bold mb-1 text-white"><?php echo $stat['value']; ?></div>
                        <div class="text-sm text-green-50 mb-2"><?php echo $stat['subtitle']; ?></div>
                        <?php if (!empty($stat['gauge'])): ?>
                            <div class="flex justify-center">
                                <div class="w-20 h-20 rounded-full bg-white flex items-center justify-center">
                                    <div class="w-16 h-16 rounded-full flex items-center justify-center font-bold text-xl text-orange-500" style="background:conic-gradient(#f36c21 0% 66%, #eee 66% 100%)">
                                        <?php echo $stat['value']; ?>
                                    </div>
                                </div>
                            </div>
                        <?php else: ?>
                            <svg class="w-full h-9 mt-2" viewBox="0 0 100 36">
                                <polyline
                                    fill="none"
                                    stroke="#fff"
                                    stroke-width="2"
                                    points="<?php
                                        $points = [];
                                        $max = max($stat['chart']);
                                        foreach ($stat['chart'] as $i => $v) {
                                            $x = 10 + $i * 12;
                                            $y = 30 - ($v/$max)*24;
                                            $points[] = "$x,$y";
                                        }
                                        echo implode(' ', $points);
                                    ?>"
                                />
                            </svg>
                        <?php endif; ?>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
        <!-- Footer -->
        <div class="text-right text-[#a0a0ff] text-base mt-4 pb-2">
             
        </div>
    </div>
</div>
<script>
    // Sidebar expand/collapse on mouse enter/leave
    const sidebar = document.getElementById('sidebar');
    const img = sidebar.querySelector('.sidebar-img');
    const labels = sidebar.querySelectorAll('.sidebar-label');
    function expandSidebar() {
        sidebar.classList.remove('w-20');
        sidebar.classList.add('w-56');
        img.classList.remove('w-12', 'h-12');
        img.classList.add('w-24', 'h-24');
        labels.forEach(label => label.classList.remove('hidden'));
        sidebar.classList.add('items-center');
    }
    function collapseSidebar() {
        sidebar.classList.remove('w-56');
        sidebar.classList.add('w-20');
        img.classList.remove('w-24', 'h-24');
        img.classList.add('w-12', 'h-12');
        labels.forEach(label => label.classList.add('hidden'));
        sidebar.classList.add('items-center');
    }
    sidebar.addEventListener('mouseenter', expandSidebar);
    sidebar.addEventListener('mouseleave', collapseSidebar);
    // Start collapsed
    collapseSidebar();
</script>
</body>
</html>