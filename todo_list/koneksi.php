<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "db_todolist"; // Menghubungkan ke database to-do list

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}
?>