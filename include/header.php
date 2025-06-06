<?php
session_start();
include './controller/conn.php';
?>
<style>
    .role-jabatan {
        position: absolute; 
    bottom: 0;
    left: 0; 
    width: 100%; 
    text-align: center;
    font-size: 12px;
    margin: 10px 0;
    color:#B2C8BA ;
    
    }
</style>
<div class="header">
            <div class="header-content">
                <nav class="navbar navbar-expand">
                    <div class="collapse navbar-collapse justify-content-between">
                        <div class="header-left">
                            <div class="search_bar dropdown">
                                <span class="search_icon p-3 c-pointer" data-toggle="dropdown">
                                    <!-- <i class="mdi mdi-magnify"></i> -->
                                </span>
                                <div class="dropdown-menu p-0 m-0">
                                    <form>
                                        <input class="form-control"  hidden type="search" placeholder="Search" aria-label="Search">
                                    </form>
                                </div>
                            </div>
                        </div>

                        <ul class="navbar-nav header-right">
                            <?php
                                $idUser = $_SESSION['id_user'];
                                $getDataUser = mysqli_query($conn, "SELECT * FROM user INNER JOIN role ON role.id = user.role WHERE user.id = '$idUser'");
                                while ($dataUser = mysqli_fetch_array($getDataUser)) {
                                    
                            ?>
                            <?php if ($_SESSION['role']=='staff gudang') {?>
                             <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell ai-icon" href="#" role="button" data-toggle="dropdown">
                                    <svg id="icon-user" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
										<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
										<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
									</svg>
                                    <?php 
                                   $query = mysqli_query($conn, "SELECT * FROM tb_barang WHERE jumlah_masuk < 20");
                                    $data = mysqli_num_rows($query);
                                    if ($data) {?>
                                    <div class="pulse-css"></div>
                                    <?php }?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="list-unstyled">
                                        <?php
                                        if ($data) {?>
                                        <li class="media dropdown-item">
                                            <span class="success"><i class="fa fa-superpowers"></i></span>
                                            <div class="media-body">
                                                <a href="premintaanPembelianBarang.php">
                                                    <p><strong><?php echo $data; ?> Barang</strong> Stock Menipis
                                                    </p>
                                                </a>   
                                            </div>
                                            
                                        </li>
                                        <?php } else{?>
                                            <li>
                                            <p class="text-center text-danger">Tidak Ada Data</p>
                                            </li>
                                        <?php }?>    
                                    </ul>
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($_SESSION['role']=='manager') {?>
                             <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell ai-icon" href="#" role="button" data-toggle="dropdown">
                                    <svg id="icon-user" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
										<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
										<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
									</svg>
                                    <?php 
                                   $query = mysqli_query($conn, "SELECT * FROM pembelian_barang WHERE status ='P'");
                                    $data = mysqli_num_rows($query);
                                    if ($data) {?>
                                    <div class="pulse-css"></div>
                                    <?php }?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="list-unstyled">
                                        <?php
                                        if ($data) {?>
                                        <li class="media dropdown-item">
                                            <span class="success"><i class="fa fa-superpowers"></i></span>
                                            <div class="media-body">
                                                <a href="dataPembelianBarang.php">
                                                    <p><strong><?php echo $data; ?>Permintaan Pembelian Barang</strong> 
                                                    </p>
                                                </a>   
                                            </div>
                                            
                                        </li>
                                        <?php } else{?>
                                            <li>
                                            <p class="text-center text-danger">Tidak Ada Data</p>
                                            </li>
                                        <?php }?>    
                                    </ul>
                                </div>
                            </li>
                            <?php }?>
                            <?php if ($_SESSION['role']=='supervisor') {?>
                                <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell ai-icon" href="#" role="button" data-toggle="dropdown">
                                    <svg id="icon-user" xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
										<path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
										<path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
									</svg>
                                    <?php 
                                    $idUser = $_SESSION['id_user'];
                                   $query = mysqli_query($conn, "SELECT * FROM pembelian_barang WHERE status ='A-' AND id_superVisor= '$idUser'");
                                    $data = mysqli_num_rows($query);
                                    if ($data) {?>
                                    <div class="pulse-css"></div>
                                    <?php }?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <ul class="list-unstyled">
                                        <?php
                                        if ($data) {?>
                                        <li class="media dropdown-item">
                                            <span class="success"><i class="fa fa-superpowers"></i></span>
                                            <div class="media-body">
                                                <a href="dataPembelianBarangSupervisor.php">
                                                    <p><strong><?php echo $data; ?> Permintaan Pembelian Barang</strong> 
                                                    </p>
                                                </a>   
                                            </div>
                                            
                                        </li>
                                        <?php } else{?>
                                            <li>
                                            <p class="text-center text-danger">Tidak Ada Data</p>
                                            </li>
                                        <?php }?>    
                                    </ul>
                                </div>
                            </li>
                            <?php }?>
                            <li class="nav-item dropdown notification_dropdown">
                                <a class="nav-link bell ai-icon" href="#" role="button" data-toggle="dropdown">
                                    <?php echo ucwords($dataUser['nama']) ?>
                                    <!-- <div class="pulse-css"></div> color:#B2C8BA ;-->
                                </a>
                                <span class="role-jabatan"><?php echo ucwords($dataUser['nama_role']) ?></span>
                                
                            </li>
                            
                            <li class="nav-item dropdown header-profile">
                                <a class="nav-link" href="#" role="button" data-toggle="dropdown">
                                    <?php
                                    if ($dataUser['photo'] != null) {
                                     ?>
                                       <img src="./images/profile/image-profile/<?php echo $dataUser['photo'] ?>" alt="" id="blah" class="picture-src">
                                     <?php }else{ ?>
                                        <img src="images/profile/unit.png" width="20" alt="">
                                        <?php }?>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a href="./profilePage.php" class="dropdown-item ai-icon">
                                        <svg id="icon-user1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                                        <span class="ml-2">Profile </span>
                                    </a>
                                    <a href="logout.php" class="dropdown-item ai-icon">
                                        <svg id="icon-logout" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewbox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-log-out"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                                        <span class="ml-2">Logout </span>
                                    </a>
                                </div>
                            </li>
                            <?php }?>
                        </ul>
                    </div>
                </nav>
            </div>
        </div>