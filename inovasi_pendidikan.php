<?php
include 'koneksi.php';
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inovasi Pendidikan - Pengembangan Inovasi</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    <main>
        <section class="section">
            <div class="container">
                <h2 class="section-title">Inovasi Pendidikan</h2>
                <p class="section-desc" style="text-align:center; max-width:700px; margin:0 auto 32px auto;">Berisi berbagai kegiatan, program, dan karya inovatif di bidang pendidikan yang mendukung pengembangan masyarakat dan pelestarian lingkungan.</p>
                <div class="inovasi-grid" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 32px; margin-top: 40px;">
                    <?php
                    $inovasi_list = $conn->query("SELECT * FROM inovasi WHERE kategori='pendidikan' AND status='active' ORDER BY tanggal DESC");
                    if ($inovasi_list->num_rows > 0):
                        while ($inovasi = $inovasi_list->fetch_assoc()):
                    ?>
                        <div class="inovasi-card" style="background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(44,62,80,0.10); padding: 32px 18px 28px 18px; text-align: center; transition: transform 0.3s ease, box-shadow 0.3s ease;">
                            <div style="font-size:2.5rem; color:#2563eb; margin-bottom:18px;"><i class="fa-solid fa-book-open"></i></div>
                            <?php if ($inovasi['gambar']): ?>
                                <img src="<?= htmlspecialchars($inovasi['gambar']) ?>" alt="<?= htmlspecialchars($inovasi['judul']) ?>" style="width: 100%; height: 200px; object-fit: cover; border-radius: 8px; margin-bottom: 20px;">
                            <?php endif; ?>
                            <h3 style="font-size:1.1rem; font-weight:700; margin-bottom:10px;"><?= htmlspecialchars($inovasi['judul']) ?></h3>
                            <p style="color:#555; margin-bottom:15px;"><?= htmlspecialchars(substr($inovasi['deskripsi'], 0, 150)) ?><?= strlen($inovasi['deskripsi']) > 150 ? '...' : '' ?></p>
                            <div style="color:#666; font-size:0.9rem;">
                                <i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($inovasi['tanggal'])) ?>
                            </div>
                            <a href="detail_inovasi.php?id=<?= $inovasi['id'] ?>" class="btn-primary" style="display: inline-block; margin-top: 15px; padding: 10px 20px; background: #2563eb; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">Lihat Detail</a>
                        </div>
                    <?php 
                        endwhile;
                    else:
                    ?>
                        <div class="inovasi-card" style="background: #fff; border-radius: 14px; box-shadow: 0 2px 12px rgba(44,62,80,0.10); padding: 32px 18px 28px 18px; text-align: center; grid-column: 1 / -1;">
                            <div style="font-size:2.5rem; color:#2563eb; margin-bottom:18px;"><i class="fa-solid fa-book-open"></i></div>
                            <h3 style="font-size:1.1rem; font-weight:700; margin-bottom:10px;">Belum ada inovasi pendidikan</h3>
                            <p style="color:#555;">Konten inovasi pendidikan akan ditampilkan di sini.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>
    <?php include 'footer.php'; ?>
    <script src="javascript.js"></script>
</body>
</html>