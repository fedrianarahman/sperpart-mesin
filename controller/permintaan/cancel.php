<?php
session_start();
include '../conn.php';

if (isset($_POST['id'])) {
    
    $id = $_POST['id'];

    $getDataPermintaan = mysqli_query($conn, "SELECT * FROM tb_permintaan WHERE id = '$id'");
    $resultDataPermintaan = mysqli_fetch_array($getDataPermintaan);

    $namaBarang = $resultDataPermintaan['nama_barang'];
    $jumlahBarangKeluar = $resultDataPermintaan['jumlah_barang'];
    
    // mengambil data barang berdasarkan nama barang
    $getDataBarang = mysqli_query($conn, "SELECT * FROM tb_barang WHERE nama_barang = '$namaBarang'");
    $resultDataBarang = mysqli_fetch_array($getDataBarang);

    $returnStock = $resultDataBarang['jumlah_masuk'] + $resultDataPermintaan['jumlah_barang'];
    $returnBarangKeluar = $resultDataBarang['jumlah_keluar'] - $resultDataPermintaan['jumlah_barang'];

    // membatalkan permintaan
    $batalkanPermintaan = mysqli_query($conn, "UPDATE tb_permintaan SET status = 'C' WHERE id = '$id'");

    if ($batalkanPermintaan) {
    //    update stock di table barang
        $updateStockBarang = mysqli_query($conn, "UPDATE tb_barang SET jumlah_masuk = '$returnStock', jumlah_keluar = '$returnBarangKeluar' WHERE nama_barang = '$namaBarang'");
        if ($updateStockBarang) {
            echo 'sukses';
        } else {
            echo 'error1';
        }
        
    } else {
        echo 'error2';
    }
    

   


}
