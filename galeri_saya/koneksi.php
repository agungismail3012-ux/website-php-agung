<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_galeri";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi ke database galeri gagal: " . mysqli_connect_error());
}
?>