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
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Dashboard Perusahaan</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            display: flex;
        }
        /* Sidebar kiri */
        .sidebar {
            width: 200px;
            background-color: #024629ff;
            color: white;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .sidebar img {
            width: 100px;
            height: 600px;
            border-radius: 50%;
            object-fit: cover;
            margin-bottom: 20px;
        }
        .sidebar button {
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: none;
            background-color: white;
            color: black;
            border-radius: 5px;
            cursor: pointer;
            font-weight: bold;
        }
        /* Konten utama */
        .content {
            flex: 1;
            background-color: #f2f2f2;
            padding: 20px;
        }
        h2 {
            margin-top: 0;
        }
        .row {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }
        .box {
            background-color: #87cefa;
            flex: 1;
            height: 100px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .big-box {
            background-color: #b0b0b0;
            flex: 2;
            height: 600px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
        .small-box {
            background-color: #b0b0b0;
            flex: 1;
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }
    </style>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <img src="<?php echo $gambarAktif; ?>" alt="Logo ">
    <button>Perusahaan</button>
    <button>Dashboard</button>
    <button>Daftar Pelamar</button>
    <button>Dashboard</button>
</div>

<!-- Konten -->
<div class="content">
    <h2>Dashboard Perusahaan</h2>

    <!-- Kotak biru -->
    <div class="row">
        <?php foreach ($kotakBiru as $isi): ?>
            <div class="box"><?php echo $isi; ?></div>
        <?php endforeach; ?>
    </div>

    <!-- Kotak abu -->
    <div class="row">
        <div class="big-box"><?php echo $kotakAbu[0]; ?></div>
        <div class="small-box"><?php echo $kotakAbu[1]; ?></div>
    </div>
</div>

</body>
</html>