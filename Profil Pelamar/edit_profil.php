<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Profil - CariKerja.id</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#00646A] min-h-screen">
    <div class="max-w-2xl mx-auto mt-12 bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Profil</h2>
        <form action="#" method="post" enctype="multipart/form-data" class="space-y-5">
            <!-- Foto Profil -->
            <div class="flex flex-col items-center">
                <img src="https://ui-avatars.com/api/?name=Nama+Pelamar&background=2563eb&color=fff&size=128"
                     class="w-24 h-24 rounded-full border-2 border-gray-200 object-cover mb-2" alt="Foto Profil">
                <label class="block">
                    <span class="sr-only">Pilih Foto Profil</span>
                    <input type="file" name="foto" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100
                    "/>
                </label>
            </div>
            <!-- Nama -->
            <div>
                <label class="block text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Nama Lengkap">
            </div>
            <!-- Email -->
            <div>
                <label class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Email">
            </div>
            <!-- Telepon -->
            <div>
                <label class="block text-gray-700 mb-1">Telepon</label>
                <input type="text" name="telepon" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Nomor Telepon">
            </div>
            <!-- Jabatan -->
            <div>
                <label class="block text-gray-700 mb-1">Jabatan/Posisi</label>
                <input type="text" name="jabatan" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Contoh: UI/UX Designer">
            </div>
            <!-- Lokasi -->
            <div>
                <label class="block text-gray-700 mb-1">Lokasi</label>
                <input type="text" name="lokasi" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Contoh: Bandung, Indonesia">
            </div>
            <!-- Ringkasan -->
            <div>
                <label class="block text-gray-700 mb-1">Ringkasan Profil</label>
                <textarea name="ringkasan" rows="4" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Ceritakan tentang diri Anda..."></textarea>
            </div>
            <!-- Pengalaman Kerja -->
            <div>
                <label class="block text-gray-700 mb-1">Pengalaman Kerja</label>
                <div class="space-y-3">
                    <div class="flex flex-col md:flex-row gap-2">
                        <input type="text" name="pengalaman_jabatan[]" class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Jabatan/Posisi">
                        <input type="text" name="pengalaman_perusahaan[]" class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Perusahaan">
                        <input type="text" name="pengalaman_tahun[]" class="md:w-40 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Tahun">
                    </div>
                    <!-- Tambah pengalaman lain dengan menambah input di sisi backend/JS jika perlu -->
                </div>
                <p class="text-xs text-gray-400 mt-1">* Tambahkan lebih banyak pengalaman dengan mengisi baris baru.</p>
            </div>
            <!-- Keahlian -->
            <div>
                <label class="block text-gray-700 mb-1">Keahlian</label>
                <div class="grid grid-cols-2 gap-2">
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="UI Design" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">UI Design</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="UX Research" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">UX Research</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Figma" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Figma</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Adobe XD" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Adobe XD</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Prototyping" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Prototyping</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Teamwork" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Teamwork</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="HTML/CSS" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">HTML/CSS</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Javascript" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Javascript</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Komunikasi" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Komunikasi</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="Manajemen Proyek" class="form-checkbox text-[#00646A]">
                        <span class="ml-2">Manajemen Proyek</span>
                    </label>
                    <!-- Tambahkan opsi lain sesuai kebutuhan -->
                </div>
                <p class="text-xs text-gray-400 mt-1">* Pilih satu atau lebih keahlian yang kamu miliki.</p>
            </div>
            <!-- Upload CV -->
            <div>
                <label class="block text-gray-700 mb-1">Upload CV (PDF, maks 2MB)</label>
                <input type="file" name="cv" accept=".pdf" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100
                "/>
                <p class="text-xs text-gray-400 mt-1">* Format file PDF. Maksimal ukuran 2MB.</p>
            </div>
            <!-- Tombol Simpan -->
            <div class="flex justify-end">
                <button type="submit" class="bg-[#00646A] text-white px-6 py-2 rounded-full shadow hover:bg-teal-800 transition">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</body>
</html>
