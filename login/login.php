<?php 
require '../function/logic.php';
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $email = $_POST['email'];
  $password = $_POST['password'];
  $stmt = $conn->prepare('SELECT * FROM user WHERE email = ?');
  $stmt->bind_param('s',$email);
  $stmt->execute();
  $result = $stmt->get_result();
  if($result && $result->num_rows > 0){
    $user = $result->fetch_assoc();
    // Ganti pengecekan password sesuai kebutuhan (hash atau plain)
    $dbPassword = $user['password'];
    $isHashed = strlen($dbPassword) === 60 && preg_match('/^\$2y\$/', $dbPassword);
    if(
      ($isHashed && password_verify($password, $dbPassword)) ||
      (!$isHashed && $password === $dbPassword)
    ){
      $_SESSION['login'] = true;
      $_SESSION['id_user'] = $user['id_user'];
      $_SESSION['email'] = $user['email'];
      $_SESSION['role'] = $user['role'];
      $_SESSION['status_akun'] = $user['status_akun'];
      // Simpan data user lengkap ke session['user']
      $_SESSION['user'] = [
        'id' => $user['id_user'],
        'email' => $user['email'],
        'nama' => $user['nama'] ?? '',
        'role' => $user['role'],
        'status_akun' => $user['status_akun']
      ];
      if($user['role'] == 'admin'){
        header('Location: ../admin/dashboard/dashboard.php');
        exit;
      }elseif($user['role'] == 'pelamar'){
        header('Location: ../landing/landing_page.php');
        exit;
      }elseif($user['role'] == 'perusahaan'){
        header('Location: ../perusahaan/dashboard_perusahaan.php');
        exit;
      }else{
        // Jika role tidak dikenali, bisa diarahkan ke halaman error atau landing
        header('Location: ../landing/landing_page.php');
        exit;
      }
    } else {
      $error2 = true;
    }
  } else {
    $error2 = true;
  }
}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
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
</head>
<body class="bg-[#181f2a] min-h-screen flex items-center justify-center p-6">

    <div class="max-w-md w-full glass rounded-2xl shadow-2xl transform transition-all duration-500 hover:scale-[1.02] floating z-10">
        <div class="bg-[#00646A] h-20 flex flex-col items-center justify-center rounded-t-2xl">
            <img src="../img/carikerja.png" alt="Logo Cari Kerja ID" class="h-20 w-auto object-contain mx-auto">
        </div>

        <div class="p-8">
            <h2 class="text-3xl font-bold text-center text-gray-800 mb-8">Login</h2>
            
            <?php if(isset($error2)): ?>
            <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r">
                <p class="font-medium">Password atau email salah</p>
            </div>
            <?php endif; ?>


            <form class="space-y-6" method="post">
                <div class="input-container">
                    <input type="email" name="email" 
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-teal-500 transition-all duration-300 bg-transparent placeholder-transparent"
                        placeholder="Email" required />
                    <label class="">Email</label>
                </div>

                <div class="input-container">
                    <input type="password" name="password" 
                        class="w-full px-4 py-3 rounded-xl border-2 border-gray-300 focus:border-teal-500 transition-all duration-300 bg-transparent placeholder-transparent"
                        placeholder="Password" required />
                    <label class="">Password</label>
                </div>

                <button name="submit" type="submit" 
                    class="w-full bg-teal-600 text-white py-3 rounded-xl font-medium
                    transition-all duration-300 transform hover:scale-105 hover:shadow-xl active:scale-95">
                    <span class="relative z-10">Login</span>
                </button>
            </form>

           

            <div class="mt-6 text-center text-gray-600">
                Belum punya akun? 
                <a href="register.php" class="text-teal-600 hover:text-teal-800 transition-colors duration-300 font-medium hover:underline">
                    Daftar sekarang
                </a>
            </div>
        </div>
    </div>

    <script>
        // Form submit animation
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = this.querySelector('button[type="submit"]');
            button.innerHTML = `
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                Loading...
            `;
            button.disabled = true;
        });
    </script>
</body>
</html>