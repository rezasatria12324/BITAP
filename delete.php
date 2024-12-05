<?php
include 'config.php';

// Ambil ID produk dari URL
$product_id = $_GET['id'];

// Hapus produk dari database
$sql = "DELETE FROM items WHERE product_id = '$product_id'";

if ($conn->query($sql) === TRUE) {
    echo "Product deleted successfully";
    header("Location: product.php"); // Kembali ke halaman utama
    exit;
} else {
    echo "Error deleting record: " . $conn->error;
}
?>
