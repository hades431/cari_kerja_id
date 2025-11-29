<?php
session_start();
include '../../function/logic.php';
include '../../function/sesi_role_aktif_admin.php';

$menuAktif = menu_aktif('dashboard');

$jumlahLoker      = getJumlahLoker();
$jumlahPerusahaan = getJumlahPerusahaan();
$jumlahUser       = getJumlahUser();
$jumlahArtikel    = getJumlahArtikel();

$aktivitas   = getAktivitasTerbaru();
$statistik   = getStatistikBulanan();
$perusahaan  = getPerusahaanBaru();
$artikel     = getArtikelTerbaru();
$notifikasi  = getNotifikasi();
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-[#222] min-h-screen">
    <div class="flex min-h-screen">
        <aside class="bg-gradient-to-b from-teal-700 to-teal-900 w-64 flex flex-col shadow-xl fixed inset-y-0 left-0">
            <div class="px-4 py-6 flex flex-col items-center gap-2">
                <img src="../../img/carikerja.png" alt="Logo" class="w-40 object-contain" />
            </div>
            <nav class="flex-1 flex flex-col gap-1 px-2 mt-4">
                <a href="../dashboard/dashboard.php"
                    class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['dashboard'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 21V10" />
                        <path d="M9 21V3" />
                        <path d="M15 21v-6" />
                        <path d="M20 21v-4" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <a href="../pelamar/pelamar.php"
                    class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['pelamar'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <circle cx="12" cy="7" r="4" />
                        <path d="M6 21v-2a6 6 0 1112 0v2" />
                    </svg>
                    <span>User</span>
                </a>

                <a href="../perusahaan/perusahaan.php"
                    class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['perusahaan'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M3 21h18M9 8h6m-6 4h6m-6 4h6M4 21V4a1 1 0 011-1h6a1 1 0 011 1v17m6 0V8a1 1 0 011-1h2a1 1 0 011 1v13" />
                    </svg>
                    <span>Perusahaan</span>
                </a>

                <a href="../transaksi/riwayat_transaksi.php"
                    class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['transaksi'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M9 7h6M9 11h6M9 15h4M4 3h16v18l-2-2-2 2-2-2-2 2-2-2-2 2-2-2-2 2V3z" />
                    </svg>
                    <span>Riwayat Transaksi</span>
                </a>

                <a href="../lowongan_kerja/lowongan_kerja.php"
                    class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['lowongan'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M7 21h10a2 2 0 002-2V7l-6-6H7a2 2 0 00-2 2v16a2 2 0 002 2z" />
                        <circle cx="15" cy="15" r="3" />
                        <path d="M18 18l3 3" />
                    </svg>
                    <span>Lowongan Kerja</span>
                </a>

                <a href="../tips_kerja/tips_kerja_artikel.php"
                    class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['artikel'] ? 'bg-teal-900 text-white' : 'text-teal-100 hover:bg-teal-900 hover:text-white' ?>">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <rect x="3" y="4" width="18" height="18" rx="2" />
                        <path d="M16 2v4M8 2v4M3 10h18" />
                    </svg>
                    <span>Artikel & Tips</span>
                </a>

                <a href="../../public/logout.php"
                    class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
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
        <h2 class="text-2xl font-bold tracking-wide">Dashboard Admin</h2>
      </header>

      <main class="p-8 flex-1 space-y-10">

        <h3 class="text-xl font-bold mb-6 text-gray-700">Statistik Ringkasan</h3>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="bg-white shadow-lg rounded-2xl flex flex-col items-center justify-center p-6 hover:shadow-xl hover:-translate-y-1 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-3 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V7l-6-6H7a2 2 0 00-2 2v16a2 2 0 002 2z" />
            <circle cx="15" cy="15" r="3" />
            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18l3 3" />
          </svg>
            <p class="text-3xl font-bold text-teal-700"><?= $jumlahLoker ?></p>
            <p class="text-gray-600 mt-1">Lowongan Tersedia</p>
          </div>

          <div class="bg-white shadow-lg rounded-2xl flex flex-col items-center justify-center p-6 hover:shadow-xl hover:-translate-y-1 transition">
            <svg class="w-12 h-12 mb-3 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" d="M3 21h18M9 8h6m-6 4h6m-6 4h6M4 21V4a1 1 0 011-1h6a1 1 0 011 1v17m6 0V8a1 1 0 011-1h2a1 1 0 011 1v13" />
            </svg>
            <p class="text-3xl font-bold text-teal-700"><?= $jumlahPerusahaan ?></p>
            <p class="text-gray-600 mt-1">Perusahaan Terdaftar</p>
          </div>

          <div class="bg-white shadow-lg rounded-2xl flex flex-col items-center justify-center p-6 hover:shadow-xl hover:-translate-y-1 transition">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-3 text-teal-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
              <path stroke-linecap="round" stroke-linejoin="round" d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
              <path stroke-linecap="round" stroke-linejoin="round" d="M6 20v-2a6 6 0 1112 0v2" />
            </svg>
            <p class="text-3xl font-bold text-teal-700"><?= $jumlahUser ?></p>
            <p class="text-gray-600 mt-1">Pelamar</p>
          </div>


          <div class="bg-white shadow-lg rounded-2xl flex flex-col items-center justify-center p-6 hover:shadow-xl hover:-translate-y-1 transition">
            <svg class="w-12 h-12 mb-3 text-teal-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
              <rect x="3" y="4" width="18" height="18" rx="2" />
              <path d="M16 2v4M8 2v4M3 10h18" />
            </svg>
            <p class="text-3xl font-bold text-teal-700"><?= $jumlahArtikel ?></p>
            <p class="text-gray-600 mt-1">Artikel & Tips</p>
          </div>
        </div>

        <div class="flex-1 flex flex-col bg-white min-h-screen ml-64">
            <header class="bg-teal-800 flex items-center justify-between px-12 py-4 text-white shadow">
                <h2 class="text-2xl font-bold tracking-wide">Dashboard Admin</h2>
            </header>

            <main class="p-8 flex-1 space-y-10">

                <h3 class="text-xl font-bold mb-6 text-gray-700">Statistik Ringkasan</h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                    <div
                        class="bg-white shadow-lg rounded-2xl flex flex-col items-center justify-center p-6 hover:shadow-xl hover:-translate-y-1 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-3 text-teal-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 21h10a2 2 0 002-2V7l-6-6H7a2 2 0 00-2 2v16a2 2 0 002 2z" />
                            <circle cx="15" cy="15" r="3" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M18 18l3 3" />
                        </svg>
                        <p class="text-3xl font-bold text-teal-700"><?= $jumlahLoker ?></p>
                        <p class="text-gray-600 mt-1">Lowongan Tersedia</p>
                    </div>

                    <div
                        class="bg-white shadow-lg rounded-2xl flex flex-col items-center justify-center p-6 hover:shadow-xl hover:-translate-y-1 transition">
                        <svg class="w-12 h-12 mb-3 text-teal-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 21h18M9 8h6m-6 4h6m-6 4h6M4 21V4a1 1 0 011-1h6a1 1 0 011 1v17m6 0V8a1 1 0 011-1h2a1 1 0 011 1v13" />
                        </svg>
                        <p class="text-3xl font-bold text-teal-700"><?= $jumlahPerusahaan ?></p>
                        <p class="text-gray-600 mt-1">Perusahaan Terdaftar</p>
                    </div>

                    <div
                        class="bg-white shadow-lg rounded-2xl flex flex-col items-center justify-center p-6 hover:shadow-xl hover:-translate-y-1 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 mb-3 text-teal-600" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 20v-2a6 6 0 1112 0v2" />
                        </svg>
                        <p class="text-3xl font-bold text-teal-700"><?= $jumlahUser ?></p>
                        <p class="text-gray-600 mt-1">Pelamar</p>
                    </div>


                    <div
                        class="bg-white shadow-lg rounded-2xl flex flex-col items-center justify-center p-6 hover:shadow-xl hover:-translate-y-1 transition">
                        <svg class="w-12 h-12 mb-3 text-teal-600" fill="none" stroke="currentColor" stroke-width="2"
                            viewBox="0 0 24 24">
                            <rect x="3" y="4" width="18" height="18" rx="2" />
                            <path d="M16 2v4M8 2v4M3 10h18" />
                        </svg>
                        <p class="text-3xl font-bold text-teal-700"><?= $jumlahArtikel ?></p>
                        <p class="text-gray-600 mt-1">Artikel & Tips</p>
                    </div>
                </div>

        <div class="bg-white shadow rounded-2xl p-5">
          <h2 class="font-semibold text-lg mb-3">Aktivitas Terbaru</h2>
          <div class="space-y-3">
            <?php foreach($aktivitas as $a): ?>
              <div class="p-4 bg-gray-50 rounded-xl shadow-sm text-sm text-gray-700">
                <?= $a['jumlah'] ?> <?= $a['pesan'] ?> - <span class="text-xs text-gray-400"><?= date("d/m/Y", strtotime($a['tanggal'])) ?></span>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

                        <div>
                            <p class="text-sm font-medium">Lowongan</p>
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full"
                                    style="width: <?= $statistik['lowongan'] ?>%"></div>
                            </div>
                            <p class="text-xs text-gray-500 mt-1"><?= $statistik['lowongan'] ?> lowongan bulan ini</p>
                        </div>
                    </div>
                </div>

                <div class="bg-white shadow rounded-2xl p-5">
                    <h2 class="font-semibold text-lg mb-3">Notifikasi</h2>
                    <div class="space-y-3">
                        <?php if (!empty($notifikasi)): ?>
                        <?php foreach ($notifikasi as $n): ?>
                        <div
                            class="p-4 bg-gray-50 rounded-xl shadow-sm flex justify-between items-center text-sm text-gray-700">
                            <span><?= $n['icon'] ?> <?= $n['pesan'] ?></span>
                            <a href="<?= $n['link'] ?>"
                                class="text-xs text-blue-600 hover:underline"><?= $n['aksi'] ?></a>
                        </div>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <p class="text-sm text-gray-500">Tidak ada notifikasi</p>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="bg-white shadow rounded-2xl p-5">
                    <h2 class="font-semibold text-lg mb-3">Aktivitas Terbaru</h2>
                    <div class="space-y-3">
                        <?php
              $sqlAct = "SELECT l.judul, p.nama_perusahaan, l.tanggal_post FROM lowongan l LEFT JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan WHERE DATE(l.tanggal_post) = CURDATE() ORDER BY l.tanggal_post DESC LIMIT 10";
              $resAct = $conn->query($sqlAct);
            ?>

                        <?php if ($resAct && $resAct->num_rows > 0): ?>
                        <?php while ($act = $resAct->fetch_assoc()): ?>
                        <?php $time = date('d/m/Y H:i', strtotime($act['tanggal_post'])); ?>
                        <div class="p-4 bg-gray-50 rounded-xl shadow-sm text-sm text-gray-700">
                            📢 Lowongan baru: <span class="font-semibold"><?= htmlspecialchars($act['judul']) ?></span>
                            oleh <span
                                class="font-semibold"><?= htmlspecialchars($act['nama_perusahaan'] ?: 'Perusahaan') ?></span>
                            - <span class="text-xs text-gray-400"><?= $time ?></span>
                        </div>
                        <?php endwhile; ?>
                        <?php else: ?>
                        <div class="p-4 bg-gray-50 rounded-xl shadow-sm text-sm text-gray-500">Tidak ada lowongan baru
                            hari ini.</div>
                        <?php endif; ?>

                    </div>
                </div>

                <div class="bg-white shadow rounded-2xl p-5">
                    <h2 class="font-semibold text-lg mb-3">Perusahaan Baru</h2>
                    <div class="space-y-3">
                        <?php foreach($perusahaan as $p): ?>
                        <div class="p-4 bg-gray-50 rounded-xl shadow-sm text-sm text-gray-700">
                            🏢 <?= $p['nama_perusahaan'] ?> - <?= date("d/m/Y", strtotime($p['created_at'])) ?>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

                <div class="bg-white shadow rounded-2xl p-5">
                    <h2 class="font-semibold text-lg mb-3">Artikel & Tips Terbaru</h2>
                    <div class="space-y-3">
                        <?php foreach($artikel as $art): ?>
                        <div
                            class="p-4 bg-gray-50 rounded-xl shadow-sm flex justify-between items-center text-sm text-gray-700">
                            <span>📄 <a href="../../admin/tips_kerja/lihat_artikel.php?= $art['id'] ?>"
                                    class="text-blue-600 hover:underline"><?= $art['judul'] ?></a></span>
                            <span
                                class="text-gray-400 text-xs"><?= date("d/m/Y", strtotime($art['created_at'])) ?></span>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>

            </main>

            <footer class="bg-gray-100 text-center py-4 text-sm text-gray-600 border-t">
                <p>&copy; <?= date("Y"); ?> CariKerjaID. All rights reserved.</p>
            </footer>
        </div>
    </div>

    <div id="logout-modal" class="fixed inset-0 bg-black bg-opacity-30 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-2xl shadow-lg p-8 max-w-md w-full text-center relative">
            <button onclick="closeLogoutModal()"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 text-xl">&times;</button>
            <h2 class="text-2xl font-bold text-[#00646A] mb-2">Konfirmasi Logout</h2>
            <p class="text-gray-500 mb-6">Apakah Anda yakin ingin logout?</p>
            <div class="flex justify-center gap-4">
                <button onclick="closeLogoutModal()"
                    class="border border-gray-400 px-6 py-2 rounded text-gray-700 hover:bg-gray-100 font-semibold">Batal</button>
                <button id="logout-confirm-btn"
                    class="border border-red-600 text-red-700 px-6 py-2 rounded hover:bg-red-50 font-semibold">Logout</button>
            </div>
        </div>
    </div>

    <script>
    function openLogoutModal() {
        document.getElementById('logout-modal').classList.remove('hidden')
    }

    function closeLogoutModal() {
        document.getElementById('logout-modal').classList.add('hidden')
    }
    document.addEventListener('DOMContentLoaded', function() {
        var confirmBtn = document.getElementById('logout-confirm-btn');
        document.querySelectorAll('a[href*="logout"]').forEach(function(a) {
            try {
                a.removeAttribute('onclick')
            } catch (e) {}
            a.addEventListener('click', function(e) {
                e.preventDefault();
                var href = a.getAttribute('href') || '../../public/logout.php';
                confirmBtn.setAttribute('data-href', href);
                openLogoutModal();
            });
        });
        confirmBtn.addEventListener('click', function() {
            var href = this.getAttribute('data-href') || '../../public/logout.php';
            window.location.href = href;
        });
    });
    </script>
</body>

</html>