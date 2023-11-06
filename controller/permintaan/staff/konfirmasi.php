<?php
session_start();
include '../../conn.php';

$iduser = $_SESSION['id_user'];
$status = 'A-';
$id = $_POST['id_permintaan'];

$updateData = mysqli_query($conn, "UPDATE tb_permintaan SET status = '$status', accepter = '$iduser' WHERE id  = '$id'");

if ($updateData) {
    $_SESSION['status-info'] = "Permintaan Berhasil Di Konfirmasi";
} else {
   $_SESSION['status-fail'] = "Permintaan Tidak Berhasil Dikonfirmasi";
}

header("Location:../../../dataPermintaan.php");
?>