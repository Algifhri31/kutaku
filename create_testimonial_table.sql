-- Buat tabel testimonial_pantai_sejarah jika belum ada
CREATE TABLE IF NOT EXISTS `testimonial_pantai_sejarah` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama` varchar(100) NOT NULL,
  `profesi` varchar(100) NOT NULL,
  `testimoni` text NOT NULL,
  `rating` int(1) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('pending','active','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci; 