<?php
session_start();
include '../conn.php';

$idUser = $_SESSION['id_user'];
$alamat = $_POST['alamat'];
$noHP = $_POST['no_hp'];
$email  = $_POST['email'];
$password = $_POST['password'];
if (!empty($_FILES['photo']['name'])) {
    $photo = upload();
    if (!$photo) {
        return false;
    }
} else {
    $photo = $_POST['old_photo'];
}

$updateProfile = mysqli_query($conn, "UPDATE user SET alamat='$alamat', no_telpon = '$noHP', email = '$email', password = '$password', photo = '$photo' WHERE id = '$idUser'");

if ($updateProfile) {
    $_SESSION['status-info'] = "Data Berhasil Dirubah";
} else {
    $_SESSION['status-fail'] = "Data Gagal Dirubah!";
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
    if ($ukuranFile > 1000000) {
        $_SESSION['status-fail'] = "Ukuran Gambar Terlalu Besar";
        return false;
    }

    // Buat nama file unik dengan timestamp
    $namaFileBaru = time() . '_' . $namaFile;

    // Lokasi penyimpanan file
    $lokasiSimpan = "../../images/profile/image-profile/" . $namaFileBaru;

    // Pindahkan file ke lokasi penyimpanan dengan nama baru
    if (move_uploaded_file($tmpName, $lokasiSimpan)) {
        return $namaFileBaru;
    } else {
        $_SESSION['status-fail'] = "Gagal Mengunggah Gambar";
        return false;
    }
}

header("Location:../../profilePage.php");
?>