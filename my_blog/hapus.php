<?php
session_start();
include 'koneksi.php';

// Keamanan Tambahan: Jika belum login tapi mencoba akses file ini, langsung tolak
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

$id = $_GET['id'];

// Eksekusi hapus artikel
$delete = mysqli_query($conn, "DELETE FROM artikel WHERE id = '$id'");

if($delete) {
    header("Location: dashboard.php");
} else {
    echo "<script>alert('Gagal menghapus artikel!'); window.location='dashboard.php';</script>";
}
?>