<?php
include 'config.php';

if (isset($_GET['q'])) {
    $searchTerm = $_GET['q'];
    
    // Query untuk mencari member berdasarkan nama atau ID
    $sql = "SELECT * FROM member WHERE name LIKE ? OR id LIKE ?";
    $stmt = $conn->prepare($sql);
    $searchTerm = "%$searchTerm%";
    $stmt->bind_param('ss', $searchTerm, $searchTerm);
    $stmt->execute();
    $result = $stmt->get_result();

    // Menyiapkan array untuk menyimpan data member
    $members = [];
    while ($row = $result->fetch_assoc()) {
        $members[] = [
            'id' => $row['id'],
            'text' => $row['name']
        ];
    }

    // Mengembalikan hasil pencarian dalam format JSON
    echo json_encode(['members' => $members]);
}
?>
