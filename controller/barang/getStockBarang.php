<?php
include '../conn.php';
session_start();

if (isset($_POST['getStockBarang'])) {
    $getDataBarang = mysqli_query($conn, "SELECT * FROM tb_barang WHERE jumlah_masuk < 20 AND status_pembelian = 'N'");
    
    $data = array();
    while ($row = mysqli_fetch_assoc($getDataBarang)) {
        $data[] = $row;
    }

    echo json_encode($data);
}
?>
