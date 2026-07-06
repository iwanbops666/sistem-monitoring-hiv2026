<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Keluarga extends Model
{
    protected $table = 'keluarga';
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'pasien_id',
        'nama',
        'status_hubungan',
        'no_hp',
        'alamat',
        'rt',
        'rw',
        'kabupaten',
        'kecamatan',
        'kelurahan',
        'provinsi',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'pasien_id', 'user_id');
    }
}