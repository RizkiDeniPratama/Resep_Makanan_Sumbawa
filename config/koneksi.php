<?php
// Konfigurasi database untuk website Resep Sumbawa
// File ini berisi pengaturan koneksi ke database MySQL

$host = 'localhost';        // Host database (biasanya localhost)
$username = 'root';         // Username database
$password = '';             // Password database (kosong untuk XAMPP default)
$database = 'resep_sumbawa'; // Nama database

try {
    // Membuat koneksi PDO ke database MySQL
    // PDO (PHP Data Objects) lebih aman dari mysqli karena mendukung prepared statements
    $pdo = new PDO("mysql:host=$host;dbname=$database;charset=utf8mb4", $username, $password);
    
    // Set error mode ke exception agar error bisa di-catch
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // Set default fetch mode ke associative array
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    // Jika koneksi gagal, tampilkan pesan error dan hentikan script
    die("Koneksi database gagal: " . $e->getMessage());
}

// Fungsi helper untuk escape HTML output (mencegah XSS)
function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}

// Fungsi untuk format waktu memasak
function formatWaktu($menit) {
    if ($menit >= 60) {
        $jam = floor($menit / 60);
        $sisaMenit = $menit % 60;
        return $jam . " jam" . ($sisaMenit > 0 ? " " . $sisaMenit . " menit" : "");
    }
    return $menit . " menit";
}
?>
