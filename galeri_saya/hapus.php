<?php
include 'koneksi.php';

$id = $_GET['id'];

// 1. Ambil data nama file gambar dari database terlebih dahulu sebelum dihapus
$query  = mysqli_query($conn, "SELECT gambar FROM galeri WHERE id = '$id'");
$data   = mysqli_fetch_assoc($query);
$gambar = $data['gambar'];

// 2. Cek apakah file gambarnya benar-benar ada di dalam folder uploads
if (file_exists("uploads/" . $gambar)) {
    // Jalankan perintah unlink() untuk menghapus file fisik gambar dari folder htdocs
    unlink("uploads/" . $gambar);
}

// 3. Setelah file fisiknya terhapus, baru hapus data barisnya di database
$delete = mysqli_query($conn, "DELETE FROM galeri WHERE id = '$id'");

if($delete) {
    header("Location: index.php");
} else {
    echo "<script>alert('Gagal menghapus arsip!'); window.location='index.php';</script>";
}
?>