<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Keluarga Pasien')</title>

    <link rel="manifest" href="/manifest.json">

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

        .keluarga-logout:hover {
            background: #ef4444;
            border-color: #ef4444;
            box-shadow: 0 8px 15px rgba(239, 68, 68, 0.3);
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

        @media (max-width: 1024px) {
            .keluarga-main { padding: 40px 30px; }
        }

        @media (max-width: 900px) {
            .keluarga-sidebar { display: none; }
            .keluarga-main { margin-left: 0; width: 100%; }
        }
    </style>
</head>
<body>

<div class="keluarga-wrapper">
    <aside class="keluarga-sidebar">
        <div class="sidebar-top">
            <div class="keluarga-logo">
                <img src="{{ asset('assets/logo-puskesmas.png') }}" alt="Logo">
                <h3>
                    PUSKESMAS BENCULUK<br>
                    <span style="font-size: 12px; opacity: 0.7;">KAB. BANYUWANGI</span>
                </h3>
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
        const panel = document.getElementById('keluargaNotifPanel');
        const close = document.getElementById('keluargaNotifClose');

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