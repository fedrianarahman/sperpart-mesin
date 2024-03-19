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
                                    <table id="example3" class="display" style="min-width: 845px">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Kode Barang</th>
                                                <th>Nama Barang</th>
                                                <th>Staff </th>
                                                <th>Status</th>
                                                <th>Total</th>
                                                <th>Tanggal Permintaan</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT
                                            pembelian_barang.kode_barang AS kode_barang,
                                            pembelian_barang.nama_barang AS nama_barang,
                                            pembelian_barang.status AS status, 
                                            pembelian_barang.created_at AS tanggal_permintaan,
                                            pembelian_barang.id AS id_pembelian, 
                                            user.nama AS nama,
                                            COUNT(*) AS total_data
                                        FROM pembelian_barang
                                        INNER JOIN user ON user.id = pembelian_barang.requester
                                        GROUP BY pembelian_barang.created_at
                                        ORDER BY pembelian_barang.created_at ASC");
                                            $no = 1;
                                            $total = mysqli_num_rows($query);
                                            while ($data = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td><?php echo $no++; ?></td>
                                                    <td><?php echo $data['kode_barang'] ?></td>
                                                    <td><?php echo $data['nama_barang'] ?></td>
                                                    <td><?php echo $data['nama'] ?></td>
                                                    <td><?php if ($data['status'] == 'P') {
                                                            echo '<span class="badge badge-warning light">Prosess</span>';
                                                        } elseif ($data['status'] == 'A') {
                                                            echo '<span class="badge badge-success light">Disetujui</span>';
                                                        }elseif ($data['status'] == 'A-') {
                                                            echo '<span class="badge badge-success light">Dalam Pembelian Supervisor</span>';
                                                        }  ?></td>
                                                    <td><?php echo $data['total_data'] ?></td>
                                                    <td><?php echo formatTanggal($data['tanggal_permintaan']) ?></td>
                                                    <td>
                                                        <a href="./detailPembelianBarang.php?id=<?php echo $data['tanggal_permintaan'] ?>" class="btn btn-sm btn-warning"><i class="la la-eye text-white"></i></a>
                                                        <?php if ($data['status'] == 'A') { ?>
                                                            <button id="kirimSupervisor" value="<?php echo $data['tanggal_permintaan'] ?>" class="btn btn-primary text-white btn-sm"><i class="fa fa-id-card-o" aria-hidden="true" data-toggle="modal" data-target="#basicModal"></i></button>
                                                        <?php } ?>
                                                    </td>
                                                </tr>
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
                                <label for="">Pilih SuperVisor</label>
                                <select name="" class="form-control" id="idSuperVisor">
                                    <option value="">Pilih</option>
                                    <?php
                                    $query = mysqli_query($conn, "SELECT * FROM user WHERE role='27'");
                                    while ($data = mysqli_fetch_array($query)) { ?>
                                        <option value="<?php echo $data['id'] ?>"><?php echo $data['nama'] ?></option>
                                    <?php } ?>
                                </select>
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
        $(document).ready(function() {
            let dataIdSuperVisor = '';
            let dataIdPembelianBarang = '';

            $(document).on('click', '#kirimSupervisor', function() {
                const value = $(this).val();
                dataIdPembelianBarang = value;
            });

            $(document).on('change', '#idSuperVisor', function() {
                const idSuperVisor = $(this).val();
                dataIdSuperVisor = idSuperVisor;
            });

            $(document).on('click', '#kirimKeSuperVisor', function() {
                $.ajax({
                    type: "POST",
                    url: "./controller/supervisor/kirimSuperVisor.php",
                    data: {
                        kirimKeSuperVisor: true,
                        idPembelianBarang: dataIdPembelianBarang,
                        idSuperVisor: dataIdSuperVisor
                    },
                    // dataType: "json",
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
                        // console.log("line 282", response);
                    }
                });
            });
        });
    </script>
</body>

</html>