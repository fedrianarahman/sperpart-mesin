<?php
session_start();
include './controller/conn.php';
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
    <style>
        .card-body-replica{
            display: flex;
    justify-content: center;
    align-items: center; /* Menengahkan vertikal (vertically center) */
    overflow: hidden;
        }
      .picture-replica {
    height: 200px;
    width: 200px;
    position: relative;
    
}

 .picture-replica img {
    width: 100%;
    height: 100%;
    display: block;
    margin: 0 auto; /* Menengahkan horizontal (horizontally center) */
}


    </style>
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
            <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Page </h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Barang</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Add</a></li>
                        </ol>
                    </div>
                </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                    <div class="card-header">
                                <!-- <h4 class="card-title">Add Barang</h4> -->
                            </div>
                            <div class="card-body">
                                <div class="basic-form">
                                    <form method="POST" action="./controller/barang/add.php" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                <label for="">Photo Barang</label>
                                                <input type="file" class="form-control input-default " placeholder="" name="photo" value="" onchange="readURL(this);">
                                                 </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="card shadow">
                                                    <div class="card-body card-body-replica">
                                                        <div class="picture-replica bg-primary">
                                                            <img src="./images/barang/replika.png" id="picture-replika" alt="">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                       <div class="row">
                                       <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="">Nama Barang</label>
                                            <input type="text" class="form-control input-default " placeholder="" name="nama_barang" value="">
                                        </div>
                                       </div>
                                       <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="">Merk Barang</label>
                                            <input type="text" class="form-control input-default " placeholder="" name="merk_barang" value="">
                                        </div>
                                       </div>
                                       <div class="col-md-6">
                                       <div class="form-group">
                                            <label>Nama Rak</label>
                                            <select class="form-control"  name="nama_rak">
                                                <option>Plih</option>
                                                <?php
                                                $ambilDataRole = mysqli_query($conn, "SELECT * FROM rak_barang");
                                                while ($data = mysqli_fetch_array($ambilDataRole)) {
                                                ?>
                                                <option value="<?php echo $data['id']?>"><?php echo $data['nama_rak']?></option>
                                                <?php }?>
                                            </select>
                                        </div>
                                       </div>
                                       <div class="col-md-6">
                                       <div class="form-group"> 
                                            <label for="">Satuan Barang</label>
                                            <input type="text" class="form-control input-default " placeholder="" name="satuan_barang" value="">
                                        </div>
                                       </div>
                                       <?php
                                       if ($_SESSION['role']!='manager') {?>
                                       <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="">awal </label>
                                            <input type="number" class="form-control input-default " placeholder="" name="awal" value="">
                                        </div>
                                       </div>
                                       <?php }?>
                                       <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="">masuk</label>
                                            <input type="number" class="form-control input-default " placeholder="" name="masuk" value="">
                                        </div>
                                       </div>
                                       <?php
                                       if ($_SESSION['role'] !='manager') {?>
                                       <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="">keluar</label>
                                            <input type="number" class="form-control input-default " placeholder="" name="keluar" value="">
                                        </div>
                                       </div>
                                       <?php }?>
                                       <div class="col-md-6">
                                       <div class="form-group">
                                            <label for="">akhir</label>
                                            <input type="number" class="form-control input-default " placeholder="" name="akhir" value="">
                                        </div>
                                       </div>
                                       <div class="col-md-6">
                                       <div class="form-group">
                                            <label>Stock</label>
                                            <select class="form-control"  name="stock">
                                                <option>Plih</option>
                                                <option value="take">take</option>
                                                <option value="bppb">bppb</option>
                                            </select>
                                        </div>
                                       </div>
                                       </div>
                                        <a href="./dataBarang.php" class="btn btn-warning text-white">Kembali</a>
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
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script>
         function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#picture-replika')
            .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
      }
    }
    </script>
	
	
</body>
</html>