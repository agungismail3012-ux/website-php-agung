<?php
include 'koneksi.php';

$id = $_GET['id'];

// Mengubah status menjadi 'Selesai' berdasarkan ID tugas
$updateStatus = mysqli_query($conn, "UPDATE tugas SET status = 'Selesai' WHERE id = '$id'");

if($updateStatus) {
    header("Location: index.php");
} else {
    echo "<script>alert('Gagal memperbarui status!'); window.location='index.php';</script>";
}
?>