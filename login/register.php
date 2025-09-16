<?php
include '../function/auth.php';
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
    <title>Daftar</title>
    <!-- Tailwind Play CDN (untuk demo cepat). Untuk produksi gunakan build Tailwind yang sebenarnya. -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        .glass {
            background: #fff; /* putih solid */
            /* backdrop-filter: blur(10px); */
        }
        @keyframes float {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }
        .floating { animation: float 6s ease-in-out infinite; }
        .input-container {
            position: relative;
            margin: 1rem 0;
        }
        .input-container label {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            transition: all 0.3s;
            pointer-events: none;
            color: #6b7280; /* abu-abu elegan */
        }
        .input-container input:focus ~ label,
        .input-container input:not(:placeholder-shown) ~ label {
            top: 0;
            font-size: 0.75rem;
            background: #fff; /* putih solid */
            padding: 0 0.5rem;
        }
    </style>
    </style>
  </head>
  <body class="bg-[#181f2a] min-h-screen flex items-center justify-center p-6">
    <div class="max-w-md w-full glass rounded-2xl shadow-2xl transform transition-all duration-500 hover:scale-[1.02] floating z-10">
      <!-- Header / Logo -->
      <div class="bg-[#00646A] h-20 flex flex-col items-center justify-center rounded-t-2xl">
        <img src="../img/logo2.png" alt="Logo Cari Kerja ID" class="h-10 w-auto object-contain mb-2">
        <span class="text-white font-semibold text-lg tracking-wide"></span>
      </div>
      <!-- Register / Login card content -->
      <div class="p-8">
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-8">Daftar</h2>
        <form class="space-y-6" method="post">
          <div class="input-container">
            <input type="username" name="username"
              class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#14746f] transition-all duration-300 bg-transparent placeholder-transparent"
              placeholder="Email" required />
            <label class="text-gray-600">Username</label>
          </div>
          <div class="input-container">
            <input type="email" name="email"
              class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#14746f] transition-all duration-300 bg-transparent placeholder-transparent"
              placeholder="Email" required />
            <label class="text-gray-600">Email</label>
          </div>
          <div class="input-container">
            <input type="password" name="password"
              class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#14746f] transition-all duration-300 bg-transparent placeholder-transparent"
              placeholder="Password" required />
            <label class="text-gray-600">Password</label>
          </div>
          <div class="input-container">
            <input type="password" name="konfirmasi_password"
              class="w-full px-4 py-3 rounded-xl border-2 border-gray-200 focus:border-[#14746f] transition-all duration-300 bg-transparent placeholder-transparent"
              placeholder="Password" required />
            <label class="text-gray-600">Konfirmasi password</label>
          </div>
          <button name="submit" type="submit" 
                    class="w-full bg-teal-600 text-white py-3 rounded-xl font-medium
                    transition-all duration-300 transform hover:scale-105 hover:shadow-xl active:scale-95">
                    <span class="relative z-10">Daftar</span>
                </button>
        </form>
        <div class="w-full mt-4 text-center text-sm text-gray-600">
          Sudah punya akun? <a href="login.php" class="text-[#14746f] hover:underline font-semibold">Login sekarang</a>
        </div>
      </div>
    </div>
    <style>
      .input-container {
        position: relative;
        margin: 1rem 0;
      }
      .input-container label {
        position: absolute;
        left: 1rem;
        top: 50%;
        transform: translateY(-50%);
        transition: all 0.3s;
        pointer-events: none;
      }
      .input-container input:focus ~ label,
      .input-container input:not(:placeholder-shown) ~ label {
        top: 0;
        font-size: 0.75rem;
        background: #fff;
        padding: 0 0.5rem;
      }
    </style>
  </body>
</html>