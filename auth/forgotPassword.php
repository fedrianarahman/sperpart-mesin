<?php
session_start();
include '../controller/conn.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];

    $cekUSername = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username'");
    $r = mysqli_fetch_array($cekUSername);

    if ($r) {
        $_SESSION['status-info'] = $r['id'];
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
    <title>Forgot Password - Dashboard</title>
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
                                    <h4 class="text-center mb-4">Enter your username</h4>
                                    <?php if (isset($error)) { ?>
                                        <p style="color:red; font-style: italic; text-align: center;">Akun Tidak Ditemukan</p>
                                    <?php } ?>
                                    <form method="POST">
                                        <div class="form-group">
                                            <label><strong>username</strong></label>
                                            <input type="text" class="form-control" value="" name="username">
                                        </div>

                                        <div class="text-center mb-2">
                                            <button type="submit" class="btn btn-sm btn-primary btn-block" name="submit">Submit</button>
                                        </div>
                                    </form>
                                    <div class="text-center">
                                        <button id="kembali" class="btn btn-sm btn-warning text-white btn-block">Kembali</button>
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
        document.addEventListener('DOMContentLoaded', function() {
            const kembali = document.getElementById('kembali');
            kembali.addEventListener('click', function() {
                window.location.href = "./login.php";
            });
        });
    </script>

    <script>
       <?php
        if (isset($_SESSION['status-info'])) {
        ?>
        Swal.fire({
            title : '',
            text : 'Akun Ditemukan',
            icon : 'success'
        }).then((result)=>{
            if (result.isConfirmed) {
                window.location.href = "./resetPassword.php?id=<?php echo $_SESSION['status-info']?>";
            } 
        })
        <?php unset($_SESSION['status-info']); }?>
    </script>
</body>

</html>