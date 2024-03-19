<?php
session_start();
if (!isset($_SESSION['nama'])) {
    header("Location: ./auth/login.php");
    exit();
}
include './controller/conn.php';
function formatTanggal($param)
{
    $newFormat = strtotime($param);
    return date('d F Y', $newFormat);
}
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
    <link rel="stylesheet" href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css">
    <!-- Datatable -->
    <link href="vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .custom-height{
            max-height: 250px;
        }
    </style>
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
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Pembelian Barang</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Detail Pembelian Barang</a></li>
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
                    </div>
                </div>
                    <!-- <?php
                    $idPembelian  = $_GET['id'];
                    $query = mysqli_query($conn, "SELECT 
                    pembelian_barang.nama_barang AS nama_barang,
                    pembelian_barang.kode_barang AS kode_barang,
                    pembelian_barang.status AS status,
                    pembelian_barang.created_at AS tanggal_permintaan,
                    pembelian_barang.updated_at AS tanggal_penyetujuan,
                    pembelian_barang.id AS id_pembelian,
                    tb_barang.jumlah_masuk AS stock,
                    tb_barang.photo AS photo,
                    u1.nama AS nama_staff,
                    u2.nama AS nama_manager
                    FROM pembelian_barang INNER JOIN tb_barang ON tb_barang.kode_barang  = pembelian_barang.kode_barang LEFT JOIN user u1 ON u1.id = pembelian_barang.requester LEFT JOIN user u2 ON u2.id = pembelian_barang.accepter WHERE pembelian_barang.id = '$idPembelian'
                    ");
                    while ($data = mysqli_fetch_array($query)) {
                    ?>
                <div class="row">
                    <div class="col-md-4 ">
                        <div class="card">
                            <div class="card-body text-center">
                            <?php
                            if ($data['photo'] != null) {?>
                            <a href="./images/barang/<?= $data['photo'] ?>" class="mb-4" target="_blank">
                                <img src="./images/barang/<?= $data['photo'] ?>" class="img-fluid" alt="<?php echo $data['nama_barang'] ?>">
                            </a>
                            
                            <?php }else{?>
                                <a href="./images/barang/replika.png" class="mb-4" target="_blank">
                                <img src="./images/barang/replika.png" class="img-fluid" alt="<?php echo $data['nama_barang'] ?>">
                            </a>
                            
                            <?php }?>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="text-center mb-4 font-weight-bold">Detail Permintaan Pembelian Barang</h5>
                                <div class="row">
                                    <div class="col-md-12">
                                        <table class="mb-4">
                                            <tr>
                                                <td class="px-2">Nama Barang</td>
                                                <td class="px-2">:</td>
                                                <td><?php echo $data['nama_barang'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="px-2"> Sisa Stock </td>
                                                <td class="px-2">:</td>
                                                <td><?php echo $data['stock'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="px-2">Staff Gudang</td>
                                                <td class="px-2">:</td>
                                                <td><?php echo $data['nama_staff'] ?></td>
                                            </tr>
                                            <tr>
                                                <td class="px-2">Tanggal Permintaan</td>
                                                <td class="px-2">:</td>
                                                <td><?php echo formatTanggal($data['tanggal_permintaan']) ?></td>
                                            </tr>
                                            <tr>
                                                <td class="px-2">Status</td>
                                                <td class="px-2">:</td>
                                                <td><?php if ($data['status']=='P') {
                                                    echo '<span class="badge badge-warning light">Menunggu Penyetujuan</span>';
                                                } elseif($data['status']=='A'){
                                                    echo '<span class="badge badge-success light">Disetujui</span>';
                                                } ?></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <?php if ($data['status']=='A') {?>
                                        <div class="col-md-12">
                                        <div class="row">
                                        <div class="col-md-6"></div>
                                        <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-6">
                                            <p class="text-center">Disetujui oleh :<br/> <span class="font-weight-bold"><?php echo $data['nama_manager']; ?></span> <br/> (Manager)</p>
                                            </div>
                                            <div class="col-md-6">
                                            <p class="text-center">Tanggal  :<br/> <span class="font-weight-bold"><?php echo formatTanggal($data['tanggal_penyetujuan']); ?></span></p>
                                            </div>
                                        </div>
                                        </div>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                                <a href="./dataPembelianBarang.php" class="btn btn-warning text-white">Kembali</a>
                                <?php
                                if($_SESSION['role']=='manager'){?>
                                    <a href="./controller/barang/konfirmasiPembelianBarang.php?id_pembelian=<?php echo $data['id_pembelian'] ?>" class="btn float-right btn-success text-white">Konfirmasi</a>
                                <?php }?>
                                <a href="./printSuratPembelianBarang.php?idPembelian=<?php echo $data['id_pembelian']  ?>" target="_blank" class="btn btn-primary float-right text-white mr-2"><i class="fa fa-print" ></i> Cetak</a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php }?> -->
                <div class="row">
                   
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                            <h5 class="text-center mb-4 font-weight-bold">Detail Permintaan Pembelian Barang</h5>
                            <div class="row mb-4">
                                <div class="col-lg-12">
                                <?php
                                
                                $query = mysqli_query($conn, "SELECT 
                                pembelian_barang.nama_barang AS nama_barang,
                                pembelian_barang.kode_barang AS kode_barang,
                                pembelian_barang.status AS status,
                                pembelian_barang.created_at AS tanggal_permintaan,
                                pembelian_barang.updated_at AS tanggal_penyetujuan,
                                pembelian_barang.id AS id_pembelian,
                                tb_barang.jumlah_masuk AS stock,
                                tb_barang.photo AS photo,
                                u1.nama AS nama_staff,
                                u2.nama AS nama_manager
                                FROM pembelian_barang INNER JOIN tb_barang ON tb_barang.kode_barang  = pembelian_barang.kode_barang LEFT JOIN user u1 ON u1.id = pembelian_barang.requester LEFT JOIN user u2 ON u2.id = pembelian_barang.accepter WHERE pembelian_barang.created_at = '$id' LIMIT 1");
                                while ($data = mysqli_fetch_array($query)) {?>
                                    <table>
                                        <tr>
                                            <td class="px-2">Tanggal Permintaan</td>
                                            <td class="px-2">:</td>
                                            <td><?php echo formatTanggal($data['tanggal_permintaan']); ?></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2">Pemohon</td>
                                            <td class="px-2">:</td>
                                            <td><?php echo $data['nama_staff'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2">Status</td>
                                            <td class="px-2">:</td>
                                            <td><?php if ($data['status']=='P') {
                                                echo '<span class="badge badge-warning light">Menunggu Penyetujuan</span>';
                                            }else{
                                                echo '<span class="badge badge-success light">Disetujui</span>';
                                            }?></td>
                                        </tr>
                                        <?php if ($data['status']=='A') {?>
                                        <tr>
                                            <td class="px-2">Penyetuju</td>
                                            <td class="px-2">:</td>
                                            <td><?php echo $data['nama_manager'] ?></td>
                                        </tr>
                                        <tr>
                                            <td class="px-2">Tanggal Penyetujuan</td>
                                            <td class="px-2">:</td>
                                            <td><?php echo formatTanggal($data['tanggal_penyetujuan']) ?></td>
                                        </tr>
                                        <?php }?>
                                    </table>
                                    <?php }?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12 px-4">
                                    <p class="mb-2">Detail Barang :</p>
                                    <table class="table table-sm table-bordered">
                                        <thead>
                                            <tr>
                                                <th>NO</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Stock Yang Tersedia</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $getDataBarang = mysqli_query($conn, "SELECT 
                                            pembelian_barang.nama_barang AS nama_barang,
                                            pembelian_barang.kode_barang AS kode_barang,
                                            pembelian_barang.status AS status,
                                            pembelian_barang.created_at AS tanggal_permintaan,
                                            pembelian_barang.updated_at AS tanggal_penyetujuan,
                                            pembelian_barang.id AS id_pembelian,
                                            tb_barang.jumlah_masuk AS stock,
                                            tb_barang.photo AS photo,
                                            u1.nama AS nama_staff,
                                            u2.nama AS nama_manager
                                            FROM pembelian_barang INNER JOIN tb_barang ON tb_barang.kode_barang  = pembelian_barang.kode_barang LEFT JOIN user u1 ON u1.id = pembelian_barang.requester LEFT JOIN user u2 ON u2.id = pembelian_barang.accepter WHERE pembelian_barang.created_at = '$id'");
                                            $no = 1;
                                            while ($dataBarang = mysqli_fetch_array($getDataBarang)) {?>
                                            <tr>
                                                <td><?php echo $no++; ?></td>
                                                <td><?php echo $dataBarang['kode_barang'] ?></td>
                                                <td><?php echo $dataBarang['nama_barang'] ?></td>
                                                <td><?php echo $dataBarang['stock'] ?></td>
                                            </tr>
                                            <?php }?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <a href="./dataPembelianBarang.php" class="btn btn-sm btn-warning text-white">Kembali</a>
                                <?php
                                if($_SESSION['role']=='manager'){?>
                                    <a href="./controller/barang/konfirmasiPembelianBarang.php?id_pembelian=<?php echo $id ?>" class="btn float-right btn-success text-white" >Konfirmasi</a>
                                <?php }?>
                                <a href="./printSuratPembelianBarang.php?idPembelian=<?php echo $id?>" target="_blank" class="btn btn-primary float-right text-white mr-2"><i class="fa fa-print" ></i> Cetak</a>
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
    
</body>

</html>