<?php
include '../header.php';
// Ambil data dari database
include __DIR__ . "/../config.php";
$id_perusahaan = $_SESSION["user"]["id"]; // Ganti dengan id perusahaan yang login
$data = [];
$res = $conn->query("SELECT * FROM perusahaan WHERE id_user='$id_perusahaan' LIMIT 1");
if ($res && $res->num_rows > 0) {
    $data = $res->fetch_assoc();
}

$nama = $data['nama_perusahaan'] ?? '';
$email = $data['email_perusahaan'] ?? '';
$telepon = $data['no_telepon'] ?? '';
$alamat = $data['alamat'] ?? '';
$website = $data['website'] ?? '';
$deskripsi = $data['deskripsi'] ?? '';
$paket = $data['paket'] ?? '';
$logo = $data["logo"] ?? "knjt";
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Profil Perusahaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#f4f6f8] min-h-screen">
    <!-- Header -->
    <!-- Back Button -->
    <div class="px-8 mt-6">
        <a href="../perusahaan/dashboard_perusahaan.php" class="inline-flex items-center px-4 py-2 bg-gray-100 rounded-md text-gray-700 hover:bg-gray-200 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>
    <!-- Profile Card -->
    <div class="flex justify-start mt-6 px-0">
        <div class="flex w-full gap-10 bg-white rounded-none shadow-none p-0">
            <!-- Avatar -->
            <div class="flex flex-col items-center justify-start pl-8 pt-8">
                <div class="w-40 h-40 rounded-full bg-[#2563eb] flex items-center justify-center text-white text-6xl font-bold shadow-md mb-4 border-4 border-white overflow-hidden">
                    <img src="<?php echo htmlspecialchars($logo); ?>" alt="Foto Profil" class="w-full h-full object-cover">
                </div>
            </div>
            <!-- Info -->
            <div class="flex-1 flex flex-col justify-center pr-8">
                <div class="mb-2">
                    <div class="text-4xl font-bold"><?php echo htmlspecialchars($nama); ?></div>
                    <div class="text-2xl text-[#00797a] font-semibold"><?php echo htmlspecialchars($paket); ?></div>
                </div>
                <div class="flex flex-col gap-4 text-gray-700 mb-6 text-lg">
                    <div class="flex items-center gap-2">
                        <span class="font-semibold w-32">Email</span>
                        <span><?php echo htmlspecialchars($email); ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-semibold w-32">Telepon</span>
                        <span><?php echo htmlspecialchars($telepon); ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-semibold w-32">Alamat</span>
                        <span><?php echo htmlspecialchars($alamat); ?></span>
                    </div>
                    <div class="flex items-center gap-2">
                        <span class="font-semibold w-32">Website</span>
                        <span><?php echo htmlspecialchars($website); ?></span>
                    </div>  
                </div>
                <div class="mb-6">
                    <div class="font-semibold text-xl">Deskripsi</div>
                    <div class="bg-gray-100 rounded-lg p-6 mt-2 text-gray-700 text-lg"><?php echo htmlspecialchars($deskripsi); ?></div>
                </div>
                <div class="mt-8 mb-2 flex justify-end">
                    <a href="edit_profile_perusahaan.php" class="bg-[#00797a] hover:bg-[#005f5f] text-white px-10 py-3 rounded-full font-semibold shadow transition text-lg text-center">Edit</a>
                </div>
            </div>
        </div>
    </div>
        </body>
</html>
            </div>
        </div>
    </div>
        </body>
</html>
