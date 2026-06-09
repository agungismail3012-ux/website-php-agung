<?php 
include 'koneksi.php'; 

// Logika untuk fitur Filter Kategori
$filter = isset($_GET['filter']) ? $_GET['filter'] : 'Semua';

if ($filter == 'Semua') {
    $query = mysqli_query($conn, "SELECT * FROM tugas ORDER BY status DESC, id DESC");
} else {
    $query = mysqli_query($conn, "SELECT * FROM tugas WHERE kategori = '$filter' ORDER BY status DESC, id DESC");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To-Do List Plus</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Inter', sans-serif; }
        body { background: #0B0F19; color: #E2E8F0; padding: 40px 20px; }
        .container { max-width: 650px; margin: 0 auto; background: #1E293B; padding: 30px; border-radius: 16px; box-shadow: 0 20px 40px rgba(0,0,0,0.3); }
        
        .header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; }
        h1 { font-size: 1.4rem; color: #FFF; }
        .btn-add { background: #38BDF8; color: #0B0F19; padding: 10px 18px; text-decoration: none; border-radius: 8px; font-weight: 600; font-size: 0.85rem; transition: 0.2s; }
        .btn-add:hover { background: #7DD3FC; }

        /* Filter Tab */
        .filter-nav { display: flex; gap: 8px; margin-bottom: 25px; background: rgba(0,0,0,0.15); padding: 6px; border-radius: 10px; }
        .filter-nav a { flex: 1; text-align: center; text-decoration: none; color: #94A3B8; padding: 8px; font-size: 0.85rem; font-weight: 500; border-radius: 6px; transition: 0.2s; }
        .filter-nav a.active { background: #38BDF8; color: #0B0F19; font-weight: 600; }

        /* List Tugas */
        .todo-card { background: rgba(255,255,255,0.02); border: 1px solid rgba(255,255,255,0.05); padding: 16px; border-radius: 10px; margin-bottom: 12px; display: flex; justify-content: space-between; align-items: center; transition: 0.2s; }
        .todo-card:hover { border-color: rgba(56, 189, 248, 0.3); }
        
        /* Jika Tugas Selesai */
        .todo-card.completed { opacity: 0.5; background: rgba(0,0,0,0.1); border-color: transparent; }
        .todo-card.completed .task-text { text-decoration: line-through; color: #64748B; }

        .task-info h3 { font-size: 1rem; color: #FFF; margin-bottom: 6px; font-weight: 500; }
        .badges { display: flex; gap: 6px; font-size: 11px; font-weight: 600; }
        .badge { padding: 3px 8px; border-radius: 4px; text-transform: uppercase; }
        
        /* Warna Badge Kategori & Prioritas */
        .bg-sekolah { background: rgba(168, 85, 247, 0.15); color: #C084FC; }
        .bg-pribadi { background: rgba(34, 197, 94, 0.15); color: #4ADE80; }
        .bg-kerja { background: rgba(245, 158, 11, 0.15); color: #FBBF24; }
        
        .prio-tinggi { color: #EF4444; }
        .prio-sedang { color: #F59E0B; }
        .prio-rendah { color: #10B981; }

        /* Tombol Aksi */
        .actions { display: flex; gap: 8px; }
        .btn-check { color: #4ADE80; background: rgba(34, 197, 94, 0.1); text-decoration: none; padding: 6px 10px; border-radius: 6px; font-size: 0.8rem; font-weight: 500; }
        .btn-check:hover { background: rgba(34, 197, 94, 0.2); }
        .btn-delete { color: #EF4444; background: rgba(239, 68, 68, 0.1); text-decoration: none; padding: 6px 10px; border-radius: 6px; font-size: 0.8rem; }
        .btn-delete:hover { background: rgba(239, 68, 68, 0.2); }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <h1>📝 To-Do List Plus</h1>
        <a href="tambah.php" class="btn-add">+ Tugas Baru</a>
    </div>

    <div class="filter-nav">
        <a href="index.php?filter=Semua" class="<?php echo $filter == 'Semua' ? 'active' : ''; ?>">Semua</a>
        <a href="index.php?filter=Sekolah" class="<?php echo $filter == 'Sekolah' ? 'active' : ''; ?>">Sekolah</a>
        <a href="index.php?filter=Pribadi" class="<?php echo $filter == 'Pribadi' ? 'active' : ''; ?>">Pribadi</a>
        <a href="index.php?filter=Kerja" class="<?php echo $filter == 'Kerja' ? 'active' : ''; ?>">Kerja</a>
    </div>

    <?php 
    if(mysqli_num_rows($query) > 0) {
        while($row = mysqli_fetch_assoc($query)) {
            $isCompleted = ($row['status'] == 'Selesai') ? 'completed' : '';
            $katClass = 'bg-' . strtolower($row['kategori']);
            $prioClass = 'prio-' . strtolower($row['prioritas']);
    ?>
        <div class="todo-card <?php echo $isCompleted; ?>">
            <div class="task-info">
                <h3 class="task-text"><?php echo htmlspecialchars($row['nama_tugas']); ?></h3>
                <div class="badges">
                    <span class="badge <?php echo $katClass; ?>"><?php echo $row['kategori']; ?></span>
                    <span class="<?php echo $prioClass; ?>">⚡ <?php echo $row['prioritas']; ?></span>
                </div>
            </div>
            <div class="actions">
            <?php if($row['status'] == 'Belum Selesai') { ?>
            <a href="status.php?id=<?php echo $row['id']; ?>" class="btn-check">✓ Selesai</a>
            <a href="edit.php?id=<?php echo $row['id']; ?>" class="btn-action btn-edit" style="color: #F59E0B; background: rgba(245, 158, 11, 0.1); text-decoration: none; padding: 6px 10px; border-radius: 6px; font-size: 0.8rem;">Edit</a>
            <?php } ?>
            <a href="hapus.php?id=<?php echo $row['id']; ?>" class="btn-delete" onclick="return confirm('Hapus tugas ini?')">Hapus</a>
            </div>
        </div>
    <?php 
        }
    } else {
        echo "<p style='text-align:center; color:#64748B; padding:20px 0;'>Tidak ada tugas di kategori ini.</p>";
    }
    ?>
</div>

</body>
</html>