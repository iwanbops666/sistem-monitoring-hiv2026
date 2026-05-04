<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanEvaluasi extends Model
{
    protected $table = 'laporan_evaluasi';
    protected $primaryKey = 'id_laporan_evaluasi';

    protected $fillable = [
        'id_pasien',
        'id_petugas',
        'tanggal',
        'standar_lain',
        'status_fungsional',
        'jumlah_cd4',
        'catatan',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function pasien()
    {
        return $this->belongsTo(Pasien::class, 'id_pasien', 'id_pasien');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }
}