<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Monitoring HIV Puskesmas Benculuk</title>

    {{-- Font Awesome --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    {{-- Google Fonts --}}
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        :root {
            --primary: #059669;
            --primary-dark: #065f46;
            --primary-light: #34d399;
            --slate-900: #0f172a;
            --slate-800: #1e293b;
            --slate-700: #334155;
            --slate-600: #475569;
            --slate-400: #94a3b8;
            --slate-50: #f8fafc;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(to bottom, rgba(15, 23, 42, 0) 0%, rgba(15, 23, 42, 0) 25%, rgba(15, 23, 42, 0.9) 90%), 
                        url('{{ asset("assets/login-bg.png") }}');
            background-size: cover;
            background-position: center 15%;
            background-attachment: fixed;
            display: flex;
            align-items: flex-end;
            justify-content: center;
            overflow-x: hidden;
            position: relative;
            padding: 20px 20px 50px;
        }

        /* Abstract Background Elements */
        .bg-glow {
            position: absolute;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(16, 185, 129, 0.12) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            pointer-events: none;
        }

        .login-container {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 950px;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background: rgba(255, 255, 255, 0.03);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 40px;
            overflow: hidden;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.8s ease-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        /* LEFT PANEL: INFO */
        .login-info {
            padding: 60px;
            background: linear-gradient(135deg, rgba(6, 78, 59, 0.8) 0%, rgba(5, 150, 105, 0.8) 100%);
            backdrop-filter: blur(10px);
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .login-info::before {
            content: '';
            position: absolute;
            top: -100px;
            right: -100px;
            width: 350px;
            height: 350px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 50%;
        }

        .brand-logos {
            display: flex;
            gap: 25px;
            margin-bottom: 40px;
            position: relative;
            z-index: 2;
        }

        .brand-logos img {
            height: 70px;
            width: auto;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.2));
        }

        .hero-text {
            position: relative;
            z-index: 2;
        }

        .hero-text h1 {
            font-size: 42px;
            font-weight: 900;
            line-height: 1.1;
            margin-bottom: 24px;
            letter-spacing: -1px;
        }

        .hero-text p {
            font-size: 17px;
            opacity: 0.9;
            line-height: 1.7;
            font-weight: 500;
            color: #ecfdf5;
        }

        .role-showcase {
            display: flex;
            gap: 15px;
            margin-top: 50px;
            position: relative;
            z-index: 2;
        }

        .role-item {
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(5px);
            padding: 20px 15px;
            border-radius: 20px;
            flex: 1;
            text-align: center;
            border: 1px solid rgba(255, 255, 255, 0.15);
            transition: all 0.3s;
        }

        .role-item:hover {
            background: rgba(255, 255, 255, 0.2);
            transform: translateY(-5px);
        }

        .role-item i {
            font-size: 26px;
            margin-bottom: 12px;
            display: block;
            color: #ffffff;
            text-shadow: 0 0 15px rgba(255,255,255,0.4);
        }

        .role-item span {
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 1px;
            display: block;
        }

        /* RIGHT PANEL: FORM */
        .login-form-area {
            padding: 60px;
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(25px) saturate(180%);
            -webkit-backdrop-filter: blur(25px) saturate(180%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
        }

        .form-header {
            margin-bottom: 45px;
        }

        .form-header h2 {
            font-size: 32px;
            font-weight: 900;
            color: white;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.2);
        }

        .form-header p {
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
            font-size: 16px;
        }

        .input-group {
            margin-bottom: 28px;
        }

        .input-group label {
            display: block;
            font-size: 14px;
            font-weight: 800;
            color: white;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            opacity: 0.9;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 20px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(255, 255, 255, 0.8);
            font-size: 18px;
            transition: all 0.3s;
        }

        .input-wrapper input {
            width: 100%;
            height: 58px;
            background: rgba(255, 255, 255, 0.15);
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-radius: 16px;
            padding: 0 20px 0 55px;
            font-size: 15px;
            font-weight: 700;
            color: white;
            transition: all 0.3s;
        }

        .input-wrapper input::placeholder {
            color: rgba(255, 255, 255, 0.5);
        }

        .input-wrapper input:focus {
            border-color: var(--primary-light);
            background: rgba(255, 255, 255, 0.2);
            outline: none;
            box-shadow: 0 0 0 4px rgba(52, 211, 153, 0.2);
        }

        .input-wrapper input:focus + i {
            color: var(--primary);
        }

        .btn-login {
            width: 100%;
            height: 62px;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 18px;
            font-size: 17px;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 15px 30px -5px rgba(5, 150, 105, 0.4);
            transition: all 0.3s;
            margin-top: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .btn-login:hover {
            background: var(--primary-dark);
            transform: translateY(-3px);
            box-shadow: 0 20px 40px -5px rgba(5, 150, 105, 0.5);
        }

        .btn-login:active {
            transform: translateY(-1px);
        }

        .alert-error {
            background: #fef2f2;
            border: 1.5px solid #fee2e2;
            padding: 18px;
            border-radius: 16px;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            gap: 12px;
            animation: shake 0.5s cubic-bezier(.36,.07,.19,.97) both;
        }

        @keyframes shake {
            10%, 90% { transform: translate3d(-1px, 0, 0); }
            20%, 80% { transform: translate3d(2px, 0, 0); }
            30%, 50%, 70% { transform: translate3d(-4px, 0, 0); }
            40%, 60% { transform: translate3d(4px, 0, 0); }
        }

        .alert-error i { color: #ef4444; font-size: 20px; }
        .alert-error span { color: #991b1b; font-size: 14px; font-weight: 700; }

        .form-footer {
            text-align: center;
            margin-top: 35px;
            font-size: 15px;
            color: rgba(255, 255, 255, 0.8);
            font-weight: 600;
        }

        .form-footer a {
            color: var(--primary-light);
            text-decoration: none;
            font-weight: 800;
            transition: all 0.2s;
        }

        .form-footer a:hover {
            color: white;
            text-decoration: underline;
        }

        .mobile-brand-logo {
            display: none;
            text-align: center;
            margin-bottom: 25px;
        }

        .mobile-brand-logo img {
            height: 60px;
            margin-bottom: 10px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.15));
        }

        .mobile-brand-logo h3 {
            font-size: 15px;
            font-weight: 800;
            color: #ffffff;
            line-height: 1.2;
        }

        .mobile-brand-logo span {
            font-size: 10px;
            color: var(--primary-light);
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        /* RESPONSIVE */
        @media (max-width: 950px) {
            .mobile-brand-logo {
                display: block;
            }
            .login-container {
                grid-template-columns: 1fr;
                max-width: 500px;
            }
            .login-info {
                display: none;
            }
            .login-form-area {
                padding: 45px 35px;
            }
        }

        @media (max-width: 576px) {
            body {
                align-items: center;
                padding: 20px 16px;
            }
            .login-container {
                border-radius: 24px;
            }
            .login-form-area {
                padding: 30px 20px;
            }
            .form-header {
                margin-bottom: 25px;
                text-align: center;
            }
            .form-header h2 {
                font-size: 26px;
            }
            .form-header p {
                font-size: 14px;
            }
            .input-group {
                margin-bottom: 20px;
            }
            .input-wrapper input {
                height: 52px;
                border-radius: 12px;
                font-size: 14px;
            }
            .btn-login {
                height: 54px;
                border-radius: 14px;
                font-size: 15px;
            }
            .form-footer {
                margin-top: 25px;
                font-size: 14px;
            }
        }
    </style>
</head>
<body>
    {{-- Background Glow Effects --}}
    <div class="bg-glow" style="top: -15%; left: -10%;"></div>
    <div class="bg-glow" style="bottom: -15%; right: -10%;"></div>

    <div class="login-container">
        {{-- LEFT PANEL --}}
        <div class="login-info">
            <div>
                <div class="brand-logos">
                    <img src="{{ asset('assets/logo-banyuwangi.png') }}" alt="Logo Kab. Banyuwangi">
                    <img src="{{ asset('assets/logo-puskesmas.png') }}" alt="Logo Puskesmas Benculuk">
                </div>
                <div class="hero-text">
                    <h1>Sistem Monitoring Pasien HIV</h1>
                    <p>Platform digital terintegrasi untuk pemantauan kepatuhan minum obat, jadwal kontrol, dan status kesehatan klinis pasien di wilayah Puskesmas Benculuk.</p>
                </div>
            </div>
            
            <div class="role-showcase">
                <div class="role-item">
                    <i class="fa-solid fa-user-shield"></i>
                    <span>Petugas</span>
                </div>
                <div class="role-item">
                    <i class="fa-solid fa-user-nurse"></i>
                    <span>Pasien</span>
                </div>
                <div class="role-item">
                    <i class="fa-solid fa-users-rectangle"></i>
                    <span>Keluarga</span>
                </div>
            </div>
        </div>

        {{-- RIGHT PANEL --}}
        <div class="login-form-area">
            {{-- Mobile Brand Logo --}}
            <div class="mobile-brand-logo">
                <img src="{{ asset('assets/logo-puskesmas.png') }}" alt="Logo Puskesmas Benculuk">
                <h3>PUSKESMAS BENCULUK</h3>
                <span>MONITORING HIV</span>
            </div>

            <div class="form-header">
                <h2>Selamat Datang</h2>
                <p>Silakan masuk untuk mengakses dashboard</p>
            </div>

            {{-- Error Alerts --}}
            @if ($errors->any())
                <div class="alert-error">
                    <i class="fa-solid fa-circle-exclamation"></i>
                    <span>{{ $errors->first('login') ?: 'Email/No HP atau password salah.' }}</span>
                </div>
            @endif

            @if (session('logout_success'))
                <div style="background: #f0fdf4; border: 1.5px solid #dcfce7; padding: 15px; border-radius: 16px; margin-bottom: 30px; display: flex; align-items: center; gap: 12px;">
                    <i class="fa-solid fa-circle-check" style="color: #10b981;"></i>
                    <span style="color: #166534; font-size: 14px; font-weight: 700;">Anda telah berhasil keluar dari sistem.</span>
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf
                <div class="input-group">
                    <label for="login">Email atau Nomor HP</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-user"></i>
                        <input 
                            type="text" 
                            id="login" 
                            name="login" 
                            placeholder="Email atau No HP..." 
                            required 
                            value="{{ old('login') }}"
                            autofocus
                        >
                    </div>
                </div>

                <div class="input-group">
                    <label for="password">Kata Sandi</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input 
                            type="password" 
                            id="password" 
                            name="password" 
                            placeholder="••••••••" 
                            required
                        >
                    </div>
                </div>

                <button type="submit" class="btn-login">
                    Masuk ke Sistem
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="form-footer">
                <p>Lupa akses akun? <a href="https://wa.me/628123456789" target="_blank">Hubungi Administrator</a></p>
            </div>
        </div>
    </div>

    {{-- SweetAlert2 for Success --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    @if (session('login_success'))
    <script>
        Swal.fire({
            icon: 'success',
            title: 'Login Berhasil',
            text: 'Menyiapkan ruang kerja Anda...',
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true,
            background: '#ffffff',
            color: '#1e293b'
        }).then(() => {
            window.location.href = "{{ url('/dashboard') }}";
        });
    </script>
    @endif
</body>
</html>