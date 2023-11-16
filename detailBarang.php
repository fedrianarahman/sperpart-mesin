<?php
session_start();
include './controller/conn.php';
if (!isset($_SESSION['nama'])) {
    header("Location: ./auth/login.php");
    exit();
}
$kode_barang = $_GET['kode_barang'];
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
    <link rel="stylesheet" href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css">
    <!-- Datatable -->
    <link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">

</head>

<body>


    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        <!--**********************************
            Nav header start
        ***********************************-->
        <?php include './include/navHeader.php' ?>
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
                            <h4>Page</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">User</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">All Barang</a></li>
                        </ol>
                    </div>
                </div>
                <div class="row">

                    <div class="col-lg-12">
                        <?php
                        if (isset($_SESSION['status-info'])) {
                            echo '
                            <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                            </button>
                            <strong>Success!</strong> ' . $_SESSION['status-info'] . '
                        </div>';
                            unset($_SESSION['status-info']);
                        }
                        if (isset($_SESSION['status-fail'])) {
                            echo '
                            <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                    </button>
                                    <strong>Fail!</strong> ' . $_SESSION['status-fail'] . '
                                </div>';
                            unset($_SESSION['status-fail']);
                        }
                        ?>
                        <div class="card">
                            <div class="card-header">
                                <a href="./dataBarang.php" class="btn btn-warning text-white">Kembali</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="" class="display table table-bordered" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Photo</th>
                                                <?php if ($_SESSION['role'] != 'teknisi'){?>
                                                    <th>Merk</th>
                                                <th>Rak</th>
                                                <th>Sat</th>
                                                <th>Awal</th>
                                                <th>Masuk</th>
                                                <th>Keluar</th>
                                                <th>Akhir</th>
                                                <th>Tanggal Dibuat</th>
                                                <th>Tgl Diupdate</th>
                                                <?php }?>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ambilDataBarang = mysqli_query($conn, "SELECT * FROM tb_barang INNER JOIN rak_barang ON rak_barang.id = tb_barang.rak WHERE tb_barang.kode_barang = '$kode_barang'");
                                            $i = 1;
                                            while ($data = mysqli_fetch_array($ambilDataBarang)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $i ?></td>
                                                    <td><?php echo $data['kode_barang'] ?></td>
                                                    <td><?php echo $data['nama_barang'] ?></td>
                                                    <td><a href="#" data-toggle="modal" data-target="#exampleModalCenter1"><img width="70" src="./images/barang/<?php echo $data['photo'] ?>" alt=""></a></td>
                                                    <div class="modal fade" id="exampleModalCenter1">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title">Modal title</h5>
                                                                    <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                                    </button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <img src="./images/barang/<?php echo $data['photo'] ?>" width="100%" alt="">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                    
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <?php if ($_SESSION['role'] != 'teknisi'){?>
                                                        <td><?php echo $data['merek'] ?></td>
                                                    <td><?php echo $data['nama_rak'] ?></td>
                                                    <td><?php echo $data['satuan'] ?></td>
                                                    <td><?php echo $data['jumlah_awal'] ?></td>
                                                    <td><?php echo $data['jumlah_masuk'] ?></td>
                                                    <td><?php echo $data['jumlah_keluar'] ?></td>
                                                    <td><?php echo $data['jumlah_akhir'] ?></td>
                                                    <td><?php echo $data['created_at'] ?></td>
                                                    <td><?php echo $data['updated_at'] ?></td>
                                                    <?php }?>
                                                </tr>
                                                <?php $i++ ?>
                                            <?php } ?>
                                        </tbody>
                                    </table>
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



    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
    <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/dlabnav-init.js"></script>

    <!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>

    <!-- Svganimation scripts -->
    <script src="vendor/svganimation/vivus.min.js"></script>
    <script src="vendor/svganimation/svg.animation.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>

</html>