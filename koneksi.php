<?php
$servername = "localhost";   // biasanya localhost
$username = "root";          // username database, default di XAMPP biasanya root
$password = "";              // password database, default kosong di XAMPP
$database = "website"; // ganti dengan nama database kamu

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>