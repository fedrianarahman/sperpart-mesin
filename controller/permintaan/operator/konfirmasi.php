<?php
session_start();
include '../../conn.php';

$idUser = $_SESSION['id_user'];
$status = 'A+';
$idPermintaan = $_GET['id_permintaan'];

$updateStatus = mysqli_query($conn, "UPDATE tb_permintaan SET status = '$status', operator = '$idUser' WHERE id = '$idPermintaan'");

if ($updateStatus) {
    $_SESSION['status-info'] = "Permintaan Berhasil Dikonfirmasi";
} else {
    $_SESSION['status-fail'] = "Permintaan Berhasil Dikonfirmasi";
}

header("Location:../../../dataPermintaan.php");

?>