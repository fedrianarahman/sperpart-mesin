<?php
session_start();
include '../conn.php';

$kodeAuto = mysqli_query($conn, "SELECT max(kode_barang) AS maxKode FROM tb_barang");
$cekKodeAuto = mysqli_fetch_array($kodeAuto);
$kodeBarang = $cekKodeAuto++;
$huruf = "BRG-";
$akhirKode = "-GE";


?>