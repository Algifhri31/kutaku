<?php
session_start();
if (!isset($_SESSION['admin'])) {
    header("Location: login.html");
    exit;
}

include 'koneksi.php';

$judul = $_POST['judul'];
$isi = $_POST['isi'];

$stmt = $conn->prepare("INSERT INTO beritadb (judul, isi) VALUES (?, ?)");
$stmt->bind_param("ss", $judul, $isi);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "Berita berhasil ditambahkan. <a href='dashboard.php'>Kembali</a>";
} else {
    echo "Gagal menambahkan berita.";
}
?>