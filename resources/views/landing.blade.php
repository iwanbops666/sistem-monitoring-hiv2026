<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Monitoring Pasien HIV</title>

    {{-- Font Awesome CDN untuk icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f3fff8;
            color: #123524;
        }

        .landing-page {
            width: 100%;
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ================= HERO SECTION ================= */

        .hero {
            position: relative;
            min-height: 470px;
            background: linear-gradient(135deg, #006b3c 0%, #10a75d 60%, #55d28a 100%);
            overflow: hidden;
            color: #ffffff;
        }

        .hero::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 85% 30%, rgba(255,255,255,0.12) 0 2px, transparent 3px),
                radial-gradient(circle at 70% 65%, rgba(255,255,255,0.10), transparent 25%),
                linear-gradient(160deg, transparent 55%, rgba(255,255,255,0.16) 55%);
            opacity: 0.9;
        }

        .hero::after {
            content: "";
            position: absolute;
            left: -10%;
            right: -10%;
            bottom: -80px;
            height: 170px;
            background: rgba(255, 255, 255, 0.15);
            border-radius: 50% 50% 0 0;
            transform: rotate(-3deg);
        }

        .medical-plus {
            position: absolute;
            color: rgba(255,255,255,0.18);
            font-size: 64px;
            font-weight: bold;
            z-index: 1;
        }

        .plus-1 { top: 90px; left: 42px; }
        .plus-2 { top: 150px; right: 355px; font-size: 76px; }
        .plus-3 { top: 195px; right: 210px; font-size: 72px; }
        .plus-4 { bottom: 95px; left: 35px; font-size: 58px; }
        .plus-5 { bottom: 75px; right: 28px; font-size: 60px; }

        .circle-pattern {
            position: absolute;
            right: 70px;
            top: 80px;
            width: 270px;
            height: 270px;
            border-radius: 50%;
            border: 1px solid rgba(255,255,255,0.15);
            box-shadow:
                0 0 0 18px rgba(255,255,255,0.04),
                0 0 0 36px rgba(255,255,255,0.04),
                0 0 0 54px rgba(255,255,255,0.035),
                0 0 0 72px rgba(255,255,255,0.03);
            z-index: 1;
        }

        /* ================= NAVBAR ================= */

        .navbar {
            position: relative;
            z-index: 5;
            width: calc(100% - 96px);
            margin: 18px auto 0;
            padding: 14px 24px;
            background: rgba(0, 69, 37, 0.88);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 12px 28px rgba(0,0,0,0.16);
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .brand img {
            height: 52px;
            width: auto;
            object-fit: contain;
        }

        .brand-text h3 {
            font-size: 17px;
            font-weight: 800;
            line-height: 1.1;
            color: #ffffff;
        }

        .brand-text span {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-top: 2px;
            color: #ffffff;
        }

        .nav-menu {
            display: flex;
            align-items: center;
            gap: 42px;
            list-style: none;
        }

        .nav-menu a {
            text-decoration: none;
            color: #ffffff;
            font-size: 15px;
            font-weight: 600;
            padding-bottom: 8px;
            position: relative;
        }

        .nav-menu a.active::after {
            content: "";
            position: absolute;
            width: 48px;
            height: 3px;
            background: #3ee17a;
            left: 50%;
            transform: translateX(-50%);
            bottom: 0;
            border-radius: 20px;
        }

        .login-btn-top {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 11px 24px;
            background: #35cc70;
            color: #ffffff;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 700;
            box-shadow: 0 6px 14px rgba(0,0,0,0.15);
            transition: 0.2s ease;
        }

        .login-btn-top:hover {
            background: #2fbb66;
            transform: translateY(-1px);
        }

        /* ================= HERO CONTENT ================= */

        .hero-content {
            position: relative;
            z-index: 4;
            max-width: 850px;
            margin-left: 70px;
            margin-top: 78px;
        }

        .hero-content h1 {
            font-size: 44px;
            line-height: 1.18;
            font-weight: 800;
            margin-bottom: 22px;
            letter-spacing: -0.5px;
        }

        .hero-content p {
            width: 720px;
            max-width: 90%;
            font-size: 19px;
            line-height: 1.55;
            margin-bottom: 28px;
            color: rgba(255,255,255,0.95);
        }

        .main-btn {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            padding: 14px 28px;
            background: #34c86c;
            color: #ffffff;
            text-decoration: none;
            border-radius: 8px;
            font-size: 18px;
            font-weight: 700;
            box-shadow: 0 8px 18px rgba(0,0,0,0.15);
            transition: 0.2s ease;
        }

        .main-btn:hover {
            background: #2dbf64;
            transform: translateY(-2px);
        }

        /* ================= CONTENT SECTION ================= */

        .content {
            background: linear-gradient(180deg, #f6fff9 0%, #effbf5 100%);
            padding: 28px 18px 26px;
        }

        .section-title {
            text-align: center;
            font-size: 26px;
            font-weight: 800;
            color: #075f35;
            margin: 0 auto 24px;
            position: relative;
            width: fit-content;
        }

        .section-title::before,
        .section-title::after {
            content: "";
            position: absolute;
            top: 50%;
            width: 64px;
            height: 2px;
            background: #0d6b3c;
        }

        .section-title::before {
            right: calc(100% + 22px);
        }

        .section-title::after {
            left: calc(100% + 22px);
        }

        .feature-grid {
            max-width: 1450px;
            margin: 0 auto 34px;
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 12px;
        }

        .benefit-grid {
            max-width: 1420px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .card {
            background: #ffffff;
            border-radius: 6px;
            padding: 22px 20px;
            display: flex;
            align-items: center;
            gap: 18px;
            box-shadow: 0 5px 12px rgba(0,0,0,0.15);
            min-height: 110px;
        }

        .benefit-grid .card {
            min-height: 105px;
        }

        .icon-box {
            width: 74px;
            height: 74px;
            min-width: 74px;
            background: #e9f7ef;
            color: #078743;
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 42px;
            position: relative;
        }

        .icon-box .badge {
            position: absolute;
            top: -8px;
            right: -8px;
            width: 28px;
            height: 28px;
            border-radius: 50%;
            background: #ff4d58;
            color: #fff;
            font-size: 15px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .card-text h4 {
            font-size: 16px;
            color: #064b2c;
            margin-bottom: 6px;
            font-weight: 800;
        }

        .card-text p {
            font-size: 13.5px;
            line-height: 1.45;
            color: #33443c;
        }

        /* ================= FOOTER ================= */

        .footer {
            background: #005b34;
            color: #ffffff;
            min-height: 52px;
            padding: 15px 10px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            font-size: 12px;
        }

        .footer strong {
            font-size: 13px;
        }

        .footer-item {
            display: flex;
            align-items: center;
            gap: 7px;
        }

        .footer i {
            font-size: 14px;
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 1100px) {
            .navbar {
                width: calc(100% - 36px);
            }

            .nav-menu {
                gap: 22px;
            }

            .hero-content {
                margin-left: 38px;
            }

            .feature-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .benefit-grid {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 768px) {
            .navbar {
                flex-wrap: wrap;
                gap: 18px;
            }

            .nav-menu {
                order: 3;
                width: 100%;
                justify-content: center;
                flex-wrap: wrap;
                gap: 18px;
            }

            .brand img {
                height: 44px;
            }

            .brand-text h3 {
                font-size: 14px;
            }

            .brand-text span {
                font-size: 11px;
            }

            .hero-content {
                margin: 55px 24px 0;
            }

            .hero-content h1 {
                font-size: 32px;
            }

            .hero-content p {
                font-size: 16px;
            }

            .feature-grid {
                grid-template-columns: 1fr;
            }

            .footer {
                flex-direction: column;
                text-align: center;
            }
        }
    </style>
</head>

<body>
<div class="landing-page">

    {{-- HERO --}}
    <section class="hero">

        {{-- Dekorasi background --}}
        <div class="medical-plus plus-1">+</div>
        <div class="medical-plus plus-2">+</div>
        <div class="medical-plus plus-3">+</div>
        <div class="medical-plus plus-4">+</div>
        <div class="medical-plus plus-5">+</div>
        <div class="circle-pattern"></div>

        {{-- NAVBAR --}}
        <nav class="navbar">
            <div class="brand">
                {{-- Ganti path logo sesuai folder public kamu --}}
                <img src="{{ asset('assets/logo-banyuwangi.png') }}" alt="Logo Banyuwangi">
                <img src="{{ asset('assets/logo-puskesmas.png') }}" alt="Logo Puskesmas">

                <div class="brand-text">
                    <h3>PUSKESMAS BENCULUK</h3>
                    <span>KABUPATEN BANYUWANGI</span>
                </div>
            </div>

            <ul class="nav-menu">
                <li><a href="#" class="active">Beranda</a></li>
                <li><a href="#tentang">Tentang Sistem</a></li>
                <li><a href="#fitur">Fitur</a></li>
                <li><a href="#kontak">Kontak</a></li>
            </ul>

            <a href="{{ url('/login') }}" class="login-btn-top">
                <i class="fa-regular fa-user"></i>
                Login
            </a>
        </nav>

        {{-- HERO CONTENT --}}
        <div class="hero-content">
            <h1>
                Sistem Monitoring Pasien HIV<br>
                Kabupaten Benculuk Banyuwangi
            </h1>

            <p>
                Platform digital untuk monitoring pasien HIV, pengelolaan data pasien,
                evaluasi pengobatan, dan notifikasi tindak lanjut secara terintegrasi.
            </p>

            <a href="{{ url('/login') }}" class="main-btn">
                <i class="fa-regular fa-user"></i>
                Masuk ke Sistem
            </a>
        </div>
    </section>

    {{-- CONTENT --}}
    <main class="content">

        {{-- FITUR UTAMA --}}
        <section id="fitur">
            <h2 class="section-title">Fitur Utama</h2>

            <div class="feature-grid">
<div class="card">
    <div class="icon-box">
        <i class="fa-solid fa-user"></i>
    </div>
    <div class="card-text">
        <h4>Monitoring Data Pasien</h4>
        <p>
            Pantau data pasien HIV secara real-time dan terintegrasi
            untuk mendukung layanan yang lebih baik.
        </p>
    </div>
</div>
                <div class="card">
                    <div class="icon-box">
                        <i class="fa-solid fa-id-card"></i>
                    </div>
                    <div class="card-text">
                        <h4>Kartu Kendali Pasien</h4>
                        <p>
                            Kelola kartu kendali pasien untuk memantau perkembangan
                            pengobatan dan kepatuhan kontrol.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="icon-box">
                        <i class="fa-solid fa-chart-column"></i>
                    </div>
                    <div class="card-text">
                        <h4>Laporan Evaluasi</h4>
                        <p>
                            Hasilkan laporan evaluasi pengobatan dan capaian program
                            secara cepat, akurat, dan terstruktur.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="icon-box">
                        <i class="fa-solid fa-bell"></i>
                        <span class="badge">1</span>
                    </div>
                    <div class="card-text">
                        <h4>Notifikasi & Pengingat</h4>
                        <p>
                            Sistem pengingat otomatis untuk kontrol pasien, pengambilan obat,
                            dan tindak lanjut lainnya.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- MANFAAT SISTEM --}}
        <section id="tentang">
            <h2 class="section-title">Manfaat Sistem</h2>

            <div class="benefit-grid">
                <div class="card">
                    <div class="icon-box">
                        <i class="fa-solid fa-user-doctor"></i>
                    </div>
                    <div class="card-text">
                        <h4>Untuk Petugas Kesehatan</h4>
                        <p>
                            Mempermudah pencatatan, monitoring, dan evaluasi pasien secara efisien
                            dan terintegrasi sehingga meningkatkan kualitas pelayanan.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="icon-box">
                        <i class="fa-solid fa-users"></i>
                    </div>
                    <div class="card-text">
                        <h4>Untuk Pasien</h4>
                        <p>
                            Membantu pasien mendapatkan layanan yang terpantau,
                            pengingat kontrol, dan pengobatan yang lebih terarah.
                        </p>
                    </div>
                </div>

                <div class="card">
                    <div class="icon-box">
                        <i class="fa-solid fa-people-group"></i>
                    </div>
                    <div class="card-text">
                        <h4>Untuk Keluarga</h4>
                        <p>
                            Memberikan informasi dan pengingat yang membantu keluarga
                            mendukung kepatuhan pengobatan pasien.
                        </p>
                    </div>
                </div>
            </div>
        </section>

    </main>

    {{-- FOOTER --}}
    <footer class="footer" id="kontak">
        <div>
            <strong>Sistem Monitoring Pasien HIV di Kabupaten Benculuk Banyuwangi</strong>
        </div>

        <div class="footer-item">
            <span>Puskesmas Benculuk</span>
            <span>•</span>
            <span>Jl. Raya Benculuk No.1, Benculuk, Banyuwangi</span>
        </div>

        <div class="footer-item">
            <i class="fa-solid fa-phone"></i>
            <span>(0333) 123456</span>
            <span>•</span>
            <span>puskesmas.benculuk@banyuwangikab.go.id</span>
        </div>
    </footer>

</div>
</body>
</html>