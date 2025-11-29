<?php
session_start();
include '../header.php';

if (!isset($_SESSION['id_pelamar'])) {
    $_SESSION['id_pelamar'] = 1; 
}

$id_pelamar = $_SESSION['id_pelamar'];



$conn = mysqli_connect("localhost", "root", "", "lowongan_kerja");
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}


$where = "WHERE lam.id_pelamar = $id_pelamar";
if (!empty($_GET['status'])) {
    $status = mysqli_real_escape_string($conn, $_GET['status']);
    $where .= " AND lam.status_lamaran = '$status'";
}
$order = "ORDER BY lam.tanggal_lamar DESC";
if (!empty($_GET['sort']) && $_GET['sort'] == "lama") {
    $order = "ORDER BY lam.tanggal_lamar ASC";
}


$sql = "SELECT 
            lam.id_lamaran AS id_lamaran,
            l.id_lowongan AS id_lowongan,
            p.nama_perusahaan AS perusahaan,
            l.posisi AS posisi,
            lam.tanggal_lamar AS tanggal,
            lam.status_lamaran AS status
        FROM lamaran lam
        JOIN lowongan l ON lam.id_lowongan = l.id_lowongan
        JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan
        $where
        $order";

$result = mysqli_query($conn, $sql) or die(mysqli_error($conn));

$filtered = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $filtered[] = $row;
    }
}

// === baru: jika ada lamaran "di proses" baru (5 menit terakhir), buat notifikasi jika belum ada ===
if (!empty($id_pelamar)) {
    $q_new = "SELECT lam.id_lamaran, l.posisi, p.nama_perusahaan, lam.tanggal_lamar
              FROM lamaran lam
              JOIN lowongan l ON lam.id_lowongan = l.id_lowongan
              JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan
              WHERE lam.id_pelamar = ?
                AND lam.status_lamaran = 'di proses'
                AND lam.tanggal_lamar >= DATE_SUB(NOW(), INTERVAL 5 MINUTE)";
    if ($st_new = mysqli_prepare($conn, $q_new)) {
        mysqli_stmt_bind_param($st_new, "i", $id_pelamar);
        mysqli_stmt_execute($st_new);
        $res_new = mysqli_stmt_get_result($st_new);
        if ($res_new) {
            while ($rown = mysqli_fetch_assoc($res_new)) {
                $posisi = trim($rown['posisi'] ?? '');
                $perusahaan = trim($rown['nama_perusahaan'] ?? '');
                if ($posisi === '' && $perusahaan === '') continue;

                $pesan = "Lamaran Anda untuk posisi {$posisi} di {$perusahaan} sedang di proses.";

                // cek apakah notifikasi serupa sudah ada
                $q_check = "SELECT 1 FROM notifikasi_lamaran WHERE id_pelamar = ? AND pesan LIKE CONCAT('%', ?, '%', ?, '%') LIMIT 1";
                if ($st_check = mysqli_prepare($conn, $q_check)) {
                    mysqli_stmt_bind_param($st_check, "iss", $id_pelamar, $posisi, $perusahaan);
                    mysqli_stmt_execute($st_check);
                    $res_check = mysqli_stmt_get_result($st_check);
                    $exists = ($res_check && mysqli_num_rows($res_check) > 0);
                    mysqli_stmt_close($st_check);

                    if (!$exists) {
                        // insert notifikasi baru (is_read = 0)
                        $q_ins = "INSERT INTO notifikasi_lamaran (id_pelamar, pesan, is_read, created_at) VALUES (?, ?, 0, NOW())";
                        if ($st_ins = mysqli_prepare($conn, $q_ins)) {
                            mysqli_stmt_bind_param($st_ins, "is", $id_pelamar, $pesan);
                            mysqli_stmt_execute($st_ins);
                            mysqli_stmt_close($st_ins);
                        }
                    }
                }
            }
        }
        mysqli_stmt_close($st_new);
    }
}
// === end baru ===

// --- baru: ambil judul lowongan jika tersedia dan tanggal diterima/ditolak per lamaran ---

// Deteksi nama kolom judul pada tabel lowongan
$possible_title_cols = ['judul','judul_lowongan','title','nama_lowongan'];
$found_title_col = null;
foreach ($possible_title_cols as $c) {
    $c_esc = mysqli_real_escape_string($conn, $c);
    $rescol = mysqli_query($conn, "SHOW COLUMNS FROM `lowongan` LIKE '$c_esc'");
    if ($rescol && mysqli_num_rows($rescol) > 0) {
        $found_title_col = $c;
        break;
    }
}

// Deteksi nama kolom tanggal diterima/ditolak di tabel lamaran (DETEKSI SEKALI, di luar loop)
$possible_accept_cols = ['tanggal_diterima','tanggal_terima','diterima_pada','diterima_tanggal'];
$possible_reject_cols  = ['tanggal_ditolak','tanggal_tolak','ditolak_pada','ditolak_tanggal'];

$accept_col = null;
foreach ($possible_accept_cols as $c) {
    $c_esc = mysqli_real_escape_string($conn, $c);
    $r = mysqli_query($conn, "SHOW COLUMNS FROM `lamaran` LIKE '$c_esc'");
    if ($r && mysqli_num_rows($r) > 0) { $accept_col = $c; break; }
}
$reject_col = null;
foreach ($possible_reject_cols as $c) {
    $c_esc = mysqli_real_escape_string($conn, $c);
    $r = mysqli_query($conn, "SHOW COLUMNS FROM `lamaran` LIKE '$c_esc'");
    if ($r && mysqli_num_rows($r) > 0) { $reject_col = $c; break; }
}

// Siapkan cache data lowongan dan lamaran untuk menghindari query berulang
$lowongan_cache = []; // id_lowongan => judul
$lamaran_cache = [];  // id_lamaran => ['diterima'=>..., 'ditolak'=>...]

if (!empty($filtered)) {
    // kumpulkan unique id_lowongan dan id_lamaran
    $ids_low = [];
    $ids_lamaran = [];
    foreach ($filtered as $f) {
        if (!empty($f['id_lowongan'])) $ids_low[(int)$f['id_lowongan']] = true;
        if (!empty($f['id_lamaran'])) $ids_lamaran[(int)$f['id_lamaran']] = true;
    }

    // ambil judul untuk setiap lowongan bila kolom tersedia (bangun IN-clause aman dari integer)
    if ($found_title_col !== null && !empty($ids_low)) {
        $ids = array_keys($ids_low);
        $ids = array_map('intval', $ids);
        $in = implode(',', $ids);
        $q = "SELECT id_lowongan, `{$found_title_col}` AS judul FROM lowongan WHERE id_lowongan IN ($in)";
        $res = mysqli_query($conn, $q);
        if ($res) {
            while ($r = mysqli_fetch_assoc($res)) {
                $lowongan_cache[(int)$r['id_lowongan']] = $r['judul'];
            }
        }
    }

    // untuk setiap lamaran ambil tanggal diterima/ditolak berdasarkan kolom yang sudah dideteksi
    if (!empty($ids_lamaran) && ($accept_col || $reject_col)) {
        foreach (array_keys($ids_lamaran) as $idl) {
            $idl = (int)$idl;
            $lamaran_cache[$idl] = ['diterima' => null, 'ditolak' => null];
            $cols = [];
            if ($accept_col) $cols[] = "`$accept_col`";
            if ($reject_col) $cols[] = "`$reject_col`";
            $cols_sql = implode(',', $cols);
            $q2 = "SELECT $cols_sql FROM lamaran WHERE id_lamaran = $idl LIMIT 1";
            $res2 = mysqli_query($conn, $q2);
            if ($res2 && $d = mysqli_fetch_assoc($res2)) {
                if ($accept_col && isset($d[$accept_col]) && $d[$accept_col] !== null && $d[$accept_col] !== '') {
                    $lamaran_cache[$idl]['diterima'] = $d[$accept_col];
                }
                if ($reject_col && isset($d[$reject_col]) && $d[$reject_col] !== null && $d[$reject_col] !== '') {
                    $lamaran_cache[$idl]['ditolak'] = $d[$reject_col];
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Riwayat Lamaran</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    .primary { background-color: #00797a; }
    .primary-text { color: #00797a; }
    .primary-border { border-color: #00797a; }
  </style>
</head>
<body class="bg-gray-100 font-sans">

  <!-- Container Full Width dengan Padding -->
  <div class="w-full px-6 mt-10">
    <div class="flex items-center justify-between mb-6">
      <h1 class="text-3xl font-bold primary-text">📄 Riwayat Lamaran</h1>
      <div class="flex items-center gap-3">
        <button id="notif-btn" class="relative inline-flex items-center px-3 py-2 bg-white border rounded shadow hover:bg-gray-50" aria-label="Notifikasi">
          <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-700" viewBox="0 0 20 20" fill="currentColor"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6z" /></svg>
          <span id="notif-count" class="absolute -top-1 -right-1 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-white bg-red-600 rounded-full hidden">0</span>
        </button>
      </div>
    </div>
  <!-- Button Kembali -->
<div class="max-w-4xl mt-4 px-4 flex justify-start">
    <a href="../public/profil_pelamar.php"
        class="inline-flex items-center px-4 py-2 bg-gray-200 text-gray-700 rounded hover:bg-gray-300 transition mb-4">
        <i class="fas fa-arrow-left mr-2"></i> Kembali
    </a>
</div>

    <!-- Notifikasi panel placeholder (injected via JS) -->
    <div id="notif-panel" class="max-w-4xl mb-4 hidden"></div>


    <!-- Filter Form -->
    <form method="GET" class="flex flex-wrap gap-3 mb-6">
      <select name="status" class="px-4 py-2 border rounded-lg primary-border">

       <option value="di proses">Di Proses</option>
<option value="di terima">Di Terima</option>
<option value="di tolak">Di Tolak</option>

      </select>

      <select name="sort" class="px-4 py-2 border rounded-lg primary-border">
        <option value="baru" <?= (($_GET['sort'] ?? '')=="baru")?"selected":""; ?>>Terbaru</option>
        <option value="lama" <?= (($_GET['sort'] ?? '')=="lama")?"selected":""; ?>>Terlama</option>
      </select>

      <button type="submit" class="primary text-white px-4 py-2 rounded-lg hover:opacity-90">Filter</button>
    </form>

    <!-- Tabel Riwayat -->
    <div class="bg-white shadow-md rounded-lg overflow-hidden">
      <table class="w-full border-collapse">
        <thead class="primary text-white">
          <tr>
            <th class="py-3 px-4 text-left">Perusahaan</th>
            <th class="py-3 px-4 text-left">Posisi</th>
            <th class="py-3 px-4 text-left">Tanggal Lamar</th>
            <th class="py-3 px-4 text-left">Status</th>
            <th class="py-3 px-4 text-left">Diterima Pada</th>
            <th class="py-3 px-4 text-left">Ditolak Pada</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($filtered)): ?>
            <?php foreach($filtered as $r): 
                $id_lamaran = (int)($r['id_lamaran'] ?? 0);
                $id_lowongan = (int)($r['id_lowongan'] ?? 0);
                // judul: dari cache jika ada, kalau tidak pakai posisi
                $judul = isset($lowongan_cache[$id_lowongan]) ? $lowongan_cache[$id_lowongan] : ($r['posisi'] ?? '-');
                $diterima = isset($lamaran_cache[$id_lamaran]['diterima']) ? $lamaran_cache[$id_lamaran]['diterima'] : null;
                $ditolak  = isset($lamaran_cache[$id_lamaran]['ditolak']) ? $lamaran_cache[$id_lamaran]['ditolak'] : null;
            ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4"><?= htmlspecialchars($r["perusahaan"]); ?></td>
                <td class="py-3 px-4"><?= htmlspecialchars($judul); ?></td>
                <td class="py-3 px-4"><?= htmlspecialchars($r["tanggal"]); ?></td>
                <td class="py-3 px-4">
                  <?php if(isset($r["status"]) && $r["status"] == "di proses"): ?>
                    <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700"><?= ucfirst(htmlspecialchars($r["status"])); ?></span>
                  <?php elseif(isset($r["status"]) && $r["status"] == "di terima"): ?>
                    <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700"><?= ucfirst(htmlspecialchars($r["status"])); ?></span>
                  <?php elseif(isset($r["status"]) && $r["status"] == "di tolak"): ?>
                    <span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-700"><?= ucfirst(htmlspecialchars($r["status"])); ?></span>
                  <?php endif; ?>
                </td>
                <td class="py-3 px-4"><?= $diterima ? htmlspecialchars($diterima) : '-' ?></td>
                <td class="py-3 px-4"><?= $ditolak ? htmlspecialchars($ditolak) : '-' ?></td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="6" class="text-center py-4 text-gray-500">Tidak ada riwayat ditemukan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>

<!-- Notification JS: load count and panel -->
<script>
document.addEventListener('DOMContentLoaded', function() {
    const btn = document.getElementById('notif-btn');
    const panel = document.getElementById('notif-panel');
    const countEl = document.getElementById('notif-count');

    function loadCount() {
        fetch('notifikasi.php?count=1')
          .then(resp => resp.json())
          .then(data => {
            const c = (data && data.count) ? data.count : 0;
            if (c > 0) {
              countEl.textContent = c;
              countEl.classList.remove('hidden');
            } else {
              countEl.classList.add('hidden');
            }
          })
          .catch(err => console.error('Notif count error', err));
    }

    function attachDeleteHandlers() {
        const delBtns = panel.querySelectorAll('.notif-delete-btn');
        delBtns.forEach(btn => {
            btn.removeEventListener('click', handleDelete); // ensure no duplicate
            btn.addEventListener('click', handleDelete);
        });
    }

    function handleDelete(e) {
        const id = e.currentTarget.dataset.id;
        if (!id) return;
        if (!confirm('Hapus notifikasi ini?')) return;
        const fd = new FormData();
        fd.append('id_notifikasi', id);
        fetch('hapus_notifikasi.php', { method: 'POST', body: fd })
            .then(r => r.json())
            .then(json => {
                if (json && json.success) {
                    // reload panel and count
                    loadPanel();
                    loadCount();
                } else {
                    alert('Gagal menghapus notifikasi');
                    console.error(json);
                }
            })
            .catch(err => {
                console.error('Delete error', err);
                alert('Terjadi kesalahan saat menghapus.');
            });
    }

    function loadPanel() {
        fetch('notifikasi.php')
            .then(r => r.text())
            .then(html => {
                panel.innerHTML = html;
                // isi panel langsung ditampilkan; pasang handler hapus jika ada tombol
                attachDeleteHandlers();
                panel.classList.remove('hidden');
                // hide badge
                countEl.classList.add('hidden');
                countEl.textContent = '0';
            })
            .catch(err => console.error('Notif load error', err));
    }

    // initial load
    loadCount();

    // Toggle panel
    btn.addEventListener('click', function() {
        if (!panel.classList.contains('hidden')) {
            panel.classList.add('hidden');
            return;
        }
        loadPanel();
    });
});
</script>

</body>
</html>
