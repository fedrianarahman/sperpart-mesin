<?php
session_start();
include './controller/conn.php';
// Cek apakah sesi login telah diatur
if (!isset($_SESSION['nama'])) {
    header("Location: ./auth/login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Profile - Dashboard </title>
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <link rel="stylesheet" href="vendor/jqvmap/css/jqvmap.min.css">
    <link rel="stylesheet" href="vendor/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="vendor/bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/skin-2.css">
    <style>
        /* picture container */
        .picture-container {
            position: relative;
            cursor: pointer;
            text-align: center;
        }

        .picture {
            width: 130px;
            height: 130px;
            background-color: #999999;
            border: 4px solid #CCCCCC;
            color: #FFFFFF;
            border-radius: 50%;
            margin: 0px auto;
            overflow: hidden;
            transition: all 0.2s;
            -webkit-transition: all 0.2s;
        }

        .picture:hover {
            border-color: #2ca8ff;
        }

        .content.ct-wizard-green .picture:hover {
            border-color: #05ae0e;
        }

        .content.ct-wizard-blue .picture:hover {
            border-color: #3472f7;
        }

        .content.ct-wizard-orange .picture:hover {
            border-color: #ff9500;
        }

        .content.ct-wizard-red .picture:hover {
            border-color: #ff3b30;
        }

        .picture input[type="file"] {
            cursor: pointer;
            display: block;
            height: 100%;
            left: 0;
            opacity: 0 !important;
            position: absolute;
            top: 0;
            width: 100%;
        }

        .pict-text {
            font-size: small;
            color: #999999;
            /* background: red; */
        }

        .picture-src {
            width: 100%;
            object-fit: fill;

        }

        .jabatan {
            font-weight: 600;
            margin-top: -10px;
            color: #999999;
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
            <!-- <?php echo $_SESSION['role'] ?> -->
            <div class="container">
            <div class="row page-titles mx-0">
                    <div class="col-sm-6 p-md-0">
                        <div class="welcome-text">
                            <h4>Profile</h4>
                        </div>
                    </div>
                    <div class="col-sm-6 p-md-0 justify-content-sm-end mt-2 mt-sm-0 d-flex">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.php">Home</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Dashboard</a></li>
                            <li class="breadcrumb-item active"><a href="javascript:void(0);">Profile</a></li>
                        </ol>
                    </div>
                </div>
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
                </div>
                <div class="card">
                    <div class="card-body">
                        <form action="./controller/profile/updateProfile.php" method="POST" enctype="multipart/form-data">
                            <?php
                            $idUser = $_SESSION['id_user'];

                            $getDataUser = mysqli_query($conn, "SELECT * FROM user INNER JOIN role ON role.id = user.role WHERE user.id = '$idUser'");

                            while ($dataUser = mysqli_fetch_array($getDataUser)) {
                                
                            ?>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <div class="picture-container">
                                    <div class="picture">
                                        <?php
                                        if ($dataUser['photo'] != null) {
                                            ?>
                                            <img src="./images/profile/image-profile/<?php echo $dataUser['photo'] ?>" alt="" id="blah" class="picture-src">
                                            <input type="file" id="wizard-picture" class="" onchange="readURL(this);" name="photo">
                                        <?php } else{?>
                                            <img src="./images/profile/unit.png" alt="" id="blah" class="picture-src">
                                            <input type="file" id="wizard-picture" class="" onchange="readURL(this);" name="photo">
                                            <?php }?>
                                    </div>
                                    <h6 class="mt-2 pict-text">Pilih Photo</h6>
                                    <h3><?php echo ucwords($dataUser['nama']) ?></h3>
                                    <p class="jabatan"><?php echo ucwords($dataUser['nama_role']) ?></p>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <table class="table border-0">
                                    <tr>
                                        <td>username</td>
                                        <td>:</td>
                                        <td><?php echo $dataUser['username'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Email</td>
                                        <td>:</td>
                                        <td><?php echo $dataUser['email'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>NO HP</td>
                                        <td>:</td>
                                        <td><?php echo $dataUser['no_telpon'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Joined at</td>
                                        <td>:</td>
                                        <td><?php echo $dataUser['created_at'] ?></td>
                                    </tr>
                                    <tr>
                                        <td>Alamat</td>
                                        <td>:</td>
                                        <td><?php echo $dataUser['alamat'] ?></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><strong>Email</strong></label>
                                                <input type="email" class="form-control" value="<?php echo $dataUser['email'] ?>" name="email">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><strong>NO HP</strong></label>
                                                <input type="text" class="form-control" value="<?php echo $dataUser['no_telpon'] ?>" name="no_hp">
                                                <input hidden type="text" class="form-control" value="<?php echo $dataUser['photo'] ?>" name="old_photo">
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label><strong>Password</strong></label>
                                                <input type="password" class="form-control" value="<?php echo $dataUser['password'] ?>" name="password">
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label><strong>Alamat</strong></label>
                                               <textarea name="alamat" class="form-control" id="" cols="30" rows="3"><?php echo $dataUser['alamat'] ?></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <button class="btn btn-primary float-right">Update</button>
                                </div>
                            </div>
                        <?php }?>
                        </form>
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

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
    <script src="vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="js/custom.min.js"></script>
    <script src="js/dlabnav-init.js"></script>
    <script src="js/jquery-3.5.1.min.js"></script>
    <script>
    function readURL(input) {
      if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function(e) {
          $('#blah')
            .attr('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
      }
    }
  </script>
    <!-- Demo scripts -->
    <script src="js/dashboard/dashboard-3.js"></script>

    

</body>

</html>