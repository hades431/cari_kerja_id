<?php
session_start();
require_once '../function/logic.php';

$id_user = $_SESSION['user']['id'];
// Ambil data profil user dari database
$pelamar = getProfilPelamarByUserId($id_user);

// Insert data pelamar jika belum ada
if (!$pelamar) {
    // Minimal insert id_user, field lain bisa NULL/default
    $conn = mysqli_connect("localhost","root","","lowongan_kerja");
    $stmt = $conn->prepare("INSERT INTO pelamar_kerja (id_user) VALUES (?)");
    $stmt->bind_param("i", $id_user);
    $stmt->execute();
    $stmt->close();
    // Ambil ulang data pelamar
    $pelamar = getProfilPelamarByUserId($id_user);
}

if (isset($_POST['submit'])) {
    // Filter hanya field yang diisi/diedit
    $data_update = [];
    foreach ($_POST as $key => $value) {
        if ($key === 'submit') continue;
        // Untuk array (misal pengalaman, keahlian), cek jika ada isian
        if (is_array($value)) {
            $filtered = array_filter($value, function($v) {
                return trim($v) !== '';
            });
            if (!empty($filtered)) {
                $data_update[$key] = $filtered;
            }
        } else {
            if (trim($value) !== '') {
                $data_update[$key] = $value;
            }
        }
    }
    // Cek file upload
    $files_update = [];
    foreach ($_FILES as $key => $file) {
        if (isset($file['name']) && $file['name'] !== '') {
            $files_update[$key] = $file;
        }
    }
    // Tetap lakukan update walaupun hanya satu field yang diisi
    if (!empty($data_update) || !empty($files_update)) {
        if (updateProfilPelamar($id_user, $data_update, $files_update) > 0) {
            echo "<script>
                    alert('Berhasil edit profil');
                    document.location.href = 'profil_pelamar.php';
                  </script>";
        } else {
            echo "<script>
                    alert('Gagal edit profil');
                  </script>";
        }
    } else {
        echo "<script>
                alert('Tidak ada perubahan yang disimpan');
              </script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Edit Profil - CariKerja.id</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#00646A] min-h-screen">
    <!-- Notifikasi Logout Modal -->
    <div id="logout-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-lg p-8 max-w-md w-full text-center relative">
            <button onclick="closeLogoutModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            <h2 class="text-2xl font-bold text-[#00646A] mb-2">Konfirmasi Logout</h2>
            <p class="text-gray-500 mb-6">Apakah Anda yakin ingin logout?</p>
            <div class="flex justify-center gap-4">
                <button onclick="closeLogoutModal()"
                    class="border border-gray-400 px-6 py-2 rounded text-gray-700 hover:bg-gray-100 font-semibold">Batal</button>
                <button onclick="window.location.href='../public/logout.php'"
                    class="border border-red-600 text-red-700 px-6 py-2 rounded hover:bg-red-50 font-semibold">Logout</button>
            </div>
        </div>
    </div>
    <div class="max-w-2xl mx-auto mt-12 bg-white rounded-xl shadow-lg p-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-6 text-center">Edit Profil</h2>
        <form action="#" method="post" enctype="multipart/form-data" class="space-y-5">
            <!-- Foto Profil -->
            <div class="flex flex-col items-center">
                <img src="<?= isset($pelamar['foto']) && $pelamar['foto'] ? '../' . htmlspecialchars($pelamar['foto']) : 'https://ui-avatars.com/api/?name=' . urlencode($pelamar['nama_lengkap'] ?? 'Nama Pelamar') . '&background=2563eb&color=fff&size=128' ?>"
                    class="w-24 h-24 rounded-full border-2 border-gray-200 object-cover mb-2" alt="Foto Profil">
                <label class="block">
                    <span class="sr-only">Pilih Foto Profil</span>
                    <input type="file" name="foto" class="block w-full text-sm text-gray-500
                        file:mr-4 file:py-2 file:px-4
                        file:rounded-full file:border-0
                        file:text-sm file:font-semibold
                        file:bg-blue-50 file:text-blue-700
                        hover:file:bg-blue-100
                    " />
                </label>
            </div>
            <!-- Nama -->
            <div>
                <label for="nama_lengkap" class="block text-gray-700 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($pelamar['nama_lengkap'] ?? '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]"
                    placeholder="Nama Lengkap">
            </div>
            <!-- Email -->
            <div>
                <label for="email" class="block text-gray-700 mb-1">Email</label>
                <input type="email" name="email" value="<?= htmlspecialchars($pelamar['email'] ?? '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]"
                    placeholder="Email">
            </div>
            <!-- Telepon -->
            <div>
                <label for="telepon" class="block text-gray-700 mb-1">Telepon</label>
                <input type="text" name="telepon" value="<?= htmlspecialchars($pelamar['no_hp'] ?? '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]"
                    placeholder="Nomor Telepon">
            </div>
            <!-- Jabatan -->
            <div>
                <label for="jabatan" class="block text-gray-700 mb-1">Kemampuan Bidang</label>
                <input type="text" name="jabatan" value="<?= htmlspecialchars($pelamar['jabatan'] ?? '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]"
                    placeholder="Contoh: UI/UX Designer">
            </div>
            <!-- Lokasi -->
            <div>
                <label for="alamat" class="block text-gray-700 mb-1">Alamat</label>
                <input type="text" name="alamat" value="<?= htmlspecialchars($pelamar['alamat'] ?? '') ?>"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]"
                    placeholder="Contoh: Bandung, Indonesia">
            </div>
            <!-- Deskripsi Profil -->
            <div>
                <label for="deskripsi" class="block text-gray-700 mb-1">Deskripsi Profil</label>
                <textarea name="deskripsi" rows="4"
                    class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]"
                    placeholder="Ceritakan tentang diri Anda..."><?= htmlspecialchars($pelamar['deskripsi'] ?? '') ?></textarea>
            </div>
            <!-- Pengalaman Kerja -->
            <div>
                <label class="block text-gray-700 mb-1">Pengalaman Kerja</label>
                <div id="pengalaman-list" class="space-y-3 max-w-full">
                    <?php
                    $pengalaman_jabatan = $pelamar['pengalaman'] ? json_decode($pelamar['pengalaman'], true)['jabatan'] ?? [] : [];
                    $pengalaman_perusahaan = $pelamar['pengalaman'] ? json_decode($pelamar['pengalaman'], true)['perusahaan'] ?? [] : [];
                    $pengalaman_tahun = $pelamar['pengalaman'] ? json_decode($pelamar['pengalaman'], true)['tahun'] ?? [] : [];
                    $count_pengalaman = max(count($pengalaman_jabatan), count($pengalaman_perusahaan), count($pengalaman_tahun));
                    if ($count_pengalaman < 1) $count_pengalaman = 1;
                    for ($i = 0; $i < $count_pengalaman; $i++):
                    ?>
                    <div class="flex flex-col md:flex-row gap-2 pengalaman-row items-center">
                        <input type="text" name="pengalaman_jabatan[]"
                            class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]"
                            placeholder="Jabatan/Posisi" value="<?= htmlspecialchars($pengalaman_jabatan[$i] ?? '') ?>">
                        <input type="text" name="pengalaman_perusahaan[]"
                            class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]"
                            placeholder="Perusahaan" value="<?= htmlspecialchars($pengalaman_perusahaan[$i] ?? '') ?>">
                        <input type="text" name="pengalaman_tahun[]"
                            class="md:w-40 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]"
                            placeholder="Tahun" value="<?= htmlspecialchars($pengalaman_tahun[$i] ?? '') ?>">
                        <button type="button" class="remove-pengalaman px-2 ml-2"
                            style="display:<?= $i === 0 ? 'none' : 'inline-block' ?>;">
                            <i class="fas fa-trash text-red-500 text-lg"></i>
                        </button>
                    </div>
                    <?php endfor; ?>
                </div>
                <button type="button" id="tambah-pengalaman"
                    class="mt-2 bg-blue-100 text-blue-700 px-4 py-1 rounded-full text-sm hover:bg-blue-200 transition">+
                    Tambah Pengalaman</button>
                <p class="text-xs text-gray-400 mt-1">* Tambahkan lebih banyak pengalaman dengan klik tombol di atas.
                </p>
            </div>
            <!-- Keahlian (diperbarui: support custom input) -->
            <div>
                <label class="block text-gray-700 mb-1">Keahlian</label>

                <div class="grid grid-cols-2 gap-2" id="predefined-skills">
                    <?php foreach ($predefined as $skill): ?>
                    <label class="inline-flex items-center">
                        <input type="checkbox" name="keahlian[]" value="<?php echo htmlspecialchars($skill) ?>"
                            class="form-checkbox text-[#00646A]"
                            <?php echo in_array($skill, $userSkills) ? 'checked' : '' ?>>
                        <span class="ml-2"><?php echo htmlspecialchars($skill) ?></span>
                    </label>
                    <?php endforeach; ?>
                </div>

                <!-- Tambah keahlian custom -->
                <div class="mt-3">
                    <label class="block text-gray-700 mb-1">Tambahkan Keahlian Lain</label>
                    <div class="flex gap-2">
                        <input id="keahlian-input" type="text"
                            class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]"
                            placeholder="Ketik keahlian lalu tekan Tambah (mis. React, Node.js)" />
                        <button type="button" id="add-keahlian"
                            class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition">Tambah</button>
                    </div>

                    <div id="custom-keahlian-list" class="flex flex-wrap gap-2 mt-3">
                        <?php
                        // render keahlian user yang bukan bagian predefined sebagai pill + hidden input
                        foreach ($userSkills as $s):
                            if (trim($s) === '') continue;
                            if (in_array($s, $predefined)) continue;
                        ?>
                        <span class="flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full text-sm">
                            <span><?php echo htmlspecialchars($s) ?></span>
                            <button type="button" class="remove-custom-keahlian text-red-500"
                                data-value="<?php echo htmlspecialchars($s) ?>">×</button>
                            <input type="hidden" name="keahlian[]" value="<?php echo htmlspecialchars($s) ?>">
                        </span>
                        <?php endforeach; ?>
                    </div>
                </div>

                <p class="text-xs text-gray-400 mt-1">* Pilih atau tambahkan keahlian yang kamu miliki.</p>
            </div>
            <!-- Upload CV -->
            <div>
                <label for="cv" class="block text-gray-700 mb-1">Upload CV (PDF, maks 2MB)</label>
                <input type="file" name="cv" accept=".pdf" class="block w-full text-sm text-gray-500
                    file:mr-4 file:py-2 file:px-4
                    file:rounded-full file:border-0
                    file:text-sm file:font-semibold
                    file:bg-blue-50 file:text-blue-700
                    hover:file:bg-blue-100
                " />
                <p class="text-xs text-gray-400 mt-1">* Format file PDF. Maksimal ukuran 2MB.</p>
            </div>
            <!-- Tombol Simpan dan Kembali -->
            <div class="flex justify-end gap-2">
                <a href="profil_pelamar.php"
                    class="bg-gray-300 text-gray-700 px-6 py-2 rounded-full shadow hover:bg-gray-400 transition">Kembali</a>
                <button type="submit" name="submit"
                    class="bg-[#00646A] text-white px-6 py-2 rounded-full shadow hover:bg-teal-800 transition">Simpan
                    Perubahan</button>
            </div>
        </form>
    </div>
    <!-- Font Awesome CDN for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <script>
    document.getElementById('tambah-pengalaman').addEventListener('click', function() {
        var pengalamanList = document.getElementById('pengalaman-list');
        var row = document.createElement('div');
        row.className = "flex flex-col md:flex-row gap-2 pengalaman-row items-center";
        row.innerHTML = `
            <input type="text" name="pengalaman_jabatan[]" class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Jabatan/Posisi">
            <input type="text" name="pengalaman_perusahaan[]" class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Perusahaan">
            <input type="text" name="pengalaman_tahun[]" class="md:w-40 w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]" placeholder="Tahun">
            <button type="button" class="remove-pengalaman px-2 ml-2">
                <i class="fas fa-trash text-red-500 text-lg"></i>
            </button>
        `;
        pengalamanList.appendChild(row);
    });

    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-pengalaman') || e.target.classList.contains('fa-trash')) {
            // Support click on button or icon
            const btn = e.target.classList.contains('remove-pengalaman') ? e.target : e.target.closest(
                '.remove-pengalaman');
            if (btn) btn.parentElement.remove();
        }
    });

    function openLogoutModal() {
        document.getElementById('logout-modal').classList.remove('hidden');
    }

    function closeLogoutModal() {
        document.getElementById('logout-modal').classList.add('hidden');
    }

    // Keahlian custom: tambah / hapus
    (function() {
        const input = document.getElementById('keahlian-input');
        const addBtn = document.getElementById('add-keahlian');
        const list = document.getElementById('custom-keahlian-list');

        function normalize(s) {
            return s.trim();
        }

        function existsValue(val) {
            if (!val) return false;
            val = normalize(val).toLowerCase();
            // cek hidden inputs nama keahlian[] dan juga predefined checkboxes
            const hidden = list.querySelectorAll('input[type="hidden"][name="keahlian[]"]');
            for (const h of hidden)
                if (h.value.trim().toLowerCase() === val) return true;
            const checkboxes = document.querySelectorAll('input[type="checkbox"][name="keahlian[]"]');
            for (const c of checkboxes)
                if (c.value.trim().toLowerCase() === val && c.checked) return true;
            return false;
        }

        function createPill(value) {
            const span = document.createElement('span');
            span.className = 'flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full text-sm';
            const text = document.createElement('span');
            text.textContent = value;
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'remove-custom-keahlian text-red-500';
            btn.dataset.value = value;
            btn.textContent = '×';
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = 'keahlian[]';
            hidden.value = value;
            span.appendChild(text);
            span.appendChild(btn);
            span.appendChild(hidden);
            return span;
        }

        addBtn && addBtn.addEventListener('click', function() {
            const v = input.value.trim();
            if (!v) return;
            if (existsValue(v)) {
                alert('Keahlian "' + v + '" sudah ada atau sudah dipilih.');
                input.value = '';
                return;
            }
            const pill = createPill(v);
            list.appendChild(pill);
            input.value = '';
        });

        // delegate remove
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-custom-keahlian')) {
                const btn = e.target;
                const pill = btn.closest('span');
                if (pill) pill.remove();
            }
        });
    })();
    </script>
</body>

</html>
</body>

</html>