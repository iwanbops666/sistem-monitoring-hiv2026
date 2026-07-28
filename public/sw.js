self.addEventListener('install', function (event) {
    self.skipWaiting();
});

self.addEventListener('activate', function (event) {
    event.waitUntil(self.clients.claim());
});

self.addEventListener('push', function (event) {
    if (!event.data) {
        console.log('Push event but no data');
        return;
    }

    try {
        const msg = event.data.json();
        console.log('Push received:', msg);

        const title = msg.title || 'Notifikasi Baru';
        const options = {
            body: msg.body || 'Anda memiliki notifikasi baru.',
            icon: msg.icon || '/assets/logo-puskesmas.png',
            badge: msg.badge || '/assets/logo-puskesmas.png',
            data: {
                url: (msg.data && msg.data.url) || msg.action_url || '/'
            },
            requireInteraction: true // Keeps notification open until user interacts
        };

        event.waitUntil(
            self.registration.showNotification(title, options)
        );
    } catch (e) {
        console.error('Error parsing push data:', e);
        event.waitUntil(
            self.registration.showNotification('Notifikasi Baru', {
                body: event.data.text(),
                icon: '/assets/logo-puskesmas.png',
                data: { url: '/' }
            })
        );
    }
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    const targetUrl = event.notification.data.url || '/';
    const absoluteTargetUrl = new URL(targetUrl, self.location.origin).href;

    event.waitUntil(
        clients.matchAll({ type: 'window', includeUncontrolled: true })
            .then(function (clientList) {
                // Cari apakah ada tab yang sudah terbuka dengan origin yang sama
                for (let i = 0; i < clientList.length; i++) {
                    const client = clientList[i];
                    if (new URL(client.url).origin === self.location.origin) {
                        // Jika ketemu, navigasikan ke URL tujuan dan fokus ke tab tersebut
                        if ('navigate' in client) {
                            client.navigate(absoluteTargetUrl);
                        }
                        return client.focus();
                    }
                }
                
                // Jika tidak ada tab yang terbuka, buka tab baru
                if (clients.openWindow) {
                    return clients.openWindow(absoluteTargetUrl);
                }
            })
    );
});
