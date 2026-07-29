<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Keluarga Pasien')</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/logo-puskesmas.png') }}">
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

        .keluarga-wrapper {
            min-height: 100vh;
            display: flex;
        }

        /* SIDEBAR KELUARGA */
        .keluarga-sidebar {
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

        .keluarga-logo {
            text-align: center;
            margin-bottom: 50px;
        }

        .keluarga-logo img {
            width: 90px;
            height: 90px;
            object-fit: contain;
            margin-bottom: 18px;
            filter: drop-shadow(0 4px 8px rgba(0,0,0,0.2));
        }

        .keluarga-logo h3 {
            color: #ffffff;
            font-size: 15px;
            line-height: 1.4;
            font-weight: 800;
            letter-spacing: 0.5px;
            opacity: 0.95;
        }

        .keluarga-menu {
            list-style: none;
            margin-top: 10px;
        }

        .keluarga-menu li {
            margin-bottom: 12px;
        }

        .keluarga-menu a {
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
        }

        .keluarga-menu a i {
            font-size: 18px;
            transition: transform 0.3s ease;
        }

        .keluarga-menu a:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
        }

        .keluarga-menu a:hover i {
            transform: scale(1.1);
        }

        .keluarga-menu a.active {
            background: #ffffff;
            color: #065f46;
            font-weight: 800;
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .keluarga-logout {
            width: 100%;
            background: #dc2626;
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
            border: 1px solid #b91c1c;
        }

        .keluarga-logout:hover {
            background: #b91c1c;
            border-color: #991b1b;
            box-shadow: 0 8px 15px rgba(220, 38, 38, 0.2);
        }

        /* CONTENT */
        .keluarga-main {
            margin-left: 280px;
            width: calc(100% - 280px);
            min-height: 100vh;
            padding: 45px 50px;
        }

        .keluarga-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 45px;
        }

        .keluarga-page-title {
            font-size: 32px;
            font-weight: 900;
            color: #111827;
            letter-spacing: -0.5px;
        }

        .keluarga-user-area {
            display: flex;
            align-items: center;
            gap: 25px;
        }

        .keluarga-bell {
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

        .keluarga-bell:hover {
            border-color: #10b981;
            color: #10b981;
            background: #f0fdf4;
            transform: translateY(-2px);
        }

        .keluarga-bell-dot {
            position: absolute;
            top: 13px;
            right: 13px;
            width: 10px;
            height: 10px;
            background: #ef4444;
            border: 2.5px solid #ffffff;
            border-radius: 50%;
            display: {{ ($global_notifications ?? collect())->count() > 0 ? 'block' : 'none' }};
        }

        .keluarga-user {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 6px 18px 6px 6px;
            background: #ffffff;
            border-radius: 18px;
            border: 1.5px solid #e5e7eb;
        }

        .keluarga-user img {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            object-fit: cover;
        }

        .keluarga-user h4 {
            font-size: 14px;
            font-weight: 800;
            color: #111827;
        }

        .keluarga-user span {
            font-size: 12px;
            font-weight: 600;
            color: #94a3b8;
        }

        /* NOTIFICATION PANEL */
        .keluarga-notif-panel {
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

        .keluarga-notif-panel.show {
            display: block;
            animation: slideDown 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes slideDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .keluarga-notif-header {
            padding: 22px 25px;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .keluarga-notif-header h3 {
            font-size: 18px;
            font-weight: 900;
            color: #111827;
        }

        .keluarga-notif-close {
            width: 32px;
            height: 32px;
            border-radius: 10px;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            cursor: pointer;
            transition: all 0.2s;
        }

        .keluarga-notif-close:hover { background: #fee2e2; color: #ef4444; }

        .keluarga-notif-body {
            max-height: 450px;
            overflow-y: auto;
        }

        .keluarga-notif-item {
            display: flex;
            gap: 15px;
            padding: 20px 25px;
            border-bottom: 1px solid #f8fafc;
            transition: background 0.2s;
            cursor: pointer;
        }

        .keluarga-notif-item:hover { background: #f8fafc; }

        .keluarga-notif-icon {
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

        .keluarga-notif-content h5 {
            font-size: 14px;
            font-weight: 800;
            color: #111827;
            margin-bottom: 4px;
        }

        .keluarga-notif-content p {
            font-size: 13px;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 6px;
        }

        .keluarga-notif-content small {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
        }

        /* RESPONSIVE STYLING */
        @media (max-width: 1024px) {
            .keluarga-main { padding: 40px 30px; }
        }

        @media (max-width: 900px) {
            .keluarga-sidebar {
                display: none;
            }
            
            .mobile-header {
                display: flex !important;
            }
            
            .mobile-bottom-nav {
                display: flex !important;
            }
            
            .keluarga-main {
                margin-left: 0;
                width: 100%;
                padding: 95px 16px 100px 16px !important; /* Spacing for fixed header and bottom nav */
            }
            
            .keluarga-topbar {
                display: none !important; /* Hide desktop topbar */
            }

            .keluarga-notif-panel {
                top: 80px;
                right: 16px;
                left: 16px;
                width: calc(100% - 32px);
                max-height: calc(100vh - 180px);
                z-index: 10001;
            }

            /* Responsive tables to card-like list on mobile */
            .modern-table, .modern-table thead, .modern-table tbody, .modern-table th, .modern-table td, .modern-table tr,
            table, table thead, table tbody, table th, table td, table tr {
                display: block;
                width: 100%;
            }
            
            .modern-table thead, table thead {
                display: none;
            }
            
            .modern-table tr, table tr {
                background: #ffffff;
                border-radius: 18px;
                margin-bottom: 16px;
                padding: 20px;
                border: 1px solid #e2e8f0;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.02);
            }
            
            .modern-table tr td, table tr td {
                background: transparent !important;
                padding: 10px 0 !important;
                display: flex;
                justify-content: space-between;
                align-items: center;
                border-radius: 0 !important;
                border-bottom: 1px dashed #f1f5f9;
                text-align: left !important;
            }
            
            .modern-table tr td:last-child, table tr td:last-child {
                border-bottom: none;
            }
            
            .modern-table tr td:first-child, table tr td:first-child {
                font-weight: 800;
                font-size: 16px;
                color: #065f46;
                border-bottom: 1.5px solid #f1f5f9;
                padding-bottom: 12px !important;
                margin-bottom: 8px;
                display: block;
            }
            
            .modern-table tr td[data-label]::before, table tr td[data-label]::before {
                content: attr(data-label);
                font-weight: 700;
                color: #94a3b8;
                font-size: 11px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
        }

        /* MOBILE BAR DESIGNS */
        .mobile-header {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            height: 75px;
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-bottom: 1px solid rgba(229, 231, 235, 0.6);
            padding: 0 20px;
            align-items: center;
            justify-content: space-between;
            z-index: 1000;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
        }

        .mobile-logo-container {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .mobile-logo-container img {
            height: 42px;
            width: 42px;
            object-fit: contain;
        }

        .mobile-logo-text h3 {
            font-size: 13px;
            font-weight: 850;
            color: #065f46;
            line-height: 1.3;
        }

        .mobile-logo-text span {
            font-size: 10px;
            color: #10b981;
            font-weight: 700;
            letter-spacing: 0.5px;
        }

        .mobile-action-btns {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .mobile-action-btn {
            width: 44px;
            height: 44px;
            border-radius: 14px;
            background: #f8fafc;
            border: 1.5px solid #e2e8f0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #475569;
            font-size: 18px;
            position: relative;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .mobile-action-btn:active {
            transform: scale(0.92);
            background: #f1f5f9;
        }

        /* Mobile Bottom Nav */
        .mobile-bottom-nav {
            display: none;
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
            height: 70px;
            background: rgba(255, 255, 255, 0.92);
            backdrop-filter: blur(15px);
            -webkit-backdrop-filter: blur(15px);
            border-top: 1px solid rgba(229, 231, 235, 0.6);
            box-shadow: 0 -8px 30px rgba(0, 0, 0, 0.05);
            z-index: 1000;
            justify-content: space-around;
            align-items: center;
            padding-bottom: env(safe-area-inset-bottom);
        }

        .mobile-nav-item {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            flex: 1;
            height: 100%;
            text-decoration: none;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
            gap: 5px;
            transition: all 0.25s;
        }

        .mobile-nav-item i {
            font-size: 19px;
            transition: transform 0.25s, color 0.25s;
        }

        .mobile-nav-item.active {
            color: #065f46;
        }

        .mobile-nav-item.active i {
            transform: scale(1.15) translateY(-2px);
            color: #10b981;
        }
    </style>
</head>
<body>

<div class="keluarga-wrapper">
    <!-- MOBILE HEADER -->
    <header class="mobile-header">
        <a href="{{ url('/') }}" class="mobile-logo-container" style="text-decoration: none; color: inherit;">
            <img src="{{ asset('assets/logo-puskesmas.png') }}" alt="Logo">
            <div class="mobile-logo-text">
                <h3>PUSKESMAS BENCULUK</h3>
                <span>MONITORING HIV - KELUARGA</span>
            </div>
        </a>
        <div class="mobile-action-btns">
            <button type="button" class="mobile-action-btn" id="keluargaBellMobileButton">
                <i class="fa-regular fa-bell"></i>
                <span class="keluarga-bell-dot" style="display: {{ ($global_notifications ?? collect())->count() > 0 ? 'block' : 'none' }}; top: 12px; right: 12px; width: 8px; height: 8px; border-width: 1.5px;"></span>
            </button>
            <a href="{{ url('/logout') }}" class="mobile-action-btn" style="background: #dc2626; color: #ffffff; border-color: #b91c1c;" title="Keluar">
                <i class="fa-solid fa-power-off"></i>
            </a>
        </div>
    </header>

    <aside class="keluarga-sidebar">
        <div class="sidebar-top">
            <div class="keluarga-logo">
                <a href="{{ url('/') }}" style="text-decoration: none; color: inherit; display: block;">
                    <img src="{{ asset('assets/logo-puskesmas.png') }}" alt="Logo">
                    <h3>
                        PUSKESMAS BENCULUK<br>
                        <span style="font-size: 12px; opacity: 0.7;">KAB. BANYUWANGI</span>
                    </h3>
                </a>
            </div>

            <ul class="keluarga-menu">
                <li>
                    <a href="{{ url('/keluarga/dashboard') }}" class="{{ request()->is('keluarga/dashboard') ? 'active' : '' }}">
                        <i class="fa-solid fa-house-chimney"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="{{ url('/keluarga/profile') }}" class="{{ request()->is('keluarga/profile') ? 'active' : '' }}">
                        <i class="fa-solid fa-user-pen"></i>
                        <span>Profile Keluarga</span>
                    </a>
                </li>
            </ul>
        </div>

        <a href="{{ url('/logout') }}" class="keluarga-logout">
            <i class="fa-solid fa-power-off"></i>
            <span>Keluar Sistem</span>
        </a>
    </aside>

    <main class="keluarga-main">
        <div class="keluarga-topbar">
            <h1 class="keluarga-page-title">@yield('page-title', 'Overview')</h1>

            <div class="keluarga-user-area">
                <button type="button" class="keluarga-bell" id="keluargaBellButton">
                    <i class="fa-regular fa-bell"></i>
                    <span class="keluarga-bell-dot"></span>
                </button>

                <div class="keluarga-user">
                    <img src="https://i.pravatar.cc/150?img=12" alt="User">
                    <div>
                        <h4>{{ Auth::user()->name }}</h4>
                        <span>Keluarga Pasien</span>
                    </div>
                </div>
            </div>
        </div>

        @yield('content')
    </main>

    <!-- MOBILE BOTTOM NAVIGATION -->
    <nav class="mobile-bottom-nav">
        <a href="{{ url('/keluarga/dashboard') }}" class="mobile-nav-item {{ request()->is('keluarga/dashboard') ? 'active' : '' }}">
            <i class="fa-solid fa-house-chimney"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ url('/keluarga/profile') }}" class="mobile-nav-item {{ request()->is('keluarga/profile') ? 'active' : '' }}">
            <i class="fa-solid fa-user-pen"></i>
            <span>Profil</span>
        </a>
        <a href="{{ url('/logout') }}" class="mobile-nav-item" style="color: #dc2626;">
            <i class="fa-solid fa-power-off"></i>
            <span>Keluar</span>
        </a>
    </nav>
</div>

{{-- NOTIFICATION PANEL --}}
<div class="keluarga-notif-panel" id="keluargaNotifPanel">
    <div class="keluarga-notif-header">
        <h3>Notifikasi Baru</h3>
        <button type="button" class="keluarga-notif-close" id="keluargaNotifClose">
            <i class="fa-solid fa-xmark"></i>
        </button>
    </div>
    <div class="keluarga-notif-body">
        @forelse($global_notifications ?? [] as $notif)
            <div class="keluarga-notif-item">
                <div class="keluarga-notif-icon">
                    <i class="fa-solid fa-circle-info"></i>
                </div>
                <div class="keluarga-notif-content">
                    <h5>{{ $notif->title }}</h5>
                    <p>{{ $notif->message }}</p>
                    <small><i class="fa-regular fa-clock"></i> {{ $notif->created_at->diffForHumans() }}</small>
                </div>
            </div>
        @empty
            <div style="padding: 40px 20px; text-align: center; color: #94a3b8;">
                <i class="fa-regular fa-bell-slash" style="font-size: 30px; margin-bottom: 10px; display: block;"></i>
                <p style="font-size: 14px; font-weight: 600;">Belum ada notifikasi baru</p>
            </div>
        @endforelse
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const bell = document.getElementById('keluargaBellButton');
        const bellMobile = document.getElementById('keluargaBellMobileButton');
        const panel = document.getElementById('keluargaNotifPanel');
        const close = document.getElementById('keluargaNotifClose');

        if (panel) {
            const togglePanel = (e) => {
                e.stopPropagation();
                panel.classList.toggle('show');
            };

            if (bell) bell.addEventListener('click', togglePanel);
            if (bellMobile) bellMobile.addEventListener('click', togglePanel);

            close.addEventListener('click', () => panel.classList.remove('show'));

            document.addEventListener('click', (e) => {
                if (!panel.contains(e.target) && 
                    (!bell || !bell.contains(e.target)) && 
                    (!bellMobile || !bellMobile.contains(e.target))) {
                    panel.classList.remove('show');
                }
            });
        }

        // Logout Confirmation
        const logoutLinks = document.querySelectorAll('a[href*="logout"], .keluarga-logout');
        logoutLinks.forEach(link => {
            link.addEventListener('click', function (e) {
                e.preventDefault();
                const targetUrl = this.getAttribute('href');
                Swal.fire({
                    title: 'Keluar dari Sistem?',
                    text: 'Apakah Anda yakin ingin keluar dari sistem monitoring HIV?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#ef4444',
                    confirmButtonText: 'Ya, Keluar!',
                    cancelButtonText: 'Batal',
                    customClass: {
                        popup: 'logout-swal-popup'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = targetUrl;
                    }
                });
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
                    sendSubscriptionToServer(subscription);
                } else {
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
</body>
</html>