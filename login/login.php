<?php 
require '../function/logic.php';
session_start();
if($_SERVER['REQUEST_METHOD'] == 'POST'){
  $email = $_POST['email'];
  $password = $_POST['password'];
  $stmt = $conn->prepare('SELECT*FROM user WHERE email = ?');
  $stmt->bind_param('s',$email);
  $stmt->execute();
  $stmt->store_result();
  if($stmt->num_rows > 0){
    $stmt->bind_result($id_user,$email,$password_hash,$role,$status_akun);
    $stmt->fetch();
    if($password == $password_hash){
      $_SESSION['login'] = true;
      $_SESSION['id_user'] = $id_user;
      $_SESSION['email'] = $email;
      $_SESSION['role'] = $role;
      $_SESSION['status_akun'] = $status_akun;
      if($role == 'admin'){
        header('Location: ../admin/dashboard.php');
      }elseif($role == 'pelamar'){
        header('Location: ../landing/landing_page.php');
      }else{
        header('Location: ../dashboard/dashboard_perusahaan.php');
      }
  }
}
$error2 = true;

}
?>
<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/particles.js@2.0.0/particles.js"></script>
    <style>
        #particles-js {
            position: absolute;
            width: 100%;
            height: 100%;
            z-index: 0;
        }
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
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
        }
        .input-container input:focus ~ label,
        .input-container input:not(:placeholder-shown) ~ label {
            top: 0;
            font-size: 0.75rem;
            background: white;
            padding: 0 0.5rem;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-gray-900 via-teal-900 to-gray-900 min-h-screen flex items-center justify-center p-6 relative overflow-hidden">
    <div id="particles-js"></div>
    
    <div class="max-w-md w-full glass rounded-2xl shadow-2xl transform transition-all duration-500 hover:scale-[1.02] floating z-10">
        <div class="bg-gradient-to-r from-teal-600 via-teal-500 to-teal-600 h-24 flex items-center justify-center rounded-t-2xl relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/10 to-transparent animate-[shine_3s_ease-in-out_infinite]"></div>
            <img src="../img/logo2.png" alt="Logo Cari Kerja ID" class="h-16 w-auto object-contain mx-auto transform transition-all duration-500 hover:scale-110 hover:rotate-2">
        </div>

        <div class="p-8">
            <h2 class="text-3xl font-bold text-center bg-gradient-to-r from-teal-600 to-teal-800 bg-clip-text text-transparent mb-8">Login</h2>
            
            <?php if(isset($error2)): ?>
            <div class="bg-red-100/80 backdrop-blur border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded-r animate-[shake_0.5s_ease-in-out]">
                <p class="font-medium">Password atau email salah</p>
            </div>
            <?php endif; ?>

            <form class="space-y-6" method="post">
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

                <button name="submit" type="submit" 
                    class="w-full bg-gradient-to-r from-teal-500 via-teal-600 to-teal-500 bg-size-200 text-white py-3 rounded-xl font-medium
                    transition-all duration-500 transform hover:scale-[1.02] hover:bg-pos-100 hover:shadow-xl active:scale-95
                    relative overflow-hidden group">
                    <span class="relative z-10">Login</span>
                    <div class="absolute inset-0 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left bg-gradient-to-r from-teal-600 via-teal-500 to-teal-600"></div>
                </button>
            </form>

            <div class="mt-6 text-center">
                <a href="#" class="text-sm text-teal-600 hover:text-teal-800 transition-colors duration-300 hover:underline relative inline-block after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:bottom-0 after:left-0 after:bg-teal-600 after:transition-transform after:duration-300 hover:after:scale-x-100">
                    Lupa password?
                </a>
            </div>

            <div class="mt-6 text-center text-gray-600">
                Belum punya akun? 
                <a href="register.php" class="text-teal-600 hover:text-teal-800 transition-colors duration-300 font-medium relative inline-block after:content-[''] after:absolute after:w-full after:scale-x-0 after:h-0.5 after:bottom-0 after:left-0 after:bg-teal-600 after:transition-transform after:duration-300 hover:after:scale-x-100">
                    Daftar sekarang
                </a>
            </div>
        </div>
    </div>

    <script>
        particlesJS('particles-js', {
            particles: {
                number: { value: 80 },
                color: { value: '#ffffff' },
                opacity: { value: 0.2 },
                size: { value: 3 },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: '#ffffff',
                    opacity: 0.1,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 2
                }
            }
        });

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