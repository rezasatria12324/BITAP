
<!-- ------------- Index.php ------------- -->
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



<!-- ------------ sidebar.php --------------- -->
<!-- Sidebar -->
<nav id="sidebar" class="bg-dark">

<div class="logo-wrapper">
    <img src="images/bitap-blue.png" alt="Logo" class="img-fluid">
    <p>Bitap</p>
</div>

<button type="button" id="sidebarToggle" class="btn btn-primary">
    <i class="fas fa-chevron-circle-left"></i>
</button>

<ul class="list-unstyled components">
    <li class="nav-item">
        <a class="nav-link active" href="index.php?page=pos">
            <i class="fas fa-cash-register"></i> POS
        </a>
    </li>
    <li class="nav-item">
        <a href="#">
            <i class="fas fa-tachometer-alt"></i> Dashboard
        </a>
    </li>
    <li class="nav-item">
        <a href="index.php?page=product">
            <i class="fas fa-box"></i> Product
        </a>
    </li>
    <li class="nav-item">
        <a href="index.php?page=member">
            <i class="fas fa-user"></i> Member
        </a>
    </li>
    <li class="nav-item">
        <a href="#">
            <i class="fas fa-exchange-alt"></i> Transaction
        </a>
    </li>
    <li class="nav-item">
        <a href="#">
            <i class="fas fa-chart-line"></i> Report
        </a>
    </li>
    <li class="nav-item">
        <a href="#">
            <i class="fas fa-cog"></i> Setting
        </a>
    </li>
</ul>

</nav>

<!-- ---------- header.php ------------ -->
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet">



     <!-- Scripts -->
     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet">

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
    <style>
        /* Reset default styles */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
        }

        /* Wrapper layout: Sidebar and content */
        .wrapper {
            display: flex;
            height: 100vh;
            transition: all 0.3s ease-in-out;
        }

        #sidebar {
            width: 200px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            background-color: white !important;
            padding-top: 20px;
            transition: all 0.3s ease;
            box-shadow: 2px 2px 2px solid grey;
        }

        #sidebar.active {
            left: -200px;
        }

        #content {
            margin-left: 200px;
            width: 80%;
            padding: 20px;
            transition: margin-left 0.3s ease;
        }

        #content.active {
            margin-left: 0;
        }

        .sidebar-header {
            text-align: center;
            margin-bottom: 30px;
        }

        .sidebar-header h3 {
            color: #fff;
            font-size: 1.5em;
        }

        #sidebar ul {
            padding-left: 0;
        }

        #sidebar ul li {
            padding: 10px 20px;
            list-style: none;
        }

        #sidebar ul li a {
            color: #bbb;
            text-decoration: none;
            display: block;
            font-size: 18px;
        }

        #sidebar ul li a:hover {
            background-color: #039be5 !important;
            color: #fff;
            padding: 10px;
        }

        .navbar {
            margin-bottom: 30px;
            padding: 0.75rem 1.25rem;
            background-color: #ffffff;
            border-radius: 0.375rem;
            box-shadow: 0 1px 5px rgba(0, 0, 0, 0.1);
        }

        .navbar-text {
            font-weight: bold;
        }

        /* Make the sidebar responsive */
        @media (max-width: 768px) {
            #sidebar {
                width: 100%;
                position: fixed;
                left: -100%;
                z-index: 1000;
            }

            #sidebar.active {
                left: 0;
            }

            #content {
                margin-left: 0;
            }

            #content.active {
                margin-left: 250px;
            }
        }


        /* Sidebar Toggle Button */
        #sidebarToggle {
            position: relative;
            left: 90%;
            top: -3%;
            border: none;
            background: none;
            font-size: 1.5em;
            color: #007bff;
            z-index: 1000;
        }

        /* Main content adjustments */
        .container-fluid {
            padding: 2rem;
        }

        /* Wrapper untuk select */
        .custom-select-wrapper {
            position: relative;
            width: 100%;
        }

        /* Menyembunyikan select default dan memberi ukuran kecil */
        .custom-select {
            appearance: none;  /* Menyembunyikan tampilan default select */
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-right: 30px;  /* Memberikan ruang untuk ikon kanan */
            padding-left: 30px;   /* Memberikan ruang untuk ikon kiri */
            font-size: 14px;      /* Ukuran font kecil */
            height: 35px;         /* Ukuran tinggi yang kecil */
            background-color: white; /* Warna latar belakang abu-abu */
            border: 1px solid #ccc;   /* Warna border abu-abu */
            border-radius: 5px;   /* Sudut border yang melengkung */
        }

        /* Ikon kiri */
        .custom-icon-left {
            color: grey;
            position: absolute;
            top: 50%;
            left: 10px;  /* Jarak dari kiri */
            transform: translateY(-50%);  /* Menjaga ikon kiri agar sejajar vertikal */
            pointer-events: none;  /* Menjaga agar ikon tidak mengganggu interaksi dengan select */
            font-size: 14px;  /* Ukuran ikon kecil */
        }

        /* Ikon kanan */
        .custom-icon-right {
            color: grey;
            position: absolute;
            top: 50%;
            right: 10px;  /* Jarak dari kanan */
            transform: translateY(-50%);  /* Menjaga ikon kanan agar sejajar vertikal */
            pointer-events: none;  /* Menjaga agar ikon tidak mengganggu interaksi dengan select */
            font-size: 14px;  /* Ukuran ikon kecil */
        }

        /* Styling untuk select dan wrapper */
        .custom-select-wrapper {
            display: inline-block;
            width: 100%;
            position: relative;
        }

        /* Efek hover atau focus */
        .custom-select:focus {
            border-color: #007bff;  /* Border biru ketika fokus */
            outline: none;
        }

        /* Menambahkan efek hover pada wrapper */
        .custom-select-wrapper:hover .custom-select {
            border-color: white;  /* Border sedikit lebih gelap ketika hover */
        }

        /* Wrapper untuk input */
        .custom-input-wrapper {
            position: relative;
            width: 100%;
        }

        /* Styling input dengan ikon di kiri */
        .custom-input {
            appearance: none;  /* Menyembunyikan tampilan default input */
            -webkit-appearance: none;
            -moz-appearance: none;
            padding-left: 30px;  /* Memberikan ruang untuk ikon kiri */
            padding-right: 15px; /* Memberikan ruang untuk icon kanan atau spasi ekstra */
            font-size: 14px;     /* Ukuran font kecil */
            height: 35px;        /* Ukuran tinggi yang kecil */
            background-color: white; /* Warna latar belakang abu-abu */
            border: 1px solid #ccc;    /* Warna border abu-abu */
            border-radius: 5px;  /* Sudut border yang melengkung */
        }

        /* Ikon kiri pada input */
        .custom-icon-left {
            position: absolute;
            top: 50%;
            left: 10px;  /* Jarak dari kiri */
            transform: translateY(-50%);  /* Menjaga ikon kiri agar sejajar vertikal */
            pointer-events: none;  /* Menjaga agar ikon tidak mengganggu interaksi dengan input */
            font-size: 16px;   /* Ukuran ikon yang sedikit lebih besar */
        }

        /* Efek hover atau focus pada input */
        .custom-input:focus {
            border-color: #007bff;  /* Border biru ketika fokus */
            outline: none;
        }

        /* Menambahkan efek hover pada wrapper */
        .custom-input-wrapper:hover .custom-input {
            border-color: #bbb;  /* Border sedikit lebih gelap ketika hover */
        }

        /* Wrapper untuk gambar dan teks */
        .logo-wrapper {
            display: flex;              /* Menggunakan Flexbox untuk menyusun elemen secara horizontal */
            align-items: center;        /* Menyelaraskan vertikal gambar dan teks */
            justify-content: center;    /* Memusatkan elemen secara horizontal */
        }

        /* Styling gambar */
        .logo-wrapper img {
            max-width: 25%;              /* Maksimal lebar gambar 35% dari kontainer */
            height: auto;               /* Menjaga proporsi gambar */
            margin-right: 15px;         /* Memberikan jarak antara gambar dan teks */
        }

        /* Styling teks untuk logo */
        .logo-wrapper p {
            font-family: 'Poppins', sans-serif;  /* Font modern untuk logo */
            font-size: 28px;                    /* Ukuran font yang besar dan mencolok */
            font-weight: 600;                   /* Bold untuk kesan profesional */
            color: black;                    /* Warna biru yang solid */
            margin: 0;                          /* Menghilangkan margin default pada paragraf */
        }

        .custom-border-bottom {
            border-bottom: 1px solid #b0bec5 !important; /* Secondary color or any custom color */
        }


    </style>
</head>
<body style="background-color:  #e0f2f1  !important;">


