<?php
session_start();
include '../conn.php';

$id = $_GET['id'];

$cekData = mysqli_query($conn, "SELECT * FROM user WHERE id ='$id'");
$r = mysqli_fetch_array($cekData);

if ($r['isActive']== 1) {
    $changeStatus = mysqli_query($conn, "UPDATE user SET isActive ='0' WHERE id = '$id'");
    if ($changeStatus) {
        $_SESSION['status-info'] = "User Berhasil Dinonakktifkan";
    } else {
        $_SESSION['status-fail'] = "Terjadi Kesalahan";
    }
    
} else {
    $changeStatus = mysqli_query($conn, "UPDATE user SET isActive ='1' WHERE id = '$id'");
    if ($changeStatus) {
        $_SESSION['status-info'] = "User Berhasil Diaktifkan";
    } else {
        $_SESSION['status-fail'] = "Terjadi Kesalahan";
    }
}

header("Location:../../dataUser.php");
?>