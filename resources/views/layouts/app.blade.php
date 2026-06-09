<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Sistem Monitoring Pasien HIV')</title>

    <link rel="manifest" href="/manifest.json">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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

        /* SIDEBAR PETUGAS */
        .sidebar {
            width: 280px;
            min-height: 100vh;
            background: #065f46; /* Darker, more premium emerald */
            position: fixed;
            left: 0;
            top: 0;
            bottom: 0;
            padding: 40px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            z-index: 50;
            box-shadow: 4px 0 20px rgba(0,0,0,0.05);
        }

        .sidebar-logo {
            text-align: center;
            margin-bottom: 40px;
        }

        .sidebar-logo img {
            width: 90px;
            height: 90px;
            object-fit: contain;
            margin-bottom: 15px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
        }

        .sidebar-logo h3 {
            color: #ffffff;
            font-size: 15px;
            line-height: 1.4;
            font-weight: 800;
            letter-spacing: 0.5px;
            opacity: 0.95;
        }

        .menu {
            list-style: none;
            margin-top: 10px;
        }

        .menu li {
            margin-bottom: 8px;
        }

        .menu-link {
            display: flex;
            align-items: center;
            gap: 15px;
            width: 100%;
            padding: 12px 18px;
            border-radius: 14px;
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            border: none;
            background: transparent;
        }

        .menu-link i:first-child {
            width: 18px;
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .menu-link:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .menu-link.active {
            background: #ffffff;
            color: #065f46;
            font-weight: 800;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .arrow-icon {
            margin-left: auto;
            font-size: 11px;
            transition: transform 0.3s ease;
        }

        .has-submenu.open .arrow-icon {
            transform: rotate(90deg);
        }

        .submenu {
            display: none;
            margin-left: 20px;
            margin-top: 5px;
            margin-bottom: 10px;
            border-left: 1.5px solid rgba(255, 255, 255, 0.2);
            padding-left: 15px;
        }

        .has-submenu.open .submenu {
            display: block;
            animation: slideDown 0.3s ease-out;
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .submenu a {
            display: flex;
            align-items: center;
            gap: 10px;
            color: rgba(255, 255, 255, 0.6);
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            padding: 10px 0;
            transition: all 0.2s;
        }

        .submenu a i {
            font-size: 10px;
        }

        .submenu a.active-sub,
        .submenu a:hover {
            color: #ffffff;
            font-weight: 700;
        }

        .logout-btn {
            width: 100%;
            background: rgba(255, 255, 255, 0.08);
            color: #ffffff;
            border-radius: 14px;
            padding: 14px 20px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 15px;
            font-weight: 700;
            transition: all 0.3s ease;
            border: 1px solid rgba(255, 255, 255, 0.1);
        }

        .logout-btn:hover {
            background: #ef4444;
            border-color: #ef4444;
            box-shadow: 0 8px 15px rgba(239, 68, 68, 0.3);
        }

        /* MAIN CONTENT */
        .main-content {
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
            padding: 45px 50px;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 45px;
        }

        .page-title {
            font-size: 32px;
            font-weight: 900;
            color: #111827;
            letter-spacing: -0.5px;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .petugas-bell {
            width: 48px;
            height: 48px;
            background: #ffffff;
            border: 1.5px solid #e5e7eb;
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            color: #64748b;
            cursor: pointer;
            position: relative;
            transition: all 0.3s ease;
        }

        .petugas-bell:hover {
            border-color: #10b981;
            color: #10b981;
            background: #f0fdf4;
            transform: translateY(-2px);
        }

        .petugas-bell-dot {
            position: absolute;
            top: 13px;
            right: 13px;
            width: 10px;
            height: 10px;
            background: #ef4444;
            border: 2.5px solid #ffffff;
            border-radius: 50%;
        }

        .petugas-user {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 6px 18px 6px 6px;
            background: #ffffff;
            border-radius: 18px;
            border: 1.5px solid #e5e7eb;
        }

        .petugas-user img {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            object-fit: cover;
        }

        .petugas-user h4 {
            font-size: 14px;
            font-weight: 800;
            color: #111827;
        }

        .petugas-user span {
            font-size: 12px;
            font-weight: 600;
            color: #94a3b8;
        }

        /* GLOBAL COMPONENTS */
        .table-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(213, 224, 235, 0.3);
            border: 1px solid #f1f5f9;
        }

        .search-box {
            background: #f8fafc;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 0 16px;
            height: 42px;
            display: flex;
            align-items: center;
            gap: 10px;
            width: 300px;
            transition: all 0.2s;
        }

        .search-box:focus-within {
            border-color: #10b981;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
        }

        .search-box input {
            border: none;
            background: transparent;
            outline: none;
            font-size: 14px;
            width: 100%;
            color: #1e293b;
        }

        table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 10px;
        }

        th {
            padding: 0 20px 10px;
            text-align: left;
            font-size: 13px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
        }

        tr td {
            background: #f8fafc;
            padding: 15px 20px;
            font-size: 14px;
            font-weight: 600;
            color: #334155;
            transition: all 0.2s;
        }

        tr td:first-child { border-radius: 12px 0 0 12px; }
        tr td:last-child { border-radius: 0 12px 12px 0; }

        tr:hover td {
            background: #f1f5f9;
        }

        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            display: inline-block;
        }

        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef9c3; color: #854d0e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }

        .btn-detail { background: #eff6ff; color: #2563eb; border: none; padding: 6px 12px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 13px; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; }
        .btn-link-action { background: transparent; color: #2563eb; border: none; padding: 6px 10px; font-weight: 700; cursor: pointer; font-size: 13px; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; }
        .btn-link-action:hover { color: #1d4ed8; text-decoration: underline; }
        .btn-compact-action { background: #10b981; color: white; border: none; padding: 6px 12px; border-radius: 8px; font-weight: 700; cursor: pointer; font-size: 13px; transition: all 0.2s; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap; }
        .btn-compact-action:hover { background: #059669; transform: translateY(-1px); box-shadow: 0 4px 10px rgba(16, 185, 129, 0.2); }
        .btn-edit { background: #fef9c3; color: #854d0e; border: none; padding: 8px 15px; border-radius: 8px; font-weight: 700; cursor: pointer; }
        .btn-delete { background: #fee2e2; color: #991b1b; border: none; padding: 8px 15px; border-radius: 8px; font-weight: 700; cursor: pointer; }

        /* MODALS & ALERTS */
        .edit-alert-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 100000;
            backdrop-filter: blur(4px);
        }

        .edit-alert-overlay.show { display: flex; }

        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(8px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
            padding: 20px;
        }

        .modal-overlay.show {
            display: flex;
        }

        .modal-close {
            position: absolute;
            top: 25px;
            right: 25px;
            width: 40px;
            height: 40px;
            background: #f1f5f9;
            border: none;
            border-radius: 12px;
            font-size: 20px;
            color: #64748b;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.2s;
        }

        .modal-close:hover {
            background: #fee2e2;
            color: #ef4444;
        }

        .btn-modal-save {
            background: linear-gradient(135deg, #065f46 0%, #059669 100%);
            color: #ffffff;
            border: none;
            padding: 12px 30px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 8px 20px rgba(6, 95, 70, 0.25);
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-modal-save:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(6, 95, 70, 0.35);
        }

        .table-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 25px;
            padding-top: 25px;
            border-top: 1.5px solid #f1f5f9;
        }

        /* PAGINATION */
        .pagination {
            display: flex;
            list-style: none;
            gap: 6px;
            padding: 0;
            margin: 0;
            align-items: center;
        }

        .pagination li {
            display: inline-block;
        }

        .pagination li a,
        .pagination li span {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            padding: 0 10px;
            border-radius: 10px;
            background: #ffffff;
            color: #64748b;
            text-decoration: none;
            font-weight: 800;
            font-size: 13px;
            border: 1.5px solid #e2e8f0;
            transition: all 0.2s;
        }

        .pagination li.active span {
            background: #065f46;
            color: #ffffff;
            border-color: #065f46;
            box-shadow: 0 4px 12px rgba(6, 95, 70, 0.2);
        }

        .pagination li a:hover {
            background: #f1f5f9;
            border-color: #cbd5e1;
            color: #1e293b;
            transform: translateY(-1px);
        }

        .pagination li.disabled span {
            background: #f8fafc;
            color: #cbd5e1;
            border-color: #f1f5f9;
            cursor: not-allowed;
        }

        .edit-alert-box {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px;
            width: 400px;
            text-align: center;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            animation: zoomIn 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes zoomIn {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .edit-alert-icon {
            width: 70px;
            height: 70px;
            background: #fee2e2;
            color: #ef4444;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            margin: 0 auto 20px;
        }

        .edit-alert-text {
            font-size: 18px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 30px;
        }

        .edit-alert-actions {
            display: flex;
            gap: 15px;
            justify-content: center;
        }

        .edit-alert-yes { background: #10b981; color: white; border: none; padding: 12px 30px; border-radius: 12px; font-weight: 800; cursor: pointer; }
        .edit-alert-no { background: #f1f5f9; color: #64748b; border: none; padding: 12px 30px; border-radius: 12px; font-weight: 800; cursor: pointer; }

        /* NOTIF PANEL */
        .notif-panel {
            position: fixed;
            top: 105px;
            right: 50px;
            width: 380px;
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.15);
            overflow: hidden;
            display: none;
            z-index: 100000;
            border: 1px solid #f1f5f9;
        }

        .notif-panel.show {
            display: block;
            animation: slideDownPanel 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideDownPanel {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .notif-header {
            padding: 22px 25px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .notif-header h3 { font-size: 18px; font-weight: 900; color: #111827; }

        .notif-close {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            cursor: pointer;
        }

        .notif-body { max-height: 450px; overflow-y: auto; }

        .notif-item {
            display: flex;
            gap: 15px;
            padding: 20px 25px;
            border-bottom: 1px solid #f8fafc;
            transition: background 0.2s;
        }

        .notif-icon-circle {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            background: #ecfdf5;
            color: #10b981;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .notif-content h5 { font-size: 14px; font-weight: 800; color: #111827; margin-bottom: 4px; }
        .notif-content p { font-size: 13px; color: #64748b; line-height: 1.5; margin-bottom: 6px; }
        .notif-content small { font-size: 11px; font-weight: 700; color: #94a3b8; }

        @media (max-width: 1024px) {
            .main-content { padding: 40px 30px; }
        }

        @media (max-width: 900px) {
            .sidebar { display: none; }
            .main-content { margin-left: 0; width: 100%; }
        }
    </style>

    @stack('styles')
</head>
<body>

<div class="wrapper">
    <aside class="sidebar">
        <div class="sidebar-top">
            <div class="sidebar-logo">
                <img src="{{ asset('assets/logo-puskesmas.png') }}" alt="Logo">
                <h3>
                    PUSKESMAS BENCULUK<br>
                    <span style="font-size: 12px; opacity: 0.7;">KAB. BANYUWANGI</span>
                </h3>
            </div>

            <ul class="menu">
                <li>
                    <a href="{{ url('/dashboard') }}" class="menu-link {{ request()->is('dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-house-chimney"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li class="has-submenu {{ request()->is('manajemen-pasien/*') ? 'open' : '' }}" id="menuManajemenPasien">
                    <button type="button" class="menu-link {{ request()->is('manajemen-pasien/*') ? 'active' : '' }}" id="toggleManajemenPasien">
                        <i class="fa-solid fa-users-gear"></i>
                        <span>Manajemen Pasien</span>
                        <i class="fa-solid fa-chevron-right arrow-icon"></i>
                    </button>
                    <div class="submenu">
                        <a href="{{ url('/manajemen-pasien/registrasi-pasien') }}" class="{{ request()->is('manajemen-pasien/registrasi-pasien') ? 'active-sub' : '' }}">
                             Registrasi Pasien
                        </a>
                        <a href="{{ url('/manajemen-pasien/data-pasien') }}" class="{{ request()->is('manajemen-pasien/data-pasien') ? 'active-sub' : '' }}">
                             Data Pasien
                        </a>
                    </div>
                </li>

                <li class="has-submenu {{ request()->is('kartu-kendali/*') ? 'open' : '' }}" id="menuKartuKendali">
                    <button type="button" class="menu-link {{ request()->is('kartu-kendali/*') ? 'active' : '' }}" id="toggleKartuKendali">
                        <i class="fa-solid fa-book-medical"></i>
                        <span>Kartu Kendali</span>
                        <i class="fa-solid fa-chevron-right arrow-icon"></i>
                    </button>
                    <div class="submenu">
                        <a href="{{ url('/kartu-kendali/kartu-kendali') }}" class="{{ request()->is('kartu-kendali/kartu-kendali') ? 'active-sub' : '' }}">
                             Kartu Kendali
                        </a>
                        <a href="{{ url('/kartu-kendali/kepatuhan-pasien') }}" class="{{ request()->is('kartu-kendali/kepatuhan-pasien') ? 'active-sub' : '' }}">
                             Kepatuhan Pasien
                        </a>
                    </div>
                </li>

                <li class="has-submenu {{ request()->is('laporan-evaluasi/*') ? 'open' : '' }}" id="menuLaporanEvaluasi">
                    <button type="button" class="menu-link {{ request()->is('laporan-evaluasi/*') ? 'active' : '' }}" id="toggleLaporanEvaluasi">
                        <i class="fa-solid fa-notes-medical"></i>
                        <span>Laporan Evaluasi</span>
                        <i class="fa-solid fa-chevron-right arrow-icon"></i>
                    </button>
                    <div class="submenu">
                        <a href="{{ url('/laporan-evaluasi/laporan-evaluasi') }}" class="{{ request()->is('laporan-evaluasi/laporan-evaluasi') ? 'active-sub' : '' }}">
                             Laporan Evaluasi
                        </a>
                        <a href="{{ url('/laporan-evaluasi/data-viral-load') }}" class="{{ request()->is('laporan-evaluasi/data-viral-load') ? 'active-sub' : '' }}">
                             Data Viral Load
                        </a>
                    </div>
                </li>

                <li>
                    <a href="{{ url('/data-laporan') }}" class="menu-link {{ request()->is('data-laporan') ? 'active' : '' }}">
                        <i class="fa-solid fa-chart-line"></i>
                        <span>Statistik Laporan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ url('/profile') }}" class="menu-link {{ request()->is('profile') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-gear"></i>
                        <span>Profile Petugas</span>
                    </a>
                </li>
            </ul>
        </div>

        <a href="{{ url('/logout') }}" class="logout-btn">
            <i class="fa-solid fa-power-off"></i>
            <span>Keluar Sistem</span>
        </a>
    </aside>

    <main class="main-content">
        <div class="topbar">
            <h1 class="page-title">@yield('title')</h1>

            <div class="user-area">
                <button type="button" class="petugas-bell" id="petugasBellButton">
                    <i class="fa-regular fa-bell"></i>
                    <span class="petugas-bell-dot"></span>
                </button>

                <div class="petugas-user">
                    <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : 'https://i.pravatar.cc/150?img=12' }}" alt="User">
                    <div>
                        <h4>{{ Auth::user()->name }}</h4>
                        <span>{{ ucfirst(Auth::user()->role) }}</span>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')
    </main>
</div>

{{-- MODALS & TOASTS (preserved logic) --}}
<div class="edit-alert-overlay" id="editAlert">
    <div class="edit-alert-box">
        <div class="edit-alert-icon">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div class="edit-alert-text">
            Perubahan akan disimpan.<br>Lanjutkan edit data ini?
        </div>
        <div class="edit-alert-actions">
            <button type="button" class="edit-alert-no" id="editAlertNo">Batal</button>
            <button type="button" class="edit-alert-yes" id="editAlertYes">Ya, Simpan</button>
        </div>
    </div>
</div>

<div class="notif-panel" id="petugasNotifPanel">
    <div class="notif-header">
        <h3>Notifikasi Baru</h3>
        <button type="button" class="notif-close" id="petugasNotifClose">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="notif-body">
        @forelse($global_notifications ?? [] as $notif)
            <div class="notif-item">
                <div class="notif-icon-circle">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div class="notif-content">
                    <h5>{{ $notif->title }}</h5>
                    <p>{{ $notif->message }}</p>
                    <small>{{ $notif->created_at->diffForHumans() }}</small>
                </div>
            </div>
        @empty
            <div style="padding: 40px 20px; text-align: center; color: #94a3b8;">
                <p>Belum ada notifikasi baru</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sidebar Submenu Logic
        const toggles = [
            { id: 'toggleManajemenPasien', menu: 'menuManajemenPasien' },
            { id: 'toggleKartuKendali', menu: 'menuKartuKendali' },
            { id: 'toggleLaporanEvaluasi', menu: 'menuLaporanEvaluasi' }
        ];

        toggles.forEach(item => {
            const btn = document.getElementById(item.id);
            const menu = document.getElementById(item.menu);
            if (btn && menu) {
                btn.addEventListener('click', (e) => {
                    e.preventDefault();
                    menu.classList.toggle('open');
                });
            }
        });

        // Notifications Logic
        const bell = document.getElementById('petugasBellButton');
        const panel = document.getElementById('petugasNotifPanel');
        const close = document.getElementById('petugasNotifClose');

        if (bell && panel) {
            bell.addEventListener('click', (e) => {
                e.stopPropagation();
                panel.classList.toggle('show');
            });
            close.addEventListener('click', () => panel.classList.remove('show'));
            document.addEventListener('click', (e) => {
                if (!panel.contains(e.target) && !bell.contains(e.target)) {
                    panel.classList.remove('show');
                }
            });
        }

        // Edit Alert Logic
        const editAlert = document.getElementById('editAlert');
        const alertYes = document.getElementById('editAlertYes');
        const alertNo = document.getElementById('editAlertNo');

        document.addEventListener('click', (e) => {
            if (e.target.closest('.btn-confirm-edit')) {
                e.preventDefault();
                editAlert.classList.add('show');
            }
        });

        if (alertNo) alertNo.addEventListener('click', () => editAlert.classList.remove('show'));
        if (alertYes) alertYes.addEventListener('click', () => editAlert.classList.remove('show'));

        // Translasi Validasi Form HTML5 Native
        const requiredInputs = document.querySelectorAll('input[required], select[required], textarea[required]');
        requiredInputs.forEach(input => {
            input.addEventListener('invalid', function() {
                if (!this.value) {
                    this.setCustomValidity('Isian ini wajib diisi.');
                }
            });
            input.addEventListener('input', function() {
                this.setCustomValidity('');
            });
            input.addEventListener('change', function() {
                this.setCustomValidity('');
            });
        });
    });
</script>

@stack('scripts')
    <script>
        // PWA & Push Notification Logic
        if ('serviceWorker' in navigator && 'PushManager' in window) {
            window.addEventListener('load', function() {
                navigator.serviceWorker.register('/sw.js').then(function(registration) {
                    console.log('ServiceWorker registration successful with scope: ', registration.scope);
                    initializePush(registration);
                }, function(err) {
                    console.log('ServiceWorker registration failed: ', err);
                });
            });
        }

        function initializePush(registration) {
            registration.pushManager.getSubscription()
            .then(function(subscription) {
                if (subscription) {
                    // Update server with existing subscription
                    sendSubscriptionToServer(subscription);
                } else {
                    // Ask user for permission and subscribe
                    subscribeUser(registration);
                }
            });
        }

        function subscribeUser(registration) {
            const applicationServerKey = urlB64ToUint8Array('{{ config('webpush.vapid.public_key') }}');
            registration.pushManager.subscribe({
                userVisibleOnly: true,
                applicationServerKey: applicationServerKey
            })
            .then(function(subscription) {
                console.log('User is subscribed:', subscription);
                sendSubscriptionToServer(subscription);
            })
            .catch(function(err) {
                console.log('Failed to subscribe the user: ', err);
            });
        }

        function sendSubscriptionToServer(subscription) {
            const key = subscription.getKey('p256dh');
            const token = subscription.getKey('auth');
            const contentEncoding = (PushManager.supportedContentEncodings || ['aesgcm'])[0];

            fetch('/push-subscriptions', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },
                body: JSON.stringify({
                    endpoint: subscription.endpoint,
                    keys: {
                        p256dh: key ? btoa(String.fromCharCode.apply(null, new Uint8Array(key))) : null,
                        auth: token ? btoa(String.fromCharCode.apply(null, new Uint8Array(token))) : null
                    },
                    content_encoding: contentEncoding
                })
            })
            .then(res => res.json())
            .then(data => console.log('Subscription saved on server:', data))
            .catch(err => console.error('Error saving subscription:', err));
        }

        function urlB64ToUint8Array(base64String) {
            const padding = '='.repeat((4 - base64String.length % 4) % 4);
            const base64 = (base64String + padding)
                .replace(/\-/g, '+')
                .replace(/_/g, '/');

            const rawData = window.atob(base64);
            const outputArray = new Uint8Array(rawData.length);

            for (let i = 0; i < rawData.length; ++i) {
                outputArray[i] = rawData.charCodeAt(i);
            }
            return outputArray;
        }
    </script>
    <script>
        // Global SweetAlert Handler
        @if(session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                confirmButtonColor: '#10b981',
                borderRadius: '20px'
            });
        @endif

        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Terjadi Kesalahan!',
                text: "{{ session('error') }}",
                confirmButtonColor: '#ef4444'
            });
        @endif
    </script>
</body>
</html>