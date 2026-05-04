<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';
    protected $primaryKey = 'id_petugas';

    protected $fillable = [
        'id_user',
        'nama_petugas',
        'jabatan',
        'no_telpon',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kartuKendali()
    {
        return $this->hasMany(KartuKendali::class, 'id_petugas', 'id_petugas');
    }

    public function laporanEvaluasi()
    {
        return $this->hasMany(LaporanEvaluasi::class, 'id_petugas', 'id_petugas');
    }

    public function registrasiPasien()
    {
        return $this->hasMany(RegistrasiPasien::class, 'id_petugas', 'id_petugas');
    }

    public function dataPengobatan()
    {
        return $this->hasMany(DataPengobatan::class, 'id_petugas', 'id_petugas');
    }

    public function dataPasien()
    {
        return $this->hasMany(DataPasien::class, 'id_petugas', 'id_petugas');
    }

    public function kepatuhanPengobatan()
    {
        return $this->hasMany(KepatuhanPengobatan::class, 'id_petugas', 'id_petugas');
    }

    public function laporan()
    {
        return $this->hasMany(Laporan::class, 'id_petugas', 'id_petugas');
    }
}