<?php
include 'koneksi.php';

// Sample data untuk inovasi
$sample_data = [
    [
        'kategori' => 'pendidikan',
        'judul' => 'Program Pelatihan Komputer untuk Masyarakat Pesisir',
        'deskripsi' => 'Program pelatihan komputer dasar yang ditujukan untuk meningkatkan keterampilan digital masyarakat pesisir. Program ini mencakup pengenalan komputer, penggunaan internet, dan aplikasi office dasar.',
        'tanggal' => '2024-01-15'
    ],
    [
        'kategori' => 'pendidikan',
        'judul' => 'Kelas Bahasa Inggris untuk Nelayan',
        'deskripsi' => 'Inisiatif pembelajaran bahasa Inggris yang disesuaikan dengan kebutuhan nelayan untuk komunikasi dengan turis asing dan ekspor hasil laut.',
        'tanggal' => '2024-01-20'
    ],
    [
        'kategori' => 'pertanian',
        'judul' => 'Sistem Hidroponik untuk Lahan Terbatas',
        'deskripsi' => 'Implementasi sistem hidroponik untuk memanfaatkan lahan terbatas di area pesisir. Sistem ini memungkinkan budidaya sayuran tanpa tanah dengan hasil yang optimal.',
        'tanggal' => '2024-01-10'
    ],
    [
        'kategori' => 'pertanian',
        'judul' => 'Pengembangan Budidaya Rumput Laut',
        'deskripsi' => 'Program pengembangan budidaya rumput laut yang ramah lingkungan dan memberikan nilai ekonomi tinggi bagi masyarakat pesisir.',
        'tanggal' => '2024-01-25'
    ],
    [
        'kategori' => 'teknologi',
        'judul' => 'Sistem Monitoring Kualitas Air Laut',
        'deskripsi' => 'Pengembangan sistem monitoring kualitas air laut menggunakan sensor IoT untuk mendukung konservasi lingkungan pesisir.',
        'tanggal' => '2024-01-05'
    ],
    [
        'kategori' => 'teknologi',
        'judul' => 'Aplikasi Mobile untuk Nelayan',
        'deskripsi' => 'Aplikasi mobile yang membantu nelayan mendapatkan informasi cuaca, harga ikan, dan rute penangkapan yang optimal.',
        'tanggal' => '2024-01-30'
    ]
];

$stmt = $conn->prepare("INSERT INTO inovasi (kategori, judul, deskripsi, tanggal) VALUES (?, ?, ?, ?)");

foreach ($sample_data as $data) {
    $stmt->bind_param("ssss", $data['kategori'], $data['judul'], $data['deskripsi'], $data['tanggal']);
    if ($stmt->execute()) {
        echo "Berhasil menambahkan: " . $data['judul'] . "\n";
    } else {
        echo "Error menambahkan: " . $data['judul'] . " - " . $stmt->error . "\n";
    }
}

$stmt->close();
$conn->close();

echo "\nData sample inovasi berhasil ditambahkan!";
?> 