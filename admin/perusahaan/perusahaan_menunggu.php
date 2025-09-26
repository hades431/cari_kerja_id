<?php
session_start();
include '../../function/logic.php';

$notif = "";

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['verifikasi'], $_POST['id'])) {
    $id = $_POST['id'];
    $aksi = $_POST['verifikasi'];

    if (verifikasiPerusahaan($id, $aksi)) {
        if ($aksi == "setujui") {
            $notif = "Perusahaan berhasil disetujui.";
        } else {
            $notif = "Perusahaan berhasil ditolak.";
        }
    } else {
        $notif = "Terjadi kesalahan saat memverifikasi perusahaan.";
    }
}

$perusahaanList = getPerusahaanPending();
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Verifikasi Perusahaan</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen p-8">
  <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-2xl font-bold mb-6 text-gray-800">Daftar Perusahaan Menunggu Verifikasi</h2>

    <?php if (!empty($notif)): ?>
      <div class="mb-4 px-4 py-3 rounded-lg 
        <?= strpos($notif, 'disetujui') !== false ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
        <?= htmlspecialchars($notif) ?>
      </div>
    <?php endif; ?>

    <?php if (count($perusahaanList) > 0): ?>
      <div class="overflow-x-auto">
        <table class="min-w-full border border-gray-200 rounded-lg">
          <thead class="bg-gray-200 text-gray-700">
            <tr>
              <th class="px-4 py-2 border">ID</th>
              <th class="px-4 py-2 border">Nama Perusahaan</th>
              <th class="px-4 py-2 border">Email</th>
              <th class="px-4 py-2 border">Alamat</th>
              <th class="px-4 py-2 border">Website</th>
              <th class="px-4 py-2 border">Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach ($perusahaanList as $row): ?>
              <tr class="hover:bg-gray-100">
                <td class="px-4 py-2 border text-center"><?= $row['id_perusahaan'] ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['nama_perusahaan']) ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['email_perusahaan']) ?></td>
                <td class="px-4 py-2 border"><?= htmlspecialchars($row['alamat']) ?></td>
                <td class="px-4 py-2 border">
                  <?php if (!empty($row['website'])): ?>
                    <a href="<?= htmlspecialchars($row['website']) ?>" target="_blank" class="text-blue-600 hover:underline">
                      <?= htmlspecialchars($row['website']) ?>
                    </a>
                  <?php else: ?>
                    <span class="text-gray-400">-</span>
                  <?php endif; ?>
                </td>
                <td class="px-4 py-2 border text-center">
                  <form method="POST" class="inline">
                    <input type="hidden" name="id" value="<?= $row['id_perusahaan'] ?>">
                    <button type="submit" name="verifikasi" value="setujui" 
                      class="bg-green-500 hover:bg-green-600 text-white px-3 py-1 rounded-md">Setujui</button>
                  </form>
                  <form method="POST" class="inline">
                    <input type="hidden" name="id" value="<?= $row['id_perusahaan'] ?>">
                    <button type="submit" name="verifikasi" value="tolak" 
                      class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-md ml-2">Tolak</button>
                  </form>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    <?php else: ?>
      <p class="text-gray-600 italic">Tidak ada perusahaan yang menunggu verifikasi.</p>
    <?php endif; ?>
  </div>
</body>
</html>
