<?php
session_start();
include '../../function/logic.php';
$menuAktif = menu_aktif('transaksi');

// Inisialisasi keyword
$keyword = isset($_GET['search']) ? trim($_GET['search']) : '';

// Ambil data perusahaan dengan filter search
$transaksi = [];
$sql = "SELECT nama_perusahaan, paket, metode_pembayaran, bukti_pembayaran, verifikasi, created_at FROM perusahaan";
if ($keyword !== '') {
    $sql .= " WHERE nama_perusahaan LIKE '%" . $conn->real_escape_string($keyword) . "%'";
}
$sql .= " ORDER BY id_perusahaan DESC";
$res = $conn->query($sql);
if ($res) {
    while ($row = $res->fetch_assoc()) {
        // Durasi dari nama paket
        $paket = strtolower(trim($row['paket']));
        $durasi = 0;
        if ($paket === 'bronze') $durasi = 15;
        elseif ($paket === 'silver') $durasi = 30;
        elseif ($paket === 'gold') $durasi = 45;
        elseif ($paket === 'diamond') $durasi = 60;

        $sisa_hari = '-';
        // Hitung sisa hari hanya jika verifikasi sudah
        if ($row['verifikasi'] === 'sudah' && !empty($row['created_at']) && $durasi > 0) {
            $tanggal_mulai = strtotime($row['created_at']);
            $tanggal_berakhir = $tanggal_mulai + ($durasi * 86400);
            $sisa = ($tanggal_berakhir - time()) / 86400;
            $sisa_hari = $sisa > 0 ? floor($sisa) . ' hari' : 'Expired';
        }
        $row['sisa_hari'] = $sisa_hari;
        $transaksi[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Riwayat Transaksi</title>
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
        <h2 class="text-2xl font-bold tracking-wide">Riwayat Transaksi</h2>
        </header>

        <!-- Tabel Transaksi -->
        <div class="p-8">
          <!-- Search Bar di atas tabel, terpisah dari tabel -->
          <div class="flex items-center justify-between mb-4">
            <form method="GET" class="flex gap-2 w-1/3">
              <input 
                type="text" 
                name="search" 
                placeholder="Cari perusahaan..." 
                value="<?= htmlspecialchars($keyword) ?>" 
                class="px-4 py-2 w-full rounded-lg border border-gray-300 
                      focus:border-teal-500 focus:ring-2 focus:ring-teal-500 focus:outline-none"
              />
              <button class="px-4 py-2 bg-teal-700 text-white rounded-lg hover:bg-teal-800">
                Cari
              </button>
            </form>
          </div>
          <div class="bg-gradient-to-r from-teal-700 to-teal-500 rounded-t-2xl overflow-hidden">
            <table class="min-w-full text-left">
              <thead>
                <tr class="text-white font-bold">
                  <th class="py-3 px-4">No</th>
                  <th class="py-3 px-4">Nama Perusahaan</th>
                  <th class="py-3 px-4">Paket</th>
                  <th class="py-3 px-4">Metode Pembayaran</th>
                  <th class="py-3 px-4">Bukti Pembayaran</th>
                  <th class="py-3 px-4">Verifikasi</th>
                  <th class="py-3 px-4">Sisa Hari</th>
                  <th class="py-3 px-4">Aksi</th>
                </tr>
              </thead>
              <tbody class="bg-white rounded-b-2xl">
                <?php if (empty($transaksi)): ?>
                  <tr>
                    <td colspan="8" class="py-8 text-center text-gray-500 italic">Belum ada data.</td>
                  </tr>
                <?php else: ?>
                  <?php foreach ($transaksi as $i => $t): ?>
                    <tr class="border-b">
                      <td class="py-3 px-4"><?= $i+1 ?></td>
                      <td class="py-3 px-4"><?= htmlspecialchars($t['nama_perusahaan']) ?></td>
                      <td class="py-3 px-4"><?= htmlspecialchars($t['paket']) ?></td>
                      <td class="py-3 px-4"><?= htmlspecialchars($t['metode_pembayaran'] ?? '-') ?></td>
                      <td class="py-3 px-4">
                        <?php if (!empty($t['bukti_pembayaran'])): ?>
                          <a href="../../<?= $t['bukti_pembayaran'] ?>" target="_blank" class="text-blue-600 underline">Lihat</a>
                        <?php else: ?>
                          <span class="text-gray-400">-</span>
                        <?php endif; ?>
                      </td>
                      <td class="py-3 px-4">
                        <?php if (strtolower($t['verifikasi']) === 'sudah'): ?>
                          <span class="inline-block bg-green-600 text-white px-5 py-2 rounded-lg font-semibold">Sudah</span>
                        <?php else: ?>
                          <span class="inline-block bg-red-600 text-white px-5 py-2 rounded-lg font-semibold">Belum</span>
                        <?php endif; ?>
                      </td>
                      <td class="py-3 px-4"><?= $t['sisa_hari'] ?></td>
                      <td class="py-3 px-4">
                        <?php
                          // Tombol perpanjang hanya muncul jika sisa_hari 'Expired' atau '0 hari'
                          $sisa = strtolower(trim($t['sisa_hari']));
                          if ($sisa === 'expired' || $sisa === '0 hari' || $sisa === '0hari' || $sisa === '0') {
                        ?>
                          <a href="perpanjang.php" class="bg-yellow-500 hover:bg-yellow-600 text-white px-4 py-2 rounded-lg font-semibold transition inline-block text-center">Perpanjang</a>
                        <?php } else { ?>
                          <span class="bg-gray-300 text-gray-500 px-4 py-2 rounded-lg font-semibold inline-block text-center cursor-not-allowed opacity-60">Perpanjang</span>
                        <?php } ?>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                <?php endif; ?>
              </tbody>
            </table>
          </div>
        </div>

        <footer class="bg-gray-100 text-center py-4 text-sm text-gray-600 border-t">
        <p>&copy; <?= date("Y"); ?> CariKerjaID. All rights reserved.</p>
        </footer>
    </div>
  </div>
</body>
</html>