<?php
$servername = "localhost";   // biasanya localhost
$username = "u909529331_eduwisata";          // username database, default di XAMPP biasanya root
$password = "u909529331_Eduwisata";              // password database, default kosong di XAMPP
$database = "u909529331_eduwisata"; // ganti dengan nama database kamu

// Membuat koneksi
$conn = mysqli_connect($servername, $username, $password, $database);

// Cek koneksi
if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>