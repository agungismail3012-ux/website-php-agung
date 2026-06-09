<?php
// 1. Membaca Environment Variables dari Railway secara otomatis
// Jika tidak ada (artinya sedang dibuka di laptop), dia akan otomatis pakai cadangan di sebelah kanan (?:)
$host     = getenv('MYSQLHOST') ?: 'localhost';
$user     = getenv('MYSQLUSER') ?: 'root';
$password = getenv('MYSQLPASSWORD') ?: ''; // Kosongkan jika XAMPP Anda tidak pakai password
$database = getenv('MYSQLDATABASE') ?: 'db_portofolio'; 
$port     = getenv('MYSQLPORT') ?: '3306';

// 2. Membuat koneksi ke database
$koneksi = mysqli_connect($host, $user, $password, $database, $port);

// 3. Cek koneksi apakah berhasil atau gagal
if (!$koneksi) {
    die("Koneksi ke database gagal: " . mysqli_connect_error());
}
?>