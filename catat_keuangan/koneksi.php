<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_keuangan";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi database keuangan gagal: " . mysqli_connect_error());
}
?>