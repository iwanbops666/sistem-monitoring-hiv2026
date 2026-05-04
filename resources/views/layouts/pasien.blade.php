<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard Pasien')</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: #f4faff;
            color: #111827;
        }

        .pasien-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* SIDEBAR PASIEN */
        .pasien-sidebar {
            width: 280px;
            min-height: 100vh;
            background: #56a66b;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            padding: 32px 14px 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 50;
        }

        .pasien-logo {
            text-align: center;
            margin-bottom: 42px;
        }

        .pasien-logo img {
            width: 105px;
            height: 105px;
            object-fit: contain;
            margin-bottom: 14px;
        }

        .pasien-logo h3 {
            color: #ffffff;
            font-size: 17px;
            line-height: 1.15;
            font-weight: 900;
        }

        .pasien-menu {
            list-style: none;
        }

        .pasien-menu li {
            margin-bottom: 8px;
        }

        .pasien-menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            width: 100%;
            padding: 8px 14px;
            border-radius: 7px;
            color: #123b25;
            text-decoration: none;
            font-size: 18px;
            font-weight: 500;
            transition: 0.2s ease;
        }

        .pasien-menu a i {
            width: 18px;
            font-size: 17px;
        }

        .pasien-menu a:hover {
            background: rgba(7, 89, 47, 0.14);
        }

        .pasien-menu a.active {
            background: #07592f;
            color: #ffffff;
            font-weight: 900;
        }

        .pasien-logout {
            width: 100%;
            background: #24713f;
            color: #ffffff;
            border-radius: 7px;
            padding: 16px 22px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 22px;
            font-weight: 900;
        }

        .pasien-logout i {
            font-size: 28px;
        }

        /* CONTENT */
        .pasien-main {
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
            padding: 70px 52px 40px;
        }

        .pasien-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 46px;
            max-width: 1050px;
        }

        .pasien-page-title {
            font-size: 42px;
            font-weight: 900;
            color: #1f2937;
        }

        .pasien-user-area {
            display: flex;
            align-items: center;
            gap: 30px;
            position: relative;
        }

        .pasien-bell-btn {
            border: none;
            background: transparent;
            font-size: 30px;
            color: #000000;
            cursor: pointer;
            position: relative;
        }

        .pasien-bell-btn::after {
            content: "";
            position: absolute;
            right: 1px;
            top: 3px;
            width: 9px;
            height: 9px;
            background: #22c55e;
            border: 2px solid #ffffff;
            border-radius: 50%;
        }

        .pasien-profile-mini {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .pasien-profile-mini img {
            width: 66px;
            height: 66px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 8px 18px rgba(0,0,0,0.18);
        }

        .pasien-profile-mini h4 {
            font-size: 16px;
            font-weight: 900;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .pasien-profile-mini span {
            font-size: 14px;
            font-weight: 600;
            color: #8b8b8b;
        }

        /* PANEL NOTIFIKASI PASIEN */
        .pasien-notification-panel {
            position: fixed;
            top: 90px;
            right: 135px;
            width: 380px;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            display: none;
            z-index: 99999;
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.16);
        }

        .pasien-notification-panel.show {
            display: block;
            animation: notifSlide 0.2s ease;
        }

        @keyframes notifSlide {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notif-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px 8px;
        }

        .notif-header h3 {
            font-size: 20px;
            font-weight: 600;
            color: #111827;
        }

        .notif-header button {
            border: none;
            background: transparent;
            font-size: 15px;
            cursor: pointer;
            color: #111827;
        }

        .notif-tabs {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 18px 12px;
            color: #4b5563;
            font-size: 13px;
            border-bottom: 1px solid #e5e7eb;
        }

        .notif-tabs small {
            background: #6d7dfc;
            color: #ffffff;
            padding: 1px 6px;
            border-radius: 8px;
            font-size: 10px;
        }

        .notif-list {
            max-height: 390px;
            overflow-y: auto;
            padding: 8px 18px 0;
        }

        .notif-item {
            display: flex;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid #f1f1f1;
            position: relative;
        }

        .notif-item::after {
            content: "";
            position: absolute;
            right: 0;
            top: 20px;
            width: 7px;
            height: 7px;
            background: #4ade80;
            border-radius: 50%;
        }

        .notif-avatar {
            position: relative;
            flex-shrink: 0;
        }

        .notif-avatar img {
            width: 34px;
            height: 34px;
            border-radius: 50%;
            object-fit: cover;
        }

        .notif-avatar span {
            position: absolute;
            right: -2px;
            bottom: 2px;
            width: 8px;
            height: 8px;
            background: #facc15;
            border-radius: 50%;
        }

        .notif-content {
            flex: 1;
            padding-right: 12px;
        }

        .notif-content small {
            color: #9ca3af;
            font-size: 11px;
        }

        .notif-content h4 {
            color: #111827;
            font-size: 13px;
            font-weight: 700;
            margin: 4px 0 8px;
        }

        .notif-box {
            background: #f3f4f6;
            border-radius: 5px;
            padding: 9px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            color: #111827;
            font-size: 11px;
        }

        .notif-box i:first-child {
            width: 24px;
            height: 24px;
            border-radius: 4px;
            background: #e5f7eb;
            color: #16a34a;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .notif-box i:last-child {
            margin-left: auto;
            color: #6b7280;
            background: transparent;
            width: auto;
            height: auto;
        }

        .notif-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 18px;
            border-top: 1px solid #e5e7eb;
        }

        .notif-footer button {
            border: none;
            background: transparent;
            color: #6b7280;
            font-size: 11px;
            cursor: pointer;
        }

        .notif-footer .view-all-btn {
            background: #57a66b;
            color: #ffffff;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
        }

        @stack('styles')

        @media (max-width: 900px) {
            .pasien-wrapper {
                flex-direction: column;
            }

            .pasien-sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .pasien-main {
                margin-left: 0;
                width: 100%;
                padding: 35px 22px;
            }

            .pasien-topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .pasien-notification-panel {
                left: 20px;
                right: 20px;
                width: auto;
            }
        }
    </style>
</head>
<body>

<div class="pasien-wrapper">
    <aside class="pasien-sidebar">
        <div>
            <div class="pasien-logo">
                <img src="{{ asset('assets/logo-puskesmas.png') }}" alt="Logo Puskesmas">
                <h3>
                    PUSKESMAS BENCULUK<br>
                    KABUPATEN BANYUWANGI
                </h3>
            </div>

            <ul class="pasien-menu">
                <li>
                    <a href="{{ url('/pasien/dashboard') }}"
                       class="{{ request()->is('pasien/dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-table-cells-large"></i>
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ url('/pasien/profile') }}"
                       class="{{ request()->is('pasien/profile') ? 'active' : '' }}">
                        <i class="fa-regular fa-circle-user"></i>
                        Profile
                    </a>
                </li>

                <li>
                    <a href="{{ url('/pasien/kartu-kendali') }}"
                       class="{{ request()->is('pasien/kartu-kendali') ? 'active' : '' }}">
                        <i class="fa-solid fa-folder-open"></i>
                        Kartu Kendali Pasien
                    </a>
                </li>

                <li>
                    <a href="{{ url('/pasien/laporan-evaluasi') }}"
                       class="{{ request()->is('pasien/laporan-evaluasi') ? 'active' : '' }}">
                        <i class="fa-regular fa-clipboard"></i>
                        Laporan Evaluasi Pasien
                    </a>
                </li>
            </ul>
        </div>

        <a href="{{ url('/logout') }}" class="pasien-logout">
            <i class="fa-solid fa-right-from-bracket"></i>
            Log Out
        </a>
    </aside>

    <main class="pasien-main">
        <div class="pasien-topbar">
            <h1 class="pasien-page-title">@yield('page-title', 'Dashboard')</h1>

            <div class="pasien-user-area">
                <button type="button" class="pasien-bell-btn" id="pasienBellButton">
                    <i class="fa-regular fa-bell"></i>
                </button>

                <div class="pasien-profile-mini">
                    <img src="https://i.pravatar.cc/150?img=12" alt="Profile Pasien">
                    <div>
                        <h4>Jono Widodo</h4>
                        <span>Pasien</span>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')
    </main>
</div>

{{-- PANEL NOTIFIKASI PASIEN --}}
<div class="pasien-notification-panel" id="pasienNotificationPanel">
    <div class="notif-header">
        <h3>Notifications</h3>
        <button type="button" id="closePasienNotification">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="notif-tabs">
        <span>Inbox</span>
        <small>3</small>
    </div>

    <div class="notif-list">
        <div class="notif-item">
            <div class="notif-avatar">
                <img src="https://i.pravatar.cc/80?img=11" alt="Petugas">
                <span></span>
            </div>

            <div class="notif-content">
                <small>2 days ago • Petugas</small>
                <h4>Waktunya Anda Kontrol Dan Pengambilan Obat</h4>

                <div class="notif-box">
                    <i class="fa-solid fa-user-doctor"></i>
                    <span>Saatnya Kontrol Dan Pengambilan Obat</span>
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </div>
            </div>
        </div>

        <div class="notif-item">
            <div class="notif-avatar">
                <img src="https://i.pravatar.cc/80?img=11" alt="Petugas">
                <span></span>
            </div>

            <div class="notif-content">
                <small>2 days ago • Petugas</small>
                <h4>Waktunya Minum Obat</h4>

                <div class="notif-box">
                    <i class="fa-solid fa-tablets"></i>
                    <span>Saatnya Minum Obat</span>
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </div>
            </div>
        </div>

        <div class="notif-item">
            <div class="notif-avatar">
                <img src="https://i.pravatar.cc/80?img=11" alt="Petugas">
                <span></span>
            </div>

            <div class="notif-content">
                <small>2 days ago • Petugas</small>
                <h4>Waktunya Anda Melakukan Viral Load</h4>

                <div class="notif-box">
                    <i class="fa-solid fa-briefcase-medical"></i>
                    <span>Saatnya Viral Load</span>
                    <i class="fa-solid fa-ellipsis-vertical"></i>
                </div>
            </div>
        </div>
    </div>

    <div class="notif-footer">
        <button type="button">
            <i class="fa-regular fa-square-check"></i>
            Mark all as read
        </button>

        <button type="button" class="view-all-btn">
            View all Notifications
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const pasienBellButton = document.getElementById('pasienBellButton');
        const pasienNotificationPanel = document.getElementById('pasienNotificationPanel');
        const closePasienNotification = document.getElementById('closePasienNotification');

        if (pasienBellButton && pasienNotificationPanel) {
            pasienBellButton.addEventListener('click', function (event) {
                event.preventDefault();
                event.stopPropagation();
                pasienNotificationPanel.classList.toggle('show');
            });
        }

        if (closePasienNotification && pasienNotificationPanel) {
            closePasienNotification.addEventListener('click', function () {
                pasienNotificationPanel.classList.remove('show');
            });
        }

        document.addEventListener('click', function (event) {
            if (
                pasienNotificationPanel &&
                pasienNotificationPanel.classList.contains('show') &&
                !event.target.closest('#pasienNotificationPanel') &&
                !event.target.closest('#pasienBellButton')
            ) {
                pasienNotificationPanel.classList.remove('show');
            }
        });
    });
</script>

@stack('scripts')

</body>
</html>s