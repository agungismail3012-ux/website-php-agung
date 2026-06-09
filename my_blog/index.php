<?php 
include 'koneksi.php'; 
// Mengambil semua artikel, yang terbaru muncul paling atas
$query = mysqli_query($conn, "SELECT * FROM artikel ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Blog Pribadi Saya</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #0B0F19; color: #E2E8F0; padding: 40px 20px; }
        .container { max-width: 700px; margin: 0 auto; }
        
        .nav { display: flex; justify-content: space-between; align-items: center; margin-bottom: 50px; }
        .nav h1 { font-size: 1.5rem; color: #FFF; }
        .nav a { color: #38BDF8; text-decoration: none; font-size: 0.9rem; font-weight: 500; }
        
        .blog-post { background: #1E293B; padding: 30px; border-radius: 12px; margin-bottom: 25px; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
        .blog-post h2 { color: #FFF; font-size: 1.35rem; margin-bottom: 8px; }
        .blog-post .meta { font-size: 0.8rem; color: #94A3B8; margin-bottom: 15px; }
        .blog-post .content { color: #CBD5E1; font-size: 0.95rem; line-height: 1.7; white-space: pre-line; }
    </style>
</head>
<body>

<div class="container">
    <div class="nav">
        <h1>✍️ My Tech Journey Blog</h1>
        <a href="login.php">Masuk Kelola Panel →</a>
    </div>

    <?php 
    if(mysqli_num_rows($query) > 0) {
        while($row = mysqli_fetch_assoc($query)) { 
    ?>
        <div class="blog-post">
            <h2><?php echo htmlspecialchars($row['judul']); ?></h2>
            <div class="meta">📅 Dipublikasikan pada: <?php echo date('d M Y, H:i', strtotime($row['tanggal'])); ?></div>
            <div class="content"><?php echo htmlspecialchars($row['isi']); ?></div>
        </div>
    <?php 
        } 
    } else {
        echo "<p style='text-align:center; color:#64748B;'>Belum ada artikel yang ditulis.</p>";
    }
    ?>
</div>

</body>
</html>