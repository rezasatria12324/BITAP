<?php
include 'config.php';

if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    // Cek apakah ID yang akan dihapus ada di database
    $sql_check = "SELECT * FROM items WHERE product_id = '$delete_id'";
    $result = $conn->query($sql_check);

    if ($result->num_rows > 0) {
        // Hapus data jika ditemukan
        $sql_delete = "DELETE FROM items WHERE product_id = '$delete_id'";
        if ($conn->query($sql_delete) === TRUE) {
            header("Location: index.php?page=product&message=success");
        } else {
            header("Location: index.php?page=product&message=error");
        }
    } else {
        header("Location: index.php?page=product&message=not_found");
    }
    exit();
} else {
    header("Location: index.php?page=product&message=invalid_request");
    exit();
}
?>
