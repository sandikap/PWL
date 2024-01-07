<?php
session_start();

include "koneksi.php";

// Cek apakah pengguna sudah login
if (!isset($_SESSION['username'])) {
    header("location: login.php");
    exit();
}

// Ambil data pengguna dari database
$username = $_SESSION['username'];
$sql = "SELECT * FROM user WHERE username='$username'";
$result = $conn->query($sql);

if (!$result) {
    die("Error in query: " . $conn->error);
}

$row = $result->fetch_assoc();

// Proses form pengubahan password
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldPassword = md5($_POST['old_password']);
    $newPassword = md5($_POST['new_password']);

    // Periksa apakah password lama sesuai dengan yang tersimpan di database
    if ($oldPassword == $row['password']) {
        // Update password baru ke database
        $updateSql = "UPDATE user SET password='$newPassword' WHERE username='$username'";
        $updateResult = $conn->query($updateSql);

        if (!$updateResult) {
            die("Error updating password: " . $conn->error);
        }

        // Hapus session dan redirect ke halaman login
        session_destroy();
        header("location: login.php");
        exit();
    } else {
        $error = "Password lama tidak sesuai.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Profil | My Daily Journal</title>
    <link rel="icon" href="img/logo.png" />
        <link
        rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css"
        />
        <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous"
        />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>
<body>
    
    <!-- nav begin -->
        <nav class="navbar navbar-expand-sm bg-body-tertiary sticky-top bg-success-subtle">
        <div class="container">
            <a class="navbar-brand" href="">Jurnal Mahasiswa</a>
            <button
            class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent"
            aria-expanded="false"
            aria-label="Toggle navigation"
            >
            <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0 text-dark">
                <li class="nav-item">
                    <a class="nav-link" href="admin.php?page=dashboard">Dashboard</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="admin.php?page=article">Article</a>
                </li> 
                <li class="nav-item">
                    <a class="nav-link" href="admin.php?page=gallery">Gallery</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-success fw-bold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <?= $_SESSION['username']?>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="profil.php">Profil</a></li> 
                        <li><a class="dropdown-item" href="logout.php">Logout</a></li>
                    </ul>
                </li> 
            </ul>
            </div>
        </div>
        </nav>
        <!-- nav end -->
        <!--conten begin-->
    <div class="container mt-5 pt-5">
        <div class="row">
            <div class="col-12 col-sm-8 col-md-6 m-auto">
                <div class="card border-0 shadow rounded-5">
                    <div class="card-body">
                        <div class="text-center mb-3">
                            <i class="bi bi-person-circle h1 display-4"></i>
                            <p>Profil Pengguna</p>
                            <hr />
                        </div>
                        <form action="" method="post">
                            <div class="mb-3">
                                <label for="old_password" class="form-label">Password Lama</label>
                                <input type="password" name="old_password" class="form-control" required />
                            </div>
                           <div class="mb-3">
                                <label for="new_password" class="form-label">Password Baru</label>
                                <input type="password" name="new_password" id="new_password" class="form-control" required/>
                            </div>
                            <div class="mb-3">
                                <label for="confirm_password" class="form-label">Konfirmasi Password Baru</label>
                                <input type="password" name="confirm_password" id="confirm_password" class="form-control" required/>
                            </div>

                            <?php if (isset($error)) : ?>
                                <div class="alert alert-success" role="alert">
                                    <?= $error; ?>
                                </div>
                            <?php endif; ?>
                            <div class="text-center my-3 d-grid">
                                <button type="submit" class="btn btn-success rounded-4">Konfirmasi</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="text-center p-5 bg-success-subtle">
        <div>
            <a href="https://www.instagram.com/udinusofficial"
            ><i class="bi bi-instagram h2 p-2 text-dark"></i
            ></a>
            <a href="https://twitter.com/udinusofficial"
            ><i class="bi bi-twitter h2 p-2 text-dark"></i
            ></a>
            <a href="https://wa.me/+62812685577"
            ><i class="bi bi-whatsapp h2 p-2 text-dark"></i
            ></a>
        </div>
        <div>Sandika Pratama Wibisono &copy; 2023</div>
        </footer>
        <!-- footer end -->
        <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"
        ></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelector('form').addEventListener('submit', function (e) {
            var newPassword = document.getElementById('new_password').value;
            var confirmPassword = document.getElementById('confirm_password').value;

            if (newPassword !== confirmPassword) {
                alert('Konfirmasi password baru tidak sesuai.');
                e.preventDefault(); // Prevent form submission
            }
        });
    });
</script>
</body>
</html>
