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
  <script>
    // Toggle field gaji (opsional)
    function toggleGaji() {
      const checkbox = document.getElementById('show_gaji');
      const gajiField = document.getElementById('gaji_field');
      if (checkbox.checked) {
        gajiField.classList.remove('hidden');
      } else {
        gajiField.classList.add('hidden');
      }
    }
  </script>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Header -->
  <header class="bg-[#00797a] text-white py-4 text-center text-xl font-bold shadow">
    Form Pasang Lowongan
  </header>

  <!-- Container -->
  <div class="max-w-4xl mx-auto mt-8 bg-white p-8 rounded-2xl shadow-lg border">
    <form action="proses_lowongan.php" method="POST" enctype="multipart/form-data" class="space-y-6">

      <!-- Nama Perusahaan -->
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Nama Perusahaan</label>
        <input type="text" name="nama_perusahaan" required
               class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
      </div>

      <!-- Posisi Pekerjaan -->
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Posisi Pekerjaan</label>
        <input type="text" name="posisi_pekerjaan" required
               class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
      </div>

      <!-- Deskripsi -->
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Deskripsi Lowongan</label>
        <textarea name="deskripsi" rows="5" required
                  class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"></textarea>
      </div>

      <!-- Kriteria -->
      <div class="space-y-6">
        <h3 class="text-lg font-bold text-gray-700">Kriteria</h3>

        <!-- Usia -->
        <div>
          <label class="block text-gray-700 font-semibold mb-2">Batas Usia</label>
          <select name="usia" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option value="">Pilih batas usia</option>
            <option value="maks_25">Maksimal 25 tahun</option>
            <option value="maks_30">Maksimal 30 tahun</option>
            <option value="maks_35">Maksimal 35 tahun</option>
            <option value="maks_40">Maksimal 40 tahun</option>
          </select>
        </div>

        <!-- Pendidikan -->
        <div>
          <label class="block text-gray-700 font-semibold mb-2">Pendidikan Minimal</label>
          <select name="pendidikan" class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
            <option value="">Pilih pendidikan</option>
            <option value="sma">SMA/SMK</option>
            <option value="d3">Diploma (D3)</option>
            <option value="s1">Sarjana (S1)</option>
            <option value="s2">Magister (S2)</option>
          </select>
        </div>

        <!-- Gender -->
        <div>
          <label class="block text-gray-700 font-semibold mb-2">Jenis Kelamin</label>
          <div class="flex items-center gap-6">
            <label class="flex items-center gap-2">
              <input type="radio" name="gender" value="pria"> Pria
            </label>
            <label class="flex items-center gap-2">
              <input type="radio" name="gender" value="wanita"> Wanita
            </label>
          </div>
        </div>
      </div>

      <!-- Media Sosial & Website -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label class="block text-gray-700 font-semibold mb-2">Media Sosial</label>
          <input type="url" name="media_sosial" placeholder="https://"
                 class="w-full p-3 border rounded-lg">
        </div>
        <div>
          <label class="block text-gray-700 font-semibold mb-2">Website</label>
          <input type="url" name="website" placeholder="https://"
                 class="w-full p-3 border rounded-lg">
        </div>
      </div>

      <!-- Banner -->
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Banner Perusahaan</label>
        <input type="file" name="logo" accept="image/*"
               class="w-full border p-3 rounded-lg bg-gray-50 cursor-pointer">
      </div>

      <!-- Jumlah yang diperlukan -->
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Jumlah yang diperlukan</label>
        <input type="number" name="jumlah" required 
               class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
      </div>

      <!-- Checkbox gaji -->
      <div>
        <label class="flex items-center gap-2">
          <input type="checkbox" id="show_gaji" onclick="toggleGaji()" class="w-4 h-4 text-teal-600">
          <span class="text-gray-700 font-semibold">Tampilkan Kisaran Gaji</span>
        </label>
      </div>

      <!-- Kisaran gaji -->
      <div id="gaji_field" class="hidden">
        <label class="block text-gray-700 font-semibold mb-2">Kisaran gaji</label>
        <input type="text" name="gaji" placeholder="Contoh: Rp3.000.000 - Rp5.000.000"
               class="w-full p-3 border rounded-lg">
      </div>

      <!-- Syarat pekerjaan -->
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Syarat pekerjaan</label>
        <textarea name="syarat" rows="5" required
                  class="w-full p-3 border rounded-lg"></textarea>
      </div>

      <!-- Batas lamaran -->
      <div>
        <label class="block text-gray-700 font-semibold mb-2">Batas lamaran</label>
        <input type="date" name="batas" required
               class="w-full p-3 border rounded-lg">
      </div>

      <!-- Tombol -->
      <div class="flex justify-end pt-4">
        <button type="submit" 
                class="px-6 py-3 bg-[#00797a] text-white rounded-lg font-bold shadow hover:bg-[#00646A] transition">
          Simpan Lowongan
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
