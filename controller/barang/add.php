<?php
session_start();
include '../conn.php';

$huruf = "BRG-";
$akhirKode = "-GE";
$urutan = 1;

// membuat kode otomatis saat masuk ke database
$kodeAuto = mysqli_query($conn, "SELECT max(kode_barang) AS maxKode FROM tb_barang");
$cekKodeAuto = mysqli_fetch_array($kodeAuto);
$kodeBarang = $cekKodeAuto['maxKode'];
if ($kodeBarang === NULL) {
    $kodeBarang = 1; // Set it to 1 if it's NULL
} else {
    $urutan = (int)substr($kodeBarang, 4, 3);
    $urutan++;
}
$kd_brg = $huruf . sprintf("%03d", $urutan) . $akhirKode;

// kode barang berdasarkan kode yang digenerate di atas
$kode_barang = $kd_brg;

// menangkap data yang dikirimkan dari form input
$nama_barang = strtolower($_POST['nama_barang']);
$merk_barang = strtolower($_POST['merk_barang']);
$nama_rak = $_POST['nama_rak'];
$stock = $_POST['stock'];
$satuan_barang = strtolower($_POST['satuan_barang']);
$awal = !empty($_POST['awal']) ? $_POST['awal'] : 0;
$masuk = !empty($_POST['masuk']) ? $_POST['masuk'] : 0;
$keluar = !empty($_POST['keluar']) ? $_POST['keluar'] : 0;
$akhir = !empty($_POST['akhir']) ? $_POST['akhir'] : 0;
$tgl_input = date('Y-m-d H:i:s');
// memasukan data ke database

// photo
if (!empty($_FILES['photo']['name'])) {
    $photo = upload();
    if (!$photo) {
        return false;
    }
} else {
    $photo = $_POST['old_photo'];
}


// $query = mysqli_query($conn, "INSERT INTO `tb_barang`(`kode_barang`, `nama_barang`, `merek`, `rak`, `satuan`, `awal`, `masuk`, `keluar`, `akhir`, `created_at`, `updated_at`) VALUES ('$kode_barang','$nama_barang','$merk_barang','$nama_rak','$satuan_barang','$awal','$masuk','$keluar','$akhir','$tgl_input','')");
$query = mysqli_query($conn, "INSERT INTO `tb_barang`(`kode_barang`, `nama_barang`,`photo`, `merek`, `rak`, `satuan`, `jumlah_awal`, `jumlah_masuk`, `jumlah_keluar`, `jumlah_total`, `jumlah_akhir`, `stock`,`created_at`, `updated_at`) VALUES ('$kode_barang','$nama_barang','$photo','$merk_barang','$nama_rak','$satuan_barang','$awal','$masuk','$keluar','$akhir','','$stock','$tgl_input','')");

if ($query) {
    $_SESSION['status-info'] = "Data Berhasil Ditambahkan";
} else {
    $_SESSION['status-fail'] = "Data Tidak Berhasil Ditambahkan";
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
    $lokasiSimpan = "../../images/barang/" . $namaFileBaru;

    // Pindahkan file ke lokasi penyimpanan dengan nama baru
    if (move_uploaded_file($tmpName, $lokasiSimpan)) {
        return $namaFileBaru;
    } else {
        $_SESSION['status-fail'] = "Gagal Mengunggah Gambar";
        return false;
    }
}

header("Location:../../dataBarang.php");



?>