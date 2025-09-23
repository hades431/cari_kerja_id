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
    // Script untuk toggle field gaji
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

      <!-- Jumlah yang diperlukan -->
      <div>
        <label for="jumlah" class="block text-gray-700 font-semibold mb-2">Jumlah yang diperlukan</label>
        <input type="number" id="jumlah" name="jumlah" required 
               class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
      </div>

      <!-- Checkbox untuk kisaran gaji -->
      <div>
        <label class="flex items-center gap-2">
          <input type="checkbox" id="show_gaji" onclick="toggleGaji()" class="w-4 h-4 text-teal-600 focus:ring-teal-500">
          <span class="text-gray-700 font-semibold">Tampilkan Kisaran Gaji</span>
        </label>
      </div>

      <!-- Kisaran gaji (hidden by default) -->
      <div id="gaji_field" class="hidden">
        <label for="gaji" class="block text-gray-700 font-semibold mb-2">Kisaran gaji</label>
        <input type="text" id="gaji" name="gaji" placeholder="Contoh: Rp3.000.000 - Rp5.000.000"
               class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
      </div>

      <!-- Grid untuk syarat pekerjaan dan batas lamaran -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Syarat pekerjaan -->
        <div>
          <label for="syarat" class="block text-gray-700 font-semibold mb-2">Syarat pekerjaan</label>
          <textarea id="syarat" name="syarat" rows="5" required
                    class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500"></textarea>
        </div>

        <!-- Batas lamaran -->
        <div>
          <label for="batas" class="block text-gray-700 font-semibold mb-2">Batas lamaran</label>
          <input type="date" id="batas" name="batas" required
                 class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>
      </div>

      <!-- Tombol -->
      <div class="flex justify-between pt-4">
        <a href="../perusahaan/form_pasang_lowongan.php" 
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
