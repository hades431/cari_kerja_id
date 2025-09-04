<?php
session_start();
include '../function/logic.php';


$id = $_GET['id'];
$query = mysqli_query($conn, "SELECT * FROM artikel WHERE id='$id'");
$artikel = mysqli_fetch_assoc($query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Edit Artikel</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
  <div class="bg-white shadow-lg rounded-xl p-8 w-full max-w-lg">
    <h2 class="text-2xl font-bold mb-6 text-gray-700">Edit Artikel</h2>

    <form action="update_artikel.php" method="post" enctype="multipart/form-data" class="space-y-4">
      <input type="hidden" name="id" value="<?= $artikel['id'] ?>">

      <div>
        <label class="block text-gray-600 font-medium mb-1">Judul Artikel</label>
        <input type="text" name="judul" value="<?= htmlspecialchars($artikel['judul']) ?>" required
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none">
      </div>

      <div>
        <label class="block text-gray-600 font-medium mb-1">Isi Artikel</label>
        <textarea name="isi" rows="5" required
          class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-teal-500 focus:outline-none"><?= htmlspecialchars($artikel['isi']) ?></textarea>
      </div>

      <div>
        <label class="block text-gray-600 font-medium mb-1">Gambar (Opsional)</label>
        <input type="file" name="gambar" class="w-full border border-gray-300 rounded-lg px-3 py-2">
        <?php if ($artikel['gambar']): ?>
          <img src="<?= $artikel['gambar'] ?>" alt="Gambar Artikel" class="w-24 mt-2 rounded-lg shadow">
        <?php endif; ?>
      </div>

      <div class="flex justify-end">
        <button type="submit" 
          class="bg-yellow-500 hover:bg-yellow-600 text-white px-5 py-2 rounded-lg font-semibold shadow-md">
          Update Artikel
        </button>
      </div>
    </form>
  </div>
</body>
</html>
