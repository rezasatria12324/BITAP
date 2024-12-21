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

// Ambil data transaksi
$sql = "SELECT * FROM transaksi a 
        JOIN detail_transaksi b ON a.id_transaksi = b.id_transaksi 
        JOIN items c ON c.product_id = b.product_id";

$result = $conn->query($sql);
?>

<div id="content">
    <main class="ms-sm-auto px-md-4">
            <div class="row mb-3">
                <div class="card py-3 text-center">
                    <h3 class="fw-bold mb-0" style="color: #0d6efd;">Transaction</h3>
                </div>
            </div>

<!-- Table to display transactions -->
<div class="card">
    <div class="card-header bg-primary text-white">
        <h5 class="mb-0">Transaction List</h5>
    </div>
    <div class="table-responsive p-3">
        <table id="transactionTable" class="table table-striped table-bordered align-middle">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Member Name</th>
                    <th>Name Items</th>
                    <th>Brand</th>
                    <th>Categories</th>
                    <th>Qty</th>
                    <th>Price</th>
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
                            </tr>";
                    }
                } else {
                    echo "<tr><td colspan='7' class='text-center'>No transactions found</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

    </main>
</div>


<script>
    $(document).ready(function () {
        $('.table').DataTable({
            "paging": true,
            "searching": true,
            "ordering": true,
            "info": true,
            "language": {
                "paginate": {
                    "previous": "&laquo;",
                    "next": "&raquo;"
                },
                "search": "Search:",
                "lengthMenu": "Display _MENU_ transactions per page"
            }
        });
    });
</script>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>