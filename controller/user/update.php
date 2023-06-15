<?php
session_start();
include '../conn.php';

$id_user = $_POST['id_user'];
$nama = strtolower($_POST['nama']);
$email = $_POST['email'];
$no_telpon = $_POST['no_telpon'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

// Mengubah Data
$updateDataUser = mysqli_query($conn, "UPDATE `user` SET `photo`='',`nama`='$nama',`email`='$email',`no_telpon`='$no_telpon',`username`='$username',`password`='$password',`alamat`='',`role`='$role' WHERE `id`='$id_user'");

if ($updateDataUser) {
    $_SESSION['status-info'] = "Data Berhasil Dirubah";
}else{
    $_SESSION['status-fail'] = "Data Tidak Berhasil Dirubah";
}

header("Location:../../dataUser.php");
?>