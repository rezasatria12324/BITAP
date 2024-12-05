<?php
// Koneksi ke database
include 'config.php';


// Ambil data anggota
$sql = "SELECT * FROM transaksi a join detail_transaksi b on a.id_transaksi = b.id_transaksi 
join items c on c.product_id = b.product_id" ;

$result = $conn->query($sql);



?>
<!-- Main Content -->
<main class="col-md-9 ms-sm-auto col-lg-10 px-md-4">
    <h2 class="mt-4">Transaction</h2>

    

    <div class="card">
        <div class="container pt-2">
        <?php
        // var_dump($result->fetch_assoc()); 
        ?>
        <table  class="table table-bordered">
            <thead>
            
                <tr>
                    <th>Id</th>
                    <th>Member Name</th>
                    <th>Name Items</th>
                    <th>Brand</th>
                    <th>Categories</th>
                    <th>Qty</th>
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
                echo "<tr><td colspan='8'>No transaction found</td></tr>";
            }
            ?>

            </tbody>
        </table>
        </div>
    </div>
</main>
