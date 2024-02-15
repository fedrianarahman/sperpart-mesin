<?php
include '../conn.php';
session_start();

if (isset($_POST['requestPembelianAll'])) {
    // Mendapatkan data barang yang ingin diajukan dari JavaScript
    $barangYangInginDiajukan = json_decode($_POST['barangYangInginDiajukan'], true);

    foreach ($barangYangInginDiajukan as $barang) {
        $kodeBarang = $barang['kode_barang'];
        $namaBarang = $barang['nama_barang'];
        $requester = $_SESSION['id_user'];
        $status = 'P'; // Misalkan status pembelian adalah "P" (Pending)

        // Simpan data pembelian barang ke database
        $simpanData = mysqli_query($conn, "INSERT INTO `pembelian_barang`(`kode_barang`, `nama_barang`, `requester`, `status`) VALUES ('$kodeBarang','$namaBarang','$requester','$status')");

        if ($simpanData) {
            // Update status pembelian barang di tabel tb_barang
            $ubahStatusPembelianBarang = mysqli_query($conn, "UPDATE tb_barang SET status_pembelian = 'P' WHERE kode_barang = '$kodeBarang'");

            if ($ubahStatusPembelianBarang) {
                echo "Permintaan Pembelian Barang Berhasil";
            } else {
                echo "Gagal mengubah status pembelian barang!";
            }
        } else {
            echo "Gagal menyimpan data pembelian barang!";
        }
    }
}
?>
