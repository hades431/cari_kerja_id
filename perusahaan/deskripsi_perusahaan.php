<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Deskripsi Perusahaan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 font-sans">
  <!-- Header -->
  <header class="bg-[#00797a] flex items-center justify-between px-8 py-4">
    <div class="flex items-center gap-3 relative">
      <!-- Logo SVG dari folder img -->
      <span class="relative flex items-center">
        <span class="relative">
          <span class="text-white text-2xl font-bold tracking-wide z-10 relative">CARIKERJA.ID <span class="font-normal text-base">BANDUNG</span></span>
          <img src="/img/logo-caker-transparan.svg" alt="Logo Caker Transparan" class="absolute left-2 top-0 h-10 w-auto pointer-events-none" style="z-index:20;">
          <!-- left-2/top-0 bisa disesuaikan agar teleskop tepat di huruf A -->
        </span>
      </span>
    </div>
    <div class="flex gap-4">
      <a href="#" class="bg-green-500 text-white px-4 py-2 rounded font-semibold hover:bg-green-600 transition">Info & Tips Kerja</a>
      <a href="../public/buka_lowongan.php" class="bg-yellow-400 text-white px-4 py-2 rounded font-semibold hover:bg-yellow-500 transition">Buka Lowongan</a>
      <a href="../login.php" class="bg-green-500 text-white px-4 py-2 rounded font-semibold hover:bg-green-600 transition">Login</a>
    </div>
  </header>

  <!-- Judul Section (background putih, terpisah dari header) -->
  <section class="bg-white py-10 shadow">
    <div class="max-w-3xl mx-auto text-center">
      <h1 class="text-4xl font-bold text-[#00797a] mb-4">Cari Kerja <span class="text-green-500">Bandung</span></h1>
      <p class="text-lg text-gray-700 mb-6">Temukan loker Bandung terbaru bulan Agustus 2025 dengan mudah di CariKerjaID. <span class="underline cursor-pointer">Selengkapnya</span></p>
      <div class="bg-gray-50 rounded-2xl shadow-lg p-6 flex flex-col md:flex-row items-center gap-4 justify-center">
        <input type="text" placeholder="Search..." class="w-full md:w-1/3 px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-teal-500">
        <select class="w-full md:w-1/4 px-4 py-2 rounded border focus:outline-none focus:ring-2 focus:ring-teal-500">
          <option value="">Lulusan</option>
          <option value="sma">SMA/SMK</option>
          <option value="d3">Diploma (D3)</option>
          <option value="s1">Sarjana (S1)</option>
          <option value="s2">Magister (S2)</option>
        </select>
        <div class="flex gap-4 items-center">
          <label class="flex items-center gap-2">
            <input type="checkbox" class="accent-teal-600">
            <span class="text-gray-700 text-sm">Tanpa pengalaman</span>
          </label>
          <label class="flex items-center gap-2">
            <input type="checkbox" class="accent-teal-600">
            <span class="text-gray-700 text-sm">1-5 Tahun</span>
          </label>
          <label class="flex items-center gap-2">
            <input type="checkbox" class="accent-teal-600">
            <span class="text-gray-700 text-sm">5 Tahun Lebih</span>
          </label>
        </div>
        <button class="bg-white border border-gray-300 rounded-full px-6 py-2 flex items-center gap-2 font-semibold hover:bg-gray-100 transition">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-teal-700" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="11" cy="11" r="8" stroke-width="2"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35"/></svg>
          Cari
        </button>
      </div>
    </div>
  </section>
  <!-- Tidak ada card/gambar lowongan di bawah -->
</body>
</html>