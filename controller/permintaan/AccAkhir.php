<?php
session_start();
include '../conn.php';

$id = $_GET['id'];

var_dump($id);

$acc = mysqli_query($conn, "UPDATE `tb_permintaan` SET `status`='Acc Akhir' WHERE `id`= '$id'");

if ($acc) {
    $_SESSION['status-info'] = "ACC AKHIR MANAGER / STAFF GUDANG Berhasil";
}else{
    $_SESSION['status-fail'] = "ACC AKHIR MANAGER / STAFF GUDANG Tidak Berhasil";
}

header("Location:../../dataPermintaan.php");
?>