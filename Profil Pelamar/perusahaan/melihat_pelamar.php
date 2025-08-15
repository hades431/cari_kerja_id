<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Pelamar</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-teal-800 text-white p-6 flex flex-col">
            <div class="flex flex-col items-center mb-10">
                <div class="w-20 h-20 bg-white rounded-full mb-3"></div>
                <h1 class="text-lg font-bold">Perusahaan</h1>
            </div>
            <nav class="flex flex-col space-y-4">
                <a href="#" class="bg-teal-600 px-4 py-2 rounded">Dashboard</a>
                <a href="#" class="bg-teal-900 px-4 py-2 rounded">Daftar Pelamar</a>
            </nav>
            <div class="mt-auto">
                <p class="text-center text-sm opacity-75">© 2025 Carikerja.id</p>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-1 p-8">
            <h2 class="text-2xl font-bold mb-6">Daftar Pelamar</h2>

            <!-- Search & Filter -->
            <div class="flex justify-between mb-4">
                <input type="text" placeholder="Cari pelamar..." class="border rounded px-3 py-2 w-1/3">
                <div>
                    <button class="border px-3 py-2 rounded">🔍</button>
                    <button class="border px-3 py-2 rounded">⚙</button>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded shadow overflow-hidden">
                <table class="w-full border-collapse">
                    <thead class="bg-gray-200">
                        <tr>
                            <th class="p-3 border">Nama</th>
                            <th class="p-3 border">Email</th>
                            <th class="p-3 border">Posisi</th>
                            <th class="p-3 border">Tanggal Lamar</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $pelamar = [
                                ["nama" => "Khaura", "email" => "khaura@example.com", "posisi" => "Frontend Developer", "tgl" => "2025-08-01"],
                                ["nama" => "Satria", "email" => "satria@example.com", "posisi" => "UI Designer", "tgl" => "2025-08-03"],
                                ["nama" => "Ola", "email" => "ola@example.com", "posisi" => "Backend Developer", "tgl" => "2025-08-05"],
                            ];

                            foreach ($pelamar as $p) {
                                echo "<tr class='hover:bg-gray-100'>
                                        <td class='p-3 border'>{$p['nama']}</td>
                                        <td class='p-3 border'>{$p['email']}</td>
                                        <td class='p-3 border'>{$p['posisi']}</td>
                                        <td class='p-3 border'>{$p['tgl']}</td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </main>
    </div>

</body>
</html>
