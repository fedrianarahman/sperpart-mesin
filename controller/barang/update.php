<?php
session_start();
include '../conn.php';

$kode_brg = $_POST['kd_brg'];
$nama_barang = trim(strtolower($_POST['nama_barang']));
$merek_barang = trim(strtolower($_POST['merk_barang']));
$rak_barang = $_POST['nama_rak'];
$satuan_barang = trim(strtolower($_POST['satuan_barang']));
$stock_barang = $_POST['stock_barang'];

$tgl_dirubah = date('Y-m-d H:i:s');

// photo
if (!empty($_FILES['photo']['name'])) {
    $photo = upload();
    if (!$photo) {
        return false;
    }
} else {
    $photo = $_POST['old_photo'];
}

$updateBarang = mysqli_query($conn, "UPDATE `tb_barang` SET `nama_barang`='$nama_barang',`photo`='$photo',`merek`='$merek_barang',`rak`='$rak_barang',`satuan`='$satuan_barang',`jumlah_masuk`='$stock_barang',`updated_at`='' WHERE `kode_barang`='$kode_brg'");

if ($updateBarang) {
    $_SESSION['status-info'] = "Data Berhasil Dipudate";
}else{
    $_SESSION['status-fail'] = "Data Tidak Berhasil Dirubah";
}

function upload() {
    $namaFile = $_FILES['photo']['name'];
    $ukuranFile = $_FILES['photo']['size'];
    $error =  $_FILES['photo']['error'];
    $tmpName = $_FILES['photo']['tmp_name'];

    if ($error === 4) {
        $_SESSION['status-fail'] = "Pilih Gambar Dulu";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg', 'jpeg', 'png', 'svg'];
    $ekstensiGambar = explode('.', $namaFile);
    $ekstensiGambar = strtolower(end($ekstensiGambar));

    if (!in_array($ekstensiGambar, $ekstensiGambarValid)) {
        $_SESSION['status-fail'] = "Yang Anda Upload Bukan Gambar";
        return false;
    }

    // cek ukuran gambar jika terlalu besar
    if ($ukuranFile > 5000000) {
        $_SESSION['status-fail'] = "Ukuran Gambar Terlalu Besar";
        return false;
    }

    // Buat nama file unik dengan timestamp
    $namaFileBaru = time() . '_' . $namaFile;

    // Lokasi penyimpanan file
    $lokasiSimpan = "../../images/barang/" . $namaFileBaru;

    // Pindahkan file ke lokasi penyimpanan dengan nama baru
    if (move_uploaded_file($tmpName, $lokasiSimpan)) {
        return $namaFileBaru;
    } else {
        $_SESSION['status-fail'] = "Gagal Mengunggah Gambar";
        return false;
    }
}

header("Location:../../DataBarang.php");
?>