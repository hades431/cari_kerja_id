<?php
session_start();
include '../../function/logic.php';
$menuAktif = menu_aktif('transaksi');

$notif = '';
$alertClass = '';

// Ambil id perusahaan dari GET jika ada
$id_perusahaan = isset($_GET['id']) ? intval($_GET['id']) : null;

// ambil data perusahaan jika id disediakan
$perusahaan = null;
if ($id_perusahaan) {
    $stmt = $conn->prepare("SELECT * FROM perusahaan WHERE id_perusahaan = ? LIMIT 1");
    $stmt->bind_param('i', $id_perusahaan);
    $stmt->execute();
    $res = $stmt->get_result();
    $perusahaan = $res->fetch_assoc();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $paket = $_POST['paket'] ?? '';
    $metode = $_POST['metode_pembayaran'] ?? '';
    $id_post = isset($_POST['id']) ? intval($_POST['id']) : 0;

    // validasi sederhana
    if (empty($paket) || empty($metode) || !$id_post) {
        $notif = 'Pilih paket, metode pembayaran, dan perusahaan terlebih dahulu.';
        $alertClass = 'bg-red-100 text-red-700';
    } else {
        // proses upload bukti
        if (isset($_FILES['bukti_pembayaran']) && $_FILES['bukti_pembayaran']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../../uploads/bukti/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);

            $originalName = basename($_FILES['bukti_pembayaran']['name']);
            $ext = pathinfo($originalName, PATHINFO_EXTENSION);
            $fileName = uniqid('bukti_') . '.' . $ext;
            $targetPath = $uploadDir . $fileName;

            if (move_uploaded_file($_FILES['bukti_pembayaran']['tmp_name'], $targetPath)) {
                $buktiPath = 'uploads/bukti/' . $fileName; // simpan relatif ke root project

                // hitung durasi paket
                $durasiMap = [
                    'bronze' => 15,
                    'silver' => 30,
                    'gold' => 45,
                    'diamond' => 60
                ];
                $days = $durasiMap[$paket] ?? 0;

                // jika perusahaan ada, coba update kolom paket/expired_at jika ada
                $updated = false;
                $newExpiry = null;
                // cek apakah kolom expired_at ada
                $colCheck = mysqli_query($conn, "SHOW COLUMNS FROM perusahaan LIKE 'expired_at'");
                $hasExpiredAt = $colCheck && mysqli_num_rows($colCheck) > 0;

                if ($hasExpiredAt) {
                    // ambil nilai expired saat ini jika ada
                    $stmt2 = $conn->prepare("SELECT expired_at FROM perusahaan WHERE id_perusahaan = ? LIMIT 1");
                    $stmt2->bind_param('i', $id_post);
                    $stmt2->execute();
                    $r2 = $stmt2->get_result()->fetch_assoc();
                    $now = new DateTime();
                    $currentExpiry = !empty($r2['expired_at']) ? new DateTime($r2['expired_at']) : null;

                    if ($currentExpiry && $currentExpiry > $now) {
                        $base = $currentExpiry;
                    } else {
                        $base = $now;
                    }
                    $base->modify("+$days days");
                    $newExpiry = $base->format('Y-m-d H:i:s');

                    // update paket dan expired_at jika kolom paket ada
                    $colPaketCheck = mysqli_query($conn, "SHOW COLUMNS FROM perusahaan LIKE 'paket'");
                    $hasPaket = $colPaketCheck && mysqli_num_rows($colPaketCheck) > 0;

                    if ($hasPaket) {
                        $stmtUpd = $conn->prepare("UPDATE perusahaan SET paket = ?, expired_at = ? WHERE id_perusahaan = ?");
                        $stmtUpd->bind_param('ssi', $paket, $newExpiry, $id_post);
                    } else {
                        // hanya update expired_at
                        $stmtUpd = $conn->prepare("UPDATE perusahaan SET expired_at = ? WHERE id_perusahaan = ?");
                        $stmtUpd->bind_param('si', $newExpiry, $id_post);
                    }

                    if ($stmtUpd->execute()) {
                        $updated = true;
                    }
                }

                // simpan transaksi jika tabel transaksi tersedia
                $tableCheck = mysqli_query($conn, "SHOW TABLES LIKE 'transaksi'");
                if ($tableCheck && mysqli_num_rows($tableCheck) > 0) {
                    // mencoba menyisipkan data transaksi dengan kolom umum
                    $created_at = date('Y-m-d H:i:s');
                    $status = 'pending';
                    // periksa kolom apa yang tersedia di tabel transaksi
                    $colsRes = mysqli_query($conn, "SHOW COLUMNS FROM transaksi");
                    $cols = [];
                    while ($c = mysqli_fetch_assoc($colsRes)) $cols[] = $c['Field'];

                    $insertCols = [];
                    $insertVals = [];
                    $types = '';
                    $params = [];

                    if (in_array('id_perusahaan', $cols)) { $insertCols[] = 'id_perusahaan'; $insertVals[] = '?'; $types .= 'i'; $params[] = $id_post; }
                    if (in_array('paket', $cols)) { $insertCols[] = 'paket'; $insertVals[] = '?'; $types .= 's'; $params[] = $paket; }
                    if (in_array('metode_pembayaran', $cols)) { $insertCols[] = 'metode_pembayaran'; $insertVals[] = '?'; $types .= 's'; $params[] = $metode; }
                    if (in_array('bukti_pembayaran', $cols)) { $insertCols[] = 'bukti_pembayaran'; $insertVals[] = '?'; $types .= 's'; $params[] = $buktiPath; }
                    if (in_array('created_at', $cols)) { $insertCols[] = 'created_at'; $insertVals[] = '?'; $types .= 's'; $params[] = $created_at; }
                    if (in_array('status', $cols)) { $insertCols[] = 'status'; $insertVals[] = '?'; $types .= 's'; $params[] = $status; }

                    if (!empty($insertCols)) {
                        $sqlIns = "INSERT INTO transaksi (".implode(',', $insertCols).") VALUES (".implode(',', $insertVals).")";
                        $stmtIns = $conn->prepare($sqlIns);
                        if ($stmtIns) {
                            $stmtIns->bind_param($types, ...$params);
                            $stmtIns->execute();
                        }
                    }
                }

                // notifikasi sukses
                $notif = 'Permintaan perpanjangan berhasil diajukan.' . ($updated ? ' Masa aktif diperbarui.' : '');
                $alertClass = 'bg-green-100 text-green-700';

            } else {
                $notif = 'Gagal mengunggah bukti pembayaran.';
                $alertClass = 'bg-red-100 text-red-700';
            }
        } else {
            $notif = 'Bukti pembayaran belum diunggah atau terjadi kesalahan upload.';
            $alertClass = 'bg-red-100 text-red-700';
        }
    }
}

// Jika tidak ada id perusahaan di URL, ambil daftar perusahaan yang sudah expired untuk ditampilkan
$expiredCompanies = [];
$colCheck = mysqli_query($conn, "SHOW COLUMNS FROM perusahaan LIKE 'expired_at'");
if ($colCheck && mysqli_num_rows($colCheck) > 0) {
    $resExp = mysqli_query($conn, "SELECT id_perusahaan, nama_perusahaan, expired_at FROM perusahaan WHERE expired_at IS NOT NULL AND expired_at <= NOW() ORDER BY expired_at ASC");
    if ($resExp) {
        while ($r = mysqli_fetch_assoc($resExp)) {
            $expiredCompanies[] = $r;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Perpanjang Paket</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#222] min-h-screen">
  <div class="flex min-h-screen">
    <aside class="bg-gradient-to-b from-teal-700 to-teal-900 w-64 flex flex-col shadow-xl fixed inset-y-0 left-0">
      <div class="px-4 py-6 flex flex-col items-center gap-2">
        <img src="../../img/carikerja.png" alt="Logo" class="w-40 object-contain" />
      </div>
      <nav class="flex-1 flex flex-col gap-1 px-2 mt-4">
        <a href="../dashboard/dashboard.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['dashboard'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2"viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round">
            <path d="M4 21V10" />
            <path d="M9 21V3" />
            <path d="M15 21v-6" />
            <path d="M20 21v-4" />
          </svg>
          <span>Dashboard</span>
        </a>

        <a href="../pelamar/pelamar.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['pelamar'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <circle cx="12" cy="7" r="4" />
            <path d="M6 21v-2a6 6 0 1112 0v2" />
          </svg>
          <span>User</span>
        </a>

        <a href="../perusahaan/perusahaan.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['perusahaan'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M9 8h6m-6 4h6m-6 4h6M4 21V4a1 1 0 011-1h6a1 1 0 011 1v17m6 0V8a1 1 0 011-1h2a1 1 0 011 1v13" />
          </svg>
          <span>Perusahaan</span>
        </a>  

        <a href="../transaksi/riwayat_transaksi.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['transaksi'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6M9 11h6M9 15h4M4 3h16v18l-2-2-2 2-2-2-2 2-2-2-2 2-2-2-2 2V3z" />
          </svg>
          <span>Riwayat Transaksi</span>
        </a>

        <a href="../lowongan_kerja/lowongan_kerja.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['lowongan'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V7l-6-6H7a2 2 0 00-2 2v16a2 2 0 002 2z" />
            <circle cx="15" cy="15" r="3" />
            <path d="M18 18l3 3" />
          </svg>
          <span>Lowongan Kerja</span>
        </a>

        <a href="../tips_kerja/tips_kerja_artikel.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['artikel'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <rect x="3" y="4" width="18" height="18" rx="2" />
            <path d="M16 2v4M8 2v4M3 10h18" />
          </svg>
          <span>Artikel & Tips</span>
        </a>

        <a href="../../public/logout.php" onclick="return confirm('Yakin mau logout?')" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['logout'] ? 'bg-red-700 text-white' : 'text-teal-100 hover:bg-red-700 hover:text-white' ?> mt-auto">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 16l4-4m0 0l-4-4m4 4H7" />
            <rect x="3" y="4" width="4" height="16" rx="2" />
          </svg>
          <span>Logout</span>
        </a>
      </nav>
    </aside>
    <div class="flex-1 flex flex-col bg-white min-h-screen ml-64">
      <header class="bg-teal-800 flex items-center justify-between px-12 py-4 text-white shadow">
        <h2 class="text-2xl font-bold tracking-wide">Perpanjang Paket</h2>
      </header>
      <div class="flex justify-center items-center flex-1">
        <div class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-lg mt-12">
          <?php if ($notif): ?>
            <div class="mb-4 p-4 rounded-md <?= $alertClass ?>">
              <?= htmlspecialchars($notif) ?>
            </div>
          <?php endif; ?>

          <?php if (!$id_perusahaan): ?>
            <?php if (!empty($expiredCompanies)): ?>
              <div class="mb-4">
                <h3 class="font-semibold text-gray-700 mb-3">Perusahaan yang sudah expired</h3>
                <div class="space-y-3">
                  <?php foreach ($expiredCompanies as $c): ?>
                    <div class="flex items-center justify-between bg-gray-50 p-3 rounded-md border">
                      <div>
                        <div class="font-medium text-gray-800"><?= htmlspecialchars($c['nama_perusahaan']) ?></div>
                        <div class="text-xs text-gray-500">Expired: <?= date("d/m/Y", strtotime($c['expired_at'])) ?></div>
                      </div>
                      <div>
                        <a href="?id=<?= $c['id_perusahaan'] ?>" class="px-3 py-1 bg-teal-600 text-white rounded-md">Perpanjang</a>
                      </div>
                    </div>
                  <?php endforeach; ?>
                </div>
              </div>
            <?php else: ?>
              <div class="text-center text-gray-600 mb-4">Tidak ada perusahaan yang perlu perpanjangan saat ini.</div>
            <?php endif; ?>
          <?php endif; ?>

          <form action="" method="post" enctype="multipart/form-data" class="space-y-6">
            <?php if ($perusahaan): ?>
              <div class="mb-2">
                <label class="block text-sm text-gray-500">Perusahaan</label>
                <div class="font-medium text-gray-800"><?= htmlspecialchars($perusahaan['nama_perusahaan']) ?></div>
              </div>
            <?php endif; ?>

            <input type="hidden" name="id" value="<?= $id_perusahaan ?? '' ?>">

            <div>
              <label class="block font-semibold mb-2">Pilih Paket</label>
              <select name="paket" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                <option value="">-- Pilih Paket --</option>
                <option value="bronze">Bronze (15 hari)</option>
                <option value="silver">Silver (30 hari)</option>
                <option value="gold">Gold (45 hari)</option>
                <option value="diamond">Diamond (60 hari)</option>
              </select>
            </div>
            <div>
              <label class="block font-semibold mb-2">Metode Pembayaran</label>
              <select name="metode_pembayaran" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500">
                <option value="">-- Pilih Metode --</option>
                <option value="transfer_bca">Transfer BCA</option>
                <option value="transfer_bri">Transfer BNI</option>
                <option value="transfer_mandiri">Transfer Mandiri</option>
                <option value="ewallet_ovo">OVO</option>
                <option value="ewallet_gopay">GoPay</option>
                <option value="ewallet_dana">Dana</option>
                <option value="ewallet_shopeepay">ShopeePay</option>
                <option value="qris">Qris</option>
              </select>
            </div>
            <div>
              <label class="block font-semibold mb-2">Upload Bukti Pembayaran</label>
              <input type="file" name="bukti_pembayaran" accept="image/*,application/pdf" required class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-teal-500" />
            </div>
            <div class="flex justify-end">
              <button type="submit" class="bg-teal-700 hover:bg-teal-800 text-white px-6 py-2 rounded-lg font-semibold transition">Ajukan Perpanjangan</button>
            </div>
          </form>
        </div>
      </div>
      <footer class="bg-gray-100 text-center py-4 text-sm text-gray-600 border-t">
        <p>&copy; <?= date("Y"); ?> CariKerjaID. All rights reserved.</p>
      </footer>
    </div>
  </div>
</body>
</html>