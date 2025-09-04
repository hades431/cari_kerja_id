<?php
session_start();
include '../function/logic.php';

$menuAktif = menu_aktif('artikel');
$notif = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $judul   = $_POST['judul'];
    $isi     = $_POST['isi'];
    $tanggal = date('Y-m-d');

    $gambar = '';
    if (isset($_FILES['gambar']) && $_FILES['gambar']['error'] === UPLOAD_ERR_OK) {
        $targetDir = "../img/"; // folder tujuan simpan gambar
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }
        $fileName   = time() . "_" . basename($_FILES["gambar"]["name"]);
        $targetFile = $targetDir . $fileName;

        if (move_uploaded_file($_FILES["gambar"]["tmp_name"], $targetFile)) {
            $gambar = $fileName; // simpan hanya nama file
        }
    }

    $sql = "INSERT INTO artikel (judul, isi, tanggal, gambar) 
            VALUES ('$judul', '$isi', '$tanggal', '$gambar')";
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Artikel berhasil ditambahkan ✅";
        header("Location: tips_kerja_artikel.php");
        exit;
    } else {
        $notif = "Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Artikel</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#222] min-h-screen">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar" class="bg-teal-800 w-64 flex flex-col min-h-screen shadow-lg relative" style="border-right:1px solid #79797aff;">
            <div class="px-4 py-6 flex flex-col items-center gap-2">
                <img src="../img/logo2.png" alt="Logo" class="w-60 h-18 object-contain mb-0" />
            </div>
            <nav class="flex-1 flex flex-col gap-1 px-2 py-2">
                <!-- Menu contoh -->
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all mb-1
                    <?php echo $menuAktif['dashboard'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>">
                    Dashboard
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all
                    <?php echo $menuAktif['artikel'] ? 'bg-teal-900 text-white shadow' : 'text-teal-100 hover:bg-teal-900 hover:text-white'; ?>">
                    Artikel & Tips
                </a>
                <a href="#" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition-all mt-auto
                    text-teal-100 hover:bg-teal-900 hover:text-white">
                    Logout
                </a>
            </nav>
        </aside>

        <!-- Main content -->
        <div id="main-content" class="flex-1 flex flex-col bg-white min-h-screen" style="border-left:1px solid #0b5f39ff;">
            <header class="bg-teal-800 flex items-center justify-between px-12 py-4" style="border-bottom:1px solid #ffffff;">
                <div class="text-xl font-medium ml-10 text-white">Tambah Artikel</div>
                <div class="flex items-center gap-3 text-white">
                    <span class="text-lg font-medium"><?= htmlspecialchars($_SESSION['nama_admin'] ?? 'Admin'); ?></span>
                    <img src="../img/beauty.png" alt="Admin" class="w-10 h-10 rounded-full border border-white shadow">
                </div>
            </header>

            <div class="flex-1 bg-gray-100 p-8">
                <?php if (!empty($notif)): ?>
                    <div class="mb-6 px-4 py-3 rounded-lg bg-red-100 border border-red-400 text-red-700 font-medium shadow text-center">
                        <?= htmlspecialchars($notif) ?>
                    </div>
                <?php endif; ?>

                <div class="max-w-3xl mx-auto bg-white rounded-xl shadow-md p-8 border border-gray-200">
                    <div class="flex justify-between items-center mb-6">
                        <h2 class="text-xl font-semibold text-gray-700">Form Tambah Artikel Baru</h2>
                        <a href="tips_kerja_artikel.php" 
                           class="bg-gray-500 hover:bg-gray-600 transition-all duration-200 text-white px-4 py-2 rounded-lg shadow text-sm">
                           ← Kembali
                        </a>
                    </div>
                    
                    <form class="flex flex-col gap-5" method="post" enctype="multipart/form-data">
                        <div class="flex flex-col gap-2">
                            <label class="text-gray-600 font-medium">Upload Gambar</label>
                            <input type="file" name="gambar" class="bg-gray-50 rounded-lg px-4 py-2 w-full border border-gray-300 shadow-sm focus:ring-2 focus:ring-teal-500 focus:outline-none" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-gray-600 font-medium">Judul Artikel*</label>
                            <input type="text" name="judul" placeholder="Masukkan Judul Artikel" required
                                class="bg-gray-50 rounded-lg px-4 py-2 w-full border border-gray-300 shadow-sm focus:ring-2 focus:ring-teal-500 focus:outline-none" />
                        </div>
                        <div class="flex flex-col gap-2">
                            <label class="text-gray-600 font-medium">Isi Artikel*</label>
                            <textarea name="isi" placeholder="Masukkan isi artikel di sini..." required
                                class="bg-gray-50 rounded-lg px-4 py-3 w-full border border-gray-300 min-h-[180px] shadow-sm focus:ring-2 focus:ring-teal-500 focus:outline-none"></textarea>
                        </div>
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-teal-600 hover:bg-teal-700 transition-all duration-200 text-white px-6 py-2 rounded-lg font-semibold text-lg shadow">
                                Tambah Artikel
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <footer class="bg-teal-800 flex items-center justify-between px-12 py-4" style="border-top:1px solid #e5e7eb;">
                <div class="text-sm text-center w-full text-white">&copy; <?= date('Y') ?> CariKerja.ID - All rights reserved.</div>
            </footer>
        </div>
    </div>
</body>
</html>
