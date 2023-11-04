<?php
session_start();
include '../conn.php';

if (isset($_POST['kode_barang'])) {
    
    $kodeBarang = $_POST['kode_barang'];

    $getDataGambar = mysqli_query($conn, "SELECT photo FROM tb_barang WHERE kode_barang = '$kodeBarang'");

    $arr_data = [];

    if (mysqli_num_rows($getDataGambar)>0) {
        while ($data = mysqli_fetch_array($getDataGambar)) {
            array_push($arr_data, ['data' => $data]);
        }
        header("Content-type: application/json");
        echo json_encode($arr_data);
    } else {
      echo "errorr";
    }
    
}

?>