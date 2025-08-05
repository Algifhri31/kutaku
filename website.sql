-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 19 Jul 2025 pada 11.20
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `website`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `admin`
--

CREATE TABLE `admin` (
  `id` int(11) NOT NULL,
  `username` varchar(50) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `admin`
--

INSERT INTO `admin` (`id`, `username`, `password`) VALUES
(1, 'admin', 'admin123');

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `draft` text DEFAULT NULL,
  `penulis` varchar(100) DEFAULT NULL,
  `tanggal_dibuat` datetime DEFAULT current_timestamp(),
  `gambar` varchar(255) DEFAULT NULL,
  `status` varchar(20) DEFAULT 'active'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `berita`
--

INSERT INTO `berita` (`id`, `judul`, `draft`, `penulis`, `tanggal_dibuat`, `gambar`, `status`) VALUES
(8, 'Pelaku UMKM di Pantai Sejarah Batubara Dapat Bantuan Gerobak dan Tenda', 'Bantuan gerobak untuk UMKM di Pantai Sejarah Batubara (Dok.Istimewa)\r\nSelain mendukung perkembangan pariwisata juga mendukung pemulihan ekonomi nasional di Kabupaten Batubara.\r\n\r\nVice Presiden CSR/TJSL PT Inalum, Ali Hasian menyebutkan, perusahaan senantiasa berkomitmen dalam mendukung setiap aspek ekonomi dari wilayah di mana PT Inalum (Persero) beroperasi. Salah satu dukungan tersebut adalah keseriusan perusahaan dalam mendukung pertumbuhan ekonomi di sektor pariwisata Kabupaten Batu Bara.', 'Ali Haidar', '2025-05-23 22:32:35', 'uploads/1748014355_whatsapp-image-2022-06-17-at-80046-am-40a81fb49892cca3a938f52c3d9ea54e.jpeg', 'active'),
(9, 'Tim Survey KSE meninjau Eco Wisata Pantai Sejarah dan Kuta View', 'Tim Survey dari Karya Salemba Empat (KSE) melakukan kunjungan lapangan ke dua destinasi wisata unggulan di Kabupaten Batubara, yakni Eco Wisata Pantai Sejarah dan Kuta View, sebagai bagian dari upaya pemetaan potensi pengembangan pariwisata berkelanjutan berbasis edukasi dan pemberdayaan masyarakat.\r\n\r\nKunjungan ini merupakan bagian dari rangkaian program pengabdian masyarakat yang digagas oleh KSE, yang berfokus pada pelestarian lingkungan, penguatan ekonomi lokal, dan edukasi publik. Dalam kegiatan tersebut, tim survey melakukan observasi langsung, berdialog dengan pengelola wisata dan masyarakat sekitar, serta mengidentifikasi peluang dan tantangan dalam pengembangan kedua lokasi wisata tersebut.', 'Dhimas Kurniawan', '2025-06-07 08:49:15', 'uploads/1749260955_WhatsApp Image 2025-06-06 at 16.17.40.jpeg', 'active');

-- --------------------------------------------------------

--
-- Struktur dari tabel `inovasi`
--

CREATE TABLE `inovasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `kategori` enum('pendidikan','pertanian','teknologi') NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `tanggal` date NOT NULL,
  `status` enum('active','inactive') DEFAULT 'active',
  `created_at` datetime DEFAULT current_timestamp(),
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `galeri`
--

CREATE TABLE `galeri` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `sejarah`
--

CREATE TABLE `sejarah` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesan_kontak`
--

CREATE TABLE `pesan_kontak` (
  `id` int(11) NOT NULL,
  `nama` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `subjek` varchar(255) NOT NULL,
  `pesan` text NOT NULL,
  `created_at` timestamp DEFAULT current_timestamp(),
  `status` enum('unread','read','replied') DEFAULT 'unread'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `preview_galeri`
--

CREATE TABLE `preview_galeri` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) DEFAULT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) NOT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk_umkm`
--

CREATE TABLE `produk_umkm` (
  `id` int(11) NOT NULL,
  `nama_produk` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `harga` decimal(15,2) NOT NULL,
  `nomor_wa` varchar(20) DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur untuk tabel `objek_wisata`
--

CREATE TABLE `objek_wisata` (
  `id` int(11) NOT NULL,
  `nama_wisata` varchar(255) NOT NULL,
  `deskripsi` text DEFAULT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `urutan` int(11) DEFAULT 0,
  `status` enum('aktif','nonaktif') DEFAULT 'aktif',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `testimonial_pantai_sejarah`
--

CREATE TABLE `testimonial_pantai_sejarah` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `profesi` varchar(100) NOT NULL,
  `testimoni` text NOT NULL,
  `rating` int(1) NOT NULL,
  `avatar` varchar(255) DEFAULT NULL,
  `status` enum('pending','active','rejected') DEFAULT 'pending',
  `created_at` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `admin`
--
ALTER TABLE `admin`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`);

--
-- Indeks untuk tabel `berita`
--
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `inovasi`
--
--ALTER TABLE `inovasi`
 -- ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `galeri`
--
ALTER TABLE `galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `sejarah`
--
ALTER TABLE `sejarah`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesan_kontak`
--
ALTER TABLE `pesan_kontak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `preview_galeri`
--
ALTER TABLE `preview_galeri`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `produk_umkm`
--
ALTER TABLE `produk_umkm`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `objek_wisata`
--
ALTER TABLE `objek_wisata`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `testimonial_pantai_sejarah`
--
ALTER TABLE `testimonial_pantai_sejarah`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `admin`
--
ALTER TABLE `admin`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- AUTO_INCREMENT untuk tabel `berita`
--
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `inovasi`
--
ALTER TABLE `inovasi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `galeri`
--
ALTER TABLE `galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `sejarah`
--
ALTER TABLE `sejarah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `pesan_kontak`
--
ALTER TABLE `pesan_kontak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `preview_galeri`
--
ALTER TABLE `preview_galeri`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `produk_umkm`
--
ALTER TABLE `produk_umkm`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `objek_wisata`
--
ALTER TABLE `objek_wisata`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `testimonial_pantai_sejarah`
--
ALTER TABLE `testimonial_pantai_sejarah`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
