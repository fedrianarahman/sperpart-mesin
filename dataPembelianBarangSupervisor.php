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
    return date('d F Y | H:i:s', $newFormat);
}
$idUser = $_SESSION['id_user'];
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
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Pembelian Barang</a></li>
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
                                <h4 class="card-title">Data Pembelian Barang</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table mb-4 verticle-middle table-sm text-center table-responsive-md table-bordered">
                                        <thead>
                                            <tr>
                                                <th>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" class="custom-control-input" id="checkAll">
                                                        <label class="custom-control-label" for="checkAll"></label>
                                                    </div>
                                                </th>
                                                <th>NO</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Nama Suplier</th>
                                                <th>No Suplier</th>
                                                <th>Jumlah Masuk</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $idUser = $_SESSION['id_user'];
                                            $query = mysqli_query($conn, "SELECT * FROM pembelian_barang WHERE id_superVisor = '$idUser' AND status = 'A-'");
                                            $no = 1;
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td>
                                                        <div class="custom-control custom-checkbox">
                                                            <input type="checkbox" class="custom-control-input" id="checkbox<?php echo $data['id'] ?>" value="<?php echo $data['id'] ?>">
                                                            <label class="custom-control-label" for="checkbox<?php echo $data['id'] ?>"></label>
                                                        </div>
                                                    </td>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $data['kode_barang']  ?></td>
                                                    <td><?php echo $data['nama_barang'] ?></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                    <td></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                    <button class="btn btn-primary" id="updateSuplier" data-toggle="modal" data-target="#basicModal" disabled>Update Suplier</button>
                                    <a class=" btn btn-secondary" href="./printSuratPembelianBarangSuperVisor.php?id_supervisor=<?php echo $idUser ?>" target="_blank"><i class="fa fa-print"></i> Cetak</a>
                                    <button class="btn btn-dark"><i class="fa fa-arrow-down" aria-hidden="true"></i> Pindahkan</button>
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
        <div class="modal fade" id="basicModal">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Kirim Ke Supervisor</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="">
                            <div class="form-group">
                                <label for="">Nama Suplier</label>
                               <input type="text" class="form-control" id="nama_suplier" value="">
                            </div>
                            <div class="form-group">
                                <label for="">No Suplier</label>
                               <input type="text" class="form-control" id="no_suplier" value="">
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-sm btn-primary" id="kirimKeSuperVisor">Konfirmasi</button>
                    </div>
                </div>
            </div>
        </div>
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
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script src="vendor/global/global.min.js"></script>
    <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/dlabnav-init.js"></script>

    <!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let dataYangAkanDirubah = [];
            let dataYangAkanDipindahkan = [];

            // Menangani checkAll
            $(document).on('change', '#checkAll', function() {
                // Ambil status centang dari checkbox #checkAll
                let isChecked = $(this).prop('checked');

                // Ubah status centang semua checkbox dalam tabel berdasarkan status centang checkbox #checkAll
                $('.custom-control-input').prop('checked', isChecked);

                // Jika checkbox #checkAll dicentang, hapus atribut disabled pada tombol "Update Suplier"
                if (isChecked) {
                    $('#updateSuplier').prop('disabled', false);
                } else {
                    // Jika tidak, tambahkan atribut disabled pada tombol "Update Suplier"
                    $('#updateSuplier').prop('disabled', true);
                }
            });

            // Menangani perubahan pada setiap checkbox individual
            $(document).on('change', '.custom-control-input', function() {
                // Periksa apakah setidaknya satu checkbox dicentang
                let atLeastOneChecked = $('.custom-control-input:checked').length > 0;

                // Jika setidaknya satu checkbox dicentang, hapus atribut disabled pada tombol "Update Suplier"
                if (atLeastOneChecked) {
                    $('#updateSuplier').prop('disabled', false);
                } else {
                    // Jika tidak ada checkbox yang dicentang, tambahkan atribut disabled pada tombol "Update Suplier"
                    $('#updateSuplier').prop('disabled', true);
                }
            });

            // Update suplier
            $(document).on('click', '#updateSuplier', function() {
                // Periksa semua checkbox yang dicentang
                $('.custom-control-input:checked').each(function() {
                    // Ambil nilai ID dari checkbox yang dicentang
                    let idPembelian = $(this).val();

                    if (idPembelian !== 'on') {
                        
                        // Tambahkan nilai ID ke dalam array dataYangAkanDirubah
                        dataYangAkanDirubah.push(idPembelian);
                    }
                });

                // Lakukan operasi update suplier dengan menggunakan data yang telah dikumpulkan
                console.log("Data yang akan diubah:", dataYangAkanDirubah);

                // Reset array dataYangAkanDirubah setelah penggunaan
                dataYangAkanDirubah = [];
            });
        });
    </script>
</body>

</html>