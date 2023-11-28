<?php
session_start();
include './controller/conn.php';
// echo $_SESSION['role'];

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
					
					<div class="col-lg-12">
                    <?php
                        if (isset($_SESSION['status-info'])) {
                            echo '
                            <div class="alert alert-success alert-dismissible fade show">
                            <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                            </button>
                            <strong>Success!</strong> '.$_SESSION['status-info'].'
                        </div>';
                            unset($_SESSION['status-info']);
                        }
                        if (isset($_SESSION['status-fail'])) {
                            echo '
                            <div class="alert alert-danger alert-dismissible fade show">
                                    <button type="button" class="close h-100" data-dismiss="alert" aria-label="Close"><span><i class="mdi mdi-close"></i></span>
                                    </button>
                                    <strong>Gagal!</strong> '.$_SESSION['status-fail'].'
                                </div>';
                            unset($_SESSION['status-fail']);
                        }
                        ?>
                        <div class="card">
							<div class="card-header">
                                <h4 class="card-title">Data Permintaan</h4>
                                <!-- <a href="#" class="btn btn-success text-white">Import Excell</a> -->
                                <?php if(($_SESSION['role'] == 'teknisi')) { ?>
                                <a href="./addPermintaan.php" class="btn btn-primary">+ Request</a>
                                <?php } ?>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table id="example3" class="display" style="min-width: 845px">
												<thead>
													<tr>
														<th>#</th>
                                                        <?php if ($_SESSION['role']=='staff gudang' || $_SESSION['role'] == 'manager' || $_SESSION['role'] =='admin' || $_SESSION['role'] =='operator gudang'){ ?>
                                                            <th>Nama Teknisi </th>
                                                        <?php }?>
                                                        <?php if ($_SESSION['role']=='operator gudang' || $_SESSION['role'] =='admin' || $_SESSION['role']=='manager') {?>
                                                            <th>Staff</th>
                                                        <?php }?>
                                                        <?php if ($_SESSION['role'] =='admin' || $_SESSION['role']=='manager') {?>
                                                            <th>Operator</th>
                                                        <?php }?>
														<th>Nama Barang</th>
														<th>Jumlah</th>
														<th>Status</th>
														<th>Tanggal</th>
                                                        <?php if ($_SESSION['role']=='teknisi' || $_SESSION['role']=='staff gudang' || $_SESSION['role'] =='admin' || $_SESSION['role']=='manager') {?>
                                                            <th class="text-center">Aksi</th>
                                                        <?php }?>
													</tr>
												</thead>
												<tbody>
                                                    <?php
                                                    $userId = $_SESSION['id_user'];
                                                    if ($_SESSION['role'] == 'teknisi') {
                                                        $getDataPermintaan = mysqli_query($conn, "SELECT tb_permintaan.created_at AS created_at,tb_permintaan.id AS id_permintaan,tb_permintaan.jumlah_barang AS jumlah_barang, tb_permintaan.status AS status, user.nama AS nama, tb_barang.nama_barang AS nama_barang FROM tb_permintaan INNER JOIN user ON user.id = tb_permintaan.id_user INNER JOIN tb_barang ON tb_barang.nama_barang = tb_permintaan.nama_barang WHERE tb_permintaan.id_user = '$userId'");
                                                    }elseif($_SESSION['role'] == 'staff gudang'     ){
                                                        $getDataPermintaan = mysqli_query($conn, "SELECT tb_permintaan.created_at AS created_at,tb_permintaan.id AS id_permintaan,tb_permintaan.jumlah_barang AS jumlah_barang, tb_permintaan.status AS status, user.nama AS nama_teknisi, tb_barang.nama_barang AS nama_barang FROM tb_permintaan INNER JOIN user ON user.id = tb_permintaan.id_user INNER JOIN tb_barang ON tb_barang.nama_barang = tb_permintaan.nama_barang WHERE tb_permintaan.status= 'P' OR tb_permintaan.status =  'A-'");
                                                    }elseif($_SESSION['role'] == 'operator gudang'){
                                                        $getDataPermintaan = mysqli_query($conn, "SELECT 
                                                        tb_permintaan.created_at AS created_at,
                                                        tb_permintaan.id AS id_permintaan,
                                                        tb_permintaan.jumlah_barang AS jumlah_barang, 
                                                        tb_permintaan.status AS status, 
                                                        u1.nama AS nama_teknisi, 
                                                        u2.nama AS nama_staff, 
                                                        tb_barang.nama_barang AS nama_barang 
                                                    FROM 
                                                        tb_permintaan 
                                                    INNER JOIN 
                                                        user u1 ON u1.id = tb_permintaan.id_user 
                                                    INNER JOIN 
                                                        user u2 ON u2.id = tb_permintaan.accepter 
                                                    INNER JOIN 
                                                        tb_barang ON tb_barang.nama_barang = tb_permintaan.nama_barang 
                                                    WHERE  
                                                        tb_permintaan.status = 'A-'
                                                    OR tb_permintaan.status = 'A+'    
                                                    ");
                                                    }elseif($_SESSION['role'] == 'manager'){
                                                        $getDataPermintaan = mysqli_query($conn, "SELECT tb_permintaan.created_at as created_at,
                                                        tb_permintaan.id AS id_permintaan,
                                                        tb_permintaan.jumlah_barang AS jumlah_barang,
                                                        tb_permintaan.status AS status,
                                                        u1.nama AS nama_teknisi,
                                                        u2.nama AS nama_staff,
                                                        u3.nama AS nama_operator,
                                                        tb_barang.nama_barang AS nama_barang
                                                        FROM 
                                                            tb_permintaan
                                                        LEFT JOIN
                                                            user u1 ON u1.id = tb_permintaan.id_user
                                                        LEFT JOIN 
                                                            user u2 ON u2.id = tb_permintaan.accepter
                                                        LEFT JOIN 
                                                            user u3 ON u3.id = tb_permintaan.operator
                                                        LEFT JOIN 
                                                            tb_barang ON tb_barang.nama_barang = tb_permintaan.nama_barang        
                                                        ");
                                                    }
                                                    $i =1;
                                                    while ($data = mysqli_fetch_array($getDataPermintaan)) {
                                                     ?>
                                                    <tr>
                                                        <td><?php echo $i++; ?></td>
                                                        <?php if ($_SESSION['role']=='staff gudang' || $_SESSION['role'] == 'manager' || $_SESSION['role']=='operator gudang'){?>
                                                            <td><?php echo $data['nama_teknisi'] ?></td>
                                                        <?php }?>
                                                        <?php if ($_SESSION['role']=='operator gudang' || $_SESSION['role']=='admin' || $_SESSION['role']=='manager') {?>
                                                            <td><?php echo $data['nama_staff'] ?></td>
                                                        <?php }?>
                                                        <?php if ( $_SESSION['role']=='admin' || $_SESSION['role']=='manager') {?>
                                                            <td><?php echo $data['nama_operator'] ?></td>
                                                        <?php }?>
                                                        <td><?php echo $data['nama_barang'] ?></td>
                                                        <td><?php echo $data['jumlah_barang'] ?></td>
                                                        <td><?php if ($data['status']=='P') {
                                                            echo '<span class="badge light badge-warning">Menunggu</span>';
                                                        } elseif($data['status']== 'C'){
                                                            echo '<span class="badge light badge-danger">Dibatalkan</span>';
                                                        }elseif($_SESSION['role']=='teknisi' && $data['status'] == 'A-' || $data['status']=='A+'){
                                                            echo '<span class="badge light badge-success">Disetujui</span>';
                                                        }elseif($_SESSION['role']=='staff gudang' && $data['status'] =='A-'){
                                                            echo '<span class="badge light badge-success">Disetujui</span>';
                                                        }elseif($_SESSION['role']=='operator gudang' && $data['status'] =='A-'){
                                                            echo '<a href="./controller/permintaan/operator/konfirmasi.php?id_permintaan='.$data['id_permintaan'] .'"><span class="badge light badge-warning">Konfirmasi</span></a>';
                                                        }elseif($_SESSION['role']=='operator gudang' && $data['status'] =='A+'){
                                                            echo '<span class="badge light badge-success">Terkonfirmasi</span>';
                                                        }elseif($_SESSION['role']=='manager' && $data['status']== 'A-'){
                                                            echo '<span class="badge light badge-warning">Menunggu Operator</span>';
                                                        }elseif($_SESSION['role']=='manager' && $data['status']== 'A+'){
                                                            echo '<span class="badge light badge-success">Terkonfirmasi</span>';
                                                        }
                                                        ?></td>
                                                        <td><?php
                                                         $dataCreatedOld =  strtotime($data['created_at']);
                                                         echo date('d F Y', $dataCreatedOld); 
                                                         ?></td>
                                                        <?php if ($_SESSION['role'] != 'operator gudang') {?>
                                                            <td>
                                                        <?php if ($_SESSION['role']== 'teknisi' && $_SESSION['role']== 'manager' && $data['status']=='A') {?>
                                                            <a href="detailPermintaan.php?id=<?php echo $data['id_permintaan']?>" class="btn btn-sm btn-warning mb-2"><i class="la la-eye text-white"></i>
                                                        </a>
                                                        <?php }?>
                                                        <?php
                                                        if ($_SESSION['role'] == 'teknisi' && $data['status']=='A-' || $data['status']=='A+') {?>
                                                        <a href="detailPermintaan.php?id=<?php echo $data['id_permintaan']?>" class="btn btn-sm btn-warning mb-2"><i class="la la-eye text-white"></i>
                                                        </a>
                                                        <?php }?>
                                                        <?php if ($_SESSION['role']== 'staff gudang' ) {?>
                                                            <a href="detailPermintaan.php?id=<?php echo $data['id_permintaan']?>" class="btn btn-sm btn-warning mb-2"><i class="la la-eye text-white"></i>
                                                        </a>
                                                        <?php }?>
                                                        <?php if ($_SESSION['role'] =='teknisi' || $_SESSION['role'] == 'manager') {?>
                                                            <button <?php if ($data['status'] =='C' || $data['status'] =='A-' || $data['status']== 'A+') {
                                                            echo 'disabled';
                                                        } ?> class="btn btn-sm btn-danger mb-2" id="hapusData" value="<?php echo $data['id_permintaan']?>" data-id="<?php echo $data['id_permintaan']?>"><i class="fa fa-times text-white" aria-hidden="true"></i>
                                                        </button>
                                                        <?php }?>
                                                        </td>
                                                        <?php }?>
                                                    </tr>
                                                    <?php  }?>
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.27/dist/sweetalert2.all.min.js"></script>
    <script src="./js/jquery-3.5.1.min.js"></script>
    <script>
        $(document).on('click', '#hapusData',function () {
           const id  = $(this).data('id');
            console.log("line 188", id);
           Swal.fire({
            title: 'Batalkan Permintaan?',
            text: "Permintaan Anda Akan Dibatalkan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, Batalkan!',
            cancelButtonText: 'Cancel'
           }).then((result)=>{
                if (result.isConfirmed) {
                    $.ajax({
                        type: "POST",
                        url: "./controller/permintaan/cancel.php",
                        data: {
                            id : id
                        },
                        success: function (response) {
                            console.log("line 206", response);
                            response = response.trim();
                            if (response ==='sukses') {
                                Swal.fire(
                                'Berhasil!',
                                'Permintaan berhasil dibatalkan.',
                                'success'
                            ).then((result) => {
                                // Refresh halaman atau lakukan tindakan lain
                                location.reload();
                            });
                            } else {
                                Swal.fire(
                                'Gagal!',
                                'Gagal menghapus data.',
                                'error'
                             ); 
                            }
                        },
                        error : function (error) {
                            console.log("line 226", error);
                        }
                    });
                } 
           })
        });
    </script>
	
</body>
</html>