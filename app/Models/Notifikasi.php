<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notifikasi extends Model
{
    protected $table = 'notifikasi';
    protected $primaryKey = 'id_notifikasi';

    protected $fillable = [
        'id_pasien',
        'id_keluarga',
        'jenis_notifikasi',
        'judul_notifikasi',
        'pesan_notifikasi',
        'tanggal_notifikasi',
        'waktu_notifikasi',
        'status_baca',
        'status_kirim',
    ];

    protected $casts = [
        'tanggal_notifikasi' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    public function keluarga()
    {
        return $this->belongsTo(Keluarga::class, 'id_keluarga', 'id_keluarga');
    }
}