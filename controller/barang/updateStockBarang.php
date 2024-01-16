<?php
include '../conn.php';
if (isset($_POST['updateStock'])) {
    
    $kodeBarang = $_POST['kodeBarang'];
    $jumlahMasuk = $_POST['jumlahMasuk'];
    $createdAt = date('Y-m-d H:i:s');

    $getDataBarang = mysqli_query($conn, "SELECT * FROM tb_barang WHERE kode_barang = '$kodeBarang'");
    $result = mysqli_num_rows($getDataBarang);
    $dataBarang = mysqli_fetch_array($getDataBarang);

    $stockSetelahDiupdate = $dataBarang['jumlah_masuk'] + $jumlahMasuk;

    if ($result > 0) {
        
        $updateStockBarang = mysqli_query($conn, "UPDATE tb_barang SET jumlah_masuk = '$stockSetelahDiupdate' WHERE kode_barang = '$kodeBarang'");

        if ($updateStockBarang) {
            $addRiwayatJumlahMasuk = mysqli_query($conn, "INSERT INTO `riwayat_barang_masuk`(`id`, `kd_barang`, `jumlah_masuk`, `created_at`) VALUES ('','$kodeBarang','$jumlahMasuk','$createdAt')");
            
            if ($addRiwayatJumlahMasuk) {
                echo 'Stock Berhasil Ditambahkan';
            } else {
                echo 'Gagal';
            }
            
            
        } else {
            echo 'something wrong';
        }
        
    }
}

?>