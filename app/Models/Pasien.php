<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';
    protected $primaryKey = 'id_pasien';

    protected $fillable = [
        'id_user',
        'nama',
        'nomor_rm',
        'nik',
        'tempat_lahir',
        'tanggal_lahir',
        'jenis_kelamin',
        'agama',
        'status_perkawinan',
        'alamat_lengkap',
        'rt',
        'rw',
        'kec',
        'kab',
        'prov',
        'kode_pos',
        'alamat_keluarga',
        'rt_keluarga',
        'rw_keluarga',
        'kec_keluarga',
        'kab_keluarga',
        'prov_keluarga',
        'no_hp',
        'no_hp_keluarga',
        'pekerjaan',
        'no_registrasi_nasional',
        'tanggal_mulai_pengobatan',
        'lokasi_diagnosa',
        'email',
        'password',
        'status_pasien',
    ];

    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_mulai_pengobatan' => 'date',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function keluarga()
    {
        return $this->hasMany(Keluarga::class, 'id_pasien', 'id_pasien');
    }

    public function kartuKendali()
    {
        return $this->hasMany(KartuKendali::class, 'id_pasien', 'id_pasien');
    }

    public function laporanEvaluasi()
    {
        return $this->hasMany(LaporanEvaluasi::class, 'id_pasien', 'id_pasien');
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class, 'id_pasien', 'id_pasien');
    }
}