<?php
session_start();
include '../conn.php';

$id_user = $_SESSION['id_user'];
$nama_teknisi = $_POST['nama_teknisi'];
$nama_barang = $_POST['nama_barang'];
$jumlah_barang = $_POST['jumlah_barang'];

if (isset($_FILES['surat_request'])) {
    $filename = $_FILES["surat_request"]["name"];
    $tempname = $_FILES["surat_request"]["tmp_name"];  
    $folder = "C:\wamp64\www\project\sperpart-mesin\images\surat_permintaan/".$filename;   
    move_uploaded_file($tempname, $folder);

    $result = mysqli_query($conn, "INSERT INTO `tb_permintaan` (`id`, `id_user`,`nama_teknisi` , `nama_barang`, `jumlah_barang`, `surat_request`) VALUES ('', '$id_user', '$nama_teknisi', '$nama_barang','$jumlah_barang','$filename')");

    if($result) {
        $_SESSION['status-info'] = "Permintaan Berhasil DiUpdate";
    } else {
        $_SESSION['status-fail'] = "Permintaan Tidak Berhasil DiUpdate";
    }
}
header("Location:../../dataPermintaan.php");
?>