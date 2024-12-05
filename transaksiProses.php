<?php
include "config.php";

$sub_total = floatval($_POST['totalPrice']);
$discount_member = floatval($_POST['totalMemberDiscount']);
$total_discount = floatval($_POST['totalDiscount'] + $discount_member);
$pajak = floatval($_POST['totalTax']);
$total = floatval($_POST['totalWithTaxAndDiscount']);
$total_bayar = floatval($_POST['pembayaran']);
$kembalian = floatval($_POST['kembalian']);
$id_member = isset($_POST['member']['id']) ? intval($_POST['member']['id']) : NULL;

$today = date("Ymd");
$transactionIdPrefix = $today;

$sqlMaxId = "SELECT MAX(CAST(id_transaksi AS UNSIGNED)) AS last_number 
             FROM transaksi WHERE id_transaksi LIKE '$today%'";
$resultMaxId = $conn->query($sqlMaxId);

if ($resultMaxId->num_rows > 0) {
    $row = $resultMaxId->fetch_assoc();
    $lastNumber = $row['last_number'] ?? 0;
    $newTransactionNumber = str_pad($lastNumber + 1, 4, "0", STR_PAD_LEFT);
} else {
    $newTransactionNumber = "0001";
}

$id_transaksi = $transactionIdPrefix . $newTransactionNumber;

$sql = "INSERT INTO transaksi (id_transaksi, id_member, tanggal_transaksi, sub_total, discount_member, total_discount, 
        pajak, total, total_bayar, kembalian) 
        VALUES ('$id_transaksi', '$id_member', NOW(), '$sub_total', '$discount_member', '$total_discount', 
        '$pajak', '$total', '$total_bayar', '$kembalian')";

if ($conn->query($sql) === TRUE) {
    if (isset($_POST['cartItems'])) {
        foreach ($_POST['cartItems'] as $item) {
            $product_id = intval($item['id']);
            $qty = intval($item['quantity']);
            $price = floatval($item['price']);
            $discount = floatval($item['discount']);
            $discount_per_unit = $price * ($discount / 100);
            $total_price = ($qty * $price) - ($qty * $discount_per_unit);

            $sqlDetail = "INSERT INTO detail_transaksi (id_transaksi, product_id, qty, price, discount, total_price) 
                          VALUES ('$id_transaksi', '$product_id', '$qty', '$price', '$discount_per_unit', '$total_price')";

            if (!$conn->query($sqlDetail)) {
                echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan detail transaksi']);
                exit();
            }

            $sqlUpdateStock = "UPDATE items 
                               SET stock = stock - $qty 
                               WHERE product_id = $product_id";

            if (!$conn->query($sqlUpdateStock)) {
                echo json_encode(['status' => 'error', 'message' => 'Gagal mengurangi stok produk']);
                exit();
            }
        }
    }

    echo json_encode(['status' => 'success', 'message' => 'Transaksi berhasil disimpan']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan transaksi']);
}

$conn->close();
?>
