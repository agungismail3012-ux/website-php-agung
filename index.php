<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include 'koneksi.php';
?>
<!DOCTYPE HTML>
<html lang="id">
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Portofolio Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        /* Reset & Base Style */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body { 
            font-family: 'Inter', sans-serif; 
            line-height: 1.7; 
            background: #181818; /* Latar belakang gelap (Deep Navy) untuk kontras tinggi */
            color: #E2E8F0; 
            padding: 40px 20px;
        }
        
        /* Container Utama */
        .container { 
            background: #160404; /* Slate Grey gelap, kontras dengan teks putih */
            max-width: 750px;
            margin: 0 auto; 
            border-radius: 16px; 
            overflow: hidden;
            box-shadow: 0 20px 40px rgba(182, 182, 182, 0.4);
            border: 1px solid #181818(255, 255, 255, 0); /* Border tipis elegan */
        }
        
        /* Area Header */
        .profile-header-container {
            position: relative; 
            text-align: center;
            padding: 60px 20px 40px 20px;
            background-image: url('sampul.jpg'); 
            background-size: cover;
            background-position: center;
            z-index: 1;
        }

        /* Overlay Gelap di Atas Sampul agar Teks Terbaca Jelas */
        .profile-header-container::before {
            content: "";
            position: absolute;
            top: 0; left: 0; right: 0; bottom: 0;
            background: rgba(11, 15, 25, 0.65); /* Opasitas diatur agar sampul tetap mengintip */
            z-index: -1;
        }
        
        /* Foto Profil */
        .profile-img {
            width: 130px; 
            height: 130px; 
            object-fit: cover; 
            border-radius: 50%; 
            border: 4px solid #720000; /* Aksen warna Biru Neon / Cyan untuk kontras tinggi */
            box-shadow: 0 0 20px #720000(56, 189, 248, 0.2);
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        }
        /* Efek Interaktif pada Foto */
        .profile-img:hover {
            transform: scale(1.08) rotate(2deg);
        }

        /* Nama */
        .profile-header-container h1 {
            font-size: 2rem;
            font-weight: 700;
            color: #FFFFFF; 
            margin: 20px 0 8px 0;
            letter-spacing: -0.5px;
        }

        /* Bar Kontak & Lokasi */
        .info-bar {
            font-size: 13px;
            color: #ffffff;
            font-weight: 400;
            margin-bottom: 6px;
        }
        .info-bar a {
            color: #ffffff;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s;
        }
        .info-bar a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        /* Bagian Konten Bawah */
        .content-section {
            padding: 40px 35px;
        }

        h2 { 
            color: #ffffff; /* Judul berwarna terang, sangat kontras di background gelap */
            font-size: 1.15rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-top: 35px;
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }
        h2::after {
            content: "";
            flex: 1;
            height: 1px;
            background: rgba(255, 255, 255, 0.36);
            margin-left: 15px;
        }
        h2:first-of-type {
            margin-top: 0;
        }

        p, ul {
            color: #CBD5E1; /* Warna teks abu-abu lembut agar tidak melelahkan mata */
            font-size: 0.95rem;
        }

        /* List Data Pribadi & Pengalaman */
        .detail-list, .experience-list {
            list-style: none;
        }
        .detail-list li {
            margin-bottom: 12px;
            font-size: 0.95rem;
        }
        .detail-list li strong {
            width: 140px;
            display: inline-block;
            color: #f8f8f8;
            font-weight: 500;
        }

        .experience-list li {
            position: relative;
            padding-left: 20px;
            margin-bottom: 10px;
        }
        /* Ikon Custom Pengalaman Simpel (Dot/Titik) */
        .experience-list li::before {
            content: "-";
            color: #ffffff;
            font-weight: bold;
            font-size: 1.2rem;
            position: absolute;
            left: 0;
            top: -2px;
        }

        /* Pembungkus Tombol Project (Grid Modern) */
        .links-grid { 
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
            gap: 12px;
            margin-top: 15px;
        }
        /* Tombol Link Interaktif */
        .links-grid a { 
            display: block; 
            background: rgba(255, 255, 255, 0.03); 
            color: #FFFFFF; 
            padding: 14px 20px; 
            text-decoration: none; 
            border-radius: 8px; 
            font-size: 0.9rem;
            font-weight: 500;
            border: 1px solid rgba(255, 255, 255, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-align: center;
        }
        /* Efek Hover Elegan Semacam Tombol Aplikasi Premium */
        .links-grid a:hover {
            background: #ffffff; 
            color: #0B0F19; /* Teks berbalik menjadi gelap saat di-hover untuk kejutan kontras */
            border-color: #ffffff;
            transform: translateY(-3px);
            box-shadow: 0 8px 20px rgba(255, 255, 255, 0.25);
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="container">
    
    <div class="profile-header-container">
        <img src="foto-profil.jpg" alt="Foto Profil Saya" class="profile-img">
        <h1>Agung Ismail</h1>
        
        <div class="info-bar">
            📍 Jakarta Utara, DKI Jakarta &nbsp;•&nbsp; 
            📧 <a href="mailto:emailanda@gmail.com">agungismail002@gmail.com</a>
        </div>
        <div class="info-bar">
            📞 <a href="https://wa.me/6289520054821" target="_blank">Contact person [WhatsApp]</a>
        </div>
    </div>
    
    <div class="content-section">
        
        <h2>Info Personal</h2>
        <ul class="detail-list">
            <li><strong>Sekolah</strong>SMK Tamansiswa 2 Jakarta</li>
            <li><strong>Tempat Tinggal</strong>JL. Ancol Selatan II NO.24 RT.006/007</li>
            <li><strong>Fokus Bidang</strong> Web Development / PHP Backend</li>
            <li><strong>Minat & Hobi</strong> Coding, Bermain Gitar</li>
        </ul>

        <h2>Tentang Saya</h2>
        <p>Saya adalah seorang pengembang web yang berfokus pada efisiensi kode dan kebersihan arsitektur database. Saat ini aktif mengeksplorasi integrasi native PHP dengan MySQL melalui ekosistem XAMPP.</p>

        <h2>Pengalaman Teknis</h2>
        <ul class="experience-list">
            <li>Merancang arsitektur database relasional via phpMyAdmin.</li>
            <li>Membangun logika backend berbasis PHP untuk manipulasi data dinamis.</li>
            <li>Implementasi antarmuka web interaktif menggunakan CSS modern.</li>
        </ul>

        <h2>Rencana Kedepan</h2>
        <p>Menguasai arsitektur MVC melalui Framework Laravel, mempelajari RESTful API, dan berkontribusi aktif pada proyek-proyek *open-source* berskala lokal.</p>

        <h2>Project Web Lainnya</h2>
        <div class="links-grid">
            <?php
            $query = mysqli_query($conn, "SELECT * FROM projects");
            if(mysqli_num_rows($query) > 0) {
                while($data = mysqli_fetch_array($query)){
                    echo "<a href='".$data['link_web']."' target='_blank'>↗️ ".$data['nama_web']."</a>";
                }
            } else {
                // Link cadangan jika database belum terisi
                echo '<a href="/folder_web_1/index.php" target="_blank">↗️ Project Web 1</a>';
                echo '<a href="/folder_web_2/index.php" target="_blank">↗️ Project Web 2</a>';
            }
            ?>
        </div>
        
    </div>
</div>

</body>
</html>