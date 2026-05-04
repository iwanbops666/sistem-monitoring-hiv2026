<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Monitoring Pasien HIV')</title>

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

        .wrapper {
            display: flex;
            min-height: 100vh;
        }

        /* SIDEBAR */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: #56a66b;
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            padding: 30px 14px 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 50;
        }

        .sidebar-logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .sidebar-logo img {
            width: 95px;
            height: 95px;
            object-fit: contain;
            margin-bottom: 14px;
        }

        .sidebar-logo h3 {
            color: #ffffff;
            font-size: 17px;
            line-height: 1.15;
            font-weight: 800;
        }

        .menu {
            list-style: none;
        }

        .menu li {
            margin-bottom: 7px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 11px;
            width: 100%;
            padding: 8px 12px;
            border-radius: 7px;
            text-decoration: none;
            color: #123b25;
            font-size: 17px;
            font-weight: 500;
            cursor: pointer;
        }

        .menu-link i:first-child {
            width: 18px;
            font-size: 16px;
        }

        .menu-link:hover {
            background: rgba(7, 89, 47, 0.14);
        }

        .menu-link.active {
            background: #07592f;
            color: #ffffff;
            font-weight: 800;
        }

        .arrow-icon {
            margin-left: auto;
            font-size: 12px;
            transition: 0.2s;
        }

        .has-submenu.open .arrow-icon {
            transform: rotate(90deg);
        }

        .submenu {
            display: none;
            margin-left: 34px;
            margin-top: 5px;
            margin-bottom: 8px;
        }

        .has-submenu.open .submenu {
            display: block;
        }

        .submenu a {
            display: flex;
            align-items: center;
            gap: 7px;
            color: #214b32;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            padding: 3px 0;
        }

        .submenu a.active-sub,
        .submenu a:hover {
            color: #07592f;
            font-weight: 800;
        }

        .logout-btn {
            width: 100%;
            background: #24713f;
            color: #ffffff;
            border: none;
            border-radius: 7px;
            padding: 15px 22px;
            display: flex;
            align-items: center;
            gap: 16px;
            text-decoration: none;
            font-size: 20px;
            font-weight: 800;
        }

        .logout-btn i {
            font-size: 25px;
        }

        /* MAIN */
        .main-content {
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
            padding: 70px 48px 40px;
        }

        .page-title {
            font-size: 38px;
            font-weight: 900;
            color: #111;
            margin-bottom: 35px;
            line-height: 1.08;
        }

        .table-card {
            background: #ffffff;
            border-radius: 24px;
            max-width: 1120px;
            padding: 38px 38px 24px;
            box-shadow: 0 18px 35px rgba(213, 224, 235, 0.58);
        }

        .table-top,
        .table-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            gap: 16px;
        }

        .table-label,
        .table-title span {
            color: #12bd75;
            font-size: 14px;
            font-weight: 600;
        }

        .table-title h3 {
            font-size: 28px;
            font-weight: 900;
            color: #000;
            margin-bottom: 10px;
        }

        .table-actions {
            display: flex;
            gap: 14px;
            align-items: center;
        }

        .search-box {
            width: 240px;
            height: 42px;
            background: #f8faff;
            border-radius: 9px;
            display: flex;
            align-items: center;
            gap: 9px;
            padding: 0 14px;
            color: #8b94a4;
        }

        .search-box input {
            width: 100%;
            border: none;
            outline: none;
            background: transparent;
            font-size: 14px;
        }

        .sort-box {
            height: 42px;
            border: none;
            outline: none;
            background: #f8faff;
            border-radius: 9px;
            padding: 0 14px;
            font-size: 14px;
            color: #6b7280;
        }

        .table-responsive {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        th {
            text-align: left;
            color: #a8adb8;
            font-size: 14px;
            font-weight: 600;
            padding-bottom: 18px;
        }

        td {
            color: #111827;
            font-size: 14px;
            padding: 16px 0;
            border-bottom: 1px solid #f1f1f1;
        }

        .btn-detail {
            background: #78dfc3;
            color: #08785c;
            border: 1px solid #17ac87;
            padding: 7px 14px;
            border-radius: 5px;
            font-size: 13px;
            cursor: pointer;
        }

        .btn-delete {
            background: #ffb8bf;
            color: #111;
            border: 1px solid #ff4d5b;
            padding: 6px 10px;
            border-radius: 5px;
            font-size: 14px;
            cursor: pointer;
            margin-left: 5px;
        }

        .btn-edit,
        .btn-modal-edit,
        .btn-edit-profile {
            background: #f8bcbc;
            color: #ef1f1f;
            border: none;
            padding: 10px 28px;
            border-radius: 4px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 3px 6px rgba(0,0,0,0.18);
        }

        .btn-save,
        .btn-modal-save,
        .btn-save-profile {
            background: #00b889;
            color: #ffffff;
            border: none;
            padding: 10px 28px;
            border-radius: 4px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 3px 6px rgba(0,0,0,0.18);
        }

        .badge {
            display: inline-block;
            min-width: 78px;
            padding: 7px 12px;
            border-radius: 5px;
            text-align: center;
            font-size: 13px;
            font-weight: 600;
        }

        .badge-danger {
            background: #ffb8bf;
            color: #ff2637;
            border: 1px solid #ff4d5b;
        }

        .badge-warning {
            background: #ffef72;
            color: #8a7600;
            border: 1px solid #e7cc00;
        }

        .badge-success,
        .badge-viral {
            background: #78dfc3;
            color: #08785c;
            border: 1px solid #17ac87;
        }

        .badge-viral {
            display: inline-block;
            min-width: 90px;
            padding: 9px 14px;
            border-radius: 6px;
            text-align: center;
            font-size: 14px;
            font-weight: 600;
        }

        .notif-icon {
            color: #6267ff;
            font-size: 22px;
        }

        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 22px;
            color: #a9aebb;
            font-size: 13px;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-btn {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            border: none;
            background: #f3f4f8;
            color: #757b87;
            font-size: 13px;
            cursor: pointer;
        }

        .page-btn.active {
            background: #5a45df;
            color: #ffffff;
        }

        /* GLOBAL MODAL */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.20);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 999;
            padding: 20px;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-close {
            position: absolute;
            top: 16px;
            right: 16px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: none;
            background: #ff1f1f;
            color: #ffffff;
            font-size: 22px;
            font-weight: bold;
            cursor: pointer;
            line-height: 34px;
        }

        /* ALERT EDIT */
        .edit-alert-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .edit-alert-overlay.show {
            display: flex;
        }

        .edit-alert-box {
            width: 420px;
            background: #ffffff;
            border-radius: 4px;
            padding: 30px 28px 28px;
            text-align: center;
            box-shadow: 0 14px 35px rgba(0, 0, 0, 0.18);
        }

        .edit-alert-icon {
            width: 84px;
            height: 76px;
            margin: 0 auto 20px;
            position: relative;
        }

        .edit-alert-icon::before {
            content: "";
            position: absolute;
            inset: 0;
            background: #ff1f2d;
            clip-path: polygon(50% 0%, 100% 100%, 0% 100%);
        }

        .edit-alert-icon::after {
            content: "!";
            position: absolute;
            left: 50%;
            top: 58%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 54px;
            background: #ffffff;
            color: #ff1f2d;
            clip-path: polygon(50% 0%, 100% 100%, 0% 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            font-weight: 900;
            padding-top: 10px;
        }

        .edit-alert-text {
            font-size: 18px;
            color: #4b4b4b;
            font-weight: 600;
            line-height: 1.35;
            margin-bottom: 28px;
        }

        .edit-alert-actions {
            display: flex;
            justify-content: center;
            gap: 28px;
        }

        .edit-alert-yes,
        .edit-alert-no {
            border: none;
            color: #ffffff;
            padding: 9px 42px;
            border-radius: 18px;
            font-weight: 700;
            cursor: pointer;
        }

        .edit-alert-yes {
            background: #23ad5c;
        }

        .edit-alert-no {
            background: #ff1f2d;
        }

        /* TOAST BERHASIL - TANPA TOMBOL EXIT */
        .success-toast {
            position: fixed;
            top: 28px;
            right: 38px;
            width: 285px;
            min-height: 74px;
            background: #65a87d;
            color: #ffffff;
            border-radius: 2px;
            padding: 14px 18px;
            display: none;
            align-items: center;
            gap: 12px;
            z-index: 100000;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.18);
        }

        .success-toast.show {
            display: flex;
            animation: slideToast 0.25s ease;
        }

        @keyframes slideToast {
            from {
                opacity: 0;
                transform: translateY(-12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .success-icon {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #2fd07c;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .success-toast h4 {
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 3px;
        }

        .success-toast p {
            font-size: 11px;
            margin: 0;
        }

        /* PANEL NOTIFIKASI */
        .notification-panel {
            position: fixed;
            top: 92px;
            right: 130px;
            width: 380px;
            background: #ffffff;
            border: 1px solid #d1d5db;
            border-radius: 5px;
            display: none;
            z-index: 99999;
            box-shadow: 0 18px 35px rgba(0, 0, 0, 0.16);
        }

        .notification-panel.show {
            display: block;
            animation: slideNotification 0.2s ease;
        }

        @keyframes slideNotification {
            from {
                opacity: 0;
                transform: translateY(-8px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 14px 18px 8px;
        }

        .notification-header h3 {
            font-size: 20px;
            font-weight: 600;
            color: #111827;
        }

        .notification-header button {
            border: none;
            background: transparent;
            font-size: 15px;
            cursor: pointer;
            color: #111827;
        }

        .notification-tabs {
            display: flex;
            align-items: center;
            gap: 8px;
            padding: 0 18px 12px;
            color: #4b5563;
            font-size: 13px;
            border-bottom: 1px solid #e5e7eb;
        }

        .notification-tabs small {
            background: #6d7dfc;
            color: #ffffff;
            padding: 1px 6px;
            border-radius: 8px;
            font-size: 10px;
        }

        .notification-list {
            max-height: 390px;
            overflow-y: auto;
            padding: 8px 18px 0;
        }

        .notification-item {
            display: flex;
            gap: 12px;
            padding: 14px 0;
            border-bottom: 1px solid #f1f1f1;
            position: relative;
        }

        .notification-item::after {
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

        .notification-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 18px;
            border-top: 1px solid #e5e7eb;
        }

        .notification-footer button {
            border: none;
            background: transparent;
            color: #6b7280;
            font-size: 11px;
            cursor: pointer;
        }

        .notification-footer .view-all-btn {
            background: #57a66b;
            color: #ffffff;
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: 700;
        }

        @stack('styles')

        @media (max-width: 850px) {
            .wrapper {
                flex-direction: column;
            }

            .sidebar {
                position: relative;
                width: 100%;
                min-height: auto;
            }

            .main-content {
                margin-left: 0;
                width: 100%;
                padding: 35px 20px;
            }

            .table-top,
            .table-header {
                flex-direction: column;
                align-items: flex-start;
            }

            .search-box {
                width: 100%;
            }

            .notification-panel {
                right: 20px;
                left: 20px;
                width: auto;
            }

            .success-toast {
                right: 20px;
                left: 20px;
                width: auto;
            }
        }
    </style>
</head>
<body>

<div class="wrapper">
    <aside class="sidebar">
        <div>
            <div class="sidebar-logo">
                <img src="{{ asset('assets/logo-puskesmas.png') }}" alt="Logo Puskesmas">
                <h3>
                    PUSKESMAS BENCULUK<br>
                    KABUPATEN BANYUWANGI
                </h3>
            </div>

            <ul class="menu">
                <li>
                    <a href="{{ url('/dashboard') }}"
                       class="menu-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-table-cells-large"></i>
                        Dashboard
                    </a>
                </li>

                <li class="has-submenu {{ request()->is('manajemen-pasien/*') ? 'open' : '' }}" id="menuManajemenPasien">
                    <a href="javascript:void(0)"
                       class="menu-link {{ request()->is('manajemen-pasien/*') ? 'active' : '' }}"
                       id="toggleManajemenPasien">
                        <i class="fa-solid fa-clipboard-list"></i>
                        Manajemen Pasien
                        <i class="fa-solid fa-chevron-right arrow-icon"></i>
                    </a>

                    <div class="submenu">
                        <a href="{{ url('/manajemen-pasien/data-viral-load') }}"
                           class="{{ request()->is('manajemen-pasien/data-viral-load') ? 'active-sub' : '' }}">
                            <i class="{{ request()->is('manajemen-pasien/data-viral-load') ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            Data Viral Load Pasien
                        </a>

                        <a href="{{ url('/manajemen-pasien/registrasi-pasien') }}"
                           class="{{ request()->is('manajemen-pasien/registrasi-pasien') ? 'active-sub' : '' }}">
                            <i class="{{ request()->is('manajemen-pasien/registrasi-pasien') ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            Registrasi Pasien
                        </a>
                    </div>
                </li>

                <li class="has-submenu {{ request()->is('manajemen-data-pasien/*') ? 'open' : '' }}" id="menuManajemenDataPasien">
                    <a href="javascript:void(0)"
                       class="menu-link {{ request()->is('manajemen-data-pasien/*') ? 'active' : '' }}"
                       id="toggleManajemenDataPasien">
                        <i class="fa-regular fa-clipboard"></i>
                        Manajemen Data Pasien
                        <i class="fa-solid fa-chevron-right arrow-icon"></i>
                    </a>

                    <div class="submenu">
                        <a href="{{ url('/manajemen-data-pasien/data-pasien') }}"
                           class="{{ request()->is('manajemen-data-pasien/data-pasien') ? 'active-sub' : '' }}">
                            <i class="{{ request()->is('manajemen-data-pasien/data-pasien') ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            Data Pasien
                        </a>

                        <a href="{{ url('/manajemen-data-pasien/data-kepatuhan-pasien') }}"
                           class="{{ request()->is('manajemen-data-pasien/data-kepatuhan-pasien') ? 'active-sub' : '' }}">
                            <i class="{{ request()->is('manajemen-data-pasien/data-kepatuhan-pasien') ? 'fa-regular fa-circle-dot' : 'fa-regular fa-circle' }}"></i>
                            Data Kepatuhan Pasien
                        </a>
                    </div>
                </li>

                <li>
                    <a href="{{ url('/kartu-kendali-pasien') }}"
                       class="menu-link {{ request()->is('kartu-kendali-pasien') ? 'active' : '' }}">
                        <i class="fa-solid fa-folder-open"></i>
                        Kartu Kendali Pasien
                    </a>
                </li>

                <li>
                    <a href="{{ url('/laporan-evaluasi-pasien') }}"
                       class="menu-link {{ request()->is('laporan-evaluasi-pasien') ? 'active' : '' }}">
                        <i class="fa-solid fa-folder-open"></i>
                        Laporan Evaluasi Pasien
                    </a>
                </li>

                <li>
                    <a href="{{ url('/data-laporan') }}"
                       class="menu-link {{ request()->is('data-laporan') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-column"></i>
                        Data Laporan
                    </a>
                </li>

                <li>
                    <a href="{{ url('/profile') }}"
                       class="menu-link {{ request()->is('profile') ? 'active' : '' }}">
                        <i class="fa-regular fa-circle-user"></i>
                        Profile
                    </a>
                </li>
            </ul>
        </div>

        <a href="{{ url('/logout') }}" class="logout-btn">
            <i class="fa-solid fa-right-from-bracket"></i>
            Log Out
        </a>
    </aside>

    <main class="main-content">
        @yield('content')
    </main>
</div>

{{-- ALERT EDIT GLOBAL --}}
<div class="edit-alert-overlay" id="editAlert">
    <div class="edit-alert-box">
        <div class="edit-alert-icon"></div>

        <div class="edit-alert-text">
            Perubahan akan disimpan.<br>
            Lanjutkan edit data ini?
        </div>

        <div class="edit-alert-actions">
            <button type="button" class="edit-alert-yes" id="editAlertYes">Ya</button>
            <button type="button" class="edit-alert-no" id="editAlertNo">Tidak</button>
        </div>
    </div>
</div>

{{-- TOAST BERHASIL TERSIMPAN --}}
<div class="success-toast" id="successToast">
    <div class="success-icon">
        <i class="fa-regular fa-circle-check"></i>
    </div>

    <div>
        <h4>Berhasil Tersimpan</h4>
        <p>Telah Tersimpan</p>
    </div>
</div>

{{-- PANEL NOTIFIKASI --}}
<div class="notification-panel" id="notificationPanel">
    <div class="notification-header">
        <h3>Notifications</h3>
        <button type="button" id="closeNotificationPanel">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>

    <div class="notification-tabs">
        <span>Inbox</span>
        <small>3</small>
    </div>

    <div class="notification-list">
        <div class="notification-item">
            <div class="notif-avatar">
                <img src="https://i.pravatar.cc/80?img=12" alt="Petugas">
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

        <div class="notification-item">
            <div class="notif-avatar">
                <img src="https://i.pravatar.cc/80?img=12" alt="Petugas">
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

        <div class="notification-item">
            <div class="notif-avatar">
                <img src="https://i.pravatar.cc/80?img=12" alt="Petugas">
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

    <div class="notification-footer">
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
        const toggleManajemenPasien = document.getElementById('toggleManajemenPasien');
        const menuManajemenPasien = document.getElementById('menuManajemenPasien');

        if (toggleManajemenPasien && menuManajemenPasien) {
            toggleManajemenPasien.addEventListener('click', function (event) {
                event.preventDefault();
                menuManajemenPasien.classList.toggle('open');
            });
        }

        const toggleManajemenDataPasien = document.getElementById('toggleManajemenDataPasien');
        const menuManajemenDataPasien = document.getElementById('menuManajemenDataPasien');

        if (toggleManajemenDataPasien && menuManajemenDataPasien) {
            toggleManajemenDataPasien.addEventListener('click', function (event) {
                event.preventDefault();
                menuManajemenDataPasien.classList.toggle('open');
            });
        }

        const editAlert = document.getElementById('editAlert');
        const editAlertYes = document.getElementById('editAlertYes');
        const editAlertNo = document.getElementById('editAlertNo');

        document.addEventListener('click', function (event) {
            const button = event.target.closest('.btn-confirm-edit');

            if (button && editAlert) {
                event.preventDefault();
                event.stopPropagation();
                editAlert.classList.add('show');
            }
        });

        if (editAlertYes) {
            editAlertYes.addEventListener('click', function () {
                editAlert.classList.remove('show');
            });
        }

        if (editAlertNo) {
            editAlertNo.addEventListener('click', function () {
                editAlert.classList.remove('show');
            });
        }

        if (editAlert) {
            editAlert.addEventListener('click', function (event) {
                if (event.target === editAlert) {
                    editAlert.classList.remove('show');
                }
            });
        }

        const notificationPanel = document.getElementById('notificationPanel');
        const closeNotificationPanel = document.getElementById('closeNotificationPanel');

        document.addEventListener('click', function (event) {
            const bellButton = event.target.closest('.notification-bell-btn');

            if (bellButton && notificationPanel) {
                event.preventDefault();
                event.stopPropagation();
                notificationPanel.classList.toggle('show');
            }
        });

        if (closeNotificationPanel) {
            closeNotificationPanel.addEventListener('click', function () {
                notificationPanel.classList.remove('show');
            });
        }

        document.addEventListener('click', function (event) {
            if (
                notificationPanel &&
                notificationPanel.classList.contains('show') &&
                !event.target.closest('#notificationPanel') &&
                !event.target.closest('.notification-bell-btn')
            ) {
                notificationPanel.classList.remove('show');
            }
        });

        const successToast = document.getElementById('successToast');
        let toastTimer = null;

        function showSuccessToast() {
            if (!successToast) return;

            successToast.classList.add('show');

            if (toastTimer) {
                clearTimeout(toastTimer);
            }

            toastTimer = setTimeout(function () {
                successToast.classList.remove('show');
            }, 1800);
        }

        document.addEventListener('click', function (event) {
            const saveButton = event.target.closest(
                '.btn-save, .btn-modal-save, .btn-save-profile, .btn-simpan-form, .btn-show-toast'
            );

            if (saveButton) {
                event.preventDefault();
                showSuccessToast();
            }
        });
    });
</script>

@stack('scripts')

</body>
</html>