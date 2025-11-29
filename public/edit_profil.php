<?php
session_start();
require_once '../function/logic.php';

$id_user = $_SESSION['user']['id'];
// Ambil data profil user dari database
$pelamar = getProfilPelamarByUserId($id_user);
$required_predefined = [
    'HTML','CSS','JavaScript','PHP','MySQL',
    'SQL','Linux','Docker','API','Bootstrap',
    'Communication','Problem Solving','Project Management','Data Analysis','AWS'
];
$additional_predefined = [
    'React','Node.js','UI/UX','Python'
];

$userSkills = [];
if (!empty($pelamar['keahlian'])) {
    $k = $pelamar['keahlian'];
    if (is_array($k)) {
        $userSkills = $k;
    } else {
        $decoded = json_decode($k, true);
        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            $userSkills = $decoded;
        } else {
            // fallback: comma separated
            $userSkills = array_filter(array_map('trim', explode(',', $k)));
        }
    }
}

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
        // VALIDASI: batas maksimal keahlian
        $max_required = 5;
        $max_additional = 3;

        // ambil nilai sementara untuk validasi (bisa berupa array atau single)
        $w_tmp = $data_update['keahlian_wajib'] ?? [];
        $t_tmp = $data_update['keahlian_tambahan'] ?? [];
        if (!is_array($w_tmp)) $w_tmp = [$w_tmp];
        if (!is_array($t_tmp)) $t_tmp = [$t_tmp];
        $w_tmp = array_values(array_filter(array_map('trim', $w_tmp)));
        $t_tmp = array_values(array_filter(array_map('trim', $t_tmp)));

        if (count($w_tmp) > $max_required) {
            echo "<script>alert('Keahlian wajib maksimal {$max_required}. Silakan hapus beberapa.');</script>";
            // batalkan update dengan mengosongkan $data_update agar tidak diproses
            $data_update = [];
        } elseif (count($t_tmp) > $max_additional) {
            echo "<script>alert('Keahlian tambahan maksimal {$max_additional}. Silakan hapus beberapa.');</script>";
            $data_update = [];
        } else {
            // Gabungkan keahlian wajib + tambahan menjadi satu key 'keahlian' yang akan disimpan
            if (isset($data_update['keahlian_wajib']) || isset($data_update['keahlian_tambahan'])) {
                $w = $data_update['keahlian_wajib'] ?? [];
                $t = $data_update['keahlian_tambahan'] ?? [];
                if (!is_array($w)) $w = [$w];
                if (!is_array($t)) $t = [$t];
                $combined = array_values(array_filter(array_map('trim', array_merge($w, $t))));
                if (!empty($combined)) {
                    $data_update['keahlian'] = $combined;
                }
                unset($data_update['keahlian_wajib'], $data_update['keahlian_tambahan']);
            }
        }

        if (!empty($data_update) && updateProfilPelamar($id_user, $data_update, $files_update) > 0) {
            echo "<script>
                    alert('Berhasil edit profil');
                    document.location.href = 'profil_pelamar.php';
                  </script>";
        } elseif (!empty($data_update)) {
            echo "<script>
                    alert('Gagal edit profil');
                  </script>";
        } else {
            // jika $data_update dikosongkan karena validasi gagal, jangan lakukan update
            // (alert sudah ditampilkan di atas)
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
            <!-- Keahlian (diperbarui: wajib & tambahan, support custom input) -->
            <div>
                <label class="block text-gray-700 mb-1">Keahlian</label>

                <div class="mb-3">
                    <div class="font-semibold text-sm text-gray-600 mb-1">Keahlian Wajib</div>
                    <div class="grid grid-cols-2 gap-2" id="required-skills">
                        <?php foreach ($required_predefined as $skill): ?>
                        <label class="inline-flex items-center">
                            <input type="checkbox" name="keahlian_wajib[]"
                                value="<?php echo htmlspecialchars($skill) ?>" class="form-checkbox text-[#00646A]"
                                <?php echo in_array($skill, $userSkills) ? 'checked' : '' ?>>
                            <span class="ml-2"><?php echo htmlspecialchars($skill) ?></span>
                        </label>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="mb-2">
                    <div class="font-semibold text-sm text-gray-600 mb-1">Keahlian Tambahan</div>

                    <!-- Tambah keahlian custom (masuk ke 'keahlian_tambahan') -->
                    <div class="mt-3">
                        <label class="block text-gray-700 mb-1">Tambahkan Keahlian Lain</label>
                        <div class="flex gap-2">
                            <input id="keahlian-input" type="text"
                                class="flex-1 border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#00646A]"
                                placeholder="Ketik keahlian lalu tekan Tambah (mis. React, Node.js)" />
                            <button type="button" id="add-keahlian"
                                class="bg-blue-600 text-white px-4 py-2 rounded-full hover:bg-blue-700 transition">Tambah</button>
                        </div>

                        <!-- pastikan container custom tambahan juga menempati bar sendiri -->
                        <div id="custom-keahlian-list" class="flex flex-wrap gap-2 mt-3 w-full">
                            <?php
                            // render keahlian user yang bukan bagian predefined sebagai pill + hidden input (masuk tambahan)
                            foreach ($userSkills as $s):
                                if (trim($s) === '') continue;
                                if (in_array($s, $required_predefined)) continue;
                                if (in_array($s, $additional_predefined)) continue;
                            ?>
                            <span class="flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full text-sm"
                                data-group="additional">
                                <span><?php echo htmlspecialchars($s) ?></span>
                                <button type="button" class="remove-custom-keahlian text-red-500"
                                    data-value="<?php echo htmlspecialchars($s) ?>">×</button>
                                <input type="hidden" name="keahlian_tambahan[]"
                                    value="<?php echo htmlspecialchars($s) ?>">
                            </span>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <p class="text-xs text-gray-400 mt-1">* Pilih keahlian wajib dan keahlian tambahan jika anda ingin.</p>
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

    // Keahlian custom: tambah / hapus untuk kedua grup (wajib & tambahan) + batas maksimal
    (function() {
        const MAX_REQUIRED = 5;
        const MAX_ADDITIONAL = 3;

        const cfg = [
            // groupId, inputId, addBtnId, listId, hiddenInputName, groupName
            {
                input: 'keahlian-input-required',
                addBtn: 'add-keahlian-required',
                list: 'custom-keahlian-list-required',
                hiddenName: 'keahlian_wajib[]',
                group: 'required'
            },
            {
                input: 'keahlian-input',
                addBtn: 'add-keahlian',
                list: 'custom-keahlian-list',
                hiddenName: 'keahlian_tambahan[]',
                group: 'additional'
            }
        ];

        function normalize(s) {
            return s.trim();
        }

        function getGroupCount(listId, checkboxName) {
            let cnt = 0;
            const lst = document.getElementById(listId);
            if (lst) {
                cnt += lst.querySelectorAll('input[type="hidden"]').length;
            }
            const boxes = document.querySelectorAll('input[type="checkbox"][name="' + checkboxName + '"]');
            boxes.forEach(b => {
                if (b.checked) cnt++;
            });
            return cnt;
        }

        function existsValueInDOM(val) {
            if (!val) return false;
            val = normalize(val).toLowerCase();
            // cek hidden inputs di kedua list (di dalam masing-masing container)
            for (const c of cfg) {
                const lst = document.getElementById(c.list);
                if (!lst) continue;
                const hidden = lst.querySelectorAll('input[type="hidden"]');
                for (const h of hidden)
                    if (h.value.trim().toLowerCase() === val) return true;
            }
            // cek kedua grup checkbox
            const checkboxesW = document.querySelectorAll('input[type="checkbox"][name="keahlian_wajib[]"]');
            for (const c of checkboxesW)
                if (c.value.trim().toLowerCase() === val && c.checked) return true;
            const checkboxesT = document.querySelectorAll('input[type="checkbox"][name="keahlian_tambahan[]"]');
            for (const c of checkboxesT)
                if (c.value.trim().toLowerCase() === val && c.checked) return true;
            return false;
        }

        function createPill(value, hiddenName, group) {
            const span = document.createElement('span');
            span.className = 'flex items-center gap-2 bg-gray-100 px-3 py-1 rounded-full text-sm';
            span.dataset.group = group; // tandai grup supaya tidak tercampur
            const text = document.createElement('span');
            text.textContent = value;
            const btn = document.createElement('button');
            btn.type = 'button';
            btn.className = 'remove-custom-keahlian text-red-500';
            btn.dataset.value = value;
            btn.textContent = '×';
            const hidden = document.createElement('input');
            hidden.type = 'hidden';
            hidden.name = hiddenName;
            hidden.value = value;
            span.appendChild(text);
            span.appendChild(btn);
            span.appendChild(hidden);
            return span;
        }

        cfg.forEach(function(c) {
            const input = document.getElementById(c.input);
            const addBtn = document.getElementById(c.addBtn);
            const list = document.getElementById(c.list);
            if (!addBtn || !input || !list) return;

            const max = c.hiddenName === 'keahlian_wajib[]' ? MAX_REQUIRED : MAX_ADDITIONAL;
            const groupLabel = c.hiddenName === 'keahlian_wajib[]' ? 'Keahlian Wajib' : 'Keahlian Tambahan';

            addBtn.addEventListener('click', function() {
                const v = input.value.trim();
                if (!v) return;
                // cek batas sebelum menambah pill
                const current = getGroupCount(c.list, c.hiddenName);
                if (current >= max) {
                    alert('Maksimal ' + max + ' ' + groupLabel + '.');
                    return;
                }
                if (existsValueInDOM(v)) {
                    alert('Keahlian "' + v + '" sudah ada atau sudah dipilih.');
                    input.value = '';
                    return;
                }
                const pill = createPill(v, c.hiddenName, c.group);
                list.appendChild(
                    pill); // append ke list grup yang sesuai — tetap berada di bawah bar grup itu
                input.value = '';
            });
        });

        // cek/ceklist handlers (tetap menegakkan limit)
        document.querySelectorAll('input[type="checkbox"][name="keahlian_wajib[]"]').forEach(cb => {
            cb.addEventListener('change', function(e) {
                if (!cb.checked) return;
                const cnt = getGroupCount('custom-keahlian-list-required', 'keahlian_wajib[]');
                if (cnt > MAX_REQUIRED) {
                    // seharusnya tidak terjadi karena kita periksa sebelum submit, tetapi jaga-jaga:
                    cb.checked = false;
                    alert('Keahlian wajib maksimal ' + MAX_REQUIRED);
                } else {
                    // hitung total setelah centang
                    let total = cnt; // cnt already includes checked checkboxes in getGroupCount
                    // Note: getGroupCount counts checkboxes including this one (because it's checked).
                    if (total > MAX_REQUIRED) {
                        cb.checked = false;
                        alert('Keahlian wajib maksimal ' + MAX_REQUIRED);
                    }
                }
            });
        });

        document.querySelectorAll('input[type="checkbox"][name="keahlian_tambahan[]"]').forEach(cb => {
            cb.addEventListener('change', function(e) {
                if (!cb.checked) return;
                const cnt = getGroupCount('custom-keahlian-list', 'keahlian_tambahan[]');
                if (cnt > MAX_ADDITIONAL) {
                    cb.checked = false;
                    alert('Maksimal ' + MAX_ADDITIONAL + ' Keahlian Tambahan.');
                } else {
                    let total = cnt;
                    if (total > MAX_ADDITIONAL) {
                        cb.checked = false;
                        alert('Maksimal ' + MAX_ADDITIONAL + ' Keahlian Tambahan.');
                    }
                }
            });
        });

        // delegate remove untuk semua pill (counts otomatis berubah karena DOM)
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