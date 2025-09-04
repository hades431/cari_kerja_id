<?php
// Dummy data
$nama = "Nama Pelamar";
$posisi = "UI/UX Designer";
$email = "email@pelamar.com";
$telepon = "0812-3456-7890";
$lokasi = "Bandung, Indonesia";
$deskripsi = "Seorang UI/UX Designer dengan pengalaman lebih dari 3 tahun di industri teknologi. Memiliki keahlian dalam desain antarmuka, prototyping, dan kolaborasi tim lintas fungsi.";
$pengalaman = [
    [
        "jabatan" => "Graphic Designer",
        "perusahaan" => "CV Kreatif Studio",
        "periode" => "Jul 2019 - Des 2020",
        "deskripsi" => "Membuat materi promosi digital dan cetak untuk berbagai klien."
    ]
];
$keahlian = ["UI Design", "UX Research", "Figma", "Adobe XD", "Prototyping", "Teamwork"];
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
    <div class="w-full bg-[#00797a] py-4 px-8 flex items-center justify-between">
        <img src="../img/logo2.png" alt="Logo" class="h-10">
        <div class="flex gap-3">
            <!-- Tombol Info & Tips Kerja dan Buka Lowongan dihapus -->
        </div>
    </div>
    <!-- Back Button -->
    <div class="px-8 mt-6">
        <a href="javascript:history.back()" class="inline-flex items-center px-4 py-2 bg-gray-100 rounded-md text-gray-700 hover:bg-gray-200 transition">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M15 19l-7-7 7-7"/></svg>
            Kembali
        </a>
    </div>
    <!-- Profile Card -->
    <div class="flex justify-center mt-6">
        <div class="bg-white rounded-2xl shadow-lg flex w-full max-w-4xl p-10 gap-10">
            <!-- Avatar -->
            <div class="flex flex-col items-center justify-start">
                <div class="w-40 h-40 rounded-full bg-[#2563eb] flex items-center justify-center text-white text-6xl font-bold shadow-md mb-4 border-4 border-white">
                    <?php echo strtoupper(substr($nama,0,1)) . strtoupper(substr(explode(' ', $nama)[1] ?? '',0,1)); ?>
                </div>
            </div>
            <!-- Info -->
            <div class="flex-1">
                <div class="mb-2">
                    <div class="text-2xl font-bold"><?php echo $nama; ?></div>
                    <div class="text-lg text-[#00797a] font-semibold"><?php echo $posisi; ?></div>
                </div>
                <div class="flex items-center gap-4 text-gray-500 mb-4 flex-wrap">
                    <div class="flex items-center gap-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M16 12a4 4 0 1 1-8 0 4 4 0 0 1 8 0z"/><path d="M12 14v7m0 0H7m5 0h5"/></svg>
                        <?php echo $email; ?>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M3 5a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5zm0 10a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-2zm10-10a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2V5zm0 10a2 2 0 0 1 2-2h2a2 2 0 0 1 2 2v2a2 2 0 0 1-2 2h-2a2 2 0 0 1-2-2v-2z"/></svg>
                        <?php echo $telepon; ?>
                    </div>
                    <div class="flex items-center gap-1">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path d="M17.657 16.657L13.414 12.414a4 4 0 1 0-1.414 1.414l4.243 4.243a1 1 0 0 0 1.414-1.414z"/><path d="M15 11a4 4 0 1 1-8 0 4 4 0 0 1 8 0z"/></svg>
                        <?php echo $lokasi; ?>
                    </div>
                </div>
                <div class="mb-4">
                    <div class="font-semibold">Deskripsi</div>
                    <div class="bg-gray-100 rounded-lg p-4 mt-1 text-gray-700"><?php echo $deskripsi; ?></div>
                </div>
                <div class="mb-4">
                    <div class="font-semibold mb-1">Pengalaman Kerja</div>
                    <?php foreach($pengalaman as $exp): ?>
                        <div class="mb-2">
                            <span class="font-bold"><?php echo $exp['jabatan']; ?></span>
                            <span class="text-gray-500">@ <?php echo $exp['perusahaan']; ?></span>
                            <div class="text-sm text-gray-500"><?php echo $exp['periode']; ?></div>
                            <div class="text-gray-700"><?php echo $exp['deskripsi']; ?></div>
                        </div>
                    <?php endforeach; ?>
                </div>
                <div>
                    <div class="font-semibold mb-1">Keahlian</div>
                    <div class="flex flex-wrap gap-2">
                        <?php foreach($keahlian as $skill): ?>
                            <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium"><?php echo $skill; ?></span>
                        <?php endforeach; ?>
                    </div>
                </div>
                <!-- Tombol Edit -->
                <div class="mt-6 mb-2 flex justify-end">
                    <button class="bg-[#00797a] hover:bg-[#005f5f] text-white px-7 py-2 rounded-full font-semibold shadow transition">Edit</button>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
</body>
</html>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
