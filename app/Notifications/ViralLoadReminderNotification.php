<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class ViralLoadReminderNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Jadwal Tes Viral Load')
            ->icon('/icons/icon-192x192.png')
            ->body('Halo, saatnya melakukan tes Viral Load rutin Anda. Silakan hubungi petugas puskesmas untuk informasi lebih lanjut.')
            ->action('Buka Aplikasi', 'view_app')
            ->data(['url' => '/']);
    }
}
