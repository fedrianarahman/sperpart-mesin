<?php
include '../conn.php';
if (isset($_POST['kirimKeSuperVisor'])) {
    $idPembelianBarang = $_POST['idPembelianBarang'];
    $idSuperVisor = $_POST['idSuperVisor'];

    $status = 'A-';

    $query = mysqli_query($conn, "UPDATE pembelian_barang SET id_superVisor = '$idSuperVisor', status = '$status' WHERE created_at = '$idPembelianBarang'");

    if ($query) {
        echo "Berhasil Mengirim KE Supervisor";
    } else {
        echo "Something wrong";
    }
}
?> 
