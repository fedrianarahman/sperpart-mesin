<?php
include '../conn.php';
session_start();
if (isset($_POST['requestPembelian'])) {
    
    $kodeBarang = $_POST['kodeBarang'];
    $idUser = $_SESSION['id_user'];

    $getDataBarang = mysqli_query($conn, "SELECT * FROM tb_barang WHERE kode_barang = '$kodeBarang'");
    $result = mysqli_num_rows($getDataBarang);
    $dataBarang = mysqli_fetch_array($getDataBarang);

    $namaBarang = $dataBarang['nama_barang'];
    if ($result > 0) {
        $query = mysqli_query($conn, "INSERT INTO `pembelian_barang`(`id`, `kode_barang`, `nama_barang`, `requester`, `status`) VALUES ('','$kodeBarang','$namaBarang','$idUser','P')");
        if ($query) {
            $updateStatusPembelianBarang = mysqli_query($conn, "UPDATE tb_barang SET status_pembelian = 'P' WHERE kode_barang = '$kodeBarang'");

            if ($updateStatusPembelianBarang) {
                echo "Pengajuan Pembelian Barang Berhasil Diproses";
            } else {
                echo 'Error!';
            }
            

        } else {
            echo "Pengajuan Pembelian Barang Tidak Berhasil";
        }
        
    } else {
        echo "something wrong";
    }
    
}
?>