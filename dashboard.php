<?php
include "config.php";

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>

<?php
// Koneksi ke database
include 'config.php';

// Ambil data anggota
$sql = "SELECT * FROM transaksi a 
            JOIN detail_transaksi b ON a.id_transaksi = b.id_transaksi 
            JOIN items c ON c.product_id = b.product_id";

$result = $conn->query($sql);
?>

<!-- Main Content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2 class="mt-4">Dashboard</h2>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Transaction Details</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Member Name</th>
                            <th>Item Name</th>
                            <th>Brand</th>
                            <th>Category</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>Discount</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                // Ambil nama anggota jika ada, atau kosongkan
                                $member_result = mysqli_query($conn, "SELECT name FROM member WHERE id = {$row['id_member']}");
                                $member_name = ($member_result && $member_result->num_rows > 0) 
                                    ? $member_result->fetch_assoc()['name'] 
                                    : 'Regular Customer';

                                // Outputkan baris tabel
                                echo "<tr>
                                        <td>{$row['id_transaksi']}</td>
                                        <td>{$member_name}</td>
                                        <td>{$row['name_item']}</td>
                                        <td>{$row['brand']}</td>
                                        <td>{$row['category']}</td>
                                        <td>{$row['qty']}</td>
                                        <td>{$row['price']}</td>
                                        <td>{$row['total_discount']}</td>
                                    </tr>";
                            }
                        } else {
                            echo "<tr><td colspan='8' class='text-center'>No transaction found</td></tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</main>
