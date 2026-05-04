<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Keluarga Pasien')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --sidebar-bg: #58a86b;
            --sidebar-active: #08703a;
            --sidebar-text: #113b24;
            --main-bg: #eef5fb;
            --card-bg: #ffffff;
            --text-dark: #172236;
            --text-soft: #8b95a5;
            --green: #12a150;
            --green-soft: #9ee3cf;
            --green-border: #22aa83;
            --danger: #ff2020;
            --shadow: 0 14px 34px rgba(22, 49, 80, 0.10);
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: var(--main-bg);
            color: var(--text-dark);
        }

        .family-wrapper {
            min-height: 100vh;
            display: flex;
        }

        .family-sidebar {
            width: 270px;
            min-height: 100vh;
            background: var(--sidebar-bg);
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            padding: 26px 14px 22px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 100;
        }

        .family-logo {
            text-align: center;
            margin-bottom: 44px;
        }

        .family-logo img {
            width: 100px;
            height: 100px;
            object-fit: contain;
            margin-bottom: 18px;
        }

        .family-logo h2 {
            color: #ffffff;
            font-size: 16px;
            font-weight: 900;
            line-height: 1.18;
            letter-spacing: 0.2px;
        }

        .family-menu {
            list-style: none;
        }

        .family-menu li {
            margin-bottom: 10px;
        }

        .family-menu a {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 100%;
            padding: 13px 16px;
            border-radius: 12px;
            color: var(--sidebar-text);
            text-decoration: none;
            font-size: 18px;
            font-weight: 700;
            transition: 0.2s ease;
        }

        .family-menu a i {
            width: 24px;
            font-size: 21px;
            text-align: center;
        }

        .family-menu a:hover {
            background: rgba(8, 112, 58, 0.13);
        }

        .family-menu a.active {
            background: var(--sidebar-active);
            color: #ffffff;
            font-weight: 900;
        }

        .family-logout {
            display: flex;
            align-items: center;
            gap: 14px;
            background: #24743f;
            color: #ffffff;
            text-decoration: none;
            padding: 18px 20px;
            border-radius: 14px;
            font-size: 21px;
            font-weight: 900;
            box-shadow: 0 10px 22px rgba(0, 0, 0, 0.12);
        }

        .family-logout i {
            font-size: 26px;
        }

        .family-main {
            margin-left: 270px;
            width: calc(100% - 270px);
            min-height: 100vh;
            padding: 44px 50px 42px;
        }

        .family-inner {
            max-width: 1220px;
            margin: 0 auto;
        }

        .family-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 24px;
            margin-bottom: 44px;
        }

        .family-title {
            font-size: 42px;
            font-weight: 900;
            color: var(--text-dark);
            line-height: 1.1;
        }

        .family-user-area {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .family-bell {
            position: relative;
            border: none;
            background: transparent;
            color: #000000;
            font-size: 31px;
            cursor: pointer;
        }

        .family-bell-dot {
            position: absolute;
            top: 2px;
            right: 0;
            width: 12px;
            height: 12px;
            background: #2dcc69;
            border: 2px solid #ffffff;
            border-radius: 50%;
        }

        .family-user {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .family-user img {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.16);
        }

        .family-user h4 {
            font-size: 18px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 5px;
        }

        .family-user span {
            font-size: 15px;
            color: var(--text-soft);
            font-weight: 600;
        }

        .family-notif-panel {
            position: fixed;
            top: 96px;
            right: 58px;
            width: 365px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 18px 42px rgba(0, 0, 0, 0.16);
            overflow: hidden;
            display: none;
            z-index: 99999;
        }

        .family-notif-panel.show {
            display: block;
            animation: notifFade 0.2s ease;
        }

        @keyframes notifFade {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .family-notif-header {
            padding: 16px 18px;
            border-bottom: 1px solid #edf0f4;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .family-notif-header h3 {
            font-size: 20px;
            font-weight: 900;
            color: #1f2937;
        }

        .family-notif-close {
            border: none;
            background: transparent;
            font-size: 18px;
            color: #555;
            cursor: pointer;
        }

        .family-notif-body {
            padding: 8px 16px 12px;
            max-height: 360px;
            overflow-y: auto;
        }

        .family-notif-item {
            display: flex;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid #f1f3f6;
        }

        .family-notif-item:last-child {
            border-bottom: none;
        }

        .family-notif-icon {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: #e9f8ef;
            color: #15964d;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 17px;
            flex-shrink: 0;
        }

        .family-notif-content h5 {
            font-size: 14px;
            font-weight: 900;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .family-notif-content p {
            font-size: 13px;
            color: #6b7280;
            line-height: 1.45;
            margin-bottom: 5px;
        }

        .family-notif-content small {
            font-size: 11px;
            color: #9aa3af;
        }

        @media (max-width: 992px) {
            .family-wrapper {
                flex-direction: column;
            }

            .family-sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .family-main {
                margin-left: 0;
                width: 100%;
                padding: 30px 20px;
            }

            .family-topbar {
                flex-direction: column;
                align-items: flex-start;
            }

            .family-user-area {
                width: 100%;
                justify-content: space-between;
            }
        }

        @media (max-width: 768px) {
            .family-title {
                font-size: 32px;
            }

            .family-notif-panel {
                left: 12px;
                right: 12px;
                width: auto;
            }
        }
    </style>

    @stack('styles')
</head>
<body>
    <div class="family-wrapper">
        <aside class="family-sidebar">
            <div>
                <div class="family-logo">
                    <img src="{{ asset('assets/logo-puskesmas.png') }}" alt="Logo Puskesmas">
                    <h2>
                        PUSKESMAS BENCULUK<br>
                        KABUPATEN BANYUWANGI
                    </h2>
                </div>

                <ul class="family-menu">
                    <li>
                        <a href="{{ url('/keluarga/dashboard') }}"
                           class="{{ request()->is('keluarga/dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-table-cells-large"></i>
                            Dashboard
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/keluarga/profile') }}"
                           class="{{ request()->is('keluarga/profile') ? 'active' : '' }}">
                            <i class="fa-regular fa-circle-user"></i>
                            Profile
                        </a>
                    </li>
                </ul>
            </div>

            <a href="{{ url('/logout') }}" class="family-logout">
                <i class="fa-solid fa-right-from-bracket"></i>
                Log Out
            </a>
        </aside>

        <main class="family-main">
            <div class="family-inner">
                <div class="family-topbar">
                    <h1 class="family-title">@yield('page-title', 'Dashboard')</h1>

                    <div class="family-user-area">
                        <button type="button" class="family-bell" id="familyBellButton">
                            <i class="fa-regular fa-bell"></i>
                            <span class="family-bell-dot"></span>
                        </button>

                        <div class="family-user">
                            <img src="https://i.pravatar.cc/150?img=12" alt="Foto Keluarga">
                            <div>
                                <h4>Supri Widodo</h4>
                                <span>Keluarga Pasien</span>
                            </div>
                        </div>
                    </div>
                </div>

                @yield('content')
            </div>
        </main>
    </div>

    <div class="family-notif-panel" id="familyNotifPanel">
        <div class="family-notif-header">
            <h3>Notifikasi</h3>
            <button type="button" class="family-notif-close" id="familyNotifClose">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <div class="family-notif-body">
            <div class="family-notif-item">
                <div class="family-notif-icon">
                    <i class="fa-solid fa-calendar-check"></i>
                </div>
                <div class="family-notif-content">
                    <h5>Jadwal kontrol sudah dekat</h5>
                    <p>Pasien memiliki jadwal kontrol dan pengambilan obat dalam 3 hari lagi.</p>
                    <small>2 jam lalu</small>
                </div>
            </div>

            <div class="family-notif-item">
                <div class="family-notif-icon">
                    <i class="fa-solid fa-pills"></i>
                </div>
                <div class="family-notif-content">
                    <h5>Pengingat minum obat</h5>
                    <p>Mohon bantu ingatkan pasien untuk minum obat sesuai jadwal.</p>
                    <small>Hari ini</small>
                </div>
            </div>

            <div class="family-notif-item">
                <div class="family-notif-icon">
                    <i class="fa-solid fa-stethoscope"></i>
                </div>
                <div class="family-notif-content">
                    <h5>Pengingat evaluasi</h5>
                    <p>Ada evaluasi pasien yang perlu diperhatikan pada kunjungan berikutnya.</p>
                    <small>Kemarin</small>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const bellButton = document.getElementById('familyBellButton');
            const notifPanel = document.getElementById('familyNotifPanel');
            const notifClose = document.getElementById('familyNotifClose');

            if (bellButton && notifPanel) {
                bellButton.addEventListener('click', function (event) {
                    event.stopPropagation();
                    notifPanel.classList.toggle('show');
                });
            }

            if (notifClose && notifPanel) {
                notifClose.addEventListener('click', function () {
                    notifPanel.classList.remove('show');
                });
            }

            document.addEventListener('click', function (event) {
                if (
                    notifPanel &&
                    notifPanel.classList.contains('show') &&
                    !notifPanel.contains(event.target) &&
                    !bellButton.contains(event.target)
                ) {
                    notifPanel.classList.remove('show');
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>