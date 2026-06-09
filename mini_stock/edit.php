<?php 
include 'koneksi.php'; 

// Mengambil ID barang yang akan diedit dari URL
$id = $_GET['id'];

// Mengambil data barang yang sesuai dengan ID tersebut
$query = mysqli_query($conn, "SELECT * FROM barang WHERE id = '$id'");
$data  = mysqli_fetch_assoc($query);

// Jika data tidak ditemukan, kembalikan ke halaman utama
if(mysqli_num_rows($query) < 1) {
    header("Location: index.php");
    exit;
}

// Logika pembaruan data saat tombol ubah ditekan
if(isset($_POST['ubah'])) {
    $kode  = $_POST['kode_barang'];
    $nama  = $_POST['nama_barang'];
    $stok  = $_POST['stok'];
    $harga = $_POST['harga'];

    // Perintah SQL untuk memperbarui data
    $update = mysqli_query($conn, "UPDATE barang SET 
        kode_barang = '$kode', 
        nama_barang = '$nama', 
        stok = '$stok', 
        harga = '$harga' 
        WHERE id = '$id'");

    if($update) {
        header("Location: index.php"); // Kembali ke halaman utama jika berhasil
    } else {
        echo "<script>alert('Gagal memperbarui data!');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Edit Barang</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #0B0F19; color: #E2E8F0; padding: 40px 20px; }
        .container { max-width: 500px; margin: 0 auto; background: #1E293B; padding: 30px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        h1 { font-size: 1.3rem; margin-bottom: 20px; color: #FFFFFF; }
        
        .form-group { margin-bottom: 15px; }
        label { display: block; font-size: 0.85rem; color: #94A3B8; margin-bottom: 5px; }
        input { width: 100%; background: #0B0F19; border: 1px solid rgba(255,255,255,0.1); padding: 10px 12px; border-radius: 6px; color: #FFF; font-size: 0.95rem; }
        input:focus { border-color: #F59E0B; outline: none; } /* Aksen warna oranye untuk mode edit */
        
        .btn-submit { background: #F59E0B; color: #0B0F19; width: 100%; padding: 12px; border: none; border-radius: 6px; font-weight: 600; font-size: 0.95rem; cursor: pointer; margin-top: 10px; transition: 0.2s; }
        .btn-submit:hover { background: #FBBF24; }
        .btn-back { display: block; text-align: center; color: #94A3B8; text-decoration: none; font-size: 0.85rem; margin-top: 15px; }
        .btn-back:hover { color: #FFF; }
    </style>
</head>
<body>

<div class="container">
    <h1>✏️ Edit Data Barang</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label>Kode Barang</label>
            <input type="text" name="kode_barang" value="<?php echo $data['kode_barang']; ?>" required>
        </div>
        <div class="form-group">
            <label>Nama Barang</label>
            <input type="text" name="nama_barang" value="<?php echo $data['nama_barang']; ?>" required>
        </div>
        <div class="form-group">
            <label>Jumlah Stok</label>
            <input type="number" name="stok" value="<?php echo $data['stok']; ?>" required>
        </div>
        <div class="form-group">
            <label>Harga Satuan (Rp)</label>
            <input type="number" name="harga" value="<?php echo $data['harga']; ?>" required>
        </div>
        <button type="submit" name="ubah" class="btn-submit">Perbarui Data</button>
        <a href="index.php" class="btn-back">← Batal</a>
    </form>
</div>

</body>
</html>