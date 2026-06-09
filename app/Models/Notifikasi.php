<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\User;
use App\Models\Pasien;
use App\Notifications\PushNotification;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';

    protected $fillable = [
        'user_id',
        'title',
        'message',
        'type',
        'is_read',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mengirim notifikasi ke pasien dan juga keluarganya (jika ada)
     */
    public static function sendToPatientAndFamily($pasienUserId, $title, $message, $type = 'info')
    {
        // 1. Kirim ke Pasien
        self::create([
            'user_id' => $pasienUserId,
            'title' => $title,
            'message' => $message,
            'type' => $type,
        ]);

        // Trigger Push Notification untuk Pasien
        $pasienUser = User::find($pasienUserId);
        if ($pasienUser) {
            $pasienUser->notify(new PushNotification($title, $message, $type));
        }

        // 2. Kirim ke Keluarga (Cari siapa keluarga dari pasien ini)
        $pasien = Pasien::with('keluarga.user')->find($pasienUserId);
        if ($pasien && $pasien->keluarga && $pasien->keluarga->user_id) {
            $keluargaUserId = $pasien->keluarga->user_id;
            
            self::create([
                'user_id' => $keluargaUserId,
                'title' => $title . ' (Keluarga)',
                'message' => "Pesan untuk " . $pasien->nama . ": " . $message,
                'type' => $type,
            ]);

            // Trigger Push Notification untuk Keluarga
            if ($pasien->keluarga->user) {
                $pasien->keluarga->user->notify(new PushNotification(
                    $title . ' (Keluarga)',
                    "Pesan untuk " . $pasien->nama . ": " . $message,
                    $type
                ));
            }
        }
    }
}