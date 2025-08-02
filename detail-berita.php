<?php
include 'koneksi.php';

// Ambil ID dari URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$berita = null;
if ($id > 0) {
    $query = mysqli_query($conn, "SELECT * FROM berita WHERE id = $id AND status = 'active' LIMIT 1");
    if ($query && mysqli_num_rows($query) > 0) {
        $berita = mysqli_fetch_assoc($query);
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detail Berita<?= $berita ? ' - ' . htmlspecialchars($berita['judul']) : '' ?></title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            background: #f4f6fb;
        }
        .detail-container {
            max-width: 700px;
            margin: 40px auto;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 4px 24px rgba(0,0,0,0.08);
            padding: 32px 28px 24px 28px;
        }
        .detail-title {
            font-size: 2rem;
            color: #2d3a4b;
            margin-bottom: 10px;
        }
        .detail-meta {
            color: #888;
            font-size: 15px;
            margin-bottom: 18px;
        }
        .detail-img {
            width: 100%;
            max-height: 350px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 22px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.07);
        }
        .detail-content {
            font-size: 1.1rem;
            color: #333;
            line-height: 1.7;
        }
        .back-link {
            display: inline-block;
            margin-top: 28px;
            color: #fff;
            background: #4f8cff;
            padding: 10px 22px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: background 0.2s;
        }
        .back-link:hover {
            background: #2563eb;
        }
        .notfound {
            text-align: center;
            color: #d32f2f;
            font-size: 1.2rem;
            padding: 40px 0;
        }
    </style>
</head>
<body>
    <div class="detail-container">
        <?php if ($berita): ?>
            <div class="detail-title"><?= htmlspecialchars($berita['judul']) ?></div>
            <div class="detail-meta">
                Oleh <b><?= htmlspecialchars($berita['penulis']) ?></b> |
                <?= date('d M Y', strtotime($berita['tanggal_dibuat'])) ?>
            </div>
            <?php if (!empty($berita['gambar'])): ?>
                <img src="<?= htmlspecialchars($berita['gambar']) ?>" alt="Gambar Berita" class="detail-img" />
            <?php endif; ?>
            <div class="detail-content">
                <?= nl2br($berita['draft']) ?>
            </div>
            <a href="index.php#blog" class="back-link">&larr; Kembali ke Berita</a>
        <?php else: ?>
            <div class="notfound">Berita tidak ditemukan atau sudah tidak aktif.</div>
            <a href="index.php#blog" class="back-link">&larr; Kembali ke Berita</a>
        <?php endif; ?>
    </div>
</body>
</html> 