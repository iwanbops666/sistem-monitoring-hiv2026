<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Laporan extends Model
{
    protected $table = 'laporan';
    protected $primaryKey = 'id_laporan';

    protected $fillable = [
        'id_petugas',
        'jenis_laporan',
        'periode',
        'dari_tanggal',
        'sampai_tanggal',
    ];

    protected $casts = [
        'dari_tanggal' => 'date',
        'sampai_tanggal' => 'date',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }
}