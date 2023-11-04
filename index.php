<?php
session_start();
include './controller/conn.php';
// Cek apakah sesi login telah diatur
if (!isset($_SESSION['nama'])) {
    header("Location: ./auth/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
	
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Edumin - Bootstrap Admin Dashboard </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link rel="stylesheet" href="vendor/jqvmap/css/jqvmap.min.css">
	<link rel="stylesheet" href="vendor/chartist/css/chartist.min.css">
	<link rel="stylesheet" href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/style.css">
	<link rel="stylesheet" href="css/skin-2.css">

</head>

<body>


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <?php include './include/navHeader.php'?>
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        <?php
        include './include/header.php';
        ?>
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        <?php
        include './include/sidebar.php'
        ?>
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <div class="container-fluid">
                <div class="row">
                <div class="col-md-4">
						<a href="./dataUser.php">
                        <div class="widget-stat card shadow-sm">
							<div class="card-body">
								<div class="media">
									<span class="mr-3" >
										<i class="fa fa-users" style=""></i>
									</span>
									<div class="media-body ">
										<p class="mb-1" >Total users</p>
                                        <?php
                                        $getDataUser = mysqli_query($conn ,"SELECT * FROM user WHERE role != '26'");
                                        $dataUser = mysqli_num_rows($getDataUser);
                                        ?>
										<h3 class=""><?= $dataUser; ?></h3>
									</div>
								</div>
							</div>
						</div>
                        </a>
                    </div>
                    <div class="col-md-4">
						<a href="./dataBarang.php">
                        <div class="widget-stat card shadow-sm">
							<div class="card-body">
								<div class="media">
									<span class="mr-3" >
										<i class="fa fa-users" style=""></i>
									</span>
									<div class="media-body ">
										<p class="mb-1" >Total Barang</p>
                                        <?php
                                        $getDataBarang = mysqli_query($conn, "SELECT * FROM tb_barang");
                                        $dataBarang = mysqli_num_rows($getDataBarang);
                                        ?>
										<h3 class=""><?= $dataBarang; ?></h3>
									</div>
								</div>
							</div>
						</div>
                        </a>
                    </div>
                    <div class="col-md-4">
						<a href="./dataPermintaan.php">
                        <div class="widget-stat card shadow-sm">
							<div class="card-body">
								<div class="media">
									<span class="mr-3" >
										<i class="fa fa-users" style=""></i>
									</span>
									<div class="media-body ">
										<p class="mb-1" >Total Permintaan</p>
                                        <?php
                                        $getdataPermintaan = mysqli_query($conn, "SELECT * FROM tb_permintaan");
                                        $dataPermintaan = mysqli_num_rows($getdataPermintaan);
                                        ?>
										<h3 class=""><?= $dataPermintaan; ?></h3>
									</div>
								</div>
							</div>
						</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="../index.htm" target="_blank">DexignLab</a> 2020</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

		<!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

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
	

	
</body>
</html>