<?php
include 'koneksi.php';

$sql = "CREATE TABLE IF NOT EXISTS inovasi (
    id int(11) NOT NULL AUTO_INCREMENT,
    kategori enum('pendidikan','pertanian','teknologi') NOT NULL,
    judul varchar(255) NOT NULL,
    deskripsi text NOT NULL,
    gambar varchar(255) DEFAULT NULL,
    tanggal date NOT NULL,
    status enum('active','inactive') DEFAULT 'active',
    created_at datetime DEFAULT current_timestamp(),
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci";

if ($conn->query($sql) === TRUE) {
    echo "Table inovasi berhasil dibuat!";
} else {
    echo "Error creating table: " . $conn->error;
}

$conn->close();
?> 