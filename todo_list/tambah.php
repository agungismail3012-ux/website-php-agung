<?php 
include 'koneksi.php'; 

if(isset($_POST['tambah'])) {
    $nama_tugas = $_POST['nama_tugas'];
    $kategori   = $_POST['kategori'];
    $prioritas  = $_POST['prioritas'];

    $insert = mysqli_query($conn, "INSERT INTO tugas (nama_tugas, kategori, prioritas, status) VALUES ('$nama_tugas', '$kategori', '$prioritas', 'Belum Selesai')");

    if($insert) {
        header("Location: index.php");
    } else {
        echo "<script>alert('Gagal menambah tugas!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Tambah Tugas Baru</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #0B0F19; color: #E2E8F0; padding: 40px 20px; }
        .container { max-width: 450px; margin: 0 auto; background: #1E293B; padding: 30px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        h1 { font-size: 1.25rem; margin-bottom: 20px; color: #FFF; }
        
        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 0.85rem; color: #94A3B8; margin-bottom: 6px; }
        input, select { width: 100%; background: #0B0F19; border: 1px solid rgba(255,255,255,0.1); padding: 11px 14px; border-radius: 8px; color: #FFF; font-size: 0.9rem; }
        input:focus, select:focus { border-color: #38BDF8; outline: none; }
        
        .btn-submit { background: #38BDF8; color: #0B0F19; width: 100%; padding: 12px; border: none; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; margin-top: 10px; }
        .btn-submit:hover { background: #7DD3FC; }
        .btn-back { display: block; text-align: center; color: #94A3B8; text-decoration: none; font-size: 0.85rem; margin-top: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h1>📌 Tambah Tugas Baru</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label>Apa yang ingin dikerjakan?</label>
            <input type="text" name="nama_tugas" placeholder="Misal: Belajar routing Laravel" required>
        </div>
        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori">
                <option value="Sekolah">Sekolah</option>
                <option value="Pribadi">Pribadi</option>
                <option value="Kerja">Kerja</option>
            </select>
        </div>
        <div class="form-group">
            <label>Tingkat Prioritas</label>
            <select name="prioritas">
                <option value="Tinggi">🔴 Tinggi</option>
                <option value="Sedang">🟡 Sedang</option>
                <option value="Rendah">🟢 Rendah</option>
            </select>
        </div>
        <button type="submit" name="tambah" class="btn-submit">Tambahkan Tugas</button>
        <a href="index.php" class="btn-back">← Kembali</a>
    </form>
</div>

</body>
</html>