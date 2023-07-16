<?php
session_start();
include '../conn.php';

$id = $_GET['id'];

var_dump($id);

$acc = mysqli_query($conn, "UPDATE `tb_permintaan` SET `status`='Acc Operator' WHERE `id`= '$id'");

if ($acc) {
    $_SESSION['status-info'] = "ACC OPERATOR Berhasil";
}else{
    $_SESSION['status-fail'] = "ACC OPERATOR Tidak Berhasil";
}

header("Location:../../dataPermintaan.php");
?>