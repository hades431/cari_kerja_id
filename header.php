<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $judul_halaman ?? 'Cari Kerja ID' ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex flex-col min-h-screen">

    <!-- Header -->
    <header class="bg-[#00646A] px-4 py-3 flex flex-col gap-1">
        <div class="flex flex-row items-center justify-between">
            <img src="../img/logo2.png" alt="Logo" class="px-2 py-0 rounded w-64 h-30 object-contain">
            <div class="flex flex-col items-end gap-1">
                <!-- Profil -->
                <?php if (!isset($hide_header_profile) || !$hide_header_profile): ?>
                <a href="../public/profil_pelamar.php" class="flex items-center gap-2 mb-0 hover:opacity-80 transition">
                    <img src="../img/avatar.png" alt="Profil"
                        class="w-10 h-10 rounded-full border-2 border-white shadow">
                    <span class="text-white font-semibold">Nama Pengguna</span>
                </a>
                <?php endif; ?>
                <div class="flex gap-3 mt-2">
                    <button class="bg-green-500 max-w-max hover:bg-[#024629] active:bg-green-700 
                      text-white px-6 py-2 rounded-full font-bold shadow transition">Info & Tips Kerja</button>
                    <a href="login.php" class="bg-green-500 max-w-max hover:bg-[#024629] active:bg-green-700 
                      text-white px-6 py-2 rounded-full font-bold shadow transition">
                        Login
                    </a>
                </div>
            </div>
        </div>
    </header>