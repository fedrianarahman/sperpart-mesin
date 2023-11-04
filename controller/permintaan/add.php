<?php
session_start();
include '../conn.php';

$id_user = $_SESSION['id_user'];
$nama_teknisi = $_POST['nama_teknisi'];
$kode_barang = $_POST['kode_barang'];
$jumlah_barang = $_POST['jumlah_barang'];

// cek ketersediaan barang
$cekJumlahBarang = mysqli_query($conn, "SELECT * FROM tb_barang WHERE kode_barang = '$kode_barang'");
$r = mysqli_fetch_array($cekJumlahBarang);
$namaBarang = $r['nama_barang'];
$jumlahStock = $r['jumlah_masuk'];
$sisaStock = $r['jumlah_masuk'] - $jumlah_barang;
// $created_at = date('Y:m:d H:i:s');

if ($jumlah_barang > $r['jumlah_masuk']) {
    $_SESSION['status-fail'] = "Jumlah Permintaan Melebihi Stock Yang Ada";
    header("Location:../../addPermintaan.php");
} else {
    
    $addRequest = mysqli_query($conn, "INSERT INTO `tb_permintaan`(`id`, `nama_barang`, `id_user`, `nama_teknisi`, `jumlah_barang`, `status`) VALUES ('','$namaBarang','$id_user','$nama_teknisi','$jumlah_barang','P')");

    if ($addRequest) {

        $updateStockBarang = mysqli_query($conn, "UPDATE tb_barang SET jumlah_masuk = '$sisaStock', jumlah_keluar = '$jumlah_barang' WHERE kode_barang = '$kode_barang'");
        if ($updateStockBarang) {
            $_SESSION['status-info'] = "Permintaan Berhasil, Silahkan Tunggu Konfirmasi";
        } else {
            $_SESSION['status-fail'] = "Permintaan Gagal";
        }
        
    } else {
        $_SESSION['status-fail'] = "Permintaan Gagal";
    }
    
    header("Location:../../dataPermintaan.php");
}


?>