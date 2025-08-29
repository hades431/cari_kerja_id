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
        "title" => "Avg. Contract Value",
        "value" => "1890",
        "subtitle" => "/ 90",
        "color" => "#00b6b9",
        "chart" => [100, 120, 90, 150, 110, 130, 120, 140]
    ],
    [
        "title" => "Lead Response Time",
        "value" => "1090",
        "subtitle" => "/ 90",
        "color" => "#00b6b9",
        "chart" => [90, 100, 110, 120, 110, 100, 120, 109]
    ],
    [
        "title" => "Sales Cycle Length",
        "value" => "11.46k",
        "subtitle" => "▲ 11364",
        "color" => "#f6a700",
        "chart" => [9000, 9500, 10000, 11000, 12000, 11500, 11460, 11364]
    ],
    [
        "title" => "Sales KPI",
        "value" => "263",
        "subtitle" => "",
        "color" => "#f36c21",
        "gauge" => true
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
</head>
<body class="bg-white text-gray-900">
<div class="flex min-h-screen">
    <!-- Sidebar -->
    <div class="w-56 bg-gradient-to-b from-[#024629] to-[#01331e] text-white flex flex-col items-center p-7 shadow-lg">
        <img src="<?php echo $gambarAktif; ?>" alt="Logo " class="w-24 h-24 rounded-full object-cover mb-8 border-4 border-white/20">
        <button class="w-full py-3 mb-2 rounded-lg bg-white text-[#024629] font-semibold hover:bg-purple-400 hover:text-white transition">Perusahaan</button>
        <button class="w-full py-3 mb-2 rounded-lg bg-white text-[#024629] font-semibold hover:bg-purple-400 hover:text-white transition">Dashboard</button>
        <button class="w-full py-3 mb-2 rounded-lg bg-white text-[#024629] font-semibold hover:bg-purple-400 hover:text-white transition">Daftar Pelamar</button>
        <button class="w-full py-3 mb-2 rounded-lg bg-white text-[#024629] font-semibold hover:bg-purple-400 hover:text-white transition">Dashboard</button>
    </div>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col gap-6 px-9 pt-9 bg-white">
        <!-- Stat Row -->
        <div class="flex gap-4 mb-4">
            <?php foreach ($dashboardStats as $stat): ?>
                <div class="flex-1 rounded-xl bg-[#024629] text-white px-6 py-5 flex flex-col justify-between min-w-0 relative shadow">
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
            <?php endforeach; ?>
        </div>
        <!-- Main Dashboard Grid -->
        <div class="grid grid-cols-3 grid-rows-2 gap-4">
            <!-- Bar Chart -->
            <div class="bg-white rounded-xl shadow p-5 flex flex-col" style="grid-row:1;grid-column:1;">
                <h4 class="font-semibold mb-2 text-base text-[#024629]">Avg. Contract Value</h4>
                <svg class="w-full h-28" viewBox="0 0 350 120">
                    <?php
                    $max = max(array_column($barChartData, 'value'));
                    $barWidth = 32;
                    $gap = 12;
                    foreach ($barChartData as $i => $d) {
                        $x = 10 + $i * ($barWidth + $gap);
                        $y = 110 - ($d['value']/$max)*90;
                        $h = ($d['value']/$max)*90;
                        echo "<rect x='$x' y='$y' width='$barWidth' height='$h' fill='#00b6b9' rx='4'></rect>";
                        echo "<text x='".($x+$barWidth/2)."' y='".($y-5)."' font-size='9' fill='#222' text-anchor='middle'>".$d['value']."</text>";
                        echo "<text x='".($x+$barWidth/2)."' y='118' font-size='9' fill='#666' text-anchor='middle' transform='rotate(-18 ".($x+$barWidth/2).",118)'>".$d['label']."</text>";
                    }
                    ?>
                </svg>
            </div>
            <!-- Table Top Channels -->
            <div class="bg-white rounded-xl shadow p-5 flex flex-col" style="grid-row:1;grid-column:2;">
                <h4 class="font-semibold mb-2 text-base text-[#024629]">Top 5 Channels</h4>
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b">
                            <th class="text-[#00b6b9] font-bold py-1 px-2 text-left">Order Date</th>
                            <th class="text-[#00b6b9] font-bold py-1 px-2 text-left">Country</th>
                            <th class="text-[#00b6b9] font-bold py-1 px-2 text-left">Units Sold</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($topChannels as $row): ?>
                        <tr class="border-b last:border-0">
                            <td class="py-1 px-2"><?php echo $row[0]; ?></td>
                            <td class="py-1 px-2"><?php echo $row[1]; ?></td>
                            <td class="py-1 px-2"><?php echo $row[2]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <!-- KPI Gauge -->
            <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center justify-center" style="grid-row:1;grid-column:3;">
                <h4 class="font-semibold mb-2 text-base text-[#024629]">Sales KPI</h4>
                <svg width="100%" height="100" viewBox="0 0 120 100">
                    <path d="M10,90 Q60,10 110,90" fill="none" stroke="#f36c21" stroke-width="10"/>
                    <path d="M10,90 Q60,10 110,90" fill="none" stroke="#eee" stroke-width="10" stroke-dasharray="0 180"/>
                    <text x="60" y="70" text-anchor="middle" font-size="2em" fill="#f36c21" font-weight="bold">263</text>
                </svg>
            </div>
            <!-- Pie Chart -->
            <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center" style="grid-row:2;grid-column:1;">
                <h4 class="font-semibold mb-2 text-base text-[#024629]">Item Type</h4>
                <svg class="w-full h-28" viewBox="0 0 100 100">
                    <?php
                    $total = array_sum(array_column($pieChartData, 'value'));
                    $angle = 0;
                    foreach ($pieChartData as $slice) {
                        $v = $slice['value'];
                        $a = ($v/$total)*360;
                        $x1 = 50 + 40 * cos(deg2rad($angle));
                        $y1 = 50 + 40 * sin(deg2rad($angle));
                        $angle += $a;
                        $x2 = 50 + 40 * cos(deg2rad($angle));
                        $y2 = 50 + 40 * sin(deg2rad($angle));
                        $largeArc = $a > 180 ? 1 : 0;
                        echo "<path d='M50,50 L$x1,$y1 A40,40 0 $largeArc,1 $x2,$y2 Z' fill='".$slice['color']."' opacity='0.8'/>";
                    }
                    ?>
                </svg>
            </div>
            <!-- Scatter Chart -->
            <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center" style="grid-row:2;grid-column:2;">
                <h4 class="font-semibold mb-2 text-base text-[#024629]">Sales Activity</h4>
                <svg class="w-full h-28" viewBox="0 0 100 100">
                    <?php foreach ($salesActivity as $dot): ?>
                        <circle cx="<?php echo $dot[0]*3; ?>" cy="<?php echo 100-$dot[1]*3; ?>" r="5" fill="<?php echo $dot[2]; ?>" opacity="0.8"/>
                    <?php endforeach; ?>
                </svg>
            </div>
            <!-- Deals Bar Chart -->
            <div class="bg-white rounded-xl shadow p-5 flex flex-col items-center" style="grid-row:2;grid-column:3;">
                <h4 class="font-semibold mb-2 text-base text-[#024629]">Top Deals</h4>
                <svg class="w-full h-28" viewBox="0 0 120 100">
                    <?php
                    $max = max(array_column($topDeals, 'value'));
                    foreach ($topDeals as $i => $deal) {
                        $w = ($deal['value']/$max)*90;
                        $y = 20 + $i*25;
                        echo "<rect x='20' y='$y' width='$w' height='16' fill='#f6a700' rx='4'></rect>";
                        echo "<text x='10' y='".($y+12)."' font-size='10' fill='#222'>".$deal['label']."</text>";
                        echo "<text x='".($w+25)."' y='".($y+12)."' font-size='10' fill='#222'>".$deal['value']."M</text>";
                    }
                    ?>
                </svg>
            </div>
        </div>
        <div class="text-right text-[#a0a0ff] text-base mt-4 pb-2">
            11:41
        </div>
    </div>
</div>
</body>
</html>