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


$hariIni = date(' F Y');
$tglAwal = "";
$tglAkhir = "";

if (isset($_POST['cari'])) {
    $tglAwal = $_POST['tgl_awal'];
    $tglAkhir = $_POST['tgl_akhir'];

    if ($tglAwal != null || $tglAkhir != null) {
        $hariIni = formatTanggal($tglAwal) ." ". "" ."Sampai". "" ." ". formatTanggal($tglAkhir);
    } else {
        $hariIni = date(' F Y');    
    }
    
} else {
    $hariIni = date(' F Y');
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
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Archive</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Riwayat Barang Masuk</a></li>
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
                                <h4 class="card-title">Data Riwayat Barang Masuk Tanggal : <span class="text-primary"><?php echo $hariIni ?></span></h4>
                            </div>
                            <div class="card-body">
                                <div class="row mb-2">
                                    <div class="col-md-12">
                                        <form action="" method="POST">
                                            <div class="row">
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Rentan Tanggal Dari</label>
                                                        <input type="date" class="form-control input-default " placeholder="" name="tgl_awal" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="form-group">
                                                        <label for="">Rentan Tanggal Hingga</label>
                                                        <input type="date" class="form-control input-default " placeholder="" name="tgl_akhir" value="">
                                                    </div>
                                                </div>
                                                <div class="col-md-4 pt-4">
                                                    <div class="form-group">
                                                        <button class="btn btn-warning mt-2" type="submit" name="cari">Cari</button>
                                                        <a href="./printRiwayatBarangMasuk.php?tgl_awal=<?php echo $tglAwal ?>&tgl_akhir=<?php echo $tglAkhir?>" class="btn btn-primary mt-2 text-white" target="_blank">Cetak</a>
                                                    </div>
                                                </div>
                                                
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Jumlah</th>
                                                <th>Tanggal</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php

                                            if (isset($_POST['cari'])) {
                                                $rentanTanggalAwal = $_POST['tgl_awal'];
                                                $rentanTanggalAkhir = $_POST['tgl_akhir'];
                                                // var_dump('line 159', $rentanTanggalAkhir);
                                                $query = mysqli_query($conn, "SELECT
                                                riwayat_barang_masuk.kd_barang AS kode_barang,
                                                riwayat_barang_masuk.jumlah_masuk AS jumlah_barang,
                                                riwayat_barang_masuk.created_at AS tanggal_masuk,
                                                tb_barang.nama_barang AS nama_barang
                                                FROM riwayat_barang_masuk INNER JOIN tb_barang ON tb_barang.kode_barang = riwayat_barang_masuk.kd_barang WHERE riwayat_barang_masuk.created_at BETWEEN '$rentanTanggalAwal' AND DATE_ADD('$rentanTanggalAkhir', INTERVAL 1 DAY) ORDER BY riwayat_barang_masuk.id");

                                                if ($rentanTanggalAwal != null || $rentanTanggalAkhir != null) {
                                                    $query = mysqli_query($conn, "SELECT
                                                riwayat_barang_masuk.kd_barang AS kode_barang,
                                                riwayat_barang_masuk.jumlah_masuk AS jumlah_barang,
                                                riwayat_barang_masuk.created_at AS tanggal_masuk,
                                                tb_barang.nama_barang AS nama_barang
                                                FROM riwayat_barang_masuk INNER JOIN tb_barang ON tb_barang.kode_barang = riwayat_barang_masuk.kd_barang WHERE riwayat_barang_masuk.created_at BETWEEN '$rentanTanggalAwal' AND DATE_ADD('$rentanTanggalAkhir', INTERVAL 1 DAY) ORDER BY riwayat_barang_masuk.id");
                                                } else {
                                                    $query = mysqli_query($conn, "SELECT
                                                riwayat_barang_masuk.kd_barang AS kode_barang,
                                                riwayat_barang_masuk.jumlah_masuk AS jumlah_barang,
                                                riwayat_barang_masuk.created_at AS tanggal_masuk,
                                                tb_barang.nama_barang AS nama_barang
                                                FROM riwayat_barang_masuk INNER JOIN tb_barang ON tb_barang.kode_barang = riwayat_barang_masuk.kd_barang WHERE DATE_FORMAT(riwayat_barang_masuk.created_at, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m') ORDER BY riwayat_barang_masuk.id");
                                                }
                                            } else {

                                                $query = mysqli_query($conn, "SELECT
                                                riwayat_barang_masuk.kd_barang AS kode_barang,
                                                riwayat_barang_masuk.jumlah_masuk AS jumlah_barang,
                                                riwayat_barang_masuk.created_at AS tanggal_masuk,
                                                tb_barang.nama_barang AS nama_barang
                                                FROM riwayat_barang_masuk INNER JOIN tb_barang ON tb_barang.kode_barang = riwayat_barang_masuk.kd_barang WHERE DATE_FORMAT(riwayat_barang_masuk.created_at, '%Y-%m') = DATE_FORMAT(CURDATE(), '%Y-%m') ORDER BY riwayat_barang_masuk.id");
                                            }


                                            $i = 1;
                                            while ($data = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo $data['kode_barang'] ?></td>
                                                    <td><?php echo $data['nama_barang'] ?></td>
                                                    <td><?php echo $data['jumlah_barang'] ?></td>
                                                    <td><?php echo formatTanggal($data['tanggal_masuk']) ?></td>
                                                </tr>
                                            <?php
                                                $i++;
                                            } ?>
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
                    }).then((result) => {
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