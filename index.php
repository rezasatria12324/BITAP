<?php
    include "config.php";
?>


<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>

    <link rel="stylesheet" href="css/style.css">

    <!-- font awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <style>
       

    </style>
</head>
<body>

<!-- contoh -->
<!-- Wrapper -->
<div class="container">
    <div class="sidebar">

        <div class="header-sidebar">
            <div class="logo-wrapper">
                <img src="images/bitap-blue.png" alt="Logo" class="logo">
                <span class="logo-title">BITAP</span>
            </div>   
        </div>

    <button type="button" id="sidebarToggle" class="toggle">
        <i class="fas fa-chevron-circle-left"></i>
    </button>

        <div class="main-sidebar">
        <ul class="list-item">
            <li class="nav-item">
                <a href="index.php?page=pos">
                    <i class="fas fa-cash-register"></i> <span>POS</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="fas fa-tachometer-alt"></i> <span>Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=product">
                    <i class="fas fa-box"></i> <span>Product</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="index.php?page=member">
                    <i class="fas fa-user"></i> <span>Member</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="fas fa-exchange-alt"></i> <span>Transaction</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="fas fa-chart-line"></i> <span>Report</span>
                </a>
            </li>
            <li class="nav-item">
                <a href="#">
                    <i class="fas fa-cog"></i> <span>Setting</span>
                </a>
            </li>
        </ul>
        </div>
    </div>

    <div class="main-content">

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
                default:
                    include "pos.php";
                    break;
            }
        } else {
            include "pos.php";
        }
    ?>
    </div>

    <script>
        // Sidebar toggle functionality
        document.getElementById('sidebarToggle').addEventListener('click', function () {
            const sidebar = document.querySelector('.sidebar');
            sidebar.classList.toggle('active');

            const navLinks = document.querySelectorAll('.nav-item span');
            navLinks.forEach(link => {
                if (sidebar.classList.contains('active')) {
                    link.style.display = 'none';
                } else {
                    link.style.display = 'inline';
                }
            });
        });
    </script>


</div>  
</body>
</html>