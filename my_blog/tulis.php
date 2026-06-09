<?php
session_start();
include 'koneksi.php';

if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

if(isset($_POST['terbit'])) {
    $judul = $_POST['judul'];
    $isi   = $_POST['isi'];

    // Mengamankan input teks kiriman dari karakter aneh/simbol SQL injection
    $judul_aman = mysqli_real_escape_string($conn, $judul);
    $isi_aman   = mysqli_real_escape_string($conn, $isi);

    $insert = mysqli_query($conn, "INSERT INTO artikel (judul, isi) VALUES ('$judul_aman', '$isi_aman')");

    if($insert) {
        header("Location: dashboard.php");
    } else {
        echo "<script>alert('Gagal menerbitkan artikel!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tulis Artikel Baru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #0B0F19; color: #E2E8F0; padding: 40px 20px; }
        .container { max-width: 650px; margin: 0 auto; background: #1E293B; padding: 30px; border-radius: 12px; }
        h1 { font-size: 1.3rem; margin-bottom: 20px; color: #FFF; }
        
        .form-group { margin-bottom: 20px; }
        label { display: block; font-size: 0.85rem; color: #94A3B8; margin-bottom: 6px; }
        input, textarea { width: 100%; background: #0B0F19; border: 1px solid rgba(255,255,255,0.1); padding: 12px; border-radius: 8px; color: #FFF; font-size: 0.95rem; }
        input:focus, textarea:focus { border-color: #38BDF8; outline: none; }
        textarea { height: 250px; resize: vertical; line-height: 1.6; }
        
        .btn-submit { background: #38BDF8; color: #0B0F19; padding: 12px 25px; border: none; border-radius: 8px; font-weight: 600; font-size: 0.95rem; cursor: pointer; transition: 0.2s; }
        .btn-submit:hover { background: #7DD3FC; }
        .btn-back { color: #94A3B8; text-decoration: none; font-size: 0.9rem; margin-left: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h1>✍️ Tulis Artikel Baru</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label>Judul Artikel</label>
            <input type="text" name="judul" placeholder="Masukkan judul materi/catatan log Anda..." required>
        </div>
        <div class="form-group">
            <label>Isi Konten Artikel</label>
            <textarea name="isi" placeholder="Tuliskan isi pikiran, tutorial, atau jurnal belajar Anda di sini..." required></textarea>
        </div>
        <button type="submit" name="terbit" class="btn-submit">Terbitkan Artikel</button>
        <a href="dashboard.php" class="btn-back">Batal</a>
    </form>
</div>

</body>
</html>