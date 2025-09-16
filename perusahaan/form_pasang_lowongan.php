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
    <!-- Notifikasi sukses jika ada -->
    <?php if (isset($_GET['success'])): ?>
      <div id="notif-success" class="mb-4 p-3 bg-green-100 text-green-700 rounded-lg font-semibold">
        Lowongan berhasil ditambahkan!
      </div>
      <script>
        setTimeout(function() {
          var notif = document.getElementById('notif-success');
          if (notif) notif.style.display = 'none';
        }, 2000);
      </script>
    <?php endif; ?>
    <form action="../dashboard/dashboard_perusahaan.php" method="POST" enctype="multipart/form-data" class="space-y-6">

      <!-- Nama Perusahaan -->
      <div>
        <label for="nama_perusahaan" class="block text-gray-700 font-semibold mb-2">Nama Perusahaan</label>
        <input type="text" id="nama_perusahaan" name="nama_perusahaan" required 
               class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
      </div>

      <!-- Judul Lowongan -->
      <div>
        <label for="judul_lowongan" class="block text-gray-700 font-semibold mb-2">Judul Lowongan</label>
        <input type="text" id="judul_lowongan" name="judul_lowongan" required 
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
        <button type="button" 
                id="btn-selanjutnya"
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

  <script>
    // Validasi sebelum redirect
    document.getElementById('btn-selanjutnya')?.addEventListener('click', function (e) {
      // Ambil form dan field wajib
      const form = document.querySelector('form');
      let valid = true;

      // Nama Perusahaan
      const namaPerusahaan = document.getElementById('nama_perusahaan');
      if (!namaPerusahaan.value.trim()) {
        namaPerusahaan.classList.add('border-red-500');
        if (!namaPerusahaan.nextElementSibling || !namaPerusahaan.nextElementSibling.classList.contains('text-red-600')) {
          const warn = document.createElement('div');
          warn.className = 'text-red-600 text-sm mt-1';
          warn.innerText = 'Harap isi bagian ini';
          namaPerusahaan.parentNode.appendChild(warn);
        }
        valid = false;
      } else {
        namaPerusahaan.classList.remove('border-red-500');
        if (namaPerusahaan.nextElementSibling && namaPerusahaan.nextElementSibling.classList.contains('text-red-600')) {
          namaPerusahaan.nextElementSibling.remove();
        }
      }

      // Judul Lowongan
      const judulLowongan = document.getElementById('judul_lowongan');
      if (!judulLowongan.value.trim()) {
        judulLowongan.classList.add('border-red-500');
        if (!judulLowongan.nextElementSibling || !judulLowongan.nextElementSibling.classList.contains('text-red-600')) {
          const warn = document.createElement('div');
          warn.className = 'text-red-600 text-sm mt-1';
          warn.innerText = 'Harap isi bagian ini';
          judulLowongan.parentNode.appendChild(warn);
        }
        valid = false;
      } else {
        judulLowongan.classList.remove('border-red-500');
        if (judulLowongan.nextElementSibling && judulLowongan.nextElementSibling.classList.contains('text-red-600')) {
          judulLowongan.nextElementSibling.remove();
        }
      }

      // Deskripsi Lowongan
      const deskripsi = document.getElementById('deskripsi');
      if (!deskripsi.value.trim()) {
        deskripsi.classList.add('border-red-500');
        if (!deskripsi.nextElementSibling || !deskripsi.nextElementSibling.classList.contains('text-red-600')) {
          const warn = document.createElement('div');
          warn.className = 'text-red-600 text-sm mt-1';
          warn.innerText = 'Harap isi bagian ini';
          deskripsi.parentNode.appendChild(warn);
        }
        valid = false;
      } else {
        deskripsi.classList.remove('border-red-500');
        if (deskripsi.nextElementSibling && deskripsi.nextElementSibling.classList.contains('text-red-600')) {
          deskripsi.nextElementSibling.remove();
        }
      }

      // Usia
      const usia = document.getElementById('usia');
      if (!usia.value) {
        usia.classList.add('border-red-500');
        if (!usia.nextElementSibling || !usia.nextElementSibling.classList.contains('text-red-600')) {
          const warn = document.createElement('div');
          warn.className = 'text-red-600 text-sm mt-1';
          warn.innerText = 'Harap isi bagian ini';
          usia.parentNode.appendChild(warn);
        }
        valid = false;
      } else {
        usia.classList.remove('border-red-500');
        if (usia.nextElementSibling && usia.nextElementSibling.classList.contains('text-red-600')) {
          usia.nextElementSibling.remove();
        }
      }

      // Pendidikan
      const pendidikan = document.getElementById('pendidikan');
      if (!pendidikan.value) {
        pendidikan.classList.add('border-red-500');
        if (!pendidikan.nextElementSibling || !pendidikan.nextElementSibling.classList.contains('text-red-600')) {
          const warn = document.createElement('div');
          warn.className = 'text-red-600 text-sm mt-1';
          warn.innerText = 'Harap isi bagian ini';
          pendidikan.parentNode.appendChild(warn);
        }
        valid = false;
      } else {
        pendidikan.classList.remove('border-red-500');
        if (pendidikan.nextElementSibling && pendidikan.nextElementSibling.classList.contains('text-red-600')) {
          pendidikan.nextElementSibling.remove();
        }
      }

      // Gender
      const genderRadios = form.querySelectorAll('input[name="gender"]');
      let genderChecked = false;
      genderRadios.forEach(radio => { if (radio.checked) genderChecked = true; });
      const genderDiv = genderRadios[0]?.closest('.flex');
      if (!genderChecked && genderDiv) {
        if (!genderDiv.nextElementSibling || !genderDiv.nextElementSibling.classList.contains('text-red-600')) {
          const warn = document.createElement('div');
          warn.className = 'text-red-600 text-sm mt-1';
          warn.innerText = 'Harap isi bagian ini';
          genderDiv.parentNode.appendChild(warn);
        }
        valid = false;
      } else if (genderDiv && genderDiv.nextElementSibling && genderDiv.nextElementSibling.classList.contains('text-red-600')) {
        genderDiv.nextElementSibling.remove();
      }

      // Jika valid, redirect
      if (valid) {
        window.location.href = '../public/buka_lowongan.php';
      }
    });
  </script>
</body>
</html>
