<?php
$servername = "localhost"; // Ganti dengan server Anda
$username = "root";        // Ganti dengan username Anda
$password = "";            // Ganti dengan password Anda
$dbname = "db_bitap";         // Ganti dengan nama database Anda

// Buat koneksi
$conn = new mysqli($servername, $username, $password, $dbname);

// Cek koneksi
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
