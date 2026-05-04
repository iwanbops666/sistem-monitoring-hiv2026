<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Sistem Monitoring Pasien HIV</title>

    {{-- Font Awesome untuk icon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #005b34 0%, #0f8f4d 55%, #34c86c 100%);
            overflow: hidden;
        }

        .login-page {
            position: relative;
            width: 100%;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            color: #ffffff;
        }

        .login-page::before {
            content: "";
            position: absolute;
            inset: 0;
            background:
                radial-gradient(circle at 36% 26%, rgba(255,255,255,0.12) 0 2px, transparent 3px),
                linear-gradient(160deg, transparent 62%, rgba(255,255,255,0.15) 62%);
            opacity: 0.8;
        }

        .login-page::after {
            content: "";
            position: absolute;
            left: -10%;
            right: -10%;
            bottom: -80px;
            height: 220px;
            background: rgba(255,255,255,0.12);
            border-radius: 50% 50% 0 0;
            transform: rotate(-2deg);
        }

        .plus {
            position: absolute;
            color: rgba(255,255,255,0.14);
            font-size: 70px;
            font-weight: 900;
            z-index: 1;
        }

        .plus-1 {
            top: 185px;
            left: 380px;
        }

        .plus-2 {
            top: 330px;
            left: 370px;
            font-size: 55px;
        }

        .container {
            position: relative;
            z-index: 3;
            width: 100%;
            max-width: 1150px;
            display: grid;
            grid-template-columns: 1fr 520px;
            align-items: center;
            gap: 70px;
        }

        /* ================= LEFT BRAND ================= */

        .brand-area {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .logo-group {
            display: flex;
            align-items: center;
            gap: 26px;
            margin-bottom: 28px;
        }

        .logo-group img {
            width: 105px;
            height: 105px;
            object-fit: contain;
        }

        .brand-title {
            font-size: 36px;
            line-height: 1.45;
            font-weight: 900;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            max-width: 560px;
        }

        /* ================= LOGIN CARD ================= */

        .login-card {
            width: 100%;
            background: #1e762c;
            border-radius: 16px;
            padding: 48px 40px 42px;
            box-shadow: 0 18px 35px rgba(0,0,0,0.18);
        }

        .login-card-header {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-bottom: 38px;
        }

        .login-card-header img {
            width: 78px;
            height: 78px;
            object-fit: contain;
        }

        .login-card-header h2 {
            font-size: 25px;
            line-height: 1.15;
            font-weight: 900;
            color: #ffffff;
        }

        .login-card-header span {
            display: block;
            font-size: 18px;
            font-weight: 800;
            margin-top: 4px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 8px;
            color: #ffffff;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper i {
            position: absolute;
            left: 18px;
            top: 50%;
            transform: translateY(-50%);
            color: #31c86b;
            font-size: 18px;
        }

        .input-wrapper input {
            width: 100%;
            height: 56px;
            border: none;
            outline: none;
            border-radius: 10px;
            background: #edf3fb;
            padding: 0 18px 0 52px;
            font-size: 16px;
            color: #1b1b1b;
        }

        .input-wrapper input:focus {
            box-shadow: 0 0 0 3px rgba(52, 200, 108, 0.35);
        }

        .forgot-password {
            display: inline-block;
            margin: 8px 0 16px;
            color: #ffffff;
            font-size: 17px;
            text-decoration: none;
            font-weight: 500;
        }

        .forgot-password:hover {
            text-decoration: underline;
        }

        .btn-login {
            width: 100%;
            height: 62px;
            border: none;
            outline: none;
            border-radius: 10px;
            background: #35cc70;
            color: #ffffff;
            font-size: 17px;
            font-weight: 900;
            cursor: pointer;
            transition: 0.2s ease;
        }

        .btn-login:hover {
            background: #2fbd67;
            transform: translateY(-1px);
        }

        .error-message {
            background: rgba(255, 88, 88, 0.15);
            border: 1px solid rgba(255, 130, 130, 0.6);
            color: #ffffff;
            padding: 12px 14px;
            border-radius: 8px;
            margin-bottom: 18px;
            font-size: 14px;
        }

        /* ================= RESPONSIVE ================= */

        @media (max-width: 992px) {
            body {
                overflow-y: auto;
            }

            .login-page {
                padding: 30px 20px;
            }

            .container {
                grid-template-columns: 1fr;
                gap: 40px;
                max-width: 600px;
            }

            .brand-area {
                text-align: center;
                align-items: center;
            }

            .logo-group {
                justify-content: center;
            }

            .brand-title {
                font-size: 30px;
            }
        }

        @media (max-width: 576px) {
            .login-card {
                padding: 34px 24px;
            }

            .login-card-header {
                flex-direction: column;
                text-align: center;
                gap: 12px;
            }

            .login-card-header h2 {
                font-size: 21px;
            }

            .login-card-header span {
                font-size: 15px;
            }

            .logo-group img {
                width: 82px;
                height: 82px;
            }

            .brand-title {
                font-size: 24px;
            }
        }
    </style>
</head>
<body>

<div class="login-page">

    {{-- Dekorasi --}}
    <div class="plus plus-1">+</div>
    <div class="plus plus-2">+</div>

    <div class="container">

        {{-- Bagian kiri --}}
        <div class="brand-area">
            <div class="logo-group">
                {{-- Ganti nama file sesuai logo kamu --}}
                <img src="{{ asset('assets/logo-banyuwangi.png') }}" alt="Logo Banyuwangi">
                <img src="{{ asset('assets/logo-puskesmas.png') }}" alt="Logo Puskesmas">
            </div>

            <h1 class="brand-title">
                Sistem Monitoring<br>
                Pasien HIV Puskesmas<br>
                Benculuk Banyuwangi
            </h1>
        </div>

        {{-- Bagian kanan login --}}
        <div class="login-card">

            <div class="login-card-header">
                <img src="{{ asset('assets/logo-puskesmas.png') }}" alt="Logo Puskesmas">

                <div>
                    <h2>PUSKESMAS BENCULUK</h2>
                    <span>KABUPATEN BANYUWANGI</span>
                </div>
            </div>

            {{-- Jika ada error login --}}
            @if ($errors->any())
                <div class="error-message">
                    Email atau password tidak sesuai.
                </div>
            @endif

            <form action="{{ url('/login') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <i class="fa-regular fa-user"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            required
                            autofocus
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <i class="fa-solid fa-lock"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            required
                        >
                    </div>
                </div>

                <a href="#" class="forgot-password">Lupa Password</a>

                <button type="submit" class="btn-login">
                    LOGIN
                </button>
            </form>

        </div>

    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('login_success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Login Berhasil',
        text: 'Anda akan diarahkan ke dashboard',
        confirmButtonText: 'OK',
        confirmButtonColor: '#2d89e5',
        allowOutsideClick: false
    }).then(() => {
        window.location.href = "{{ url('/dashboard') }}";
    });
</script>
@endif
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if (session('logout_success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Logout Berhasil',
        text: 'Anda telah keluar dari sistem',
        confirmButtonText: 'OK',
        confirmButtonColor: '#2d89e5'
    });
</script>
@endif
</body>
</html>