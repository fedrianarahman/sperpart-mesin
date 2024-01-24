<?php
include '../conn.php';
session_start();
if (isset($_POST['requestPembelianAll'])) {

    $getDataBarangYangMenipis = mysqli_query($conn, "SELECT * FROM tb_barang WHERE jumlah_masuk < 20 AND status_pembelian = 'N'");
    
    $kodeBarang = "";
    $namaBarang = "";
    $requester = $_SESSION['id_user'];
    $status = 'P';
    
    while ($data = mysqli_fetch_array($getDataBarangYangMenipis)) {
        $kodeBarang = $data['kode_barang'];
        $namaBarang = $data['nama_barang'];
        
        $simpanData = mysqli_query($conn, "INSERT INTO `pembelian_barang`(`id`, `kode_barang`, `nama_barang`, `requester`, `status`) VALUES ('','$kodeBarang','$namaBarang','$requester','$status')");

        if ($simpanData) {
            $ubahStatusPembelianBarang = mysqli_query($conn, "UPDATE tb_barang SET status_pembelian = 'P' WHERE jumlah_masuk < 20 AND status_pembelian = 'N'");
            if ($ubahStatusPembelianBarang) {
                echo "Permintaan Pembelian Barang Berhasil";
            }else{
                echo "Gagal !";
            }
            
        } else {
            echo "Error Bos!";
        }
        
    }
    
}
?>
