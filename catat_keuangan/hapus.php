<?php
include 'koneksi.php';

$id = $_GET['id'];

$delete = mysqli_query($conn, "DELETE FROM transaksi WHERE id = '$id'");

if($delete) {
    header("Location: index.php");
} else {
    echo "<script>alert('Gagal menghapus catatan keuangan!'); window.location='index.php';</script>";
}
?>