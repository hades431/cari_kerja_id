<?php
include '../../function/logic.php';

$menuAktif = menu_aktif('perusahaan');
$keyword = $_GET['search'] ?? '';
$sql = "SELECT * FROM perusahaan WHERE verifikasi = 'ditolak'";
if ($keyword) {
    $sql .= " AND nama_perusahaan LIKE '%" . $conn->real_escape_string($keyword) . "%'";
}
$result = mysqli_query($conn, $sql);
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
        <h2 class="text-2xl font-bold tracking-wide">Daftar Perusahaan</h2>
      </header>

      <main class="p-8 flex-1 space-y-8">
          <div class="flex justify-between items-center mb-6">
              <h3 class="text-xl font-bold text-gray-700">
                  Daftar Perusahaan ditolak
              </h3>

              <a href="../perusahaan/perusahaan.php" 
                class="px-4 py-2 bg-teal-600 text-white rounded-lg shadow hover:bg-teal-700 transition">
                  Kembali
              </a>
          </div>
        <form method="GET" class="mb-6">
          <input type="text" name="search" value="<?= htmlspecialchars($keyword) ?>" 
                 placeholder="Cari perusahaan..." 
                 class="px-4 py-2 border rounded-lg w-80 focus:ring-2 focus:ring-teal-500 focus:outline-none" />
          <button type="submit" 
                  class="ml-2 px-4 py-2 bg-teal-600 text-white rounded-lg hover:bg-teal-700">Cari</button>
        </form>

        <div class="overflow-x-auto">
          <table class="w-full border border-gray-200 rounded-lg overflow-hidden shadow">
            <thead class="bg-teal-700 text-white">
              <tr>
                <th class="px-4 py-3 text-left">No</th>
                <th class="px-4 py-3 text-left">Nama Perusahaan</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php 
              $no = 1;
                if (mysqli_num_rows($result) > 0): 
                    while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?= $no++; ?></td>
                            <td><?= htmlspecialchars($row['nama_perusahaan']); ?></td>
                        </tr>
                    <?php endwhile; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5" class="px-4 py-6 text-center text-gray-500 italic">Belum ada perusahaan terdaftar.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
          </table>
        </div>
      </main>
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