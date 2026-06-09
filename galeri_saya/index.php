<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL); 
include 'koneksi.php'; 

// Mengambil semua data dari database, yang baru diupload muncul pertama
$query = mysqli_query($conn, "SELECT * FROM galeri ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arsip Sertifikat & Galeri Project</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #0B0F19; color: #E2E8F0; padding: 40px 20px; }
        .container { max-width: 950px; margin: 0 auto; }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 40px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 20px; }
        h1 { font-size: 1.5rem; color: #FFF; }
        .btn-upload { background: #38BDF8; color: #0B0F19; padding: 10px 20px; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.9rem; transition: 0.2s; }
        .btn-upload:hover { background: #7DD3FC; }

        /* Grid Layout untuk Galeri */
        .gallery-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 25px; }
        
        /* Kartu Gambar */
        .gallery-card { background: #1E293B; border-radius: 12px; overflow: hidden; box-shadow: 0 10px 20px rgba(0,0,0,0.3); border: 1px solid rgba(255,255,255,0.05); transition: 0.3s; }
        .gallery-card:hover { transform: translateY(-5px); border-color: rgba(56, 189, 248, 0.3); }
        
        /* Pembungkus Gambar agar ukurannya rapi seragam */
        .image-wrapper { width: 100%; height: 180px; overflow: hidden; background: #0B0F19; position: relative; }
        .image-wrapper img { width: 100%; height: 100%; object-fit: cover; }
        
        /* Badge Kategori */
        .category-badge { position: absolute; top: 12px; left: 12px; font-size: 11px; font-weight: 600; padding: 4px 10px; border-radius: 20px; text-transform: uppercase; }
        .badge-sertifikat { background: #10B981; color: #FFF; }
        .badge-project { background: #38BDF8; color: #0B0F19; }

        /* Detail Teks Kartu */
        .card-details { padding: 20px; }
        .card-details h3 { font-size: 1.05rem; color: #FFF; margin-bottom: 10px; font-weight: 600; line-height: 1.4; }
        .card-action { display: flex; justify-content: space-between; align-items: center; margin-top: 15px; }
        .date { font-size: 0.8rem; color: #64748B; }
        .btn-delete { color: #EF4444; text-decoration: none; font-size: 0.85rem; font-weight: 500; padding: 4px 8px; background: rgba(239, 68, 68, 0.1); border-radius: 4px; transition: 0.2s; }
        .btn-delete:hover { background: rgba(239, 68, 68, 0.2); }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>🖼️ Arsip Sertifikat & Galeri Project</h1>
        <a href="upload.php" class="btn-upload">+ Upload Arsip Baru</a>
    </div>

    <div class="gallery-grid">
        <?php 
        if(mysqli_num_rows($query) > 0) {
            while($row = mysqli_fetch_assoc($query)) { 
                $badgeClass = ($row['kategori'] == 'Sertifikat') ? 'badge-sertifikat' : 'badge-project';
        ?>
            <div class="gallery-card">
                <div class="image-wrapper">
                    <span class="category-badge <?php echo $badgeClass; ?>"><?php echo $row['kategori']; ?></span>
                    <img src="uploads/<?php echo $row['gambar']; ?>" alt="Gambar Arsip">
                </div>
                <div class="card-details">
                    <h3><?php echo htmlspecialchars($row['nama_pencapaian']); ?></h3>
                    <div class="card-action">
                        <span class="date">📅 <?php echo date('d M Y', strtotime($row['tanggal_upload'])); ?></span>
                        <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Hapus berkas gambar ini dari arsip?')">Hapus</a>
                    </div>
                </div>
            </div>
        <?php 
            } 
        } else {
            echo "<p style='grid-column: 1/-1; text-align:center; color:#64748B; padding: 40px 0;'>Belum ada sertifikat atau project yang diupload.</p>";
        }
        ?>
    </div>
</div>

</body>
</html>