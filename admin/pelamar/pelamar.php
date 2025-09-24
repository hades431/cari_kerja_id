<?php
session_start();
include '../../function/logic.php';

$menuAktif = menu_aktif('pelamar');
$sql = "SELECT id_user, email, role, status_akun, created_at FROM user ORDER BY id_user ASC";
$result = mysqli_query($conn, $sql);
$users = [];
if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $users[] = $row;
    }
}
?>
<!DOCTYPE html>
<html lang="id">  
<head>
  <meta charset="UTF-8">
  <title>Daftar User</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#222] min-h-screen">
  <div class="flex min-h-screen">
    <!-- Sidebar -->
    <aside class="bg-gradient-to-b from-teal-700 to-teal-900 w-64 flex flex-col shadow-xl">
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

        <a href="../logout.php" onclick="return confirm('Yakin mau logout?')" class="flex items-center gap-3 px-6 py-3 rounded-lg font-medium transition 
          <?= $menuAktif['logout'] ? 'bg-red-700 text-white' : 'text-teal-100 hover:bg-red-700 hover:text-white' ?> mt-auto">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path d="M17 16l4-4m0 0l-4-4m4 4H7" />
            <rect x="3" y="4" width="4" height="16" rx="2" />
          </svg>
          <span>Logout</span>
        </a>
      </nav>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col bg-white min-h-screen">
      <header class="bg-teal-800 flex items-center justify-between px-12 py-4 text-white shadow">
        <h2 class="text-2xl font-bold tracking-wide">Daftar User</h2>
        <div class="flex items-center gap-3">
          <span class="text-lg font-medium"><?= htmlspecialchars($_SESSION['nama_admin'] ?? 'Admin'); ?></span>
          <img src="../../img/beauty.png" alt="Admin" class="w-10 h-10 rounded-full border-2 border-white shadow-md">
        </div>
      </header>

      <div class="flex-1 p-8 bg-gray-50">
        <div class="flex items-center justify-between mb-6">
          <h2 class="text-2xl font-bold text-gray-700">List User Terdaftar</h2>
        </div>
        <div class="bg-white rounded-xl shadow-lg overflow-hidden border border-gray-200">
          <table class="w-full text-left border-collapse">
            <thead class="bg-gradient-to-r from-teal-600 to-teal-700 text-white">
              <tr>
                <th class="px-4 py-3">No</th>
                <th class="px-4 py-3">Role</th>
                <th class="px-4 py-3">Email</th>
                <th class="px-4 py-3">Status Akun</th>
                <th class="px-4 py-3 text-center">Aksi</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
              <?php if (count($users) > 0): ?>
                <?php foreach ($users as $i => $row): ?>
                  <tr class="hover:bg-gray-50 transition">
                    <td class="px-4 py-3"><?= $i+1 ?>.</td>
                    <td class="px-4 py-3 font-medium text-gray-700"><?= htmlspecialchars($row['role']); ?></td>
                    <td class="px-4 py-3 text-gray-600"><?= htmlspecialchars($row['email']); ?></td>
                    <td class="px-4 py-3">
                      <span class="px-2 py-1 rounded-full text-xs font-semibold <?= $row['status_akun'] == 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                        <?= $row['status_akun']; ?>
                      </span>
                    </td>
                    <td class="px-4 py-3 text-center">
                      <?php if ($row['status_akun'] == 'aktif'): ?>
                        <a href="update_status.php?id=<?= $row['id_user']; ?>&status=nonaktif" class="bg-red-600 hover:bg-red-700 text-white px-4 py-1.5 rounded-lg text-sm shadow">Nonaktifkan</a>
                      <?php else: ?>
                        <a href="update_status.php?id=<?= $row['id_user']; ?>&status=aktif" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1.5 rounded-lg text-sm shadow">Aktifkan</a>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" class="px-4 py-6 text-center text-gray-500 italic">Belum ada user terdaftar.</td>
                </tr>
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
