<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushMessage;
use NotificationChannels\WebPush\WebPushChannel;

class KontrolReminderNotification extends Notification
{
    use Queueable;

    public $tanggalKontrol;

    public function __construct($tanggalKontrol = null)
    {
        $this->tanggalKontrol = $tanggalKontrol;
    }

    public function via(object $notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        $body = 'Halo, ini pengingat rutin mingguan Anda. Jangan lupa untuk selalu memantau jadwal kontrol dan ketersediaan obat ARV Anda di Puskesmas ya!';
        if ($this->tanggalKontrol) {
            $body = 'Halo, jadwal kontrol (pengambilan obat ARV) Anda adalah pada tanggal ' . \Carbon\Carbon::parse($this->tanggalKontrol)->isoFormat('D MMMM YYYY') . '. Jangan lupa datang ke Puskesmas ya!';
        }

        return (new WebPushMessage)
            ->title('Pengingat Jadwal Kontrol')
            ->icon('/icons/icon-192x192.png')
            ->body($body)
            ->action('Lihat Detail', 'view_detail')
            ->data(['url' => '/pasien/kartu-kendali']);
    }
}
