<?php
include '../conn.php';

$nama = $_POST['nama'];
$email = $_POST['email'];
$no_hp = $_POST['no_telpon'];
$username = $_POST['username'];
$password = $_POST['password'];
$role = $_POST['role'];

$cekUsername = mysqli_query($conn, "SELECT * FROM user WHERE username = '$username' AND role = '$role'");
$resultCekUsername = mysqli_fetch_array($cekUsername);

if ($resultCekUsername) {
    echo'200';
} else {
   echo '401';
}


