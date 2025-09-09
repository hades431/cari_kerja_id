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

      <!-- Deskripsi Lowongan -->
      <div>
        <label for="deskripsi" class="block text-gray-700 font-semibold mb-2">Deskripsi Lowongan</label>
        <textarea id="deskripsi" name="deskripsi" rows="5" required
                  class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"></textarea>
      </div>

      <!-- Kriteria -->
      <div class="space-y-6">
        <h3 class="text-lg font-bold text-gray-700">Kriteria</h3>

        <!-- Batas Usia -->
        <div>
          <label for="usia" class="block text-gray-700 font-semibold mb-2">Batas Usia</label>
          <select id="usia" name="usia" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option value="">Pilih batas usia</option>
            <option value="maks_25">Maksimal 25 tahun</option>
            <option value="maks_30">Maksimal 30 tahun</option>
            <option value="maks_35">Maksimal 35 tahun</option>
            <option value="maks_40">Maksimal 40 tahun</option>
          </select>
        </div>

        <!-- Pendidikan -->
        <div>
          <label for="pendidikan" class="block text-gray-700 font-semibold mb-2">Pendidikan Minimal</label>
          <select id="pendidikan" name="pendidikan" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option value="">Pilih pendidikan</option>
            <option value="sma">SMA/SMK</option>
            <option value="d3">Diploma (D3)</option>
            <option value="s1">Sarjana (S1)</option>
            <option value="s2">Magister (S2)</option>
          </select>
        </div>

       
        <!-- Jenis Kelamin -->
        <div>
          <label class="block text-gray-700 font-semibold mb-2">Jenis Kelamin</label>
          <div class="flex items-center gap-6">
            <label class="flex items-center gap-2">
              <input type="radio" name="gender" value="pria" class="text-teal-600 focus:ring-teal-500">
              Pria
            </label>
            <label class="flex items-center gap-2">
              <input type="radio" name="gender" value="wanita" class="text-teal-600 focus:ring-teal-500">
              Wanita
            </label>
          </div>
        </div>
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
        <label for="logo" class="block text-gray-700 font-semibold mb-2">Banner Perusahaan</label>
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
    <div class="font-bold text-lg">CariKerja.id</div>
    <p class="text-sm">© 2025 CariKerja.id | All Rights Reserved</p>
  </footer>

</body>
</html>
