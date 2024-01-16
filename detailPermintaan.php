<?php
session_start();
include './controller/conn.php';
$id = $_GET['id'];

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
            <?php
            $getDataPermintaan = mysqli_query($conn, "SELECT
             tb_permintaan.nama_barang AS nama_barang,
             tb_permintaan.status AS status,
             tb_permintaan.id AS id_permintaan,
             tb_permintaan.jumlah_barang AS jumlah_barang,
             tb_barang.photo AS photo,
             u1.nama AS nama_teknisi,
             u2.nama AS nama_staff ,
             u3.nama AS nama_operator
            FROM tb_permintaan
            INNER JOIN user u1 ON u1.id = tb_permintaan.id_user
            LEFT JOIN user u2 ON u2.id = tb_permintaan.accepter
            LEFT JOIN user u3 ON u3.id = tb_permintaan.operator
            INNER JOIN tb_barang ON tb_barang.nama_barang = tb_permintaan.nama_barang
            WHERE tb_permintaan.id = '$id'
            ");
            while ($data = mysqli_fetch_array($getDataPermintaan)) {?>
            <div class="row">
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body text-center">
                            <?php
                            if ($data['photo'] != null) {?>
                            <a href="./images/barang/<?= $data['photo'] ?>" class="mb-4" target="_blank">
                                <img src="./images/barang/<?= $data['photo'] ?>" class="img-fluid" alt="">
                            </a>
                            <p class="mt-4"><?php echo $data['nama_barang'] ?></p>
                            <?php }else{?>
                                <a href="./images/barang/replika.png" class="mb-4" target="_blank">
                                <img src="./images/barang/replika.png" class="img-fluid" alt="">
                            </a>
                            <p class="mt-4"><?php echo $data['nama_barang'] ?></p>
                            <?php }?>
                            <!-- <h6>Surat Permintaan (Klik gambar)</h6> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-8">
                    <div class="card">
                    <div class="card-header">
                                <h4 class="card-title">Detail Permintaan </h4>
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form method="POST" action="./controller/permintaan/staff/konfirmasi.php" enctype="multipart/form-data"> 
                                       <div class="row">
                                       <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="">Nama Teknisi </label>
                                            <input type="text" class="form-control input-default " placeholder="" name="nama_teknisi" value="<?= $data['nama_teknisi'] ?>" readonly>
                                            <input hidden type="text" class="form-control input-default " placeholder="" name="id_permintaan" value="<?= $data['id_permintaan'] ?>" readonly>
                                        </div>
                                       </div>
                                       <!-- <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="">Nama Barang </label>
                                            <input type="text" class="form-control input-default " placeholder="" name="nama_teknisi" value="<?= $data['nama_barang'] ?>" readonly>
                                        </div>
                                       </div> -->
                                       
                                       <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="jumlah_barang">Jumlah</label>
                                            <input type="number" class="form-control input-default " placeholder="" name="jumlah_barang" value="<?= $data['jumlah_barang'] ?>" readonly>
                                        </div>
                                       </div>
                                       <?php if ($data['status']=='A-') {?>
                                        <div class="col-md-6">
                                        <p class="text-center">Disetujui oleh :<br/> <span class="font-weight-bold"><?php echo $data['nama_staff'] ?></span> <br/> (Staff Gudang)</p>
                                       </div>
                                        <?php }?>
                                        <?php if ($data['status'] == 'A+'){?>
                                         <div class="col-md-6">
                                        <p class="text-center">Disetujui oleh :<br/> <span class="font-weight-bold"><?php echo $data['nama_staff'] ?></span> <br/> (Staff Gudang)</p>
                                       </div>   
                                        <div class="col-md-6">
                                        <p class="text-center">Disetujui oleh :<br/> <span class="font-weight-bold"><?php echo $data['nama_operator'] ?></span> <br/> (Operator Gudang)</p>
                                       </div>
                                        <?php }?>
                                       
                                       </div>
                                        <a href="./dataPermintaan.php" class="btn btn-warning text-white">Kembali</a>
                                        <?php
                                        if ($data['status']=='A+') {?>
                                        <a href="./printPermintaan.php?id=<?php echo $data['id_permintaan'] ?>" target="_blank" class="btn btn-primary float-right text-white"><i class="fa fa-print" ></i> Cetak</a>
                                        <?php }?>
                                        <?php if ($data['status']=='P') {?>
                                        <button class="btn float-right btn-success text-white">Konfirmasi</button>
                                        <?php }?>
                                    </form>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <?php }?>
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