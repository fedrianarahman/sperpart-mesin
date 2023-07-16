<?php
session_start();
include '../conn.php';

$id = $_GET['id'];

var_dump($id);

$acc = mysqli_query($conn, "UPDATE `tb_permintaan` SET `status`='Ditolak' WHERE `id`= '$id'");

if ($acc) {
    $_SESSION['status-info'] = "PERMINTAAN DI TOLAK Berhasil";
}else{
    $_SESSION['status-fail'] = "PERMINTAAN DI TOLAK Tidak Berhasil";
}

header("Location:../../dataPermintaan.php");
?>