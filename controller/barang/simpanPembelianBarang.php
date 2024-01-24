<?php
include '../conn.php';

if (isset($_POST['simpanPembelianBarang'])) {
    $data = json_decode($_POST['data'], true);

    $values = [];
    foreach ($data as $key => $value) {
        $values[] = "'" . mysqli_real_escape_string($conn, $value) . "'";
    }

    $columnNames = implode(", ", array_keys($data));
    $columnValues = implode(", ", $values);

    $querySimpanData = mysqli_query($conn, "INSERT INTO pembelian_barang ($columnNames) VALUES ($columnValues)");

    if ($querySimpanData) {
        echo "Berhasil Mengajukan Pembelian Barang";
    } else {
        echo "Error Bos!";
    }
}
?>
