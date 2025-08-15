<?php
include '../function/logic.php';
if(isset($_POST['submit'])){
    if(register($_POST) > 0){
        echo "<script>alert('User baru berhasil ditambahkan!');window.location='login.php';</script>";
        exit;
    } else {
        echo "<script>alert('User baru gagal ditambahkan!');</script>";
    }
}
?>
<!doctype html>

<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Register</title>
    <!-- Tailwind Play CDN (untuk demo cepat). Untuk produksi gunakan build Tailwind yang sebenarnya. -->
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-900 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-xl w-full bg-white shadow-lg">
      <!-- Header / Logo -->
      <div class="bg-teal-700 text-white text-center py-6">
        <h1 class="text-xl font-semibold">Cari Kerja ID</h1>
      </div><!-- Register / Login card content -->
  <div class="p-8">
    <div class="mb-6">
      <div class="bg-gray-200 text-center py-2 font-bold">Register</div>
    </div>

    <form class="space-y-4" action="#" method="post">
      <div class="flex items-center">
        <label class="w-40 font-semibold">Username</label>
        <span class="mr-2">:</span>
        <input type="text" name="username" class="flex-1 bg-gray-200 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-teal-400" placeholder="Masukkan username" />
      </div>

      <div class="flex items-center">
        <label class="w-40 font-semibold">Email / No telp</label>
        <span class="mr-2">:</span>
        <input type="email" name="email" class="flex-1 bg-gray-200 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-teal-400" placeholder="contoh@gmail.com / 0812xxxx" />
      </div>

      <div class="flex items-center">
        <label class="w-40 font-semibold">Password</label>
        <span class="mr-2">:</span>
        <input type="password" name="password" class="flex-1 bg-gray-200 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-teal-400" placeholder="Masukkan password" />
      </div>

      <div class="flex items-center">
        <label class="w-40 font-semibold">Confirm Password</label>
        <span class="mr-2">:</span>
        <input type="password" name="confirm_password" class="flex-1 bg-gray-200 px-3 py-2 rounded focus:outline-none focus:ring-2 focus:ring-teal-400" placeholder="Konfirmasi password" />
      </div>

      <div class="flex justify-center">
        <button type="submit" class="bg-gray-300 px-6 py-2 rounded font-semibold hover:opacity-90">Register</button>
      </div>
    </form>

    <div class="w-full mt-4 text-center text-sm text-gray-600">
                Sudah punya akun? <a href="login.php" class="text-indigo-600 hover:underline font-semibold">Login sekarang</a>
            </div>
  </div>
</div>

