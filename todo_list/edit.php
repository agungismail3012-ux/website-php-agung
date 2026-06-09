<?php 
include 'koneksi.php'; 

// Mengambil ID tugas dari URL
$id = $_GET['id'];

// Mengambil data tugas spesifik berdasarkan ID
$query = mysqli_query($conn, "SELECT * FROM tugas WHERE id = '$id'");
$data  = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan di database, kembalikan ke halaman utama
if(mysqli_num_rows($query) < 1) {
    header("Location: index.php");
    exit;
}

// Logika pembaruan data saat tombol "Perbarui Tugas" ditekan
if(isset($_POST['update'])) {
    $nama_tugas = $_POST['nama_tugas'];
    $kategori   = $_POST['kategori'];
    $prioritas  = $_POST['prioritas'];

    // Eksekusi perubahan ke database
    $update = mysqli_query($conn, "UPDATE tugas SET 
        nama_tugas = '$nama_tugas', 
        kategori = '$kategori', 
        prioritas = '$prioritas' 
        WHERE id = '$id'");

    if($update) {
        header("Location: index.php"); // Kembali ke halaman utama jika berhasil
    } else {
        echo "<script>alert('Gagal memperbarui tugas!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Tugas</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #0B0F19; color: #E2E8F0; padding: 40px 20px; }
        .container { max-width: 450px; margin: 0 auto; background: #1E293B; padding: 30px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        h1 { font-size: 1.25rem; margin-bottom: 20px; color: #FFF; }
        
        .form-group { margin-bottom: 18px; }
        label { display: block; font-size: 0.85rem; color: #94A3B8; margin-bottom: 6px; }
        input, select { width: 100%; background: #0B0F19; border: 1px solid rgba(255,255,255,0.1); padding: 11px 14px; border-radius: 8px; color: #FFF; font-size: 0.9rem; }
        input:focus, select:focus { border-color: #F59E0B; outline: none; }
        
        .btn-submit { background: #F59E0B; color: #0B0F19; width: 100%; padding: 12px; border: none; border-radius: 8px; font-weight: 600; font-size: 0.9rem; cursor: pointer; margin-top: 10px; }
        .btn-submit:hover { background: #FBBF24; }
        .btn-back { display: block; text-align: center; color: #94A3B8; text-decoration: none; font-size: 0.85rem; margin-top: 15px; }
    </style>
</head>
<body>

<div class="container">
    <h1>✏️ Edit Tugas</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label>Deskripsi Tugas</label>
            <input type="text" name="nama_tugas" value="<?php echo htmlspecialchars($data['nama_tugas']); ?>" required>
        </div>
        
        <div class="form-group">
            <label>Kategori</label>
            <select name="kategori">
                <option value="Sekolah" <?php echo ($data['kategori'] == 'Sekolah') ? 'selected' : ''; ?>>Sekolah</option>
                <option value="Pribadi" <?php echo ($data['kategori'] == 'Pribadi') ? 'selected' : ''; ?>>Pribadi</option>
                <option value="Kerja" <?php echo ($data['kategori'] == 'Kerja') ? 'selected' : ''; ?>>Kerja</option>
            </select>
        </div>
        
        <div class="form-group">
            <label>Tingkat Prioritas</label>
            <select name="prioritas">
                <option value="Tinggi" <?php echo ($data['prioritas'] == 'Tinggi') ? 'selected' : ''; ?>>🔴 Tinggi</option>
                <option value="Sedang" <?php echo ($data['prioritas'] == 'Sedang') ? 'selected' : ''; ?>>🟡 Sedang</option>
                <option value="Rendah" <?php echo ($data['prioritas'] == 'Rendah') ? 'selected' : ''; ?>>🟢 Rendah</option>
            </select>
        </div>
        
        <button type="submit" name="update" class="btn-submit">Perbarui Tugas</button>
        <a href="index.php" class="btn-back">← Batal</a>
    </form>
</div>

</body>
</html>