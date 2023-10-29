<div class="dlabnav">
            <div class="dlabnav-scroll">
                <ul class="metismenu" id="menu">
                    <li class="nav-label first">Main Menu</li>
					<li class="mm-active"><a class="ai-icon" href="index.php" aria-expanded="false">
							<i class="la la-home"></i>
							<span class="nav-text">Dashboard</span>
						</a>
                    </li>
                    <?php
                    if ($_SESSION['role'] =='manager') {?>
					<li class=""><a class="ai-icon" href="dataUser.php" aria-expanded="false">
							<i class="la la-users"></i>
							<span class="nav-text">Data Users</span>
						</a>
                    </li>
                    <?php }?>
                    <?php if ($_SESSION['role'] == 'admin') {   
                    ?>
                    <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
							<i class="la la-users"></i>
							<span class="nav-text">Users</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="dataUser.php">All Users</a></li>
                            <li><a href="dataRole.php">role</a></li>
                           
                        </ul>
                    </li>
					<?php }?>
                    <li class=""><a class="ai-icon" href="dataBarang.php" aria-expanded="false">
							<i class="fa fa-bookmark"></i>
							<span class="nav-text">Data Barang</span>
						</a>
                    </li>
                   <?php if ($_SESSION['role'] !='teknisi') {
                    # code...
                   } ?>
                    <li class=""><a class="ai-icon" href="dataPermintaan.php" aria-expanded="false">
							<i class="fa fa-pencil-square-o"></i>
							<span class="nav-text">Permintaan</span>
						</a>
                    </li>
                    <!-- <li><a class="has-arrow" href="javascript:void()" aria-expanded="false">
							<i class="la la-building"></i>
							<span class="nav-text">Departments</span>
						</a>
                        <ul aria-expanded="false">
                            <li><a href="dataBarang.php">Data Barang</a></li>
                            <?php if ($_SESSION['role'] == 'manager' || $_SESSION['role'] == 'admin') {   
                            }
                    ?>
                            <li><a href="dataRak.php">Data Rak</a></li>
                            <li><a href="dataPermintaan.php">Permintaan</a></li>
                        </ul>
                    </li> -->
					
				</ul>
            </div>
        </div>