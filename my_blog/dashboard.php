<?php
session_start();
include 'koneksi.php';

// Proteksi Halaman: Jika belum login, tendang kembali ke halaman login.php
if(!isset($_SESSION['login'])) {
    header("Location: login.php");
    exit;
}

// Mengambil artikel untuk ditampilkan di tabel dashboard
$query = mysqli_query($conn, "SELECT * FROM artikel ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Admin Blog</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #0B0F19; color: #E2E8F0; padding: 40px 20px; }
        .container { max-width: 850px; margin: 0 auto; background: #1E293B; padding: 30px; border-radius: 12px; }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; }
        h1 { font-size: 1.4rem; color: #FFF; }
        
        .btn { padding: 9px 16px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 0.85rem; display: inline-block; }
        .btn-add { background: #38BDF8; color: #0B0F19; }
        .btn-logout { background: rgba(239, 68, 68, 0.1); color: #EF4444; border: 1px solid rgba(239, 68, 68, 0.2); }
        .btn-logout:hover { background: rgba(239, 68, 68, 0.2); }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { padding: 12px; text-align: left; font-size: 0.9rem; }
        th { color: #38BDF8; border-bottom: 2px solid rgba(56, 189, 248, 0.2); font-weight: 600; }
        td { border-bottom: 1px solid rgba(255,255,255,0.05); color: #CBD5E1; }
        
        .btn-delete { color: #EF4444; text-decoration: none; font-weight: 500; }
        .btn-delete:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>🛠️ Dashboard Admin (Kelola Artikel)</h1>
        <div>
            <a href="tulis.php" class="btn btn-add">+ Tulis Artikel Baru</a>
            <a href="logout.php" class="btn btn-logout">Keluar</a>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Judul Artikel</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_assoc($query)) { 
            ?>
                <tr>
                    <td style="color: #94A3B8; width: 180px;"><?php echo date('d M Y, H:i', strtotime($row['tanggal'])); ?></td>
                    <td><strong><?php echo htmlspecialchars($row['judul']); ?></strong></td>
                    <td style="width: 100px;">
                        <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Hapus artikel ini?')">Hapus</a>
                    </td>
                </tr>
            <?php 
                } 
            } else {
                echo "<tr><td colspan='3' style='text-align:center; color:#64748B;'>Belum ada artikel. Silakan tulis artikel pertama Anda!</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>