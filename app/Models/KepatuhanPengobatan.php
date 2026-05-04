<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KepatuhanPengobatan extends Model
{
    protected $table = 'kepatuhan_pengobatan';
    protected $primaryKey = 'id_kepatuhan';

    protected $fillable = [
        'id_petugas',
        'akses_dibuat_pada',
        'tanggal_kunjungan',
        'catatan',
    ];

    protected $casts = [
        'akses_dibuat_pada' => 'datetime',
        'tanggal_kunjungan' => 'date',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }
}