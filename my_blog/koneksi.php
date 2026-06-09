<?php
$host     = getenv('MYSQLHOST') ?: 'localhost';
$user     = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: ''; 
$database = getenv('MYSQLDATABASE') ?: 'db_blog'; // Sesuaikan nama DB lokal laptop Anda
$port     = getenv('MYSQLPORT') ?: '3306';

$koneksi = mysqli_connect($host, $user, $password, $database, $port);
$conn = $koneksi; // Cadangan jika script Anda menggunakan nama variabel $conn

if (!$koneksi) {
    die("Koneksi database gagal: " . mysqli_connect_error());
}
?>