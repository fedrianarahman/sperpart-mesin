<?php
session_start();
include '../conn.php';

$id_role = $_POST['id_role'];
$nama_role = strtolower($_POST['role']);

$query = mysqli_query($conn, "UPDATE `role` SET `nama_role`='$nama_role' WHERE `id`='$id_role'");

if ($query) {
    $_SESSION['status-info'] = "Data Berhasil Diubah";
}else{
    $_SESSION['status-fail'] = "Data Tidak Berhasil Diubah";
}


header("Location:../../dataRole.php");
?>