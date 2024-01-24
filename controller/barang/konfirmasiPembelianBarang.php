<?php
include '../conn.php';
session_start();
date_default_timezone_set('Asia/Jakarta');
$idPembelian = $_GET['id_pembelian'];
$accepter = $_SESSION['id_user'];
$tglPenyetujuan = date('Y-m-d H:i:s');

// cek data 
$cekData = mysqli_query($conn, "SELECT * FROM pembelian_barang WHERE created_at = '$idPembelian'");
$data = mysqli_fetch_array($cekData);
var_dump($data);
$kodeBarang = $data['kode_barang'];

if ($kodeBarang != null) {
    
$updateStatusPembelian = mysqli_query($conn, "UPDATE pembelian_barang SET status = 'A',accepter = '$accepter', updated_at = '$tglPenyetujuan' WHERE created_at = '$idPembelian'");

if ($updateStatusPembelian) {
    $updateStatusBarang  = mysqli_query($conn, "UPDATE tb_barang SET status_pembelian = 'P' WHERE kode_barang = '$kodeBarang'");

    if ($updateStatusBarang) {
        $_SESSION['status-info'] = "Permintaan Berhasil Dikonfirmasi";
    } else {
        $_SESSION['status-fail'] = "PErmintaan Gagal Dikonfirmasi";
    }
    
} else {
    $_SESSION['status-fail'] = "Gagal Mengkonfirmasi Permintaan !";
}
} else {
   $_SESSION['status-fail'] = "Error!";
}

header("Location:../../detailPembelianBarang.php?id=$idPembelian");

?>