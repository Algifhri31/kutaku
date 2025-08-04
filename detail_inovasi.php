<?php
include 'koneksi.php';

// Get inovasi ID from URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch inovasi data
$stmt = $conn->prepare("SELECT * FROM inovasi WHERE id = ? AND status = 'active'");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$inovasi = $result->fetch_assoc();

// If inovasi not found, redirect to home
if (!$inovasi) {
    header('Location: index.php');
    exit;
}

// Get related inovasi (same category)
$stmt = $conn->prepare("SELECT * FROM inovasi WHERE kategori = ? AND id != ? AND status = 'active' ORDER BY tanggal DESC LIMIT 3");
$stmt->bind_param("si", $inovasi['kategori'], $id);
$stmt->execute();
$related_result = $stmt->get_result();
$related_inovasi = [];
while ($row = $related_result->fetch_assoc()) {
    $related_inovasi[] = $row;
}

$stmt->close();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($inovasi['judul']) ?> - Detail Inovasi</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
</head>
<body>
    <?php include 'navbar.php'; ?>
    
    <main>
        <section class="section">
            <div class="container">
                <!-- Breadcrumb -->
                <div class="breadcrumb" style="margin-bottom: 30px;">
                    <a href="index.php" style="color: #666; text-decoration: none;">Beranda</a>
                    <span style="margin: 0 10px; color: #ccc;">/</span>
                    <a href="index.php#team" style="color: #666; text-decoration: none;">Pengembangan Inovasi</a>
                    <span style="margin: 0 10px; color: #ccc;">/</span>
                    <a href="inovasi_<?= $inovasi['kategori'] ?>.php" style="color: #666; text-decoration: none;"><?= ucfirst($inovasi['kategori']) ?></a>
                    <span style="margin: 0 10px; color: #ccc;">/</span>
                    <span style="color: #333; font-weight: 600;"><?= htmlspecialchars($inovasi['judul']) ?></span>
                </div>

                <!-- Main Content -->
                <div class="detail-inovasi-grid" style="display: grid; grid-template-columns: 2fr 1fr; gap: 40px; margin-bottom: 40px;">
                    <!-- Left Column - Main Content -->
                    <div class="detail-inovasi">
                        <h1 style="font-size: 2.5rem; font-weight: 700; margin-bottom: 20px; color: #333;"><?= htmlspecialchars($inovasi['judul']) ?></h1>
                        
                        <div style="margin-bottom: 20px; color: #666; font-size: 0.95rem;">
                            <i class="fas fa-calendar"></i> <?= date('d F Y', strtotime($inovasi['tanggal'])) ?>
                            <span style="margin: 0 15px;">•</span>
                            <i class="fas fa-tag"></i> <?= ucfirst($inovasi['kategori']) ?>
                        </div>

                        <?php if ($inovasi['gambar']): ?>
                            <div style="margin-bottom: 30px;">
                                <img src="<?= htmlspecialchars($inovasi['gambar']) ?>" alt="<?= htmlspecialchars($inovasi['judul']) ?>" style="width: 100%; max-height: 400px; object-fit: cover; border-radius: 12px; box-shadow: 0 4px 20px rgba(0,0,0,0.1);">
                            </div>
                        <?php endif; ?>

                        <div style="line-height: 1.8; color: #555; font-size: 1.1rem;">
                            <?= nl2br(htmlspecialchars($inovasi['deskripsi'])) ?>
                        </div>
                    </div>

                    <!-- Right Column - Sidebar -->
                    <div>
                        <!-- Category Info -->
                        <div style="background: #f8f9fa; padding: 25px; border-radius: 12px; margin-bottom: 25px;">
                            <h3 style="margin-bottom: 15px; color: #333; font-size: 1.2rem;">
                                <?php
                                $icon_color = '';
                                $icon = '';
                                switch($inovasi['kategori']) {
                                    case 'pendidikan':
                                        $icon_color = '#2563eb';
                                        $icon = 'fa-book-open';
                                        break;
                                    case 'pertanian':
                                        $icon_color = '#16a34a';
                                        $icon = 'fa-leaf';
                                        break;
                                    case 'teknologi':
                                        $icon_color = '#f59e42';
                                        $icon = 'fa-microchip';
                                        break;
                                }
                                ?>
                                <i class="fa-solid <?= $icon ?>" style="color: <?= $icon_color ?>; margin-right: 10px;"></i>
                                Inovasi <?= ucfirst($inovasi['kategori']) ?>
                            </h3>
                            <p style="color: #666; line-height: 1.6;">
                                <?php
                                switch($inovasi['kategori']) {
                                    case 'pendidikan':
                                        echo 'Kegiatan dan program inovatif di bidang pendidikan yang mendukung pengembangan masyarakat dan pelestarian lingkungan.';
                                        break;
                                    case 'pertanian':
                                        echo 'Inovasi pertanian yang mendukung keberlanjutan dan kesejahteraan masyarakat pesisir.';
                                        break;
                                    case 'teknologi':
                                        echo 'Teknologi terapan untuk mendukung konservasi dan pengelolaan sumber daya alam.';
                                        break;
                                }
                                ?>
                            </p>
                        </div>

                        <!-- Related Inovasi -->
                        <?php if (!empty($related_inovasi)): ?>
                            <div>
                                <h3 style="margin-bottom: 20px; color: #333; font-size: 1.2rem;">Inovasi Terkait</h3>
                                <?php foreach ($related_inovasi as $related): ?>
                                    <div style="background: white; border-radius: 8px; padding: 15px; margin-bottom: 15px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                                        <?php if ($related['gambar']): ?>
                                            <img src="<?= htmlspecialchars($related['gambar']) ?>" alt="<?= htmlspecialchars($related['judul']) ?>" style="width: 100%; height: 120px; object-fit: cover; border-radius: 6px; margin-bottom: 10px;">
                                        <?php endif; ?>
                                        <h4 style="font-size: 1rem; margin-bottom: 8px; color: #333;">
                                            <a href="detail_inovasi.php?id=<?= $related['id'] ?>" style="color: inherit; text-decoration: none;"><?= htmlspecialchars($related['judul']) ?></a>
                                        </h4>
                                        <p style="color: #666; font-size: 0.9rem; margin-bottom: 8px;"><?= htmlspecialchars(substr($related['deskripsi'], 0, 80)) ?>...</p>
                                        <div style="color: #999; font-size: 0.8rem;">
                                            <i class="fas fa-calendar"></i> <?= date('d/m/Y', strtotime($related['tanggal'])) ?>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>

                <!-- Back Button -->
                <div style="text-align: center; margin-top: 40px;">
                    <a href="inovasi_<?= $inovasi['kategori'] ?>.php" class="btn-primary" style="display: inline-block; padding: 12px 30px; background: #2563eb; color: white; text-decoration: none; border-radius: 8px; font-weight: 600;">
                        <i class="fas fa-arrow-left" style="margin-right: 8px;"></i>
                        Kembali ke Inovasi <?= ucfirst($inovasi['kategori']) ?>
                    </a>
                </div>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>
    <script src="javascript.js"></script>
</body>
</html> 