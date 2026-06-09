<?php 
include 'koneksi.php'; 

if(isset($_POST['upload'])) {
    $nama_pencapaian = $_POST['nama_pencapaian'];
    $kategori        = $_POST['kategori'];
    
    // Informasi File Gambar yang diupload
    $nama_file = $_FILES['gambar']['name'];
    $tmp_name  = $_FILES['gambar']['tmp_name'];
    $error_file = $_FILES['gambar']['error'];
    
    // Memisahkan nama file dengan ekstensi untuk keamanan nama file unik
    $ekstensi_valid = ['jpg', 'jpeg', 'png'];
    $ekstensi_gambar = explode('.', $nama_file);
    $ekstensi_gambar = strtolower(end($ekstensi_gambar));

    // Validasi apakah yang diupload benar-block gambar
    if(in_array($ekstensi_gambar, $ekstensi_valid)) {
        if($error_file === 0) {
            // Membuat nama file baru yang acak unik agar tidak ada file yang bentrok namanya
            $nama_file_baru = uniqid() . '.' . $ekstensi_gambar;
            
            // Proses pemindahan file asli ke folder 'uploads' di komputer kita
            move_uploaded_file($tmp_name, 'uploads/' . $nama_file_baru);
            
            // Menyimpan nama file barunya ke database
            $insert = mysqli_query($conn, "INSERT INTO galeri (nama_pencapaian, kategori, gambar) VALUES ('$nama_pencapaian', '$kategori', '$nama_file_baru')");
            
            if($insert) {
                header("Location: index.php");
                exit;
            } else {
                echo "<script>alert('Gagal mencatat database!');</script>";
            }
        } else {
            echo "<script>alert('Terjadi error saat mengupload file!');</script>";
        }
    } else {
        echo "<script>alert('Format file harus JPG, JPEG, atau PNG!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Upload Arsip Baru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #0B0F19; color: #E2E8F0; padding: 40px 20px; }
        .container { max-width: 450px; margin: 0 auto; background: #1E293B; padding: 30px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        h1 { font-size: 1.25rem; margin-bottom: 20px; color: #FFF; }
        
        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 0.85rem; color: #94A3B8; margin-bottom: 6px; }
        input[type="text"], select { width: 100%; background: #0B0F19; border: 1px solid rgba(255,255,255,0.1); padding: 11px 14px; border-radius: 8px; color: #FFF; font-size: 0.9rem; }
        input[type="file"] { color: #94A3B8; font-size: 0.9rem; margin-top: 5px; }
        input:focus, select:focus { border-color: #38BDF8; outline: none; }
        
        .btn-submit { background: #38BDF8; color: #0B0F19; width: 100%; padding: 12px; border: none; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; margin-top: 10px; }
        .btn-submit:hover { background: #7DD3FC; }
        .btn-back { display: block; text-align: center; color: #94A3B8; text-decoration: none; font-size: 0.85rem; margin-top: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h1>📦 Upload Arsip Baru</h1>
    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label>Nama Sertifikat / Project</label>
            <input type="text" name="nama_pencapaian" placeholder="Misal: Sertifikat Backend PHP Dicoding" required>
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori">
                <option value="Sertifikat">Sertifikat</option>
                <option value="Project">Project Website</option>
            </select>
        </div>
        <div class="form-group">
            <label>Pilih File Gambar (JPG / PNG)</label>
            <input type="file" name="gambar" accept="image/*" required>
        </div>
        <button type="submit" name="upload" class="btn-submit">Simpan ke Galeri</button>
        <a href="index.php" class="btn-back">← Kembali</a>
    </form>
</div>

</body>
</html>