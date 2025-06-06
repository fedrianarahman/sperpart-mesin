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
                                    <strong>Fail!</strong> '.$_SESSION['status-fail'].'
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
														<th>Nama Teknisi</th>
														<th>Nama Barang</th>
														<th>Jumlah</th>
														<th>Surat</th>
														<th>status</th>
                                                        <th class="text-center">Aksi</th>
													</tr>
												</thead>
												<tbody>
                                                    <?php
                                                    if($_SESSION['role'] == 'operator gudang' || $_SESSION['role'] == 'teknisi') {
                                                        $ambilDataBarang = mysqli_query($conn, "SELECT * FROM `tb_permintaan` INNER JOIN `tb_barang` ON tb_permintaan.nama_barang=tb_barang.nama_barang WHERE `status`='P'");
                                                    } else if($_SESSION['role'] != 'operator gudang' || $_SESSION['role'] != 'teknisi' || $_SERVER['role'] != 'admin') {
                                                        $ambilDataBarang = mysqli_query($conn, "SELECT * FROM `tb_permintaan` INNER JOIN `tb_barang` ON tb_permintaan.nama_barang=tb_barang.nama_barang WHERE `status`='Acc Akhir' OR `status`='Acc Operator' OR `status`='Ditolak'");
                                                    }
                                                    if($_SESSION['role'] == 'admin') {
                                                        $ambilDataBarang = mysqli_query($conn, "SELECT * FROM `tb_permintaan` INNER JOIN `tb_barang` ON tb_permintaan.nama_barang=tb_barang.nama_barang");
                                                    }
                                                    $i=1;
                                                    while ($data = mysqli_fetch_array($ambilDataBarang)) {
                                                    ?>
                                                    <tr>
                                                        <td><?php echo $i?></td>
                                                        <td><?php echo $data['nama_teknisi']?></td>
                                                        <td><?php echo $data['nama_barang']?> 
                                                        <?php if($_SESSION['role'] != 'teknisi') { ?>
                                                            <?= $data['jumlah_total'] ?>
                                                        <?php } ?>
                                                        </td>
                                                        <td><?php echo $data['jumlah_barang']?> <?= $data['satuan'] ?></td>
                                                        <td><a href="./images/surat_permintaan/<?= $data['surat_request'] ?>"><?php echo $data['surat_request']?></a></td>
                                                        <td>
                                                            <?php if($data['status'] == "menunggu") { ?>
                                                                <div style="width: 150px; font-weight: bold; text-align: center; font-size: 14px;" class="bg-primary p-2 rounded text-white">
                                                                    <?php echo $data['status']?>
                                                                </div>
                                                            <?php } else if($data['status'] == "Acc Operator") { ?>
                                                                <div style="width: 150px; font-weight: bold; text-align: center; font-size: 14px;" class="bg-info p-2 rounded text-white">
                                                                    <?php echo $data['status']?>
                                                                </div>
                                                            <?php } else if($data['status'] == "Acc Akhir") { ?>
                                                                <div style="width: 150px; font-weight: bold; text-align: center; font-size: 14px;" class="bg-success p-2 rounded text-white">
                                                                    <?php echo $data['status']?>
                                                                </div>
                                                            <?php } else { ?>
                                                                <div style="width: 150px; font-weight: bold; text-align: center; font-size: 14px;" class="bg-danger p-2 rounded text-white">
                                                                    <?php echo $data['status']?>
                                                                </div>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <div class="d-flex">
                                                                <?php if($data['status'] == 'Ditolak') { ?>
                                                                <a href="./controller/permintaan/delete.php?id=<?php echo $data['id'] ?>" class="m-1 btn btn-sm btn-danger"><i class="la la-trash-o"></i></a>
                                                                <?php } ?>
                                                                <?php if($_SESSION['role'] == 'teknisi') { ?>
                                                                    <a href="editPermintaan.php?id=<?php echo $data['id'] ?>" class="m-1 btn btn-sm btn-primary" ><i class="la la-times"></i></a>
                                                                <?php } ?>
                                                                <?php if($_SESSION['role'] == 'operator gudang') { ?>
                                                                    <a href="./controller/permintaan/Tolak.php?id=<?php echo $data['id'] ?>"  class="m-1 btn btn-sm btn-danger text-white"><i class="la la-times"></i></a>
                                                                    <a href="./controller/permintaan/AccOperator.php?id=<?php echo $data['id'] ?>"  class="m-1 btn btn-sm btn-success text-white"><i class="la la-check"></i></a>
                                                                <?php } ?>
                                                                <?php if($_SESSION['role'] == 'staff gudang' || $_SESSION['role'] == 'manager') { ?>
                                                                <?php if($data['status'] == 'Ditolak') { ?>
                                                                <?php } else if($data['status'] == 'Acc Akhir') { ?>
                                                                <a href="./detailPermintaan.php?id=<?php echo $data['id'] ?>"  class="m-1 btn btn-sm btn-warning text-white"><i class="la la-eye"></i></a>
                                                                <?php } else { ?>
                                                                <a href="./controller/permintaan/AccAkhir.php?id=<?php echo $data['id'] ?>"  class="m-1 btn btn-sm btn-primary text-white"><i class="la la-check"></i></a>
                                                                <?php } ?>
                                                                <?php } ?>
                                                                <?php if($_SESSION['role'] == 'admin') { ?>
                                                                        <a href="editPermintaan.php?id=<?php echo $data['id'] ?>" class="m-1 btn btn-sm btn-primary" ><i class="la la-pencil"></i></a>
                                                                        <?php if($data['status'] == 'Acc Operator' || $data['status'] == 'Acc Akhir' || $data['status'] == 'Ditolak') {  ?>
                                                                        <?php } else { ?>
                                                                        <a href="./controller/permintaan/Tolak.php?id=<?php echo $data['id'] ?>"  class="m-1 btn btn-sm btn-danger text-white"><i class="la la-times"></i></a>
                                                                        <?php } ?>
                                                                        <?php if($data['status'] == 'menunggu') {  ?>
                                                                        <a href="./controller/permintaan/AccOperator.php?id=<?php echo $data['id'] ?>"  class="m-1 btn btn-sm btn-primary text-white"><i class="la la-check"></i></a>
                                                                        <?php } else if ($data['status'] == 'Acc Operator') {  ?>
                                                                            <a href="./controller/permintaan/AccAkhir.php?id=<?php echo $data['id'] ?>"  class="m-1 btn btn-sm btn-success text-white"><i class="la la-check"></i></a>
                                                                        <?php } else if ($data['status'] == 'Acc Akhir') {  ?>
                                                                            <a href="./detailPermintaan.php?id=<?php echo $data['id'] ?>"  class="m-1 btn btn-sm btn-warning text-white"><i class="la la-eye"></i></a>
                                                                        <?php } else { ?>
                                                                    <?php } ?>
                                                                <?php } ?>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                    <?php $i++?>
                                                    <?php }?>
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
	
</body>
</html>