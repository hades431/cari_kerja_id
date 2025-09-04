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
      <div class="bg-teal-700 h-16 flex items-center justify-center ">
        <img src="../img/logo2.png" alt="Logo Cari Kerja ID" class="h-12 w-auto object-contain mx-auto">
      </div>
<!-- Register / Login card content -->
  <div class="p-8">
    <div class="mb-6">
      <div class="bg-gray-200 text-center py-2 font-bold">Register</div>
    </div>

   <form class="space-y-6" method="post">
                <div class="input-container">
                    <input type="username" name="username" 
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 transition-all duration-300 bg-transparent placeholder-transparent"
                        placeholder="Username" required />
                    <label class="text-gray-600">Username</label>
                </div>

                <div class="input-container">
                    <input type="email" name="email" 
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 transition-all duration-300 bg-transparent placeholder-transparent"
                        placeholder="Email" required />
                    <label class="text-gray-600">Email</label>
                </div>

                <div class="input-container">
                    <input type="password" name="password" 
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 transition-all duration-300 bg-transparent placeholder-transparent"
                        placeholder="Password" required />
                    <label class="text-gray-600">Password</label>
                </div>

                <div class="input-container">
                    <input type="password" name="konfirmasi_password" 
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-teal-500 transition-all duration-300 bg-transparent placeholder-transparent"
                        placeholder="Password" required />
                    <label class="text-gray-600">Konfirmasi password</label>
                </div>

                <button name="submit" type="submit" 
                    class="w-full bg-gradient-to-r from-[#166534] via-[#103d22] to-[#166534] bg-size-200 text-white py-3 rounded-xl font-medium
                    transition-all duration-500 transform hover:scale-[1.02] hover:bg-pos-100 hover:shadow-xl active:scale-95
                    relative overflow-hidden group">
                    <span class="relative z-10">Login</span>
                    <div class="absolute inset-0 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left bg-gradient-to-r from-[#103d22] via-[#166534] to-[#103d22]"></div>
                </button>
            </form>

    <div class="w-full mt-4 text-center text-sm text-gray-600">
                Sudah punya akun? <a href="login.php" class="text-indigo-600 hover:underline font-semibold">Login sekarang</a>
            </div>
  </div>
</div>

