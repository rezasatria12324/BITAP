<?php
include 'config.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $conn->query("DELETE FROM users WHERE id = $id");
}

header('Location: index.php?page=user');
exit;
?>
