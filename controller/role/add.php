<?php
session_start();
include '../conn.php';

// mengambil data yang dikirimkan dari from
$role = strtolower($_POST['role']);

// mengecek apakah ada data yang sama
$cekData = mysqli_query($conn, "SELECT * FROM `role` WHERE nama_role like '%" . $role . "%' ");
$result = mysqli_fetch_array($cekData);

if (!empty($result['nama_role'])) {
    $_SESSION['status-fail'] = "Nama RoleSudah Ada";
}else{
    $query = mysqli_query($conn, "INSERT INTO `role`(`id`, `nama_role`) VALUES ('','$role')");
    if ($query) {
        $_SESSION['status-info'] = "Data Berhasil Ditambahkan";
    } else {
        $_SESSION['status-fail'] = "Data Tidak Berhasil Ditambahkan";
    }
}

header("Location:../../dataRole.php");

?>