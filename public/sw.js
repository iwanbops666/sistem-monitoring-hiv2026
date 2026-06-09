self.addEventListener('push', function (event) {
    if (!(self.Notification && self.Notification.permission === 'granted')) {
        return;
    }

    if (event.data) {
        const msg = event.data.json();
        console.log('Push received:', msg);

        event.waitUntil(
            self.registration.showNotification(msg.title, {
                body: msg.body,
                icon: msg.icon || '/assets/logo-puskesmas.png',
                badge: '/assets/logo-puskesmas.png',
                data: {
                    url: (msg.data && msg.data.url) || msg.action_url || '/'
                }
            })
        );
    }
});

self.addEventListener('notificationclick', function (event) {
    event.notification.close();

    event.waitUntil(
        clients.openWindow(event.notification.data.url)
    );
});
