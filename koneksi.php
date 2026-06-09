<?php
$host     = getenv('MYSQLHOST') ?: 'localhost';
$user     = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: ''; 
$database = getenv('MYSQLDATABASE') ?: 'db_portofolio'; // Ganti dengan nama database di XAMPP Anda
$port     = getenv('MYSQLPORT') ?: '3306';

$koneksi = mysqli_connect($host, $user, $password, $database, $port);
$conn = $koneksi;
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>