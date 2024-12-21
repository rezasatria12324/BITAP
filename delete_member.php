<?php
include "config.php";

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepared statement untuk menghindari SQL injection
    $stmt = $conn->prepare("DELETE FROM member WHERE id = ?");
    $stmt->bind_param("s", $id);
    
    if ($stmt->execute()) {
        echo "<script>alert('Member deleted successfully'); window.location.href='index.php?page=member';</script>";
    } else {
        echo "Error: " . $stmt->error;
    }
    $stmt->close();
}
?>
