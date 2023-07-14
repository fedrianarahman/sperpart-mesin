<?php
session_start();
include './controller/conn.php';
$id = $_GET['id'];
if($id) {
    $getData = mysqli_query($conn, "SELECT * FROM `tb_permintaan` WHERE `id`='$id'");
    $data = mysqli_fetch_array($getData);
    if($getData) {
        echo "berhasil";
} else {
        echo "error";
    }
} else {
    header("Location:../../dataPermintaan.php");    
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
<div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>

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
            <!-- row -->
            <div class="container-fluid">
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <h6>Surat Permintaan (Klik gambar)</h6>
                            <a href="./images/surat_permintaan/<?= $data['surat_request'] ?>" target="_blank">
                                <img src="./images/surat_permintaan/<?= $data['surat_request'] ?>" class="img-fluid" alt="">
                            </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                    <div class="card-header">
                                <h4 class="card-title">Edit Permintaan</h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form method="POST" action="./controller/permintaan/update.php?id=<?= $data['id'] ?>" enctype="multipart/form-data"> 
                                       <div class="row">
                                       <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="">Nama Teknisi</label>
                                            <input type="text" class="form-control input-default " placeholder="" name="nama_teknisi" value="<?= $data['nama_teknisi'] ?>" required>
                                        </div>
                                       </div>
                                       <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="jumlah_barang">Jumlah</label>
                                            <input type="number" class="form-control input-default " placeholder="" name="jumlah_barang" value="<?= $data['jumlah_barang'] ?>" required>
                                        </div>
                                       </div>
                                       <div class="col-md-12">
                                        <div class="form-group">
                                                <label for="surat_request">Surat Permintaan</label> 
                                                <input type="file" class="mb-1 form-control input-default" placeholder="" name="surat_request" value="">
                                                <p class="text-small text-danger">surat permintaan betuk harus bentuk foto/gambar</p>
                                            </div>
                                            </div>
                                       </div>
                                        <a href="./dataPermintaan.php" class="btn btn-warning text-white">Kembali</a>
                                        <button class="btn float-right btn-primary" type="submit">Tambah</button>
                                    </form>
                                </div>
                            </div>
                    </div>
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
	
	<!-- Svganimation scripts -->
    <script src="vendor/svganimation/vivus.min.js"></script>
    <script src="vendor/svganimation/svg.animation.js"></script>
    <script src="js/styleSwitcher.js"></script>
	
</body>
</html>