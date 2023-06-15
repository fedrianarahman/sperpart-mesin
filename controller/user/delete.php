<?php
session_start();
include '../conn.php';

$id = $_GET['id'];

$hapusData = mysqli_query($conn, "DELETE  FROM user WHERE id = '$id'");

if ($hapusData) {
    $_SESSION['status-info'] = "Data Berhasil dihapus";
}else{
    $_SESSION['status-fail'] = "Data Tidak Berhasil Dihapus";
}

header("Location:../../dataUser.php");
?>