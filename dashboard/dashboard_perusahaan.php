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
        "subtitle" => "",
        "color" => "#00b6b9",
        "chart" => [100, 120, 90, 150, 110, 130, 120, 140],
        "key" => "pelamar"
    ],
    [
        "title" => "Total lowongan diberikan",
        "value" => "--",
        "subtitle" => "",
        "color" => "#00b6b9",
        "chart" => [90, 100, 110, 120, 110, 100, 120, 109],
        "key" => "lowongan"
    ],
    [
        "title" => "Jumlah pelamar yang diterima",
        "value" => "--",
        "subtitle" => "",
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

// Tambah: data lowongan
$lowonganList = [
    // ...existing code...
];

// Jika ada data POST dari form tambah lowongan
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['judul_lowongan'])) {
    $lowonganBaru = [
        "judul" => $_POST['judul_lowongan'],
        "departemen" => isset($_POST['departemen']) ? $_POST['departemen'] : '',
        "status" => isset($_POST['status']) ? $_POST['status'] : 'Aktif',
        "nama_perusahaan" => isset($_POST['nama_perusahaan']) ? $_POST['nama_perusahaan'] : '',
        "deskripsi" => isset($_POST['deskripsi']) ? $_POST['deskripsi'] : '',
        "usia" => isset($_POST['usia']) ? $_POST['usia'] : '',
        "pendidikan" => isset($_POST['pendidikan']) ? $_POST['pendidikan'] : '',
        "gender" => isset($_POST['gender']) ? $_POST['gender'] : '',
        "media_sosial" => isset($_POST['media_sosial']) ? $_POST['media_sosial'] : '',
        "website" => isset($_POST['website']) ? $_POST['website'] : ''
        // Logo tidak diproses di dashboard
    ];
    $lowonganList[] = $lowonganBaru;
    // Redirect agar tidak submit ulang jika refresh
    header("Location: dashboard_perusahaan.php?success=1");
    exit;
}

// Update dashboardStats untuk menampilkan jumlah dan jenis lowongan
$dashboardStats[1]['value'] = count($lowonganList);
$dashboardStats[1]['subtitle'] = count($lowonganList) > 0 ? implode(', ', array_column($lowonganList, 'judul')) : '-';
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
    <div id="sidebar" class="bg-[#00888a] text-white flex flex-col items-center py-10 px-0 shadow-lg w-64 min-h-screen relative">
        <div class="flex flex-col items-center w-full flex-1">
            <div
                class="bg-white rounded-full w-24 h-24 flex items-center justify-center mb-4 border-4 border-white/30 shadow-lg cursor-pointer"
                onclick="window.location.href='../perusahaan/profile_perusahaan.php'">
                <img src="../img/barber.jpg" alt="Logo Perusahaan" title="Logo Perusahaan" class="w-20 h-20 rounded-full object-cover">
            </div>
            <div class="text-lg font-bold text-white mb-8 text-center">Perusahaan</div>
            <div class="flex flex-col gap-4 w-full px-6">
                <a href="../dashboard/dashboard_perusahaan.php" class="w-full py-3 rounded-lg bg-white text-[#00888a] font-semibold text-left pl-6 hover:bg-[#009fa3] hover:text-white transition">Dashboard</a>
                <a href="../perusahaan/daftar_pelamar.php" class="w-full py-3 rounded-lg bg-white text-[#00888a] font-semibold text-left pl-6 hover:bg-[#009fa3] hover:text-white transition">Daftar Pelamar</a>
                <button onclick="window.location.href='../perusahaan/form_pasang_lowongan.php'" class="w-full py-3 rounded-lg bg-white text-[#00888a] font-semibold text-left pl-6 hover:bg-[#009fa3] hover:text-white transition">
                    Pasang Lowongan
                </button>
            </div>
        </div>  
        <div class="absolute bottom-6 left-0 w-full px-6 text-base text-white/70 text-center font-semibold">© 2025 Carikerja.id</div>
    </div>
    <!-- Main Content -->
    <div class="flex-1 flex flex-col gap-6 px-9 pt-9 bg-white">
        <!-- Notifikasi sukses -->
        <?php if (isset($_GET['success'])): ?>
            <div id="notif-success" class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg font-semibold">
                Lowongan berhasil ditambahkan!
            </div>
            <script>
                setTimeout(function() {
                    var notif = document.getElementById('notif-success');
                    if (notif) notif.style.display = 'none';
                }, 2000);
            </script>
        <?php endif; ?>
        <h1 class="text-2xl font-bold text-[#009fa3] mb-2">Dashboard</h1>
        <!-- Statistik Card utama -->
        <div class="flex gap-4 mb-4">
            <?php foreach ($dashboardStats as $stat): ?>
                <div class="flex-1 bg-[#009fa3] rounded-lg shadow px-6 py-4 flex flex-col justify-center items-start">
                    <div class="text-base font-semibold mb-1 text-white"><?php echo $stat['title']; ?></div>
                    <div class="text-3xl font-bold mb-1 text-white"><?php echo $stat['value']; ?></div>
                    <div class="text-sm text-white mb-1"><?php echo $stat['subtitle']; ?></div>
                </div>
            <?php endforeach; ?>
        </div>
        <!-- Tabel Daftar Pelamar -->
        <div class="w-full mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full rounded-lg shadow bg-white">
                    <thead>
                        <tr class="bg-[#009fa3] text-white">
                            <th class="py-3 px-4 text-left font-bold">Nama</th>
                            <th class="py-3 px-4 text-left font-bold">Email</th>
                            <th class="py-3 px-4 text-left font-bold">Posisi</th>
                            <th class="py-3 px-4 text-left font-bold">No HP</th>
                            <th class="py-3 px-4 text-left font-bold">CV</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="5" class="py-6 px-4 text-center text-gray-400">Tidak ada data pelamar</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Tabel Jumlah Pelamar Diterima (warna sama seperti tabel pertama) -->
        <div class="w-full mb-6">
            <div class="overflow-x-auto">
                <table class="min-w-full rounded-lg shadow bg-white">
                    <thead>
                        <tr class="bg-[#009fa3] text-white">
                            <th class="py-3 px-4 text-left font-bold">Nama Pelamar</th>
                            <th class="py-3 px-4 text-left font-bold">Posisi</th>
                            <th class="py-3 px-4 text-left font-bold">Tanggal Diterima</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td colspan="3" class="py-6 px-4 text-center text-gray-400">Belum ada pelamar yang diterima</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <!-- Footer -->
        <div class="text-right text-[#a0a0ff] text-base mt-4 pb-2">
             
        </div>
    </div>
</div>
</body>
</html>