<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Lamar Lowongan</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .brand-green { color: #00646A; }
    .brand-green-bg { background-color: #00646A; }
    .brand-green-focus:focus {
      outline: none;
      border-color: #00646A;
      box-shadow: 0 0 0 2px rgba(0,100,106,0.3);
    }
  </style>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Wrapper -->
  <div class="max-w-2xl mx-auto mt-10">

    <!-- Card -->
    <div class="bg-white rounded-2xl shadow-lg p-8">

      <!-- Header -->
      <div class="mb-6 text-center">
        <h2 class="text-2xl font-bold brand-green">Formulir Lamaran</h2>
        <p class="text-gray-500">Lengkapi data berikut untuk melamar pekerjaan.</p>
      </div>

      <!-- Ringkasan Lowongan -->
      <div class="bg-gray-50 p-4 rounded-lg border mb-6">
        <h3 class="text-lg font-bold brand-green">PT Maju Jaya</h3>
        <p class="text-gray-600">Posisi: <span class="font-medium">Montir</span></p>
        <p class="text-gray-600">Lokasi: <span class="font-medium">Bandung</span></p>
        <p class="text-gray-600">Gaji: <span class="font-medium">Rp 2.000.000</span></p>
      </div>

      <!-- Form -->
      <form action="proses_lamaran.php" method="POST" enctype="multipart/form-data" class="space-y-5">

        <!-- Nama -->
        <div>
          <label class="block font-medium text-gray-700 mb-1">Nama Lengkap</label>
          <input type="text" name="nama_pelamar" placeholder="Masukkan nama lengkap"
            class="w-full border rounded-lg px-3 py-2 brand-green-focus">
        </div>

        <!-- Email -->
        <div>
          <label class="block font-medium text-gray-700 mb-1">Email</label>
          <input type="email" name="email" placeholder="contoh@email.com"
            class="w-full border rounded-lg px-3 py-2 brand-green-focus">
        </div>

        <!-- No HP -->
        <div>
          <label class="block font-medium text-gray-700 mb-1">Nomor HP</label>
          <input type="text" name="no_hp" placeholder="08xxxxxxxxxx"
            class="w-full border rounded-lg px-3 py-2 brand-green-focus">
        </div>

        <!-- Upload CV -->
        <div>
          <label class="block font-medium text-gray-700 mb-1">Upload CV</label>
          <input type="file" name="cv" accept=".pdf,.doc,.docx"
            class="w-full border rounded-lg px-3 py-2">
          <p class="text-sm text-gray-500 mt-1">* Format PDF/DOC, maksimal 2MB</p>
        </div>

        <!-- Tombol -->
        <div class="flex justify-end space-x-3 pt-4">
          <button type="reset"
            class="px-5 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
            Reset
          </button>
          <button type="submit"
            class="px-5 py-2 rounded-lg brand-green-bg text-white hover:opacity-90">
            Lamar Sekarang
          </button>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
        </div>
      </form>
    </div>
  </div>

</body>
</html>
