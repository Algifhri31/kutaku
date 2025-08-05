<?php
session_start();
include 'koneksi.php';

// Ambil ID galeri dari parameter URL
$id = isset($_GET['id']) ? intval($_GET['id']) : 0;
$type = isset($_GET['type']) ? $_GET['type'] : 'galeri';

$gallery_item = null;

if ($type == 'galeri') {
    // Ambil data dari tabel galeri
    $stmt = $conn->prepare("SELECT * FROM galeri WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $gallery_item = $result->fetch_assoc();
    }
} else if ($type == 'objek_wisata') {
    // Ambil data dari tabel objek_wisata
    $stmt = $conn->prepare("SELECT * FROM objek_wisata WHERE id = ? AND status = 'aktif'");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result && $result->num_rows > 0) {
        $gallery_item = $result->fetch_assoc();
    }
}

// Jika tidak ada data, redirect ke galeri
if (!$gallery_item) {
    header('Location: galeri.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($gallery_item['judul'] ?? $gallery_item['nama_wisata']) ?> - Eco Wisata Mangrove Park</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <style>
        .detail-container {
            max-width: 900px;
            margin: 0 auto;
            padding: 40px 20px;
        }
        .detail-image {
            width: 100%;
            max-width: 800px;
            height: 500px;
            object-fit: cover;
            border-radius: 15px;
            margin-bottom: 30px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
        }
        .detail-info {
            background: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .detail-title {
            font-size: 2.5rem;
            color: #2c3e50;
            margin-bottom: 15px;
            font-weight: 700;
        }
        .detail-description {
            font-size: 1.1rem;
            line-height: 1.8;
            color: #555;
            margin-bottom: 25px;
        }
        .detail-meta {
            display: flex;
            gap: 30px;
            margin-bottom: 30px;
            flex-wrap: wrap;
        }
        .meta-item {
            display: flex;
            align-items: center;
            gap: 10px;
            color: #666;
        }
        .meta-item i {
            color: #3498db;
            font-size: 1.2rem;
        }
        .back-button {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: #3498db;
            color: white;
            padding: 12px 25px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            margin-bottom: 30px;
        }
        .back-button:hover {
            background: #2980b9;
            transform: translateY(-2px);
        }
        .related-gallery {
            margin-top: 50px;
        }
        .related-title {
            font-size: 1.8rem;
            color: #2c3e50;
            margin-bottom: 20px;
            text-align: center;
        }
        .related-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-top: 30px;
        }
        .related-item {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }
        .related-item:hover {
            transform: translateY(-5px);
        }
        .related-item img {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }
        .related-info {
            padding: 15px;
            background: white;
        }
        .related-info h4 {
            margin: 0 0 10px 0;
            color: #2c3e50;
        }
        .related-info p {
            margin: 0;
            color: #666;
            font-size: 0.9rem;
        }
        @media (max-width: 768px) {
            .detail-container {
                padding: 20px 15px;
            }
            .detail-image {
                height: 300px;
            }
            .detail-title {
                font-size: 2rem;
            }
            .detail-meta {
                flex-direction: column;
                gap: 15px;
            }
        }
    </style>
</head>
<body>

    <div class="container-full">
        <div class="detail-container">
            <a href="galeri.php" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Kembali ke Galeri
            </a>

            <div class="detail-info">
                <img src="<?= htmlspecialchars($gallery_item['gambar']) ?>" alt="<?= htmlspecialchars($gallery_item['judul'] ?? $gallery_item['nama_wisata']) ?>" class="detail-image">

                <h1 class="detail-title"><?= htmlspecialchars($gallery_item['judul'] ?? $gallery_item['nama_wisata']) ?></h1>

                <div class="detail-meta">
                    <div class="meta-item">
                        <i class="fas fa-calendar"></i>
                        <span>Dibuat: <?= date('d F Y', strtotime($gallery_item['created_at'])) ?></span>
                    </div>
                    <div class="meta-item">
                        <i class="fas fa-image"></i>
                        <span>Kategori: <?= $type == 'galeri' ? 'Galeri Foto' : 'Objek Wisata' ?></span>
                    </div>
                    <?php if ($type == 'objek_wisata' && isset($gallery_item['urutan'])): ?>
                    <div class="meta-item">
                        <i class="fas fa-sort-numeric-up"></i>
                        <span>Urutan: <?= $gallery_item['urutan'] ?></span>
                    </div>
                    <?php endif; ?>
                </div>

                <div class="detail-description">
                    <?= nl2br(htmlspecialchars($gallery_item['deskripsi'])) ?>
                </div>
            </div>

            <!-- RELATED GALLERY -->
            <div class="related-gallery">
                <h2 class="related-title">Foto Lainnya</h2>
                <div class="related-grid">
                    <?php
                    // Ambil 4 foto lainnya dari galeri
                    $related_query = "SELECT * FROM galeri WHERE id != ? AND judul IS NOT NULL AND judul != '' ORDER BY created_at DESC LIMIT 4";
                    $stmt = $conn->prepare($related_query);
                    $stmt->bind_param("i", $id);
                    $stmt->execute();
                    $related_result = $stmt->get_result();

                    while ($related = $related_result->fetch_assoc()) {
                        echo "<div class='related-item'>";
                        echo "<a href='detail-galeri.php?id=" . $related['id'] . "&type=galeri'>";
                        echo "<img src='" . htmlspecialchars($related['gambar']) . "' alt='" . htmlspecialchars($related['judul']) . "'>";
                        echo "<div class='related-info'>";
                        echo "<h4>" . htmlspecialchars($related['judul']) . "</h4>";
                        echo "<p>" . htmlspecialchars(substr($related['deskripsi'], 0, 100)) . "...</p>";
                        echo "</div>";
                        echo "</a>";
                        echo "</div>";
                    }

                    // Jika kurang dari 4, tambahkan dari objek_wisata
                    $remaining = 4 - $related_result->num_rows;
                    if ($remaining > 0) {
                        $objek_query = "SELECT * FROM objek_wisata WHERE status = 'aktif' AND gambar IS NOT NULL AND gambar != '' ORDER BY urutan ASC LIMIT ?";
                        $stmt = $conn->prepare($objek_query);
                        $stmt->bind_param("i", $remaining);
                        $stmt->execute();
                        $objek_result = $stmt->get_result();

                        while ($objek = $objek_result->fetch_assoc()) {
                            echo "<div class='related-item'>";
                            echo "<a href='detail-galeri.php?id=" . $objek['id'] . "&type=objek_wisata'>";
                            echo "<img src='" . htmlspecialchars($objek['gambar']) . "' alt='" . htmlspecialchars($objek['nama_wisata']) . "'>";
                            echo "<div class='related-info'>";
                            echo "<h4>" . htmlspecialchars($objek['nama_wisata']) . "</h4>";
                            echo "<p>" . htmlspecialchars(substr($objek['deskripsi'], 0, 100)) . "...</p>";
                            echo "</div>";
                            echo "</a>";
                            echo "</div>";
                        }
                    }
                    ?>
                </div>
            </div>
        </div>

        <!-- FOOTER -->
        <footer id="contact">
            <div class="footer-grid">
                <div>
                    <h5>Informasi</h5>
                    <p>Eco Wisata Mangrove Park adalah destinasi wisata alam yang menawarkan pengalaman unik menjelajahi ekosistem mangrove dengan pemandangan yang memukau dan udara yang segar.</p>
                </div>
                <div>
                    <h5>Kontak</h5>
                    <p><i class="fas fa-map-marker-alt"></i> Jl. Pantai Perupuk, Kec. Tanjung Bunga<br>
                    <i class="fas fa-phone"></i> +62 812-3456-7890<br>
                    <i class="fas fa-envelope"></i> info@ecowisatamangrove.com</p>
                </div>
                <div>
                    <h5>Jam Operasional</h5>
                    <p><i class="fas fa-clock"></i> Senin - Minggu<br>
                    08:00 - 17:00 WIB<br>
                    <i class="fas fa-ticket-alt"></i> Tiket: Rp 25.000/orang</p>
                </div>
                <div>
                    <h5>Lokasi</h5>
                    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15933.350915208945!2d99.5305239!3d3.26608285!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3033c76efa846e87%3A0x5a8951815a32f425!2sPantai%20Sejarah%20Pantai%20Perupuk!5e0!3m2!1sen!2sid!4v1747710129374!5m2!1sen!2sid" width="100%" height="150" style="border: none; border-radius: 10px; box-shadow: 0 4px 8px rgba(0,0,0,0.2);" allowfullscreen="" loading="lazy"></iframe>
                    <div class="footer-social">
                        <a href="#" class="footer-social-link" aria-label="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="footer-social-link" aria-label="Facebook"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="footer-social-link" aria-label="TikTok"><i class="fab fa-tiktok"></i></a>
                        <a href="#" class="footer-social-link" aria-label="WhatsApp"><i class="fab fa-whatsapp"></i></a>
                    </div>
                </div>
            </div>
            <div style='text:center; color:#fff; align-items: center; justify-content: center;display: flex;'>
                <p>&copy; 2025 Kutaku Sejahtera. All rights reserved.</p>
            </div>
        </footer>
    </div>

    <script src="javascript.js"></script>
</body>
</html>