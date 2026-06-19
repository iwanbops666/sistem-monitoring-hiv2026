<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Petugas extends Model
{
    protected $table = 'petugas';
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'nip',
        'nama',
        'tanggal_lahir',
        'jenis_kelamin',
        'no_hp',
        'alamat',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function pasiens()
    {
        return $this->hasMany(Pasien::class, 'petugas_id', 'user_id');
    }
}