<?php
include '../../function/logic.php';
$menuAktif = menu_aktif('perusahaan');

$qAcc = mysqli_query($conn, "SELECT COUNT(*) AS total FROM perusahaan WHERE verifikasi='sudah'") or die(mysqli_error($conn));
$rowAcc = mysqli_fetch_assoc($qAcc);
$acc = $rowAcc['total'] ?? 0;

$qBelum = mysqli_query($conn, "SELECT COUNT(*) AS total FROM perusahaan WHERE verifikasi='belum'") or die(mysqli_error($conn));
$rowBelum = mysqli_fetch_assoc($qBelum);
$belum = $rowBelum['total'] ?? 0;

$qDitolak = mysqli_query($conn, "SELECT COUNT(*) AS total FROM perusahaan WHERE verifikasi='ditolak'") or die(mysqli_error($conn));
$rowDitolak = mysqli_fetch_assoc($qDitolak);
$ditolak = $rowDitolak['total'] ?? 0;
?>

<!DOCTYPE html>
<html lang="id">
<head> 
  <meta charset="UTF-8">
  <title>Perusahaan</title>
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

        <a href="../../public/logout.php" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
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
        <h2 class="text-2xl font-bold tracking-wide">Daftar Perusahaan</h2>
      </header>

      <div class="p-8 grid grid-cols-1 md:grid-cols-3 gap-6">
        <a href="acc.php" class="block">
          <div class="bg-gradient-to-br from-green-500 to-green-700 rounded-2xl shadow-lg p-8 text-white border-2 border-transparent hover:border-white/40 transform hover:-translate-y-1 active:scale-95 transition duration-200 text-center">
            <h3 class="text-xl font-semibold">Perusahaan ACC</h3>
            <p class="text-5xl font-extrabold mt-3"><?= $acc ?></p>
            <p class="text-sm opacity-90">Sudah disetujui</p>
          </div>
        </a>

        <a href="menunggu.php" class="block">
          <div class="bg-gradient-to-br from-yellow-400 to-yellow-600 rounded-2xl shadow-lg p-8 text-white border-2 border-transparent hover:border-white/40 transform hover:-translate-y-1 active:scale-95 transition duration-200 text-center">
            <h3 class="text-xl font-semibold">Menunggu ACC</h3>
            <p class="text-5xl font-extrabold mt-3"><?= $belum ?></p>
            <p class="text-sm opacity-90">Belum disetujui</p>
          </div>
        </a>

        <a href="ditolak.php" class="block">
          <div class="bg-gradient-to-br from-red-400 to-red-600 rounded-2xl shadow-lg p-8 text-white border-2 border-transparent hover:border-white/40 transform hover:-translate-y-1 active:scale-95 transition duration-200 text-center">
            <h3 class="text-xl font-semibold">Ditolak</h3>
            <p class="text-5xl font-extrabold mt-3"><?= $ditolak ?></p>
            <p class="text-sm opacity-90">Status ditolak</p>
          </div>
        </a>
      </div>

      <div class="px-8 pb-8">
        <h3 class="text-xl font-bold mb-4">Aktivitas Terbaru</h3>
        <div class="space-y-3">
          <?php
          $qNotif = mysqli_query($conn, "SELECT nama_perusahaan, logo, verifikasi, created_at 
                                         FROM perusahaan 
                                         ORDER BY created_at DESC LIMIT 5");

          if (mysqli_num_rows($qNotif) > 0) {
              while ($n = mysqli_fetch_assoc($qNotif)) {
                  // tentukan path logo yang fleksibel
                  $logoSrc = '';
                  if (!empty($n['logo'])) {
                      $logoVal = trim($n['logo']);
                      if (preg_match('#^https?://#i', $logoVal)) {
                          $logoSrc = $logoVal;
                      } else {
                          $clean = preg_replace('#^(\./|\.\./|/)+#', '', $logoVal);
                          $base = basename($clean);
                          $candidates = [
                              $clean,
                              'uploads/'.$clean,
                              'uploads/logo/'.$clean,
                              'uploads/logo_perusahaan/'.$clean,
                              'uploads/'.$base,
                              'uploads/logo/'.$base,
                              'uploads/logo_perusahaan/'.$base
                          ];
                          $projectRoot = realpath(__DIR__ . '/../../');
                          foreach ($candidates as $cand) {
                              $full = realpath(__DIR__ . '/../../' . $cand);
                              if ($full && strpos($full, $projectRoot) === 0 && file_exists($full)) {
                                  $logoSrc = '../../' . $cand;
                                  break;
                              }
                          }
                      }
                  }

                  ?>
                  <div class="bg-gray-50 rounded-xl p-4 flex items-center gap-3 shadow-sm">
                    <div class="flex-shrink-0 w-10 h-10 flex items-center justify-center bg-gray-100 rounded-full overflow-hidden">
                      <?php if (!empty($logoSrc)): ?>
                        <img src="<?= htmlspecialchars($logoSrc) ?>" alt="Logo <?= htmlspecialchars($n['nama_perusahaan']) ?>" class="w-full h-full object-cover">
                      <?php else: ?>
                        <span class="text-gray-400">🏢</span>
                      <?php endif; ?>
                    </div>
                    <div>
                      <p class="text-sm">
                        Perusahaan <span class="font-semibold text-gray-800"><?= htmlspecialchars($n['nama_perusahaan']) ?></span>
                        <?php
                          if ($n['verifikasi'] === 'sudah') {
                              echo '<span class="text-green-600 font-medium"> sudah di ACC</span>';
                          } elseif ($n['verifikasi'] === 'ditolak') {
                              echo '<span class="text-red-600 font-medium"> ditolak</span>';
                          } else {
                              echo '<span class="text-yellow-600 font-medium"> menunggu ACC</span>';
                          }
                        ?>
                      </p>
                      <span class="text-xs text-gray-500"><?= date("d/m/Y", strtotime($n['created_at'])) ?></span>
                    </div>
                  </div>
                  <?php
              }
          } else {
              echo '
              <div class="bg-gray-50 rounded-xl p-4 text-center text-gray-500 shadow-sm">
                Belum ada pembaruan
              </div>';
          }
          ?>
        </div>
      </div>

      <footer class="bg-gray-100 text-center py-4 text-sm text-gray-600 border-t">
        <p>&copy; <?= date("Y"); ?> CariKerjaID. All rights reserved.</p>
      </footer>
    </div>
  </div>

  <div id="logout-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-2xl shadow-lg p-8 max-w-md w-full text-center relative">
        <button onclick="closeLogoutModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
        <h2 class="text-2xl font-bold text-[#00646A] mb-2">Konfirmasi Logout</h2>
        <p class="text-gray-500 mb-6">Apakah Anda yakin ingin logout?</p>
        <div class="flex justify-center gap-4">
            <button onclick="closeLogoutModal()" class="border border-gray-400 px-6 py-2 rounded text-gray-700 hover:bg-gray-100 font-semibold">Batal</button>
            <button id="logout-confirm-btn" class="border border-red-600 text-red-700 px-6 py-2 rounded hover:bg-red-50 font-semibold">Logout</button>
        </div>
    </div>
  </div>

  <script>
    function openLogoutModal(){document.getElementById('logout-modal').classList.remove('hidden')}
    function closeLogoutModal(){document.getElementById('logout-modal').classList.add('hidden')}
    document.addEventListener('DOMContentLoaded',function(){
      var confirmBtn=document.getElementById('logout-confirm-btn');
      document.querySelectorAll('a[href*="logout"]').forEach(function(a){
        try{a.removeAttribute('onclick')}catch(e){}
        a.addEventListener('click',function(e){
          e.preventDefault();
          var href=a.getAttribute('href')||'../../public/logout.php';
          confirmBtn.setAttribute('data-href',href);
          openLogoutModal();
        });
      });
      confirmBtn.addEventListener('click',function(){
        var href=this.getAttribute('data-href')||'../../public/logout.php';
        window.location.href=href;
      });
    });
  </script>
</body>
</html>
