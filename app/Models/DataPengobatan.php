<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DataPengobatan extends Model
{
    protected $table = 'data_pengobatan';
    protected $primaryKey = 'id_pengobatan';

    protected $fillable = [
        'id_petugas',
        'tanggal',
        'status_viral_load',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }
}