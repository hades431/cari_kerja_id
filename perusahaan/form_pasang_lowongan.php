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

      <!-- Ringkasan -->
      <div class="space-y-6">
        <h3 class="text-lg font-bold text-gray-700">Ringkasan</h3>

        <!-- Batas Pengalaman -->
        <div>
          <label class="block text-gray-700 font-semibold mb-2">Batas Pengalaman (tahun)</label>
          <div id="pengalaman-options" class="flex gap-4">
            <label class="flex items-center gap-2">
              <input type="checkbox" name="pengalaman[]" value="0" class="pengalaman-checkbox text-teal-600 focus:ring-teal-500">
              0 Tahun
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" name="pengalaman[]" value="1" class="pengalaman-checkbox text-teal-600 focus:ring-teal-500">
              1 Tahun
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" name="pengalaman[]" value="2" class="pengalaman-checkbox text-teal-600 focus:ring-teal-500">
              2 Tahun
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" name="pengalaman[]" value="3" class="pengalaman-checkbox text-teal-600 focus:ring-teal-500">
              3 Tahun
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" name="pengalaman[]" value="4" class="pengalaman-checkbox text-teal-600 focus:ring-teal-500">
              4 Tahun
            </label>
          </div>
          <div id="pengalaman-warning" class="text-red-600 text-sm mt-1 hidden">Pilih 2 pengalaman!</div>
        </div>

       
        <!-- Pendidikan -->
        <div>
          <label for="pendidikan" class="block text-gray-700 font-semibold mb-2">Pendidikan Minimal</label>
          <div id="pendidikan-options" class="flex flex-wrap gap-4">
            <label class="flex items-center gap-2">
              <input type="checkbox" name="pendidikan[]" value="sma" class="pendidikan-checkbox text-teal-600 focus:ring-teal-500">
              SMA/SMK
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" name="pendidikan[]" value="d3" class="pendidikan-checkbox text-teal-600 focus:ring-teal-500">
              Diploma (D3)
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" name="pendidikan[]" value="s1" class="pendidikan-checkbox text-teal-600 focus:ring-teal-500">
              Sarjana (S1)
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" name="pendidikan[]" value="s2" class="pendidikan-checkbox text-teal-600 focus:ring-teal-500">
              Magister (S2)
            </label>
          </div>
          <div id="pendidikan-warning" class="text-red-600 text-sm mt-1 hidden">Masukkan pendidikan!</div>
        </div>

       
        <!-- Jenis Kelamin -->
        <div>
          <label class="block text-gray-700 font-semibold mb-2">Jenis Kelamin</label>
          <div id="gender-options" class="flex items-center gap-6">
            <label class="flex items-center gap-2">
              <input type="checkbox" name="gender[]" value="pria" class="gender-checkbox text-teal-600 focus:ring-teal-500">
              Pria
            </label>
            <label class="flex items-center gap-2">
              <input type="checkbox" name="gender[]" value="wanita" class="gender-checkbox text-teal-600 focus:ring-teal-500">
              Wanita
            </label>
          </div>
          <div id="gender-warning" class="text-red-600 text-sm mt-1 hidden">Pilih minimal 1 jenis kelamin!</div>
        </div>
      </div>

      <!-- Lokasi Kerja & Besaran Gaji -->
      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        <div>
          <label for="lokasi_kerja" class="block text-gray-700 font-semibold mb-2">Lokasi Kerja</label>
          <input type="text" id="lokasi_kerja" name="lokasi_kerja" placeholder="Contoh: Bandung, Jakarta, dll"
                 class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
        </div>
        <div>
          <label for="besaran_gaji" class="block text-gray-700 font-semibold mb-2">Besaran Gaji</label>
          <input type="text" id="besaran_gaji" name="besaran_gaji" placeholder="Contoh: 5.000.000 atau Kompetitif"
                 class="w-full p-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-teal-500">
          <div id="gaji-warning" class="text-red-600 text-sm mt-1 hidden">Masukkan besaran gaji!</div>
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
                <a href
                class="px-6 py-3 bg-[#00797a] text-white rounded-lg font-bold shadow hover:bg-[#00646A] transition">
          Selanjutnya
      </a>
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
    document.getElementById('btn-selanjutnya')?.addEventListener('click', function (e) {
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

      // Hapus validasi usia dan pendidikan yang pakai id (karena sudah pakai checkbox)
      // --- Hapus blok berikut ---
      // const usia = document.getElementById('usia');
      // if (!usia.value) {
      //   usia.classList.add('border-red-500');
      //   if (!usia.nextElementSibling || !usia.nextElementSibling.classList.contains('text-red-600')) {
      //     const warn = document.createElement('div');
      //     warn.className = 'text-red-600 text-sm mt-1';
      //     warn.innerText = 'Harap isi bagian ini';
      //     usia.parentNode.appendChild(warn);
      //   }
      //   valid = false;
      // } else {
      //   usia.classList.remove('border-red-500');
      //   if (usia.nextElementSibling && usia.nextElementSibling.classList.contains('text-red-600')) {
      //     usia.nextElementSibling.remove();
      //   }
      // }

      // const pendidikan = document.getElementById('pendidikan');
      // if (!pendidikan.value) {
      //   pendidikan.classList.add('border-red-500');
      //   if (!pendidikan.nextElementSibling || !pendidikan.nextElementSibling.classList.contains('text-red-600')) {
      //     const warn = document.createElement('div');
      //     warn.className = 'text-red-600 text-sm mt-1';
      //     warn.innerText = 'Harap isi bagian ini';
      //     pendidikan.parentNode.appendChild(warn);
      //   }
      //   valid = false;
      // } else {
      //   pendidikan.classList.remove('border-red-500');
      //   if (pendidikan.nextElementSibling && pendidikan.nextElementSibling.classList.contains('text-red-600')) {
      //     pendidikan.nextElementSibling.remove();
      //   }
      // }
      // --- End hapus ---

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

      // Validasi pengalaman (harus pilih 2)
      const pengalamanChecked = Array.from(document.querySelectorAll('.pengalaman-checkbox')).filter(x => x.checked);
      const pengalamanWarning = document.getElementById('pengalaman-warning');
      if (pengalamanChecked.length !== 2) {
        pengalamanWarning.classList.remove('hidden');
        valid = false;
      } else {
        pengalamanWarning.classList.add('hidden');
      }

      // Validasi pendidikan (harus ada yang dipilih)
      const pendidikanChecked = Array.from(document.querySelectorAll('.pendidikan-checkbox')).filter(x => x.checked);
      const pendidikanWarning = document.getElementById('pendidikan-warning');
      if (pendidikanChecked.length === 0) {
        pendidikanWarning.classList.remove('hidden');
        valid = false;
      } else {
        pendidikanWarning.classList.add('hidden');
      }

      // Validasi gender (minimal 1 dipilih)
      const genderChecked = Array.from(document.querySelectorAll('.gender-checkbox')).filter(x => x.checked);
      const genderWarning = document.getElementById('gender-warning');
      if (genderChecked.length === 0) {
        genderWarning.classList.remove('hidden');
        valid = false;
      } else {
        genderWarning.classList.add('hidden');
      }

      // Validasi besaran gaji (harus diisi)
      const besaranGaji = document.getElementById('besaran_gaji');
      const gajiWarning = document.getElementById('gaji-warning');
      if (!besaranGaji.value.trim()) {
        gajiWarning.classList.remove('hidden');
        valid = false;
      } else {
        gajiWarning.classList.add('hidden');
      }

      // Jika valid, submit form (otomatis pindah ke dashboard perusahaan)
      if (valid) {
        document.querySelector('form').submit();
      } else {
        // Scroll ke field error pertama (cari field dengan border-red-500 atau warning yang tidak hidden)
        const firstError = document.querySelector('.border-red-500, .text-red-600:not(.hidden)');
        if (firstError) {
          // Jika warning, scroll ke parent (agar tidak scroll ke text kecil)
          if (firstError.classList.contains('text-red-600')) {
            firstError.parentNode.scrollIntoView({ behavior: 'smooth', block: 'center' });
          } else {
            firstError.scrollIntoView({ behavior: 'smooth', block: 'center' });
          }
        }
      }
    });

    // Pengalaman checkbox logic
    const pengalamanCheckboxes = document.querySelectorAll('.pengalaman-checkbox');
    pengalamanCheckboxes.forEach(cb => {
      cb.addEventListener('change', function() {
        let checked = Array.from(pengalamanCheckboxes).filter(x => x.checked);
        // Batasi maksimal 2
        if (checked.length > 2) { 
          this.checked = false;
        }
      });
    });
  </script>
</body>
</html>
