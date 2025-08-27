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
    <style>
        body {
            margin: 0;
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #003110ff;
            color: #fff;
        }
        .dashboard-container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 220px;
            background: linear-gradient(180deg, #024629ff 80%, #01331e 100%);
            color: white;
            padding: 28px 18px 18px 18px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            box-shadow: 2px 0 12px #0002;
        }
        .sidebar img {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 30px;
            border: 3px solid #fff3;
        }
        .sidebar button {
            width: 100%;
            padding: 12px 0;
            margin: 7px 0;
            border: none;
            background-color: #fff;
            color: #024629;
            border-radius: 7px;
            cursor: pointer;
            font-weight: 600;
            font-size: 1.05em;
            transition: background 0.2s, color 0.2s;
        }
        .sidebar button:hover {
            background: #a97cff;
            color: #fff;
        }
        .main-content {
            flex: 1;
            padding: 36px 36px 0 36px;
            display: flex;
            flex-direction: column;
            gap: 24px;
        }
        .dashboard-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            grid-template-rows: 130px 240px;
            gap: 18px;
        }
        .box, .box2 {
            background: #23235b;
            border-radius: 14px;
            padding: 18px 16px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            justify-content: center;
            box-shadow: 0 2px 8px #0001;
        }
        .box2 {
            grid-row: 2 / span 1;
            grid-column: span 2;
            min-height: 220px;
        }
        .alert-box {
            background: #3a235b;
            border: 2px solid #a97cff;
            color: #fff;
            border-radius: 12px;
            padding: 10px 14px 10px 10px;
            margin-top: 12px;
            position: relative;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-box .excl {
            position: absolute;
            right: 10px;
            top: 10px;
            background: #ff4d6d;
            color: #fff;
            border-radius: 50%;
            width: 22px;
            height: 22px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            font-size: 1em;
        }
        .stat-big {
            font-size: 2.2em;
            font-weight: bold;
            letter-spacing: 1px;
        }
        .stat-label {
            font-size: 1.08em;
            margin-bottom: 7px;
            font-weight: 500;
            color: #a0a0ff;
        }
        .stat-small {
            font-size: 1.1em;
            font-weight: bold;
        }
        .stat-change {
            color: #ff4d6d;
            font-size: 0.95em;
            margin-left: 8px;
        }
        .gauge {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: conic-gradient(#7cffb2 <?php echo $csatGauge; ?>%, #23235b <?php echo $csatGauge; ?>%);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px auto;
            box-shadow: 0 0 0 4px #23235b;
        }
        .gauge-label {
            font-size: 1.1em;
            font-weight: bold;
        }
        .table-list {
            width: 100%;
            border-collapse: collapse;
            color: #fff;
            font-size: 0.98em;
        }
        .table-list th, .table-list td {
            padding: 5px 8px;
            text-align: left;
        }
        .table-list th {
            color: #a0a0ff;
            font-weight: bold;
            font-size: 1em;
            border-bottom: 1px solid #35357a;
        }
        .table-list tr:not(:last-child) td {
            border-bottom: 1px solid #23235b;
        }
        .feedback-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .feedback-list li {
            margin-bottom: 13px;
            display: flex;
            align-items: flex-start;
        }
        .feedback-list .icon {
            color: #7cffb2;
            margin-right: 10px;
            font-size: 1.15em;
        }
        .feedback-list .msg {
            flex: 1;
        }
        .feedback-list .time {
            color: #a0a0ff;
            font-size: 0.93em;
            margin-top: 2px;
        }
        .footer {
            text-align: right;
            color: #a0a0ff;
            font-size: 1.08em;
            margin-top: 16px;
            padding-bottom: 8px;
        }
        /* Dummy chart */
        .chart {
            width: 100%;
            height: 150px;
            background: linear-gradient(180deg, #2e2e6a 60%, #23235b 100%);
            border-radius: 10px;
            position: relative;
            margin-top: 8px;
        }
        .chart-label {
            position: absolute;
            left: 10px;
            bottom: 10px;
            color: #7cffb2;
            font-size: 1em;
        }
        /* Responsive */
        @media (max-width: 1100px) {
            .dashboard-grid {
                grid-template-columns: 1fr 1fr;
                grid-template-rows: repeat(4, 1fr);
            }
            .box2, .box {
                min-width: 0;
            }
        }
        @media (max-width: 800px) {
            .dashboard-container {
                flex-direction: column;
            }
            .sidebar {
                flex-direction: row;
                width: 100%;
                height: auto;
                justify-content: flex-start;
                align-items: center;
                padding: 12px 10px;
            }
            .sidebar img {
                margin-bottom: 0;
                margin-right: 18px;
            }
            .main-content {
                padding: 18px 6px 0 6px;
            }
        }
        .stat-row {
            display: flex;
            gap: 18px;
            margin-bottom: 18px;
        }
        .stat-card {
            flex: 1;
            border-radius: 10px;
            background: #024629ff; /* hijau sidebar */
            color: #fff;
            padding: 18px 20px 12px 20px;
            box-shadow: 0 2px 8px #0001;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            min-width: 0;
            position: relative;
        }
        .stat-card .stat-title {
            font-size: 1.05em;
            font-weight: 600;
            margin-bottom: 8px;
            color: #a7ffd7;
        }
        .stat-card .stat-value {
            font-size: 2.1em;
            font-weight: bold;
            margin-bottom: 2px;
            color: #fff;
        }
        .stat-card .stat-sub {
            font-size: 1em;
            color: #d2ffe9;
        }
        .stat-card .stat-chart {
            width: 100%;
            height: 36px;
            margin-top: 10px;
        }
        .stat-card .gauge {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            background: #fff;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
        .stat-card .gauge-inner {
            width: 70px;
            height: 70px;
            border-radius: 50%;
            background: conic-gradient(#f36c21 0% 66%, #eee 66% 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5em;
            font-weight: bold;
            color: #f36c21;
        }
        .dashboard-main {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            grid-template-rows: 220px 180px;
            gap: 18px;
        }
        .main-card {
            background: #fff;
            color: #222;
            border-radius: 10px;
            box-shadow: 0 2px 8px #0001;
            padding: 18px 20px;
            min-width: 0;
            min-height: 0;
            display: flex;
            flex-direction: column;
            justify-content: flex-start;
        }
        .main-card h4 {
            margin: 0 0 10px 0;
            font-size: 1.08em;
            font-weight: 600;
        }
        .bar-chart {
            width: 100%;
            height: 120px;
        }
        .pie-chart {
            width: 100%;
            height: 120px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .scatter-chart {
            width: 100%;
            height: 120px;
        }
        .deals-bar-chart {
            width: 100%;
            height: 120px;
        }
        .main-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.98em;
        }
        .main-table th, .main-table td {
            padding: 4px 8px;
            text-align: left;
        }
        .main-table th {
            color: #00b6b9;
            font-weight: bold;
            border-bottom: 1px solid #eee;
        }
        .main-table tr:not(:last-child) td {
            border-bottom: 1px solid #f3f3f3;
        }
    </style>
</head>
<body>
<div class="dashboard-container">
    <!-- Sidebar -->
    <div class="sidebar">
        <img src="<?php echo $gambarAktif; ?>" alt="Logo ">
        <button>Perusahaan</button>
        <button>Dashboard</button>
        <button>Daftar Pelamar</button>
        <button>Dashboard</button>
    </div>
    <!-- Main Content -->
    <div class="main-content">
        <!-- Stat Row -->
        <div class="stat-row">
            <?php foreach ($dashboardStats as $stat): ?>
                <div class="stat-card" style="background:<?php echo $stat['color']; ?>;color:#fff;">
                    <div class="stat-title"><?php echo $stat['title']; ?></div>
                    <div class="stat-value"><?php echo $stat['value']; ?></div>
                    <div class="stat-sub"><?php echo $stat['subtitle']; ?></div>
                    <?php if (!empty($stat['gauge'])): ?>
                        <div class="gauge" style="background:#fff;">
                            <div class="gauge-inner" style="background:conic-gradient(#f36c21 0% 66%, #eee 66% 100%);">
                                <?php echo $stat['value']; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <svg class="stat-chart" viewBox="0 0 100 36">
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
        <div class="dashboard-main">
            <!-- Bar Chart -->
            <div class="main-card" style="grid-row:1;grid-column:1;">
                <h4>Avg. Contract Value</h4>
                <svg class="bar-chart" viewBox="0 0 350 120">
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
            <div class="main-card" style="grid-row:1;grid-column:2;">
                <h4>Top 5 Channels</h4>
                <table class="main-table">
                    <tr><th>Order Date</th><th>Country</th><th>Units Sold</th></tr>
                    <?php foreach ($topChannels as $row): ?>
                        <tr>
                            <td><?php echo $row[0]; ?></td>
                            <td><?php echo $row[1]; ?></td>
                            <td><?php echo $row[2]; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </table>
            </div>
            <!-- KPI Gauge -->
            <div class="main-card" style="grid-row:1;grid-column:3;">
                <h4>Sales KPI</h4>
                <svg width="100%" height="100" viewBox="0 0 120 100">
                    <path d="M10,90 Q60,10 110,90" fill="none" stroke="#f36c21" stroke-width="10"/>
                    <path d="M10,90 Q60,10 110,90" fill="none" stroke="#eee" stroke-width="10" stroke-dasharray="0 180"/>
                    <text x="60" y="70" text-anchor="middle" font-size="2em" fill="#f36c21" font-weight="bold">263</text>
                </svg>
            </div>
            <!-- Pie Chart -->
            <div class="main-card" style="grid-row:2;grid-column:1;">
                <h4>Item Type</h4>
                <svg class="pie-chart" viewBox="0 0 100 100">
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
            <div class="main-card" style="grid-row:2;grid-column:2;">
                <h4>Sales Activity</h4>
                <svg class="scatter-chart" viewBox="0 0 100 100">
                    <?php foreach ($salesActivity as $dot): ?>
                        <circle cx="<?php echo $dot[0]*3; ?>" cy="<?php echo 100-$dot[1]*3; ?>" r="5" fill="<?php echo $dot[2]; ?>" opacity="0.8"/>
                    <?php endforeach; ?>
                </svg>
            </div>
            <!-- Deals Bar Chart -->
            <div class="main-card" style="grid-row:2;grid-column:3;">
                <h4>Top Deals</h4>
                <svg class="deals-bar-chart" viewBox="0 0 120 100">
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
        <div class="footer">
            11:41
        </div>
    </div>
</div>
</body>
</html>