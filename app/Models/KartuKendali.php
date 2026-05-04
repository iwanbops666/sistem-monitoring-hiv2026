<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKendali extends Model
{
    protected $table = 'kartu_kendali';
    protected $primaryKey = 'id_kartu_kendali';

    protected $fillable = [
        'id_pasien',
        'id_petugas',
        'tanggal_kunjungan',
        'rencana_tanggal_kunjungan_selanjutnya',
        'rejimen_dan_jumlah_obat_arv_yang_tersisa',
        'jumlah_inh_yang_tersisa',
        'jumlah_inh_yang_diberikan_untuk_bulan_berikutnya',
        'efek_samping_dan_lab_profilaksis',
        'catatan',
    ];

    protected $casts = [
        'tanggal_kunjungan' => 'date',
        'rencana_tanggal_kunjungan_selanjutnya' => 'date',
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