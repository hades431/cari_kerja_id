<?php 
$conn = mysqli_connect("localhost","root","","lowongan_kerja");

if (mysqli_connect_errno()){
    echo "Koneksi database gagal : " . mysqli_connect_error(); 
    exit;
}

if (!function_exists('getArtikelList')) {
    function getArtikelList() {
        global $conn;
        $sql = "SELECT id, judul, isi, gambar, tanggal FROM artikel ORDER BY id DESC";
        $result = mysqli_query($conn, $sql);

        $data = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}


if (!function_exists('menu_aktif')) {
    function menu_aktif($page) {
        $menuAktif = [
            'dashboard' => false,
            'lowongan' => false,
            'perusahaan' => false,
            'transaksi' => false,
            'pelamar' => false,
            'artikel' => false,
            'logout' => false
        ];

        if (array_key_exists($page, $menuAktif)) {
            $menuAktif[$page] = true;
        }

            return $menuAktif;
        }
    }
    

if (!function_exists('searchArtikel')) {
    function searchArtikel($keyword) {
        global $conn;
        $sql = "SELECT * FROM artikel WHERE judul LIKE ?";
        $stmt = $conn->prepare($sql);
        $like = "%$keyword%";
        $stmt->bind_param("s", $like);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}

if (!function_exists('tambahArtikel')) {
    function tambahArtikel($data, $file) {
        global $conn;

        $judul = htmlspecialchars($data['judul']);
        $isi = htmlspecialchars($data['isi']);
        $ringkasan = substr($isi, 0, 150) . (strlen($isi) > 150 ? '...' : '');

        $gambar = null;
        if (isset($file['gambar']) && $file['gambar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileName = uniqid() . '_' . basename($file['gambar']['name']);
            $targetFilePath = $uploadDir . $fileName;

            if (move_uploaded_file($file['gambar']['tmp_name'], $targetFilePath)) {
                $gambar = 'uploads/' . $fileName;
            } else {
                return false; 
            }
        }

        $sql = "INSERT INTO artikel (judul, ringkasan, isi, gambar, tanggal) VALUES (?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssss", $judul, $ringkasan, $isi, $gambar);
        
        if ($stmt->execute()) {
            return mysqli_affected_rows($conn);
        } else {
            return false; 
        }
    }
}

if (!function_exists('update_artikel')) {
    function update_artikel($data, $file) {
        global $conn;

        $id = $data['id'];
        $judul = htmlspecialchars($data['judul']);
        $isi = htmlspecialchars($data['isi']);
        $ringkasan = substr($isi, 0, 150) . (strlen($isi) > 150 ? '...' : '');

        $gambar = null;
        if (isset($file['gambar']) && $file['gambar']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }
            $fileName = uniqid() . '_' . basename($file['gambar']['name']);
            $targetFilePath = $uploadDir . $fileName;

            if (move_uploaded_file($file['gambar']['tmp_name'], $targetFilePath)) {
                $gambar = 'uploads/' . $fileName;
            } else {
                return false; 
            }
        }

        if ($gambar) {
            $sql = "UPDATE artikel SET judul=?, ringkasan=?, isi=?, gambar=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssssi", $judul, $ringkasan, $isi, $gambar, $id);
        } else {
            $sql = "UPDATE artikel SET judul=?, ringkasan=?, isi=? WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $judul, $ringkasan, $isi, $id);
        }

        if ($stmt->execute()) {
            return mysqli_affected_rows($conn);
        } else {
            return false; 
        }
    }
}

if (!function_exists('getProfilPelamarByUserId')) {
    function getProfilPelamarByUserId($id_user) {
        global $conn;
        $sql = "SELECT * FROM pelamar_kerja WHERE id_user = ? LIMIT 1";
        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die('Query prepare gagal: ' . $conn->error . ' | SQL: ' . $sql);
        }
        $stmt->bind_param('i', $id_user);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result ? $result->fetch_assoc() : null;
    }
}

if (!function_exists('updateProfilPelamar')) {
    function updateProfilPelamar($id_user, $data, $file) {
        global $conn;
        $lama = getProfilPelamarByUserId($id_user);
        if (!$lama) return 0;

        $fields = [];
        $params = [];
        $types = '';
        $map = [
            'nama' => 'nama_lengkap',
            'email' => 'email',
            'telepon' => 'no_hp',
            'jabatan' => 'jabatan',
            'alamat' => 'alamat',
            'deskripsi' => 'deskripsi'
        ];
        foreach ($map as $formKey => $dbKey) {
            if (isset($data[$formKey]) && trim($data[$formKey]) !== '') {
                $fields[] = "$dbKey=?";
                $params[] = htmlspecialchars($data[$formKey]);
                $types .= 's';
            }
        }

        if (isset($data['pengalaman_jabatan']) && !empty(array_filter($data['pengalaman_jabatan']))) {
            $pengalaman = json_encode([
                'jabatan' => $data['pengalaman_jabatan'],
                'perusahaan' => $data['pengalaman_perusahaan'],
                'tahun' => $data['pengalaman_tahun']
            ]);
            $fields[] = "pengalaman=?";
            $params[] = $pengalaman;
            $types .= 's';
        }

        if (isset($data['keahlian']) && !empty($data['keahlian'])) {
            $keahlian = implode(',', $data['keahlian']);
            $fields[] = "keahlian=?";
            $params[] = $keahlian;
            $types .= 's';
        }

        if (isset($file['foto']) && $file['foto']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $fileName = uniqid() . '_' . basename($file['foto']['name']);
            $targetFilePath = $uploadDir . $fileName;
            if (move_uploaded_file($file['foto']['tmp_name'], $targetFilePath)) {
                $fields[] = "foto=?";
                $params[] = 'uploads/' . $fileName;
                $types .= 's';
            }
        }

        if (isset($file['cv']) && $file['cv']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '../uploads/';
            if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
            $fileName = uniqid() . '_' . basename($file['cv']['name']);
            $targetFilePath = $uploadDir . $fileName;
            if (move_uploaded_file($file['cv']['tmp_name'], $targetFilePath)) {
                $fields[] = "cv=?";
                $params[] = 'uploads/' . $fileName;
                $types .= 's';
            }
        }

        if (empty($fields)) return 0; 

        $sql = "UPDATE pelamar_kerja SET " . implode(', ', $fields) . " WHERE id_user=?";
        $params[] = $id_user;
        $types .= 'i';

        $stmt = $conn->prepare($sql);
        if (!$stmt) {
            die('Prepare failed: ' . $conn->error . ' | SQL: ' . $sql);
        }
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->affected_rows;
    }
}

if (!function_exists('getJumlahLoker')) {
    function getJumlahLoker() {
        global $conn;
        $sql = "SELECT COUNT(*) as total FROM lowongan";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }
}

if (!function_exists('getJumlahPerusahaan')) {
    function getJumlahPerusahaan() {
        global $conn;
        $sql = "SELECT COUNT(*) as total FROM perusahaan";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }
}

if (!function_exists('getJumlahUser')) {
    function getJumlahUser() {
        global $conn;
        $sql = "SELECT COUNT(*) as total FROM user"; 
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }
}

if (!function_exists('getJumlahArtikel')) {
    function getJumlahArtikel() {
        global $conn;
        $sql = "SELECT COUNT(*) as total FROM artikel";
        $result = mysqli_query($conn, $sql);
        $row = mysqli_fetch_assoc($result);
        return $row['total'] ?? 0;
    }
}

if (!function_exists('getAktivitasTerbaru')) {
    function getAktivitasTerbaru() {
        global $conn;
        $aktivitas = [];

        $sql1 = "SELECT id_user, created_at FROM user ORDER BY created_at DESC LIMIT 3";
        $res1 = mysqli_query($conn, $sql1);
        while ($row = mysqli_fetch_assoc($res1)) {
            $aktivitas[] = [
                "icon" => "👤",
                "pesan" => "User baru mendaftar: <span class='font-medium'>".$row['id_user']."</span>",
                "tanggal" => $row['created_at']
            ];
        }

        $sql2 = "SELECT id_perusahaan, created_at FROM lowongan ORDER BY created_at DESC LIMIT 3";
        $res2 = mysqli_query($conn, $sql2);
        while ($row = mysqli_fetch_assoc($res2)) {
            $aktivitas[] = [
                "icon" => "🏢",
                "pesan" => $row['id_perusahaan']." menambahkan lowongan",
                "tanggal" => $row['created_at']
            ];
        }

        $sql3 = "SELECT judul, created_at FROM artikel ORDER BY created_at DESC LIMIT 3";
        $res3 = mysqli_query($conn, $sql3);
        while ($row = mysqli_fetch_assoc($res3)) {
            $aktivitas[] = [
                "icon" => "📝",
                "pesan" => "Artikel baru dipublikasikan: <span class='font-medium'>".$row['judul']."</span>",
                "tanggal" => $row['created_at']
            ];
        }

        usort($aktivitas, function($a, $b) {
            return strtotime($b['tanggal']) - strtotime($a['tanggal']);
        });

        return array_slice($aktivitas, 0, 5);
    }
}

if (!function_exists('getStatistikBulanan')) {
    function getStatistikBulanan() {
        global $conn;

        $bulanIni = date("Y-m");
        $stat = [];

        $sql1 = "SELECT COUNT(*) as total FROM user WHERE DATE_FORMAT(created_at, '%Y-%m') = '$bulanIni'";
        $res1 = mysqli_query($conn, $sql1);
        $stat['user'] = mysqli_fetch_assoc($res1)['total'] ?? 0;

        $sql2 = "SELECT COUNT(*) as total FROM lowongan WHERE DATE_FORMAT(created_at, '%Y-%m') = '$bulanIni'";
        $res2 = mysqli_query($conn, $sql2);
        $stat['lowongan'] = mysqli_fetch_assoc($res2)['total'] ?? 0;

        return $stat;
    }
}

if (!function_exists('getPerusahaanBaru')) {
    function getPerusahaanBaru() {
        global $conn;
        $data = [];
        $sql = "SELECT nama_perusahaan, created_at FROM perusahaan ORDER BY created_at DESC LIMIT 5";
        $res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }
}

if (!function_exists('getArtikelTerbaru')) {
    function getArtikelTerbaru() {
        global $conn;
        $data = [];
        $sql = "SELECT id, judul, created_at FROM artikel ORDER BY created_at DESC LIMIT 5";
        $res = mysqli_query($conn, $sql);
        while ($row = mysqli_fetch_assoc($res)) {
            $data[] = $row;
        }
        return $data;
    }
}

if (!function_exists('getNotifikasi')) {
    function getNotifikasi() {
        global $conn;
        $notifikasi = [];

        $sql2 = "SELECT COUNT(*) as total FROM user WHERE created_at >= NOW() - INTERVAL 7 DAY";
        $res2 = mysqli_query($conn, $sql2);
        $row2 = mysqli_fetch_assoc($res2);
        if (($row2['total'] ?? 0) > 0) {
            $notifikasi[] = [
                "icon" => "🆕",
                "pesan" => $row2['total']." user baru mendaftar",
                "aksi" => "Lihat",
                "link" => "../pelamar/pelamar.php"
            ];
        }
        return $notifikasi;
    }
}

if (!function_exists('hitungPerusahaan')) {
    function hitungPerusahaan($status) {
        global $conn;
        if ($status === 'aktif') {
            $q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM perusahaan WHERE status='aktif'");
        } else {
            $q = mysqli_query($conn, "SELECT COUNT(*) AS total FROM perusahaan WHERE status!='aktif'");
        }
        $row = mysqli_fetch_assoc($q);
        return $row['total'] ?? 0;
    }
}

if (!function_exists('getPerusahaanPending')) {
    function getPerusahaanPending() {
        global $conn;
        $sql = "SELECT * FROM perusahaan WHERE verifikasi = 'belum'";
        $result = mysqli_query($conn, $sql);

        if (!$result) {
            die("Query Error: " . mysqli_error($conn));
        }

        $data = [];
        while ($row = mysqli_fetch_assoc($result)) {
            $data[] = $row;
        }
        return $data;
    }
}

if (!function_exists('verifikasiPerusahaan')) {
    function verifikasiPerusahaan($id, $aksi) {
        global $conn;
        $status = $aksi === 'setujui' ? 'aktif' : 'ditolak';
        $sql = "UPDATE perusahaan SET status='$status' WHERE id='$id'";
        return mysqli_query($conn, $sql);
    }
}

if (!function_exists('getPerusahaanAcc')) {
    function getPerusahaanAcc($keyword = '') {
        global $conn;
        $sql = "SELECT * FROM perusahaan WHERE verifikasi='setuju'";
        if (!empty($keyword)) {
            $keyword = mysqli_real_escape_string($conn, $keyword);
            $sql .= " AND nama_perusahaan LIKE '%$keyword%'";
        }

        $result = mysqli_query($conn, $sql);
        if (!$result) {
            die("Query error: " . mysqli_error($conn) . "<br>SQL: " . $sql);
        }
        return $result;
    }
}

function getLowonganList($keyword = '') {
  global $conn;
  $keyword = mysqli_real_escape_string($conn, $keyword);
  $sql = "SELECT l.*, p.nama_perusahaan 
          FROM lowongan l 
          JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan 
          WHERE p.nama_perusahaan LIKE '%$keyword%' 
          OR l.judul LIKE '%$keyword%' 
          ORDER BY l.tanggal_post DESC";

  $result = mysqli_query($conn, $sql);

  $data = [];
  if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
  }
  return $data; 
}

if (!function_exists('getUserList')) {
    function getUserList() {
        global $conn;
        $sql = "SELECT id_user, email, role, status_akun, created_at FROM user ORDER BY id_user DESC";
        $result = mysqli_query($conn, $sql);

        $data = [];
        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $data[] = $row;
            }
        }
        return $data;
    }
}

function tampil($query){
    global $conn;
    $result = mysqli_query($conn, $query);
    $rows = [];
    while ($row = mysqli_fetch_array($result)){
        $rows[] = $row;
    } return $rows;
}

function getPerusahaanMenunggu() {
    global $conn;
    // ambil perusahaan yang masih pending
    return mysqli_query($conn, "SELECT * FROM perusahaan WHERE verifikasi='pending'");
}

function getPerusahaanById($id_perusahaan) {
    global $conn;
    $q = mysqli_query($conn, "SELECT * FROM perusahaan WHERE id_perusahaan='$id_perusahaan'");
    return mysqli_fetch_assoc($q);
}

function verifikasiPerusahaan($id_perusahaan, $aksi) {
    global $conn;

    if ($aksi === "sudah") {
        $verifikasi = "sudah";
    } else {
        $verifikasi = "ditolak";
    }

    $sql = "UPDATE perusahaan SET verifikasi=? WHERE id_perusahaan=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $verifikasi, $id_perusahaan);
    return $stmt->execute();
}

function getPerusahaanPending() {
    global $conn;

    $sql = "SELECT * FROM perusahaan WHERE verifikasi='pending'";
    $result = $conn->query($sql);

    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
    return $data;
}
function cari($data){
    global $conn;
    $where = [];
    // search text
    if (!empty($data['search'])) {
        $keyword = mysqli_real_escape_string($conn, $data['search']);
        $where[] = "(p.nama_perusahaan LIKE '%$keyword%' OR l.posisi LIKE '%$keyword%' OR l.deskripsi LIKE '%$keyword%')";
    }

    // lokasi (select pertama di form punya label "Lokasi" tanpa value)
    if (!empty($data['lokasi']) && $data['lokasi'] !== 'Lokasi') {
        $lokasi = mysqli_real_escape_string($conn, $data['lokasi']);
        $where[] = "l.lokasi LIKE '%$lokasi%'";
    }

    // pendidikan (select pertama punya label "Pendidikan" tanpa value)
    if (!empty($data['pendidikan']) && $data['pendidikan'] !== 'Pendidikan') {
        $pendidikan = mysqli_real_escape_string($conn, $data['pendidikan']);
        // Jika kolom l.pendidikan berisi beberapa nilai dipisah koma (mis. "SMK,D3"),
        // maka cari apakah $pendidikan termasuk di antaranya.
        // REPLACE digunakan untuk menghilangkan spasi agar FIND_IN_SET bekerja juga pada "SMK, D3".
        $where[] = "(FIND_IN_SET('$pendidikan', REPLACE(l.pendidikan, ' ', '')) OR l.pendidikan LIKE '%$pendidikan%')";
    }

    // pengalaman dari select (aside) atau checkbox (header)
    $pengConditions = [];
    // select pengalaman
    if (!empty($data['pengalaman']) && $data['pengalaman'] !== 'Pengalaman') {
        if ($data['pengalaman'] === 'tanpa') {
            $pengConditions[] = "(l.pengalaman = '' OR l.pengalaman = '0')";
        } elseif ($data['pengalaman'] === '1-5') {
            $pengConditions[] = "(CAST(l.pengalaman AS UNSIGNED) BETWEEN 1 AND 5)";
        } elseif ($data['pengalaman'] === '>5') {
            $pengConditions[] = "(CAST(l.pengalaman AS UNSIGNED) > 5)";
        }
    }

    // checkbox alternatif dari header form
    if (isset($data['tanpa_pengalaman'])) {
        $pengConditions[] = "(l.pengalaman = '' OR l.pengalaman = '0')";
    }
    if (isset($data['satu_lima_tahun'])) {
        $pengConditions[] = "(CAST(l.pengalaman AS UNSIGNED) BETWEEN 1 AND 5)";
    }
    if (isset($data['lima_lebih_tahun'])) {
        $pengConditions[] = "(CAST(l.pengalaman AS UNSIGNED) > 5)";
    }

    if (!empty($pengConditions)) {
        // gabungkan OR antar opsi pengalaman, lalu jadikan satu kondisi AND dengan kondisi lain
        $where[] = '(' . implode(' OR ', array_unique($pengConditions)) . ')';
    }

    $sql = "SELECT l.*, p.nama_perusahaan 
            FROM lowongan l 
            JOIN perusahaan p ON l.id_perusahaan = p.id_perusahaan";

    if (!empty($where)) {
        $sql .= " WHERE " . implode(' AND ', $where);
    }

    $sql .= " ORDER BY l.tanggal_post DESC";

    return tampil($sql);
}
?>