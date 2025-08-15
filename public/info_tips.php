<?php
$articles = [
    [
        'img' => 'https://images.unsplash.com/photo-1519389950473-47ba0277781c?auto=format&fit=crop&w=400&q=80',
        'title' => 'Inilah 5 Daftar Pekerjaan Paling Diminati Saat Ini',
        'desc' => 'Pada era sekarang ini, jenis pekerjaan ada banyak sekali macamnya. Namun, tahukah Anda pekerjaan apa yang paling diminati oleh orang saat ini? Yuk, simak daftarnya dalam artikel ini.'
    ],
    [
        'img' => 'https://images.unsplash.com/photo-1464983953574-0892a716854b?auto=format&fit=crop&w=400&q=80',
        'title' => '5 Pekerjaan Freelance Paling Menjanjikan Saat Ini',
        'desc' => 'Seiring dengan berkembangnya jaman, stigma masyarakat terkait dunia kerja pun juga mulai berubah. Jika sebelumnya bekerja di kantor paling diminati, saat ini pekerjaan freelance pun mulai banyak dilirik oleh kalangan milenial.'
    ],
    [
        'img' => 'https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=400&q=80',
        'title' => '5 Jurusan Kuliah yang Paling Banyak Dicari di Dunia Kerja',
        'desc' => 'Memilih jurusan kuliah yang tepat sangat penting untuk masa depan karir. Berikut adalah jurusan yang paling banyak dicari di dunia kerja saat ini.'
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Artikel - LokerBandung.id</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <nav class="bg-[#223047] py-4 px-8 flex items-center justify-between">
        <div class="flex items-center">
            <span class="text-3xl font-bold text-white">LokerB<span class="inline-block align-middle"><svg xmlns="http://www.w3.org/2000/svg" class="inline w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M9 21V7a2 2 0 012-2h2a2 2 0 012 2v14" /></svg></span>ndung.id</span>
        </div>
        <div class="flex gap-8 items-center">
            <a href="#" class="text-white font-semibold text-lg">Tips Kerja</a>
            <a href="#" class="text-white font-semibold text-lg">Kota Lainnya</a>
            <a href="#" class="ml-4 px-4 py-2 border border-yellow-400 rounded bg-yellow-400 text-[#223047] font-bold hover:bg-yellow-300 transition">Pasang Lowongan</a>
        </div>
    </nav>
    <div class="bg-blue-50 py-2 px-8 text-sm text-gray-600">
        <span class="opacity-80">LokerBandung.id &gt; Artikel</span>
    </div>
    <main class="max-w-3xl mx-auto bg-white rounded-xl shadow-lg mt-8 p-8">
        <h1 class="text-xl font-semibold mb-4">Cari artikel disini..</h1>
        <?php foreach($articles as $idx => $a): ?>
            <div class="flex gap-6 mb-8 pb-8 border-b last:border-b-0 last:mb-0 last:pb-0">
                <img src="<?= htmlspecialchars($a['img']) ?>" alt="" class="w-40 h-28 object-cover rounded-lg flex-shrink-0">
                <div>
                    <h2 class="text-2xl font-bold mb-1 <?= $idx === 0 ? 'inline' : '' ?>">
                        <?= $a['title'] ?>
                    </h2>
                    <p class="text-gray-700 mt-2"><?= $a['desc'] ?></p>
                </div>
            </div>
        <?php endforeach; ?>
    </main>
    <div class="fixed bottom-6 right-6 flex items-center gap-2">
        <a href="#" class="flex items-center px-4 py-2 rounded-full bg-gradient-to-r from-pink-500 to-yellow-400 text-white font-semibold shadow-lg">
            <span class="flex gap-1 mr-2">
                <img src="https://upload.wikimedia.org/wikipedia/commons/0/09/Tiktok_logo.svg" class="w-5 h-5 bg-white rounded-full p-0.5" alt="tiktok">
                <img src="https://upload.wikimedia.org/wikipedia/commons/8/82/Telegram_logo.svg" class="w-5 h-5 bg-white rounded-full p-0.5" alt="telegram">
                <img src="https://upload.wikimedia.org/wikipedia/commons/a/a5/Instagram_icon.png" class="w-5 h-5 bg-white rounded-full p-0.5" alt="instagram">
            </span>
            Ikuti Kami
        </a>
    </div>
    <a href="#" class="fixed top-32 right-10 bg-white rounded-full shadow-lg p-2">
        <img src="https://upload.wikimedia.org/wikipedia/commons/8/87/PDF_file_icon.svg" class="w-7 h-7" alt="pdf">
    </a>
</body>
</html>