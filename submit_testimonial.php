<?php
session_start();
include 'koneksi.php';

// Fungsi untuk membersihkan input
function clean_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

// Proses form jika method POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama = clean_input($_POST['nama']);
    $profesi = clean_input($_POST['profesi']);
    $testimoni = clean_input($_POST['testimoni']);
    $rating = intval($_POST['rating']);
    
    // Validasi input
    $errors = array();
    
    if (empty($nama)) {
        $errors[] = "Nama harus diisi";
    }
    
    if (empty($profesi)) {
        $errors[] = "Profesi harus diisi";
    }
    
    if (empty($testimoni)) {
        $errors[] = "Testimoni harus diisi";
    }
    
    if ($rating < 1 || $rating > 5) {
        $errors[] = "Rating harus dipilih";
    }
    
    // Jika tidak ada error, simpan ke database
    if (empty($errors)) {
        // Simpan ke database tanpa avatar
        $stmt = $conn->prepare("INSERT INTO testimonial_pantai_sejarah (nama, profesi, testimoni, rating, status, created_at) VALUES (?, ?, ?, ?, 'pending', NOW())");
        $stmt->bind_param("sssi", $nama, $profesi, $testimoni, $rating);
        
        if ($stmt->execute()) {
            $_SESSION['success_message'] = "Testimoni Anda berhasil dikirim! Tim kami akan meninjau dan mempublikasikan testimoni Anda segera.";
        } else {
            $_SESSION['error_message'] = "Gagal mengirim testimoni. Silakan coba lagi.";
        }
        
        $stmt->close();
    } else {
        $_SESSION['error_message'] = implode(", ", $errors);
    }
}

// Redirect kembali ke halaman pantai-sejarah
header('Location: pantai-sejarah.php');
exit;
?> 