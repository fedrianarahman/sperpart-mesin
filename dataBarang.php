<?php
session_start();
if (!isset($_SESSION['nama'])) {
    header("Location: ./auth/login.php");
    exit();
}
include './controller/conn.php';
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
                                <h4 class="card-title">Data Barang</h4>
                                <!-- <a href="#" class="btn btn-success text-white">Import Excell</a> -->
                                <?php if ($_SESSION['role'] == 'manager' || $_SESSION['role'] == 'admin' || $_SESSION['role'] == 'staff gudang') {
                                    echo '<a href="./addBarang.php" class="btn btn-primary">+ Add new</a>';
                                } ?>

                                <!-- <a href="./addBarang.php" class="btn btn-primary">+ Add new</a> -->
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Merk</th>
                                                <th>Rak</th>
                                                <th>Sat</th>
                                                <th>Stock Barang</th>
                                                <th>Keluar</th>
                                                <?php if ($_SESSION['role'] == 'manager' || $_SESSION['role'] == 'staff gudang' || $_SESSION['role'] == 'admin' || $_SESSION['role']=='operator gudang') { ?>
                                                    <th>Update Stock</th>
                                                <?php } ?>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $ambilDataBarang = mysqli_query($conn, "SELECT * FROM tb_barang INNER JOIN rak_barang ON rak_barang.id = tb_barang.rak");
                                            $i = 1;
                                            while ($data = mysqli_fetch_array($ambilDataBarang)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $i ?></td>
                                                    <td><?php echo $data['kode_barang'] ?></td>
                                                    <td><?php echo $data['nama_barang'] ?></td>
                                                    <td><?php echo $data['merek'] ?></td>
                                                    <td><?php echo $data['nama_rak'] ?></td>
                                                    <td><?php echo $data['satuan'] ?></td>
                                                    <td><?php echo $data['jumlah_masuk'] ?></td>
                                                    <td><?php echo $data['jumlah_keluar'] ?></td>
                                                    <?php if ($_SESSION['role'] == 'manager' || $_SESSION['role'] == 'staff gudang' || $_SESSION['role'] == 'admin' || $_SESSION['role']=='operator gudang') { ?>
                                                        <td><button class="btn btn-sm btn-success text-white" id="updateStock" value="<?php echo $data['kode_barang'] ?>" data-id="<?php echo $data['kode_barang'] ?>" data-toggle="modal" data-target="#<?php echo $data['kode_barang'] ?>">Update</button></td>
                                                        <div class="modal fade" id="<?php echo $data['kode_barang'] ?>">
                                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header">
                                                                        <h5 class="modal-title">Updat Stock Barang</h5>
                                                                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="">Kode Barang</label>
                                                                                    <input type="text" class="form-control input-default" name="kode_barang" value="<?php echo $data['kode_barang'] ?>" id="kode_barang" readonly>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-md-12">
                                                                                <div class="form-group">
                                                                                    <label for="">Jumlah Masuk</label>
                                                                                    <input type="number" name="jumlah_masuk" class="form-control input-default" id="jumlah_masuk">
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                        <button type="button" class="btn btn-primary" id="updateStockBarang">Update Stock</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    <?php } ?>
                                                    <td>
                                                        <a href="./detailBarang.php?kode_barang=<?php echo $data['kode_barang'] ?>" class="btn btn-sm mb-2 btn-warning"><i class="la la-eye text-white"></i>
                                                        </a>
                                                        <?php if ($_SESSION['role'] == 'staff gudang') { ?>

                                                            <a href="./editBarang.php?kode_brg=<?php echo $data['kode_barang'] ?>" class="btn btn-sm mb-2 btn-primary"><i class="la la-pencil"></i></a>
                                                        <?php } ?>
                                                        <?php if ($_SESSION['role'] == 'manager' || $_SESSION['role'] == 'admin') {

                                                        ?>
                                                            <a href="./editBarang.php?kode_brg=<?php echo $data['kode_barang'] ?>" class="btn btn-sm mb-2 btn-primary"><i class="la la-pencil"></i></a>
                                                            <a href="./controller/barang/delete.php?kode_barang=<?php echo $data['kode_barang'] ?>" class="btn btn-sm mb-2 btn-danger"><i class="la la-trash-o"></i></a>
                                                        <?php } ?>
                                                    </td>
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
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        
        

        $(document).on('click', '#updateStockBarang', function(event) {
            event.preventDefault();
            const thisClicked = $(this);

            const getDataKodeBarang = thisClicked.closest('.modal-content').find('#kode_barang').val();
            const getDataJumlahMasuk = thisClicked.closest('.modal-content').find('#jumlah_masuk').val();

            $.ajax({
                type: "POST",
                url: "./controller/barang/updateStockBarang.php",
                data: {
                    kodeBarang: getDataKodeBarang,
                    jumlahMasuk: getDataJumlahMasuk,
                    updateStock: true
                },
                success: function(response) {
                   $('.modal').find('.close').click();
                    Swal.fire({
                        title: '',
                        text: response,
                        icon: 'success'
                    }).then((result)=>{
                        if (result.isConfirmed) {
                            location.reload();
                        }
                    })
                }
            });
        });
    </script>

</body>

</html>