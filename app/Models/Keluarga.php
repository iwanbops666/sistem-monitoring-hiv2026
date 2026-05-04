<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    protected $table = 'keluarga';
    protected $primaryKey = 'id_keluarga';

    protected $fillable = [
        'id_user',
        'id_pasien',
        'hubungan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_keluarga', 'id_keluarga');
    }
}