<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPasien extends Model
{
    protected $table = 'data_pasien';
    protected $primaryKey = 'id_data_pasien';

    protected $fillable = [
        'id_petugas',
        'akses_dibuat_pada',
    ];

    protected $casts = [
        'akses_dibuat_pada' => 'datetime',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }
}