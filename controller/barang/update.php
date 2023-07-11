<?php
session_start();
include '../conn.php';

$kode_brg = $_POST['kd_brg'];
$nama_barang = trim(strtolower($_POST['nama_barang']));
$merek_barang = trim(strtolower($_POST['merk_barang']));
$rak_barang = $_POST['nama_rak'];
$satuan_barang = trim(strtolower($_POST['satuan_barang']));
$awal = $_POST['awal'];
$masuk = $_POST['masuk'];
$keluar = $_POST['keluar'];
$akhir = $_POST['akhir'];
$tgl_dirubah = date('Y-m-d H:i:s');

$updateBarang = mysqli_query($conn, "UPDATE `tb_barang` SET `nama_barang`='$nama_barang',`merek`='$merek_barang',`rak`='$rak_barang',`satuan`='$satuan_barang',`awal`='$awal',`masuk`='$masuk',`keluar`='$keluar',`akhir`='$akhir',`updated_at`='$tgl_dirubah' WHERE `kode_barang`='$kode_brg'");

if ($updateBarang) {
    $_SESSION['status-info'] = "Data Berhasil Dipudate";
}else{
    $_SESSION['status-fail'] = "Data Tidak Berhasil Dirubah";
}

header("Location:../../DataBarang.php");
?>