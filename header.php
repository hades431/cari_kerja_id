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
    <header class="bg-[#00646A] p-4 flex flex-col gap-2">
        <div class="flex items-center justify-between">
            <img src="../img/logo2.png" alt="Logo" class="px-6 py-2 rounded w-64 h-30 object-contain">
        </div>
        <div class="flex justify-end gap-4 mt-2">
            <button class="bg-green-500 max-w-max hover:bg-green-600 active:bg-green-700 
              text-white px-6 py-2 rounded-full font-bold shadow transition">Info & Tips Kerja</button>
            <a href="login.php" class="bg-green-500 max-w-max hover:bg-green-600 active:bg-green-700 
              text-white px-6 py-2 rounded-full font-bold shadow transition">
                Login
            </a>
        </div>
    </header>