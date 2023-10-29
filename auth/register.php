<?php
session_start();
include '../controller/conn.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $no_hp = $_POST['no_telpon'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = $_POST['role'];

    // cek apakah username dan role sudah ada dalam tabel user
    $cekUsername = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    $resultCekUsername = mysqli_fetch_array($cekUsername);

    if ($resultCekUsername) {
        $_SESSION['status-fail'] ="";
    }else{
        $addData = mysqli_query($conn, "INSERT INTO `user`(`id`, `nama`, `email`, `no_telpon`, `username`, `password`, `role`, `isActive`) VALUES ('','$name','$email','$no_hp','$username','$password','$role','false')");

        if ($addData) {
           $_SESSION['status-info'] = "";
        } else {
            $_SESSION['status-error'] = "";
        }
        
    }

}
?>



<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Register - Dashboard</title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="../images/favicon.png">
    <link href="../css/style.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

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
                                    <h4 class="text-center mb-4">Sign up your account</h4>
                                    <form method="POST">
                                        <div class="form-group">
                                            <label><strong>Name</strong></label>
                                            <input type="text" class="form-control" id="nama" value="" name="name" required>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Email</strong></label>
                                            <input type="email" class="form-control" value="" id="email" name="email" required>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>NO HP</strong></label>
                                            <input type="text" class="form-control" value="" id="no_telpon" name="no_telpon" required>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>username</strong></label>
                                            <input type="text" class="form-control" value="" id="username" name="username" required>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Password</strong></label>
                                            <input type="password" class="form-control" value="" id="password" name="password" required>
                                        </div>
                                        <div class="form-group">
                                            <label><strong>Role</strong></label>
                                            <select class="form-control" id="role" name="role">
                                                <option>Plih</option>
                                                <?php
                                                $ambilDataRole = mysqli_query($conn, "SELECT * FROM role where nama_role !='admin'");
                                                while ($data = mysqli_fetch_array($ambilDataRole)) {
                                                ?>
                                                <option value="<?php echo $data['id']?>"><?php echo $data['nama_role']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn  btn-primary btn-block" name="submit" id="regist-button">Regist</button>
                                        </div>
                                    </form>
                                    <div class="new-account mt-3">
                                        <p>Sudah Punya Akun ? <a href="./login.php" class="text-primary">Login Disini !</a></p>
                                    </div>
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
    <script src="vendor/global/global.min.js"></script>
	<script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="js/custom.min.js"></script>
	<script src="js/dlabnav-init.js"></script>

    <!-- Chart ChartJS plugin files -->
    <script src="vendor/chart.js/Chart.bundle.min.js"></script>
	
	<!-- Chart piety plugin files -->
    <script src="vendor/peity/jquery.peity.min.js"></script>
	
	<!-- Chart sparkline plugin files -->
    <script src="vendor/jquery-sparkline/jquery.sparkline.min.js"></script>
	
		<!-- Demo scripts -->
    <script src="js/dashboard/dashboard-3.js"></script>
	
	<!-- Svganimation scripts -->
    <script src="vendor/svganimation/vivus.min.js"></script>
    <script src="vendor/svganimation/svg.animation.js"></script>
    <script src="js/styleSwitcher.js"></script>
    <!-- sweet alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/jquery-3.5.1.min.js"></script>
   
    <script>
        <?php
        if (isset($_SESSION['status-fail'])) {
        ?>
        Swal.fire({
            title : 'Error',
            text : 'username sudah tersedia',
            icon : 'error'
        })
        <?php unset($_SESSION['status-fail']); }?>
        <?php
        if (isset($_SESSION['status-info'])) {
        ?>
        Swal.fire({
            title : 'Berhasil',
            text : 'Akun Berhasil Dibuat',
            icon : 'success'
        }).then((result)=>{
            if (result.isConfirmed) {
                window.location.href = "./login.php";
            } 
        })
        
        
        <?php unset($_SESSION['status-info']); }?>
        
        <?php
        if (isset($_SESSION['status-error'])) {
        ?>
        Swal.fire({
            title : 'Error',
            text : 'Gagal Membuat Akun',
            icon : 'error'
        })
        <?php unset($_SESSION['status-error']); }?>
    </script>
</body>

</html>