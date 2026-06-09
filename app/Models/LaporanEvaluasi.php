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
        'kunjungan',
        'tanggal',
        'standar_klinis',
        'hasil_arv_terakhir',
        'status_viral_load',
        'status_fungsional',
        'jumlah_cd4',
        'berat_badan',
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