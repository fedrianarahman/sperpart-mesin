<?php
session_start();
include '../conn.php';

// menangkap kode berdasarkan parameter yang dikirimkan
$kode_barang = $_GET['kode_barang'];

$query = mysqli_query($conn, "DELETE FROM tb_barang WHERE kode_barang = '$kode_barang'");

if ($query) {
    $_SESSION['status-info'] = "Data Berhasil Dihapus";
} else {
    $_SESSION['status-fail'] = "Data Tidak Berhasil Dihapus";
}


header("Location:../../dataBarang.php");

?>