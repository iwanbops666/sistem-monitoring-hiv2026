<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistrasiPasien extends Model
{
    protected $table = 'registrasi_pasien';
    protected $primaryKey = 'id_registrasi';

    protected $fillable = [
        'id_petugas',
    ];

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'id_petugas', 'id_petugas');
    }
}