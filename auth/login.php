<?php
session_start();
include '../controller/conn.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $cekDataUser = mysqli_query($conn, "SELECT * FROM `user` INNER JOIN role ON role.id = user.role");
    $getUser = mysqli_query($conn, "SELECT * FROM `user` WHERE `username`='$username'");
    $user = mysqli_fetch_array($getUser);
    $_SESSION['id_user'] = $user['id'];
    $loggedIn = false; // Flag untuk menandakan status login
    while ($result = mysqli_fetch_array($cekDataUser)) {
        if ($username == $result['username'] && $password == $result['password']) {
            $loggedIn = true;
            $_SESSION['nama'] = $result['nama'];
            $_SESSION['email'] = $result['email'];
            $_SESSION['role'] = $result['nama_role'];
            break; // Keluar dari loop jika data ditemukan
        }
    }
    if ($loggedIn) {
        header("Location: ../index.php");
        exit();
    } else {
        $error = true;
    }
}


?>

<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Login - Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
    <link href="../css/style.css" rel="stylesheet">

</head>

<body class="h-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    <?php if (isset($error)) {?>
                                        <p style="color:red; font-style: italic; text-align: center;">username / password salah</p>
                                    <?php }?>
                                    <form method="POST">
                                        <div class="form-group">
                                            <label><strong>username</strong></label>
                                            <input type="text" class="form-control" value="" name="username">
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input type="password" class="form-control" value="" name="password">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block" name="submit">Sign in</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="../vendor/global/global.min.js"></script>
    <script src="../vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="../js/custom.min.js"></script>
    <script src="../js/dlabnav-init.js"></script>

</body>

</html>