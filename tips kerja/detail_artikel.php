<?php

$judul_halaman = "Detail Artikel";
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
include '../header.php';

// Validate id
if ($id <= 0) {
    echo '<div style="max-width:900px;margin:30px auto;padding:20px;background:#fff;border-radius:16px;">';
    echo '<p>ID artikel tidak valid.</p>';
    echo '</div>';
    return;
}

// Query: join artikel with user and filter by artikel.id
$data = tampil("SELECT artikel.*, user.username, user.email
FROM artikel
JOIN user ON artikel.id_user = user.id_user
WHERE artikel.id = {$id} LIMIT 1");

// Normalize result to a single associative array
$artikel = null;
if (is_array($data)) {
    if (isset($data[0]) && is_array($data[0])) {
        $artikel = $data[0];
    } elseif (!empty($data)) {
        $artikel = $data;
    }
}

if (empty($artikel)) {
    echo '<div style="max-width:900px;margin:30px auto;padding:20px;background:#fff;border-radius:16px;">';
    echo '<p>Artikel tidak ditemukan.</p>';
    echo '</div>';
    return;
}

$title = htmlspecialchars($artikel['judul'] ?? 'Judul tidak tersedia');
$tanggal = !empty($artikel['tanggal']) ? date('d M Y', strtotime($artikel['tanggal'])) : '';
$author = htmlspecialchars($artikel['username'] ?? $artikel['email'] ?? 'Penulis');
$gambar = !empty($artikel['gambar']) ? $artikel['gambar'] : '../img/blank.png';
$isi_raw = $artikel['isi'] ?? '';
$isi = nl2br(htmlspecialchars($isi_raw));
?>

<div
    style="max-width:900px;margin:30px auto;padding:20px;background:#fff;border-radius:16px;box-shadow:0 2px 8px rgba(0,0,0,0.06);">
    <h1 style="font-size:2.5rem;font-weight:700;margin-bottom:0.5em;color:#23395d;"><?php echo $title; ?></h1>
    <span style="color:#5c6e7c;font-size:1.1rem;margin-bottom:1.5em;display:block;margin-bottom:1em;">
        <?php echo $tanggal; ?> &middot; oleh <?php echo $author; ?>
    </span>
    <div style="margin-bottom:2em;">
        <img src="../uploads/<?php echo htmlspecialchars($gambar); ?>" alt="<?php echo $title; ?>"
            style="width:100%;border-radius:16px;">
    </div>
    <div style="font-size:1.15rem;color:#374151;">
        <?php echo $isi; ?>
    </div>
    <div style="margin-top:2.5em;">
        <a href="../tips kerja/info_tips_kerja.php"
            class="inline-block px-10 py-3 text-lg font-medium rounded-xl bg-[#00646A] text-white shadow hover:bg-black transition-colors duration-200">
            &#8592; Kembali
        </a>
    </div>
</div>
<?php

?>