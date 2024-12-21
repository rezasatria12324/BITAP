<?php
session_start();
include "config.php";

ini_set('display_errors', 1);
error_reporting(E_ALL);

$error_message = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Query untuk mendapatkan pengguna berdasarkan username
    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("Error pada query: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verifikasi password menggunakan bcrypt
        if (password_verify($password, $user['password'])) {
            $_SESSION['role'] = $user['role'];
            header("Location: index.php");
            exit();
        } else {
            $error_message = "Username atau password salah.";
        }
    } else {
        $error_message = "Username atau password salah.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        .login-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 15px;
        }
        .custom-container {
            padding: 20px 20px 40px;
            background-color: #ffffff;
            border-radius: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 860px;
            width: 100%;
        }
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px 0;
            margin: 0;
            min-height: 100vh;
            background-image: url(images/pattern.png);
            background-blend-mode: multiply;
            background-color: #d5e6f9;
        }
        @media (max-width: 768px) {
            .login-image {
                display: none;
            }
        }
    </style>
</head>
<body>
    <div class="container custom-container">
        <div class="row">
            <div class="col-md-6 d-none d-md-flex align-items-center justify-content-center">
                <img src="images/login-img.png" class="login-image" alt="Login Image">
            </div>
            <div class="col-md-6 d-flex justify-content-center align-items-center">
                <div class="card shadow-sm" style="border-radius: 15px;">
                    <div class="card-body" style="width: 350px;">
                        <div class="d-flex justify-content-center mb-6">
                            <img src="images/bitap-blue.png" alt="Logo" style="width: 75px; border-radius: 5px;">
                        </div>
                        <h2 class="card-title text-center mb-6" style="font-weight: bold; color: #343a40;">Welcome Back!</h2>
                        <p class="text-center mb-6" style="color: #6c757d; letter-spacing: 2px;">Sign in to continue</p>
                        <form method="POST">
                            <div class="mb-3">
                                <label for="username" class="form-label">Username</label>
                                <input type="text" class="form-control" id="username" name="username" required style="border-radius: 10px;">
                            </div>
                            <div class="mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required style="border-radius: 10px;">
                            </div>
                            <button type="submit" class="btn btn-primary w-100" style="border-radius: 10px; transition: background-color 0.3s;">Sign In</button>
                        </form>
                        <div class="text-center mt-3">
                            <a href="#" style="color: #007bff;">Forgot Password?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php if ($error_message): ?>
    <script>
        Swal.fire({
            icon: 'error',
            title: 'Login gagal!',
            text: '<?php echo $error_message; ?>'
        });
    </script>
    <?php endif; ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
