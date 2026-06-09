<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
include 'koneksi.php';

// Query SQL diperbarui untuk mengambil kolom saga dan phase
$query = "SELECT t.urutan_chronological, t.tipe, t.keterangan_waktu,
                 IF(t.tipe = 'film', f.judul_film, s.judul_series) AS judul,
                 IF(t.tipe = 'film', f.tahun_rilis, s.tahun_rilis) AS tahun_rilis,
                 IF(t.tipe = 'film', f.sinopsis, s.sinopsis) AS sinopsis,
                 IF(t.tipe = 'film', f.poster, s.poster) AS poster,
                 IF(t.tipe = 'film', f.saga, s.saga) AS saga,
                 IF(t.tipe = 'film', f.phase, s.phase) AS phase,
                 f.durasi_menit, s.jumlah_episode
          FROM tbl_timeline t
          LEFT JOIN tbl_film f ON t.id_konten = f.id_film AND t.tipe = 'film'
          LEFT JOIN tbl_series s ON t.id_konten = s.id_series AND t.tipe = 'series'
          ORDER BY t.urutan_chronological ASC";

$result = mysqli_query($koneksi, $query);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Marvel Cinematic Universe Timeline</title>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --marvel-red: #e62429;
            --marvel-dark: #0f0f12;
            --card-bg: rgba(30, 30, 35, 0.65);
            --gold: #ffca28;
            --blue-glow: #00bcd4;
        }

        body {
            font-family: 'Montserrat', sans-serif;
            background-color: var(--marvel-dark);
            background-image: 
                radial-gradient(circle at 20% 30%, rgba(230, 36, 41, 0.04) 0%, transparent 40%),
                radial-gradient(circle at 80% 70%, rgba(0, 188, 212, 0.03) 0%, transparent 40%);
            color: #ffffff;
            margin: 0;
            padding: 40px 20px;
            backdrop-filter: blur(100px);
        }

        h1 {
            text-align: center;
            color: #ffffff;
            font-weight: 800;
            font-size: 2.5rem;
            text-transform: uppercase;
            letter-spacing: 4px;
            margin-bottom: 10px;
            text-shadow: 0 4px 12px rgba(0, 0, 0, 0.5);
        }
        
        h1 span {
            color: var(--marvel-red);
            position: relative;
        }

        /* TAMPILAN SAGA HEADER MODERN ELEGAN */
        .saga-header {
            text-align: center;
            background: linear-gradient(135deg, #16161a 0%, #1f1f27 100%);
            color: #fff;
            padding: 16px;
            font-size: 22px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 5px;
            margin: 70px auto 30px auto;
            max-width: 850px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.7);
            position: relative;
            overflow: hidden;
        }

        .saga-header::before {
            content: '';
            position: absolute;
            top: 0; left: 0; width: 100%; height: 3px;
            background: linear-gradient(90deg, transparent, var(--marvel-red), transparent);
        }

        /* TAMPILAN PHASE HEADER SIMPEL DENGAN AKSEN GLOW GOLD */
        .phase-header {
            max-width: 850px;
            margin: 40px auto 20px auto;
            color: var(--gold);
            font-size: 16px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 3px;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .phase-header::after {
            content: '';
            flex: 1;
            height: 1px;
            background: linear-gradient(90deg, rgba(255, 202, 40, 0.3), transparent);
        }

        /* FILTER BUTTONS YANG MINIMALIS */
        .filter-container {
            text-align: center;
            margin: 30px 0 60px 0;
        }

        .btn-filter {
            background-color: rgba(255, 255, 255, 0.03);
            color: #b0b0b5;
            border: 1px solid rgba(255, 255, 255, 0.1);
            padding: 10px 24px;
            margin: 0 8px;
            font-size: 12px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            border-radius: 30px;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.25, 1, 0.5, 1);
        }

        .btn-filter:hover, .btn-filter.active {
            color: #ffffff;
            background-color: var(--marvel-red);
            border-color: var(--marvel-red);
            box-shadow: 0 6px 20px rgba(230, 36, 41, 0.4);
            transform: translateY(-2px);
        }

        /* STRUKTUR GARIS TIMELINE LEBIH HALUS */
        .timeline {
            max-width: 850px;
            margin: 0 auto;
            position: relative;
            padding-left: 40px;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            width: 2px;
            height: 100%;
            background: linear-gradient(to bottom, rgba(230, 36, 41, 0.4), rgba(0, 188, 212, 0.4));
        }

        /* KARTU ITEM MODERN (GLASSMORPHISM EFFECT) */
        .timeline-item {
            position: relative;
            margin-bottom: 35px;
            background: var(--card-bg);
            border: 1px solid rgba(255, 255, 255, 0.05);
            padding: 25px;
            border-radius: 16px;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.4);
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 30px;
            backdrop-filter: blur(10px);
            transition: all 0.4s ease;
        }

        .timeline-item:hover {
            transform: translateX(10px);
            border-color: rgba(255, 255, 255, 0.15);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
            background: rgba(35, 35, 42, 0.8);
        }

        /* SIMPUL TIMELINE YANG BERSINAR */
        .timeline-item::before {
            content: '';
            position: absolute;
            left: -46px;
            top: 50%;
            transform: translateY(-50%);
            background: #1a1a1a;
            border: 3px solid var(--marvel-red);
            border-radius: 50%;
            width: 10px;
            height: 10px;
            z-index: 2;
            transition: all 0.4s ease;
        }

        .timeline-item:hover::before {
            background: var(--marvel-red);
            box-shadow: 0 0 12px var(--marvel-red);
            scale: 1.2;
        }

        .konten-wrapper {
            flex: 1;
        }

        /* FRAME POSTER YANG PRESISI & ELEGAN */
        .poster-wrapper {
            flex: 0 0 105px;
            width: 105px;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 10px;
            background: #121214;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        .poster-wrapper img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.5s ease;
        }

        .timeline-item:hover .poster-wrapper img {
            transform: scale(1.08);
        }

        /* BADGE MINIMALIS MODERN */
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 6px;
            font-size: 10px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 12px;
        }
        
        .badge-film { 
            background-color: rgba(0, 117, 255, 0.15); 
            color: #66b2ff;
            border: 1px solid rgba(0, 117, 255, 0.3);
        }
        
        .badge-series { 
            background-color: rgba(40, 167, 69, 0.15); 
            color: #72e58e;
            border: 1px solid rgba(40, 167, 69, 0.3);
        }

        .waktu {
            color: #8e8e93;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            margin-bottom: 6px;
        }

        .judul {
            margin: 0 0 6px 0;
            font-size: 20px;
            font-weight: 600;
            letter-spacing: -0.5px;
            color: #ffffff;
        }

        .meta {
            font-size: 12px;
            color: #a1a1a6;
            margin-bottom: 14px;
        }

        .sinopsis {
            font-size: 13.5px;
            color: #d1d1d6;
            line-height: 1.6;
            margin: 0;
            font-weight: 400;
        }

        /* RESPONSIVE DESIGN UNTUK SMARTPHONE */
        @media (max-width: 600px) {
            .timeline-item {
                flex-direction: column-reverse;
                align-items: flex-start;
                gap: 15px;
            }
            .poster-wrapper {
                width: 85px;
                height: 120px;
                flex: 0 0 85px;
            }
        }
    </style>
</head>
<body>

    <h1>Marvel Cinematic Universe <span>Timeline</span></h1>

    <div class="filter-container">
        <button class="btn-filter active" onclick="filterKonten('all')">Semua Konten</button>
        <button class="btn-filter" onclick="filterKonten('film')">Hanya Film</button>
        <button class="btn-filter" onclick="filterKonten('series')">Hanya Series</button>
    </div>

    <div style="max-width: 850px; margin: 0 auto;">
        <?php 
        $current_saga = '';
        $current_phase = '';
        
        while($row = mysqli_fetch_assoc($result)): 
            
            if ($row['saga'] != $current_saga && !empty($row['saga'])) {
                $current_saga = $row['saga'];
                echo "<div class='saga-header'>{$current_saga}</div>";
                $current_phase = ''; 
            }

            if ($row['phase'] != $current_phase && !empty($row['phase'])) {
                $current_phase = $row['phase'];
                echo "<div class='phase-header'>Phase {$current_phase}</div>";
            }
        ?>
            <div class="timeline">
                <div class="timeline-item" data-tipe="<?php echo $row['tipe']; ?>">
                    
                    <div class="konten-wrapper">
                        <div class="waktu">#<?php echo $row['urutan_chronological']; ?> &bull; <?php echo $row['keterangan_waktu']; ?></div>
                        
                        <span class="badge <?php echo ($row['tipe'] == 'film') ? 'badge-film' : 'badge-series'; ?>">
                            <?php echo $row['tipe']; ?>
                        </span>

                        <h2 class="judul"><?php echo $row['judul']; ?></h2>
                        
                        <div class="meta">
                            Rilis: <?php echo $row['tahun_rilis']; ?> 
                            <?php if($row['tipe'] == 'film'): ?>
                                &bull; <?php echo $row['durasi_menit']; ?> menit
                            <?php else: ?>
                                &bull; <?php echo $row['jumlah_episode']; ?> Episode
                            <?php endif; ?>
                        </div>

                        <p class="sinopsis"><?php echo $row['sinopsis']; ?></p>
                    </div>

                    <div class="poster-wrapper">
    <?php 
    // Ambil gambar dari database, jika tidak ada pakai default
    $gambar = (!empty($row['poster']) && file_exists("images/" . $row['poster'])) ? $row['poster'] : 'default.jpg';
    ?>
    
    <img src="images/<?php echo $gambar; ?>" alt="Poster <?php echo $row['judul']; ?>">
</div>

                </div>
            </div>
        <?php endwhile; ?>
    </div>

    <script>
        function filterKonten(kategori) {
            const items = document.querySelectorAll('.timeline-item');
            const timelines = document.querySelectorAll('.timeline');
            const sagaHeaders = document.querySelectorAll('.saga-header');
            const phaseHeaders = document.querySelectorAll('.phase-header');
            
            items.forEach((item, index) => {
                if (kategori === 'all' || item.getAttribute('data-tipe') === kategori) {
                    timelines[index].style.display = 'block';
                } else {
                    timelines[index].style.display = 'none';
                }
            });

            if (kategori !== 'all') {
                sagaHeaders.forEach(h => h.style.display = 'none');
                phaseHeaders.forEach(h => h.style.display = 'none');
            } else {
                sagaHeaders.forEach(h => h.style.display = 'block');
                phaseHeaders.forEach(h => h.style.display = 'flex');
            }

            const tombols = document.querySelectorAll('.btn-filter');
            tombols.forEach(tombol => tombol.classList.remove('active'));
            event.target.classList.add('active');
        }
    </script>
</body>
</html>