<?php
// Data dummy
include '../header.php';
$riwayat = [
    ["perusahaan" => "PT Maju Jaya", "posisi" => "Frontend Developer", "tanggal" => "2025-09-01", "status" => "Menunggu"],
    ["perusahaan" => "CV Kreatifindo", "posisi" => "UI/UX Designer", "tanggal" => "2025-09-05", "status" => "Diproses"],
    ["perusahaan" => "PT Sukses Makmur", "posisi" => "Backend Developer", "tanggal" => "2025-09-10", "status" => "Ditolak"],
    ["perusahaan" => "PT Teknologi Hebat", "posisi" => "Mobile Developer", "tanggal" => "2025-08-28", "status" => "Diterima"],
];

// Filter status
$filtered = $riwayat;
if (!empty($_GET['status'])) {
    $filtered = array_filter($filtered, fn($r) => $r['status'] == $_GET['status']);
}

// Urutkan tanggal
if (!empty($_GET['sort'])) {
    usort($filtered, function($a, $b) {
        if ($_GET['sort'] == "lama") {
            return strtotime($a['tanggal']) <=> strtotime($b['tanggal']);
        }
        return strtotime($b['tanggal']) <=> strtotime($a['tanggal']);
    });
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
    <h1 class="text-3xl font-bold mb-6 primary-text">📄 Riwayat Lamaran</h1>

    <!-- Filter Form -->
    <form method="GET" class="flex flex-wrap gap-3 mb-6">
      <select name="status" class="px-4 py-2 border rounded-lg primary-border">
        <option value="">Semua Status</option>
        <option value="Menunggu" <?= (($_GET['status'] ?? '')=="Menunggu")?"selected":""; ?>>Menunggu</option>
        <option value="Diproses" <?= (($_GET['status'] ?? '')=="Diproses")?"selected":""; ?>>Diproses</option>
        <option value="Diterima" <?= (($_GET['status'] ?? '')=="Diterima")?"selected":""; ?>>Diterima</option>
        <option value="Ditolak" <?= (($_GET['status'] ?? '')=="Ditolak")?"selected":""; ?>>Ditolak</option>
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
            <th class="py-3 px-4 text-left">Tanggal</th>
            <th class="py-3 px-4 text-left">Status</th>
          </tr>
        </thead>
        <tbody>
          <?php if (!empty($filtered)): ?>
            <?php foreach($filtered as $r): ?>
              <tr class="border-b hover:bg-gray-50">
                <td class="py-3 px-4"><?= $r["perusahaan"]; ?></td>
                <td class="py-3 px-4"><?= $r["posisi"]; ?></td>
                <td class="py-3 px-4"><?= $r["tanggal"]; ?></td>
                <td class="py-3 px-4">
                  <?php if($r["status"] == "Menunggu"): ?>
                    <span class="px-3 py-1 rounded-full text-sm bg-yellow-100 text-yellow-700"><?= $r["status"]; ?></span>
                  <?php elseif($r["status"] == "Diproses"): ?>
                    <span class="px-3 py-1 rounded-full text-sm bg-blue-100 text-blue-700"><?= $r["status"]; ?></span>
                  <?php elseif($r["status"] == "Diterima"): ?>
                    <span class="px-3 py-1 rounded-full text-sm bg-green-100 text-green-700"><?= $r["status"]; ?></span>
                  <?php else: ?>
                    <span class="px-3 py-1 rounded-full text-sm bg-red-100 text-red-700"><?= $r["status"]; ?></span>
                  <?php endif; ?>
                </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="4" class="text-center py-4 text-gray-500">Tidak ada riwayat ditemukan.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</body>
</html>
