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
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Permintaan Barang</a></li>
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
                                <button type="button" class="btn btn-sm btn-primary" id="ajukanPembelianMasal">+ Ajukan Semua</button>
                                <!-- <button type="button" class="btn btn-sm btn-primary" data-toggle="modal" data-target="#basicModal">+ Ajukan Semua</button> -->
                                <!-- Modal -->
                                <div class="modal fade" id="basicModal">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Data Barang</h5>
                                                <button type="button" class="close" data-dismiss="modal"><span>&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                <table class="table table-sm">
                                                    <thead>
                                                        <tr>
                                                            <th>NO</th>
                                                            <th>Kode Barang</th>
                                                            <th>Nama Barang</th>
                                                            <th>Stock</th>
                                                            <th>Action</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-sm btn-danger" data-dismiss="modal">Close</button>
                                                <button class="btn btn-sm btn-warning text-white">Reset</button>
                                                <button type="button" class="btn btn-sm btn-primary" id="ajukanPembelian">Ajukan</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
                                                <th>Stock Barang</th>
                                                <th>Status</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $query = mysqli_query($conn, "SELECT * FROM tb_barang INNER JOIN rak_barang ON rak_barang.id = tb_barang.rak WHERE tb_barang.jumlah_masuk < 20");
                                            $no = 1;
                                            while ($data = mysqli_fetch_array($query)) {
                                            ?>
                                                <tr>
                                                    <td><?php echo $no; ?></td>
                                                    <td><?php echo $data['kode_barang'] ?></td>
                                                    <td><?php echo $data['nama_barang'] ?></td>
                                                    <td><?php echo $data['merek'] ?></td>
                                                    <td><?php echo $data['nama_rak'] ?></td>
                                                    <td><?php echo $data['jumlah_masuk'] ?></td>
                                                    <td><?php if ($data['status_pembelian'] == 'N') {
                                                            echo '<span class ="badge badge-danger light">Stock Menipis</span>';
                                                        } elseif ($data['status_pembelian'] == 'P') {
                                                            echo '<span class="badge badge-warning light">Proses</span>';
                                                        } ?></td>
                                                    <td>

                                                        <button <?php if ($data['status_pembelian'] == 'P') {
                                                                    echo 'disabled';
                                                                } ?> id="requestPembelian" value="<?php echo $data['kode_barang'] ?>" class="btn btn-sm mb-2 btn-primary"><i class="la la-pencil"></i></button>
                                                    </td>
                                                </tr>
                                            <?php
                                                $no++;
                                            }
                                            ?>
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
    <!-- <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script> -->
    <script src="js/custom.min.js"></script>
    <script src="js/dlabnav-init.js"></script>

    <!-- Datatable -->
    <script src="vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="js/plugins-init/datatables.init.js"></script>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JavaScript -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            let barangYangInginDiajukan = []; // Variabel untuk melacak barang yang ingin diajukan

            // ajukan semua pembelian
            $(document).on('click', '#ajukanPembelianMasal', function() {
                Swal.fire({
                    title: 'Ajukan Semua Pembelian Barang ?',
                    icon: 'info',
                    showCancelButton: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "./controller/barang/getStockBarang.php",
                            data: {
                                getStockBarang: true
                            },
                            dataType: "json",
                            success: function(response) {
                                // Kosongkan tabel terlebih dahulu
                                $('#basicModal').find('tbody').empty();

                                // Set variabel barangYangInginDiajukan dengan data yang diterima
                                barangYangInginDiajukan = response;

                                // Iterasi melalui data dan tambahkan baris-baris ke tabel
                                $.each(response, function(index, data) {
                                    var newRow = '<tr>' +
                                        '<td>' + (index + 1) + '</td>' +
                                        '<td>' + data.kode_barang + '</td>' +
                                        '<td>' + data.nama_barang + '</td>' +
                                        '<td>' + data.jumlah_masuk + '</td>' +
                                        '<td><button type="button" class="btn btn-sm btn-danger remove-item" data-kode="' + data.kode_barang + '">X</button></td>' +
                                        '</tr>';
                                    $('#basicModal').find('tbody').append(newRow);
                                });

                                // Tampilkan modal setelah menambahkan data ke tabel
                                $('#basicModal').modal('show');
                                console.log("line 282", barangYangInginDiajukan);
                            }
                        });
                    }
                });
            });

            // Menangani klik pada tombol "X"
            $(document).on('click', '.remove-item', function() {
                // Hapus baris tabel saat tombol "X" di klik
                $(this).closest('tr').remove();
                var kodeBarang = $(this).data('kode');
                console.log('Kode Barang:', kodeBarang, 'Dibatalkan');

                // Hapus barang dari variabel barangYangInginDiajukan
                barangYangInginDiajukan = barangYangInginDiajukan.filter(function(item) {
                    return item.kode_barang !== kodeBarang;
                });
                console.log("Variabel barang YangInginDiajukan setelah dihapus:", barangYangInginDiajukan);
            });



            // Menangani klik pada tombol "Reset"
            $(document).on('click', '.btn-warning', function() {
                // Kembalikan data tabel ke kondisi awal
                $.ajax({
                    type: "POST",
                    url: "./controller/barang/getStockBarang.php",
                    data: {
                        getStockBarang: true
                    },
                    dataType: "json",
                    success: function(response) {
                        $('#basicModal').find('tbody').empty();
                        barangYangInginDiajukan = response;
                        $.each(response, function(index, data) {
                            var newRow = '<tr>' +
                                '<td>' + (index + 1) + '</td>' +
                                '<td>' + data.kode_barang + '</td>' +
                                '<td>' + data.nama_barang + '</td>' +
                                '<td>' + data.jumlah_masuk + '</td>' +
                                '<td><button type="button" class="btn btn-sm btn-danger remove-item" data-kode="' + data.kode_barang + '">X</button></td>' +
                                '</tr>';
                            $('#basicModal').find('tbody').append(newRow);
                        });
                        console.log("line 328", barangYangInginDiajukan);
                    }
                });
            });

            // ajukan pembelian barang berdasarkan data yang terpilih
            $(document).on('click', '#ajukanPembelian', function() {
                $('#basicModal .close').click();

                // Kirim data barang yang ingin diajukan
                $.ajax({
                    type: "POST",
                    url: "./controller/barang/requestPembelianBarangAll.php",
                    data: {
                        requestPembelianAll: true,
                        barangYangInginDiajukan: JSON.stringify(barangYangInginDiajukan) // Kirim data sebagai JSON string
                    },
                    success: function(response) {
                        console.log("Data yang akan disimpan:", response);

                        // Lanjutkan ke AJAX kedua di sini
                        Swal.fire({
                            text: 'Permintaan Pembelian Barang Berhasil !',
                            icon: 'success'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(response) {
                        Swal.fire({
                            text: response,
                            icon: 'danger'
                        });
                    }
                });
            });

            // request pembelian 1 barang
            $(document).on('click', '#requestPembelian', function() {
                let kodeBarang = $(this).val();
                Swal.fire({
                    title: 'Ajukan Pembelian Barang ?',
                    text: 'kode : ' + kodeBarang,
                    showCancelButton: true,
                    icon: 'info'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            type: "POST",
                            url: "./controller/barang/pembelianBarang.php",
                            data: {
                                requestPembelian: true,
                                kodeBarang: kodeBarang
                            },
                            success: function(response) {
                                Swal.fire({
                                    text: response,
                                    icon: 'success'
                                }).then((result) => {
                                    if (result.isConfirmed) {
                                        location.reload();
                                    }
                                });
                            },
                            error: function(response) {
                                Swal.fire({
                                    text: response,
                                    icon: 'danger'
                                });
                            }
                        });
                    }
                })
            });
        });
    </script>

</body>

</html>