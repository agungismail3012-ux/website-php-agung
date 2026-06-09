<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'koneksi.php'; 

// Mengambil semua data barang dari database
$query = mysqli_query($conn, "SELECT * FROM barang ORDER BY id DESC");
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Inventaris Mini Stock</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #0B0F19; color: #E2E8F0; padding: 40px 20px; }
        .container { max-width: 900px; margin: 0 auto; background: #1E293B; padding: 30px; border-radius: 12px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 15px; }
        h1 { font-size: 1.5rem; color: #FFFFFF; }
        
        /* Tombol Tambah */
        .btn-add { background: #38BDF8; color: #0B0F19; padding: 10px 20px; text-decoration: none; border-radius: 6px; font-weight: 600; font-size: 0.9rem; transition: 0.2s; }
        .btn-add:hover { background: #7DD3FC; transform: translateY(-2px); }

        /* Tabel Modern */
        table { width: 100%; border-collapse: collapse; margin-top: 10px; font-size: 0.95rem; }
        th, td { padding: 14px 16px; text-align: left; }
        th { background: rgba(255,255,255,0.03); color: #38BDF8; font-weight: 600; border-bottom: 2px solid rgba(56, 189, 248, 0.2); }
        td { border-bottom: 1px solid rgba(255,255,255,0.05); color: #CBD5E1; }
        tr:hover td { background: rgba(255,255,255,0.02); }

        /* Badge Stok */
        .badge-stok { background: rgba(56, 189, 248, 0.1); color: #38BDF8; padding: 4px 8px; border-radius: 4px; font-weight: 600; }
        .badge-warning { background: rgba(239, 68, 68, 0.1); color: #EF4444; }

        /* Tombol Aksi */
        .btn-action { text-decoration: none; font-size: 0.85rem; font-weight: 500; margin-right: 10px; padding: 4px 8px; border-radius: 4px; transition: 0.2s; }
        .btn-edit { color: #F59E0B; background: rgba(245, 158, 11, 0.1); }
        .btn-edit:hover { background: rgba(245, 158, 11, 0.2); }
        .btn-delete { color: #EF4444; background: rgba(239, 68, 68, 0.1); }
        .btn-delete:hover { background: rgba(239, 68, 68, 0.2); }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>📦 Manajemen Inventaris Barang</h1>
        <a href="tambah.php" class="btn-add">+ Tambah Barang</a>
    </div>

    <table>
        <thead>
            <tr>
                <th>Kode</th>
                <th>Nama Barang</th>
                <th>Harga</th>
                <th>Stok</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            if(mysqli_num_rows($query) > 0) {
                while($row = mysqli_fetch_assoc($query)) { 
                    // Logika pewarnaan jika stok menipis (di bawah 3)
                    $stokClass = ($row['stok'] <= 3) ? 'badge-stok badge-warning' : 'badge-stok';
            ?>
                <tr>
                    <td><strong><?php echo $row['kode_barang']; ?></strong></td>
                    <td><?php echo $row['nama_barang']; ?></td>
                    <td>Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></td>
                    <td><span class="<?php echo $stokClass; ?>"><?php echo $row['stok']; ?></span></td>
                    <td>
                        <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit">Edit</a>
                        <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn-action btn-delete" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</a>
                    </td>
                </tr>
            <?php 
                } 
            } else {
                echo "<tr><td colspan='5' style='text-align:center; color:#94A3B8;'>Belum ada data barang.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>

</body>
</html>