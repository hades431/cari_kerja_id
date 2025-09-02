<?php 
session_start();
include '../function/logic.php';
if(isset($_POST["submit"])){
    $name = $_POST["username"];
    $password = $_POST["password"];
    if(empty($name) || empty($password)){
        $error2 = true;
    } else {
        $result  = mysqli_query($koneksi, "SELECT*FROM user WHERE Username = '$name'");
        $row = mysqli_fetch_assoc($result);
        if($row > 0 ){
            $error = true;
        } 
        $error1 = true;
    }
}
?>
<!doctype html>

<html lang="id">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <!-- Tailwind Play CDN (untuk demo cepat). Untuk produksi gunakan build Tailwind yang sebenarnya. -->
    <script src="https://cdn.tailwindcss.com"></script>
  </head>
  <body class="bg-gray-900 min-h-screen flex items-center justify-center p-6">
    <div class="max-w-xl w-full bg-white shadow-lg">
      <!-- Header / Logo -->
      <div class="bg-[00646A] h-16 flex items-center justify-center">
        <img src="../img/logo2.png" alt="Logo Cari Kerja ID" class="h-12 w-auto object-contain mx-auto">
      </div>
      <!-- Register / Login card content -->
  <div class="p-8">
    <div class="mb-6">
      <div class="bg-gray-200 text-center py-2 font-bold">Login</div>
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

      <div class="flex justify-center">
        <button type="submit" class="bg-gray-300 px-6 py-2 rounded font-semibold hover:opacity-90">Login</button>
      </div>
    </form>

    <div class="mt-4 flex items-start space-x-2">
        <input id="remember" type="checkbox" class="mt-1" />
        <label for="remember" class="text-sm">ingat saya</label>
      </div>

      <div class="mt-3 text-sm">
        <a href="#" class="text-gray-700 underline">Lupa password?</a>
      </div>

    </form>

                <div class="text-sm text-gray-600 mt-6 text-center">
                Belum punya akun? <a href="register.php" class="text-indigo-600 hover:underline font-semibold">Daftar sekarang</a>.
            </div>
  </div>
</div>

