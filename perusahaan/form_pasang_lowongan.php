<?php
// kalau sudah ada sistem login perusahaan, bisa tambahkan session cek disini
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Form Pasang Lowongan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Header -->
  <header class="bg-[#00797a] text-white py-4 text-center text-xl font-bold shadow">
    Form Pasang Lowongan
  </header>

  <!-- Container -->
  <div class="max-w-3xl mx-auto mt-8 bg-white p-8 rounded-2xl shadow-lg border">
    <form action="proses_lowongan.php" method="POST" enctype="multipart/form-data" class="space-y-6">

      <!-- Nama Perusahaan -->
      <div>
        <label for="nama_perusahaan" class="block text-gray-700 font-semibold mb-2">Nama Perusahaan</label>
        <input type="text" id="nama_perusahaan" name="nama_perusahaan" required 
               class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
      </div>

      <!-- Deskripsi Perusahaan -->
      <div>
        <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi Perusahaan</label>
        <textarea id="deskripsi" name="deskripsi" rows="5" required
                  class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"></textarea>
      </div>

      <!-- Media Sosial & Website -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="media_sosial" class="block text-gray-700 font-semibold mb-2">Media Sosial</label>
          <input type="url" id="media_sosial" name="media_sosial" placeholder="https://"
                 class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>
        <div>
          <label for="website" class="block text-gray-700 font-semibold mb-2">Website</label>
          <input type="url" id="website" name="website" placeholder="https://"
                 class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>
      </div>

      <!-- Logo -->
      <div>
        <label for="logo" class="block text-gray-700 font-semibold mb-2">Logo Perusahaan</label>
        <input type="file" id="logo" name="logo" accept="image/*"
               class="w-full border p-3 rounded-lg bg-gray-50 cursor-pointer focus:outline-none focus:ring-2 focus:ring-teal-500">
      </div>

     <!-- Tombol -->
      <div class="flex justify-between pt-4">
        <a href="../perusahaan/daftar_pelamar.php" 
           class="px-6 py-3 bg-gray-300 text-gray-800 rounded-lg font-semibold shadow hover:bg-gray-400 transition">
          Kembali
        </a>
        <button type="submit" 
                class="px-6 py-3 bg-[#00797a] text-white rounded-lg font-bold shadow hover:bg-[#00646A] transition">
          Selanjutnya
        </button>
      </div>
    </form>
  </div>

  <!-- Footer -->
  <footer class="mt-10 bg-[#00797a] py-6 text-center text-white">
    <div class="flex flex-col items-center space-y-2">
      <img src="../assets/logo.png" alt="Logo" class="w-16 h-16 rounded-full">
      <div class="font-bold text-lg">CariKerja.id</div>
      <p class="text-sm">© 2025 CariKerja.id | All Rights Reserved</p>
    </div>
  </footer>

</body>
</html>
