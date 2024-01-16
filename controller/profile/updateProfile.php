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

if (!empty($_FILES['tanda_tangan']['name'])) {
    $tandaTangan = uploadTandaTangan();
    if (!$tandaTangan) {
        return false;
    }
} else {
    $tandaTangan = $_POST['ttd_old'];
}


$updateProfile = mysqli_query($conn, "UPDATE user SET alamat='$alamat', no_telpon = '$noHP', email = '$email', password = '$password', photo = '$photo', tanda_tangan = '$tandaTangan' WHERE id = '$idUser'");

if ($updateProfile) {
    $_SESSION['status-info'] = "Data Berhasil Dirubah";
} else {
    $_SESSION['status-fail'] = "Data Gagal Dirubah!";
}


function uploadTandaTangan (){
    $namaFile = $_FILES['tanda_tangan']['name'];
    $ukuranFile = $_FILES['tanda_tangan']['size'];
    $error = $_FILES['tanda_tangan']['error'];
    $tmpName = $_FILES['tanda_tangan']['tmp_name'];

    if ($error === 4) {
        $_SESSION['status-fail'] = "Pilih Gambar Dulu";
        return false;
    }

    // cek apakah yang diupload adalah gambar
    $ekstensiGambarValid = ['jpg','jpeg','png','svg'];
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
    $lokasiSimpan = "../../images/ttd/" . $namaFileBaru;

    // Pindahkan file ke lokasi penyimpanan dengan nama baru
    if (move_uploaded_file($tmpName, $lokasiSimpan)) {
        return $namaFileBaru;
    } else {
        $_SESSION['status-fail'] = "Gagal Mengunggah Gambar";
        return false;
    }
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