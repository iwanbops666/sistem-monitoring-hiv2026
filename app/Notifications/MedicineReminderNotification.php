<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class MedicineReminderNotification extends Notification
{
    use Queueable;

    public function __construct()
    {
        //
    }

    public function via(object $notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage)
            ->title('Waktunya Minum Obat!')
            ->icon('/icons/icon-192x192.png')
            ->body('Halo, jangan lupa untuk meminum obat ARV Anda tepat waktu untuk menjaga kesehatan.')
            ->action('Lihat Jadwal', 'view_schedule')
            ->data(['url' => '/']);
    }
}
