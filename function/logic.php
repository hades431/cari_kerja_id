<?php 
$conn = mysqli_connect("localhost","root","","lowongan_kerja");

if (mysqli_connect_errno()){
    echo "Koneksi database gagal : " . mysqli_connect_error(); 
    exit;
}

function profilPelamar($nik) {
    global $conn;

    $nama_lengkap = htmlspecialchars($_POST['nama_lengkap']);
    $email = htmlspecialchars($_POST['email']);
    $no_hp = htmlspecialchars($_POST['no_hp']);
    $alamat = htmlspecialchars($_POST['alamat']);
    $deskripsi = htmlspecialchars($_POST['deskripsi']);
    $cv = upload();

    $query = "INSERT INTO pengaduan VALUES ('','$nama_lengkap','$email','$no_hp','$alamat','$deskripsi','$cv','proses')";
    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

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

function menu_aktif($page) {
    $menuAktif = [
        'dashboard' => false,
        'lowongan' => false,
        'perusahaan' => false,
        'pelamar' => false,
        'artikel' => false,
        'logout' => false
    ];

    if (array_key_exists($page, $menuAktif)) {
        $menuAktif[$page] = true;
    }

    return $menuAktif;
}

function searchArtikel($keyword) {
    global $conn;
    $sql = "SELECT * FROM artikel WHERE judul LIKE ?";
    $stmt = $conn->prepare($sql);
    $like = "%$keyword%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

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

?>
