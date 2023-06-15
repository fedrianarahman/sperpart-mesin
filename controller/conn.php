<?php

$server = 'localhost';
$username = 'root';
$password = '';
$db_name = 'web_sparepart';

$conn = mysqli_connect($server,$username,$password,$db_name);

if (!$conn) {
    echo "
    <script>alert('Database Belum Dikoneksikan')</script>
    ";
}

?>