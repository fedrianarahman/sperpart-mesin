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
                            <h4>Page</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">User</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">All Role</a></li>
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
                                <h4 class="card-title">Data Role</h4>
                                <a href="./addUser.php" class="btn btn-primary">+ Add new</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                <table id="example3" class="display" style="min-width: 845px">
												<thead>
													<tr>
														<th>#</th>
														<th>Name</th>
														<th>No Hp</th>
														<th>Email</th>
														<th>status</th>
														<th>Posisi</th>
														<th>Aksi</th>
													</tr>
												</thead>
												<tbody>
                                                  <?php
                                                  $ambilDataUser = mysqli_query($conn,"SELECT user.id AS user_id, user.nama, user.email, user.no_telpon, role.nama_role FROM user INNER JOIN role ON role.id = user.role");
                                                  $i = 1;

                                                  while ($data = mysqli_fetch_array($ambilDataUser)) {
                                                    
                                                  ?>
                                                    <tr>
                                                        <td><?php echo $i?></td>
														<td><img class="rounded-circle" width="35" src="images/profile/small/pic1.jpg" alt=""><span class="ml-2"><?php echo ucwords($data['nama'])?></span></td>
														<td><?php echo $data['email']?></td>
														<td><?php echo $data['no_telpon']?></td>
														<td><?php echo $data['nama_role']?></td>
														
														<td><?php echo $data['nama_role']?></td>
														<td>
															<a href="./editUser.php?id=<?php echo $data['user_id']?>" class="btn btn-sm btn-primary" ><i class="la la-pencil"></i></a>
															<a href="detailUser.php?id=<?php echo $data['user_id']?>" class="btn btn-sm btn-warning"><i class="la la-eye text-white"></i></a>
                                                            <a href="./controller/user/delete.php?id=<?php echo $data['user_id']?>" class="btn btn-sm btn-danger"><i class="la la-trash-o"></i></a>
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
	
    <!-- Svganimation scripts -->
    <script src="vendor/svganimation/vivus.min.js"></script>
    <script src="vendor/svganimation/svg.animation.js"></script>
    <script src="js/styleSwitcher.js"></script>
</body>
</html>