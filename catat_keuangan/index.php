<?php 
include 'koneksi.php'; 

// 1. Mengambil seluruh riwayat transaksi
$query = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY tanggal DESC, id DESC");

// 2. Hitung Otomatis Total Uang Masuk menggunakan SUM() SQL
$hitung_masuk = mysqli_query($conn, "SELECT SUM(nominal) as total FROM transaksi WHERE jenis = 'Masuk'");
$row_masuk    = mysqli_fetch_assoc($hitung_masuk);
$total_masuk  = $row_masuk['total'] ?? 0; // Jika kosong/null, set jadi 0

// 3. Hitung Otomatis Total Uang Keluar menggunakan SUM() SQL
$hitung_keluar = mysqli_query($conn, "SELECT SUM(nominal) as total FROM transaksi WHERE jenis = 'Keluar'");
$row_keluar    = mysqli_fetch_assoc($hitung_keluar);
$total_keluar  = $row_keluar['total'] ?? 0;

// 4. Hitung Sisa Saldo Bersih
$saldo_akhir = $total_masuk - $total_keluar;
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pencatat Keuangan Harian</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #0B0F19; color: #E2E8F0; padding: 40px 20px; }
        .container { max-width: 750px; margin: 0 auto; }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        h1 { font-size: 1.4rem; color: #FFF; }
        .btn-add { background: #38BDF8; color: #0B0F19; padding: 10px 18px; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; }

        /* Widget Summary Box Keuangan */
        .summary-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 15px; margin-bottom: 30px; }
        .card-box { background: #1E293B; padding: 20px; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); }
        .card-box p { font-size: 0.8rem; color: #94A3B8; text-transform: uppercase; margin-bottom: 5px; }
        .card-box h2 { font-size: 1.25rem; color: #FFF; }
        .txt-masuk { color: #4ADE80 !important; }
        .txt-keluar { color: #F87171 !important; }

        /* Tabel Transaksi */
        .table-wrapper { background: #1E293B; padding: 20px; border-radius: 12px; box-shadow: 0 10px 20px rgba(0,0,0,0.2); }
        table { width: 100%; border-collapse: collapse; }
        th, td { padding: 12px 14px; text-align: left; font-size: 0.9rem; }
        th { color: #38BDF8; border-bottom: 2px solid rgba(56, 189, 248, 0.2); font-weight: 600; }
        td { border-bottom: 1px solid rgba(255,255,255,0.05); }
        
        .badge-jenis { padding: 3px 6px; border-radius: 4px; font-size: 11px; font-weight: 600; }
        .badge-masuk { background: rgba(34, 197, 94, 0.15); color: #4ADE80; }
        .badge-keluar { background: rgba(239, 68, 68, 0.15); color: #F87171; }
        
        .btn-delete { color: #EF4444; text-decoration: none; font-size: 0.85rem; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>💰 Catatan Keuangan Harian</h1>
        <a href="tambah.php" class="btn-add">+ Catat Transaksi</a>
    </div>

    <div class="summary-grid">
        <div class="card-box">
            <p>Total Pemasukan</p>
            <h2 class="txt-masuk">Rp <?php echo number_format($total_masuk, 0, ',', '.'); ?></h2>
        </div>
        <div class="card-box">
            <p>Total Pengeluaran</p>
            <h2 class="txt-keluar">Rp <?php echo number_format($total_keluar, 0, ',', '.'); ?></h2>
        </div>
        <div class="card-box" style="background: rgba(56, 189, 248, 0.05); border-color: rgba(56, 189, 248, 0.2);">
            <p style="color: #38BDF8;">Sisa Saldo Bersih</p>
            <h2 style="color: #38BDF8;">Rp <?php echo number_format($saldo_akhir, 0, ',', '.'); ?></h2>
        </div>
    </div>

    <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Keterangan</th>
                    <th>Jenis</th>
                    <th>Nominal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                if(mysqli_num_rows($query) > 0) {
                    while($row = mysqli_fetch_assoc($query)) {
                        $badge = ($row['jenis'] == 'Masuk') ? 'badge-masuk' : 'badge-keluar';
                        $tanda = ($row['jenis'] == 'Masuk') ? '+' : '-';
                ?>
                    <tr>
                        <td style="color: #94A3B8;"><?php echo date('d/m/Y', strtotime($row['tanggal'])); ?></td>
                        <td><strong><?php echo htmlspecialchars($row['keterangan']); ?></strong></td>
                        <td><span class="badge-jenis <?php echo $badge; ?>"><?php echo $row['jenis']; ?></span></td>
                        <td class="<?php echo $badge; ?>"><?php echo $tanda; ?> Rp <?php echo number_format($row['nominal'], 0, ',', '.'); ?></td>
                        <td>
                            <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Hapus catatan transaksi ini?')">Hapus</a>
                        </td>
                    </tr>
                <?php 
                    }
                } else {
                    echo "<tr><td colspan='5' style='text-align:center; color:#64748B;'>Belum ada riwayat transaksi.</td></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>