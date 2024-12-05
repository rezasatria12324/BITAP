<?php include "header.php"; ?>

<!-- Wrapper -->
<div class="wrapper">
    <?php include "sidebar.php"; ?>

    <!-- Content -->
    <?php
        if (isset($_GET['page'])) {
            $pages = $_GET['page'];
            switch ($pages) {
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
                default:
                    include "pos.php";
                    break;
            }
        } else {
            include "pos.php";
        }
    ?>

    <script>
        // Sidebar toggle functionality
        $('#sidebarToggle').on('click', function (e) {
            e.preventDefault();
            $('#sidebar').toggleClass('active');  // Toggle sidebar visibility
            $('#content').toggleClass('active');  // Adjust content area when sidebar is active
        });
    </script>


<?php include "footer.php"; ?>
