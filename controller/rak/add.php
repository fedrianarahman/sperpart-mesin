<?php
session_start();
include '../conn.php';

$rak = strtolower($_POST['rak']);

$cekDataRak  = mysqli_query($conn, "SELECT * FROM `rak_barang` WHERE nama_rak = '$rak'");
$result = mysqli_fetch_array($cekDataRak);

if ($result) {
    $_SESSION['status-fail'] = "Rak Sudah Tersedia";
} else {
    
    $addRak = mysqli_query($conn, "INSERT INTO `rak_barang`(`id`, `nama_rak`) VALUES ('','$rak')");

    if ($addRak) {
        $_SESSION['status-info'] = "Rak Berhasil Ditambahkan";
    } else {
        $_SESSION['status-fail'] = "Rak Tidak Berhasil Ditambahkan";
    }
    
}

header("Location:../../dataRak.php");
?>