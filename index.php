<?php
session_start();
include "config.php";

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit();
}

$role = $_SESSION['role'];
?>

<?php include "header.php"; ?>

<!-- Wrapper -->
<div class="wrapper">
    <?php include "sidebar.php"; ?>

    <!-- Content -->
    <?php
        if (isset($_GET['page'])) {
            $pages = $_GET['page'];
            switch ($pages) {
                case 'dashboard':
                    include "dashboard.php";
                    break;
                case 'product':
                    include "product.php";
                    break;
                case 'member':
                    include "member.php";
                    break;
                case 'pembayaran':
                    include "pembayaran.php";
                    break;
                case 'transaction':
                    include "transaction.php";
                    break;
                case 'user':
                    if ($role === 'admin') {
                        include "User.php";
                    } else {
                        echo "<script>
                            Swal.fire({
                                icon: 'error',
                                title: 'Akses Ditolak!',
                                text: 'Anda tidak memiliki izin untuk mengakses halaman ini.'
                            }).then(() => {
                                window.location.href = 'index.php';
                            });
                        </script>";
                    }
                    break;
                default:
                    include "pos.php";
                    break;
            }
        } else {
            include "pos.php";
        }
    ?>

    <script>
        // Mengambil elemen-elemen yang diperlukan
        const sidebar = document.getElementById("sidebar");
        const content = document.getElementById("content");
        const sidebarToggle = document.getElementById("sidebarToggle");

        // Menambahkan event listener untuk tombol toggle
        sidebarToggle.addEventListener("click", () => {
        // Menambahkan atau menghapus kelas active untuk sidebar dan konten
        sidebar.classList.toggle("active");
        content.classList.toggle("active");
        
        // Menambahkan atau menghapus kelas collapsed untuk menyembunyikan teks di sidebar
        sidebar.classList.toggle("collapsed");
        });
    </script>


<?php include "footer.php"; ?>
