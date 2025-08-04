<?php
include 'koneksi.php';

// Cek apakah table inovasi ada
$result = $conn->query("SHOW TABLES LIKE 'inovasi'");
if ($result->num_rows > 0) {
    echo "Table inovasi ada.\n";
    
    // Cek struktur table
    $result = $conn->query("DESCRIBE inovasi");
    echo "\nStruktur table inovasi:\n";
    while ($row = $result->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
} else {
    echo "Table inovasi tidak ada.\n";
}

$conn->close();
?> 