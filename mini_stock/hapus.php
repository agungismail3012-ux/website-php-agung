<?php
include 'koneksi.php';

// Mengambil ID dari parameter URL
$id = $_GET['id'];

// Menghapus data berdasarkan ID
$delete = mysqli_query($conn, "DELETE FROM barang WHERE id = '$id'");

if($delete) {
    header("Location: index.php");
} else {
    echo "<script>alert('Gagal menghapus data!'); window.location='index.php';</script>";
}
?>