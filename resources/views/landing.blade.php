<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Monitoring Pasien HIV - Puskesmas Benculuk</title>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #059669;
            --primary-dark: #064e3b;
            --primary-light: #34d399;
            --slate-900: #0f172a;
            --slate-800: #1e293b;
            --slate-700: #334155;
            --slate-600: #475569;
            --slate-50: #f8fafc;
            --white: #ffffff;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
            scroll-behavior: smooth;
        }

        body {
            background: var(--slate-50);
            color: var(--slate-800);
            overflow-x: hidden;
        }

        /* ================= HERO SECTION ================= */
        .hero {
            min-height: 100vh;
            background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.6)), 
                        url('{{ asset("assets/puskesmas-bg.png") }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
            position: relative;
            color: var(--white);
            display: flex;
            flex-direction: column;
            overflow: hidden;
        }

        /* Abstract Decoration */
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: radial-gradient(circle at 20% 50%, rgba(5, 150, 105, 0.3) 0%, transparent 50%);
            z-index: 1;
        }

        .hero::after {
            content: '';
            position: absolute;
            bottom: -1px;
            left: 0;
            width: 100%;
            height: 120px;
            background: linear-gradient(to top, var(--slate-50) 20%, transparent);
            z-index: 2;
        }

        /* ================= NAVBAR ================= */
        .navbar {
            position: sticky;
            top: 0;
            z-index: 1000;
            padding: 20px 80px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            animation: slideDown 0.8s ease;
        }

        @keyframes slideDown {
            from { transform: translateY(-100%); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .brand img {
            height: 50px;
            filter: drop-shadow(0 5px 10px rgba(0,0,0,0.3));
        }

        .brand-text h3 {
            font-size: 18px;
            font-weight: 800;
            line-height: 1.1;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .brand-text span {
            font-size: 12px;
            font-weight: 600;
            opacity: 0.9;
            letter-spacing: 1px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .nav-links {
            display: flex;
            gap: 40px;
            list-style: none;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--white);
            font-size: 15px;
            font-weight: 700;
            opacity: 0.9;
            transition: all 0.3s;
            position: relative;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .nav-links a:hover {
            opacity: 1;
            color: var(--primary-light);
        }

        .nav-links a::after {
            content: '';
            position: absolute;
            bottom: -8px;
            left: 0;
            width: 0;
            height: 2px;
            background: var(--primary-light);
            transition: width 0.3s;
        }

        .nav-links a:hover::after {
            width: 100%;
        }

        .btn-login-nav {
            padding: 12px 24px;
            background: var(--primary);
            border: none;
            border-radius: 14px;
            color: var(--white);
            text-decoration: none;
            font-size: 14px;
            font-weight: 800;
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 4px 15px rgba(5, 150, 105, 0.4);
        }

        .btn-login-nav:hover {
            background: var(--primary-light);
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(5, 150, 105, 0.5);
        }

        /* ================= HERO BODY ================= */
        .hero-body {
            flex: 1;
            display: flex;
            align-items: center;
            padding: 0 80px 100px;
            position: relative;
            z-index: 10;
        }

        .hero-text {
            max-width: 750px;
            animation: fadeInRight 1s ease-out;
        }

        @keyframes fadeInRight {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .hero-text h1 {
            font-size: 56px;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 25px;
            letter-spacing: -2px;
            text-shadow: 0 10px 30px rgba(0,0,0,0.5);
        }

        .hero-text p {
            font-size: 18px;
            line-height: 1.6;
            opacity: 1;
            margin-bottom: 40px;
            font-weight: 500;
            color: #f1f5f9;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
            max-width: 600px;
        }

        .hero-btns {
            display: flex;
            gap: 20px;
        }

        .btn-main {
            padding: 22px 45px;
            background: var(--primary);
            color: var(--white);
            border-radius: 20px;
            text-decoration: none;
            font-size: 18px;
            font-weight: 800;
            box-shadow: 0 20px 40px rgba(5, 150, 105, 0.4);
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .btn-main:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 50px rgba(5, 150, 105, 0.5);
            background: var(--primary-light);
        }

        /* ================= SECTIONS ================= */
        section {
            padding: 120px 80px;
            position: relative;
        }

        .section-header {
            text-align: center;
            margin-bottom: 80px;
        }

        .section-header h2 {
            font-size: 42px;
            font-weight: 900;
            color: var(--slate-900);
            margin-bottom: 20px;
            letter-spacing: -1px;
        }

        .section-header p {
            color: var(--slate-600);
            font-weight: 600;
            font-size: 18px;
            max-width: 700px;
            margin: 0 auto;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
            gap: 30px;
            max-width: 1400px;
            margin: 0 auto;
        }

        .card {
            background: var(--white);
            padding: 50px 40px;
            border-radius: 32px;
            border: 1px solid rgba(226, 232, 240, 0.8);
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.02);
        }

        .card:hover {
            transform: translateY(-15px);
            border-color: var(--primary-light);
            box-shadow: 0 40px 80px rgba(5, 150, 105, 0.1);
        }

        .card-icon {
            width: 70px;
            height: 70px;
            background: #ecfdf5;
            color: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 20px;
            font-size: 30px;
            margin-bottom: 30px;
            transition: all 0.3s;
        }

        .card:hover .card-icon {
            background: var(--primary);
            color: var(--white);
            transform: rotate(10deg);
        }

        .card h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 18px;
            color: var(--slate-900);
        }

        .card p {
            color: var(--slate-600);
            line-height: 1.7;
            font-size: 15px;
            font-weight: 500;
        }

        /* ================= FOOTER ================= */
        footer {
            background: var(--slate-900);
            color: var(--white);
            padding: 100px 80px 40px;
            position: relative;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1.5fr;
            gap: 80px;
            max-width: 1400px;
            margin: 0 auto 80px;
        }

        .footer-brand h2 {
            font-size: 28px;
            font-weight: 900;
            margin-bottom: 25px;
            letter-spacing: -0.5px;
        }

        .footer-brand p {
            opacity: 0.6;
            line-height: 1.8;
            font-size: 15px;
            font-weight: 500;
        }

        .footer-links h4 {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 30px;
            color: var(--primary-light);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 18px;
        }

        .footer-links a {
            color: var(--white);
            opacity: 0.6;
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .footer-links a:hover {
            opacity: 1;
            color: var(--primary-light);
            padding-left: 5px;
        }

        .contact-info li {
            display: flex;
            gap: 15px;
            opacity: 0.7;
            font-size: 15px;
            font-weight: 500;
            line-height: 1.6;
        }

        .contact-info i {
            color: var(--primary-light);
            font-size: 18px;
            margin-top: 3px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255,255,255,0.1);
            padding-top: 40px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
            opacity: 0.4;
            letter-spacing: 0.5px;
        }

        /* ================= RESPONSIVE ================= */
        @media (max-width: 1100px) {
            .navbar, .hero-body, section, footer { padding: 40px 40px; }
            .hero-text h1 { font-size: 48px; }
            .nav-links { display: none; }
            .footer-grid { grid-template-columns: 1fr 1fr; gap: 40px; }
            .footer-brand { grid-column: span 2; }
        }

        @media (max-width: 768px) {
            .hero-text h1 { font-size: 38px; }
            .hero-btns { flex-direction: column; }
            .btn-main { justify-content: center; }
            .section-header h2 { font-size: 32px; }
            .footer-grid { grid-template-columns: 1fr; }
            .footer-brand { grid-column: span 1; }
        }
    </style>
</head>
<body>

    {{-- HERO SECTION --}}
    <div class="hero">
        <nav class="navbar">
            <div class="brand">
                <img src="{{ asset('assets/logo-banyuwangi.png') }}" alt="Logo Kab. Banyuwangi">
                <img src="{{ asset('assets/logo-puskesmas.png') }}" alt="Logo Puskesmas Benculuk">
                <div class="brand-text">
                    <h3>PUSKESMAS BENCULUK</h3>
                    <span>KABUPATEN BANYUWANGI</span>
                </div>
            </div>
            
            <ul class="nav-links">
                <li><a href="#">Beranda</a></li>
                <li><a href="#fitur">Fitur Utama</a></li>
                <li><a href="#tentang">Manfaat</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>

            <a href="{{ url('/login') }}" class="btn-login-nav">
                <i class="fa-solid fa-lock"></i>
                Login System
            </a>
        </nav>

        <div class="hero-body">
            <div class="hero-text">
                <span style="background: rgba(5, 150, 105, 0.2); padding: 8px 20px; border-radius: 100px; font-size: 14px; font-weight: 700; color: var(--primary-light); margin-bottom: 20px; display: inline-block; backdrop-filter: blur(5px); border: 1px solid rgba(52, 211, 153, 0.3);">
                    Digital Health Solutions
                </span>
                <h1>Sistem Monitoring Pasien HIV Terintegrasi</h1>
                <p>Platform digital modern yang dirancang untuk memperkuat pengawasan kepatuhan minum obat, jadwal kontrol berkala, dan manajemen data klinis secara aman dan efisien.</p>
                
                <div class="hero-btns">
                    <a href="{{ url('/login') }}" class="btn-main">
                        Dapatkan Akses Sekarang
                        <i class="fa-solid fa-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- FEATURES SECTION --}}
    <section id="fitur">
        <div class="section-header">
            <h2>Fitur Unggulan</h2>
            <p>Dibangun dengan fokus pada kemudahan penggunaan dan akurasi data untuk mendukung operasional tenaga kesehatan.</p>
        </div>

        <div class="grid">
            <div class="card">
                <div class="card-icon"><i class="fa-solid fa-chart-pie"></i></div>
                <h3>Dashboard Real-time</h3>
                <p>Pantau status kesehatan dan tingkat kepatuhan seluruh pasien dalam satu tampilan dashboard yang komprehensif.</p>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fa-solid fa-notes-medical"></i></div>
                <h3>Kartu Kendali Digital</h3>
                <p>Pencatatan riwayat kunjungan dan stok obat ARV yang terorganisir, menggantikan sistem manual yang rentan kesalahan.</p>
            </div>
            <div class="card">
                <div class="card-icon"><i class="fa-solid fa-file-waveform"></i></div>
                <h3>Laporan Otomatis</h3>
                <p>Hasilkan laporan evaluasi bulanan dan tahunan secara instan untuk kebutuhan pelaporan internal maupun dinas kesehatan.</p>
            </div>
        </div>
    </section>

    {{-- BENEFITS SECTION --}}
    <section id="tentang" style="background: var(--white);">
        <div class="section-header">
            <h2>Manfaat Sistem</h2>
            <p>Memberikan nilai tambah bagi seluruh pihak yang terlibat dalam ekosistem perawatan pasien.</p>
        </div>

        <div class="grid">
            <div class="card" style="background: var(--slate-50);">
                <div class="card-icon"><i class="fa-solid fa-user-doctor"></i></div>
                <h3>Tenaga Kesehatan</h3>
                <p>Efisiensi waktu dalam pendataan dan kemudahan mengidentifikasi pasien yang berisiko mangkir dari pengobatan (LTFU).</p>
            </div>
            <div class="card" style="background: var(--slate-50);">
                <div class="card-icon"><i class="fa-solid fa-hospital-user"></i></div>
                <h3>Bagi Pasien</h3>
                <p>Memperoleh pengawasan medis yang lebih terstruktur dan pengingat kontrol rutin untuk menjaga kesehatan yang stabil.</p>
            </div>
            <div class="card" style="background: var(--slate-50);">
                <div class="card-icon"><i class="fa-solid fa-hand-holding-heart"></i></div>
                <h3>Bagi Keluarga</h3>
                <p>Memudahkan keluarga atau pendamping minum obat (PMO) dalam mendukung dan memotivasi kepatuhan pasien.</p>
            </div>
        </div>
    </section>

    {{-- FOOTER --}}
    <footer id="kontak">
        <div class="footer-grid">
            <div class="footer-brand">
                <h2>PUSKESMAS BENCULUK</h2>
                <p>Berkomitmen untuk terus berinovasi dalam memberikan pelayanan kesehatan berkualitas tinggi melalui integrasi teknologi informasi yang inklusif bagi masyarakat Kabupaten Banyuwangi.</p>
            </div>
            
            <div class="footer-links">
                <h4>Navigasi</h4>
                <ul>
                    <li><a href="#">Beranda</a></li>
                    <li><a href="#fitur">Fitur Utama</a></li>
                    <li><a href="#tentang">Manfaat</a></li>
                    <li><a href="{{ url('/login') }}">Akses Login</a></li>
                </ul>
            </div>

            <div class="footer-links">
                <h4>Informasi Kontak</h4>
                <ul class="contact-info">
                    <li>
                        <i class="fa-solid fa-location-dot"></i>
                        <span>Jl. Raya Benculuk No.1, Benculuk, Cluring, Kabupaten Banyuwangi, Jawa Timur</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-phone"></i>
                        <span>(0333) 123456</span>
                    </li>
                    <li>
                        <i class="fa-solid fa-envelope"></i>
                        <span>puskesmas.benculuk@banyuwangikab.go.id</span>
                    </li>
                </ul>
            </div>
        </div>

        <div class="footer-bottom">
            &copy; 2026 Puskesmas Benculuk Banyuwangi. Seluruh Hak Cipta Dilindungi.
        </div>
    </footer>

</body>
</html>