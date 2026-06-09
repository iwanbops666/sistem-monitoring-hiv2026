<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use NotificationChannels\WebPush\HasPushSubscriptions;


class User extends Authenticatable
{
    use Notifiable, HasPushSubscriptions;


    protected $table = 'users';
    protected $fillable = [
        'name',
        'email',
        'phone_number',
        'password',
        'role',
        'foto_profil',
    ];

    protected $hidden = [
        'password',
    ];

    public function petugas()
    {
        return $this->hasOne(Petugas::class, 'user_id');
    }

    public function pasien()
    {
        return $this->hasOne(Pasien::class, 'user_id');
    }

    public function keluarga()
    {
        return $this->hasOne(Keluarga::class, 'user_id');
    }
}