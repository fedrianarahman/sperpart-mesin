<?php
session_start();
include '../conn.php';

$id = $_GET['id'];
$nama_teknisi = $_POST['nama_teknisi'];
$jumlah_barang = $_POST['jumlah_barang'];

if (isset($_FILES['surat_request'])) {
    $filename = $_FILES["surat_request"]["name"];
    $tempname = $_FILES["surat_request"]["tmp_name"];  
    $folder = "C:\wamp64\www\project\sperpart-mesin\images\surat_permintaan/".$filename;   
    move_uploaded_file($tempname, $folder);
    $result = mysqli_query($conn, "UPDATE `tb_permintaan` SET `surat_request`=$filename,`nama_teknisi`='$nama_teknisi',`jumlah_barang`='$jumlah_barang' WHERE `tb_permintaan`.`id`='$id'");
} else {
    $result = mysqli_query($conn, "UPDATE `tb_permintaan` SET `nama_teknisi`='$nama_teknisi',`jumlah_barang`='$jumlah_barang' WHERE `tb_permintaan`.`id`='$id'");
}

if($result) {
    $_SESSION['status-info'] = "Permintaan Berhasil Ditambahkan";
} else {
    $_SESSION['status-fail'] = "Permintaan Tidak Berhasil Ditambahkan";
}

header("Location:../../dataPermintaan.php");
?>