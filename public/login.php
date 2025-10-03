<?php
session_start();
$judul_halaman = "Login";
include '../header.php';

// Koneksi database
$conn = mysqli_connect("localhost", "root", "", "lowongan_kerja");
if (mysqli_connect_errno()) {
    echo "Koneksi database gagal : " . mysqli_connect_error();
    exit;
}

// Proses login jika form disubmit
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';

    // Cek ke database
    $sql = "SELECT * FROM user WHERE email = '$email' AND password = '$password' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $user = mysqli_fetch_assoc($result);

    if ($user) {
        // Setelah user berhasil login:
        $_SESSION['user'] = $user;
        if ($user['role'] == 'perusahaan') {
            // Cek status verifikasi perusahaan
            $id_user = $user['id_user'];
            $cek = mysqli_query($conn, "SELECT verifikasi FROM perusahaan WHERE id_user = $id_user ORDER BY id_perusahaan DESC LIMIT 1");
            if ($cek && $row = mysqli_fetch_assoc($cek)) {
                if ($row['verifikasi'] != 'sudah') {
                    // Jika belum diverifikasi, logout dan redirect ke halaman menunggu verifikasi
                    session_destroy();
                    header('Location: menunggu_verifikasi.php');
                    exit;
                }
            }
        }
        // Redirect berdasarkan role
        if ($user['role'] == 'admin') {
            header('Location: ../admin/dashboard.php');
        } elseif ($user['role'] == 'perusahaan') {
            header('Location: ../perusahaan/dashboard.php');
        } else {
            header('Location: ../public/index.php');
        }
        exit;
    } else {
        $error = "Email atau password salah.";
    }
}
?>

<div class="max-w-md mx-auto mt-10 bg-white p-8 rounded-lg border border-gray-200 shadow-lg">
    <h2 class="text-2xl font-bold mb-6 text-center">Login</h2>
    <?php if (isset($error)): ?>
        <div class="mb-4 text-red-600 text-sm text-center">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>
    <form action="" method="POST">
        <div class="mb-4">
            <label for="email" class="block mb-1 font-medium">Email</label>
            <input type="email" id="email" name="email" class="w-full border rounded px-3 py-2" required>
        </div>
        <div class="mb-4">
            <label for="password" class="block mb-1 font-medium">Password</label>
            <input type="password" id="password" name="password" class="w-full border rounded px-3 py-2" required>
        </div>
        <button type="submit"
            class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 px-4 rounded">
            Masuk
        </button>
        <div class="mt-4 text-center text-sm">
            Belum punya akun? <a href="daftar.php" class="text-blue-600 hover:underline">Daftar sekarang</a>
        </div>
    </form>
</div>

</body>
<?php
include '../footer.php';
?>

</html>