<?php
session_start();
include '../conn.php';

$idRak = $_POST['id_rak'];
$nama_rak = strtolower($_POST['nama_rak']);

$updateRak = mysqli_query($conn, "UPDATE `rak_barang` SET `nama_rak`='$nama_rak' WHERE `id`='$idRak'");


if ($updateRak) {
    $_SESSION['status-info'] = "Berhasil update data";
} else {
    $_SESSION['status-fail'] = "Gagal mengupdate data";
}

header("Location:../../dataRak.php");
