<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pasien extends Model
{
    protected $table = 'pasien';
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $fillable = [
        'user_id',
        'petugas_id',
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
        'kabupaten',
        'kecamatan',
        'kode_pos',
        'provinsi',
        'no_hp',
        'no_registrasi_nasional',
        'status_pasien',
        'tanggal_awal_pengobatan',
        'lokasi_diagnosa',
        'keterangan_pasien',
        'tanggal_kunjungan_terakhir',
        'rencana_kunjungan_berikutnya',
        'status_kunjungan',
        'kelurahan',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function petugas()
    {
        return $this->belongsTo(Petugas::class, 'petugas_id', 'user_id');
    }

    public function keluarga()
    {
        return $this->hasOne(Keluarga::class, 'pasien_id', 'user_id');
    }

    public function kartuKendali()
    {
        return $this->hasMany(KartuKendali::class, 'id_pasien', 'user_id');
    }

    public function dataPengobatan()
    {
        return $this->hasMany(DataPengobatan::class, 'id_pasien', 'user_id');
    }

    public function laporanEvaluasi()
    {
        return $this->hasMany(LaporanEvaluasi::class, 'id_pasien', 'user_id');
    }

    public function getDisplayStatusAttribute()
    {
        if ($this->status_pasien === 'Meninggal') {
            return 'Meninggal';
        }

        $lastVisitDate = $this->tanggal_kunjungan_terakhir;

        // Thresholds (Revised Final v2):
        // 0-30 days: Active
        // 30-61 days: Inactive
        // >= 61 days: LTFU
        if (!$lastVisitDate) {
            $diffDays = $this->created_at->diffInDays(now());
            if ($diffDays >= 61) return 'LTFU';
            if ($diffDays >= 30) return 'Inactive';
            return 'Active';
        }

        $tglKunjungan = \Carbon\Carbon::parse($lastVisitDate);
        $diffDays = $tglKunjungan->diffInDays(now());

        if ($diffDays >= 61) return 'LTFU';
        if ($diffDays >= 30) return 'Inactive';
        
        return 'Active';
    }

    public function getKunjunganStatusAttribute()
    {
        $lastVisitDate = $this->tanggal_kunjungan_terakhir;
        $createdDate = $this->created_at;
        
        $diffDays = $lastVisitDate 
            ? \Carbon\Carbon::parse($lastVisitDate)->diffInDays(now())
            : $createdDate->diffInDays(now());

        if ($diffDays >= 61) return 'LTFU';
        if ($diffDays >= 7) return 'Late';
        return 'OnTime';
    }

    public function getViralLoadStatusAttribute()
    {
        $mulaiArt = $this->laporanEvaluasi()->where('kunjungan', 'Saat Mulai ART')->orderBy('tanggal', 'asc')->first();

        if (!$mulaiArt) {
            return 'Belum Mulai ART';
        }

        $start = \Carbon\Carbon::parse($mulaiArt->tanggal);
        $now = now();
        $diffMonths = $start->diffInMonths($now);

        // 1. Initial 6-month check
        $hasM6 = $this->dataPengobatan()
            ->where(function($query) use ($start) {
                $query->where('kategori_viral_load', 'Viraload 6 Bulan Awal')
                      ->orWhereBetween('tanggal', [
                          $start->copy()->addMonths(6)->subMonths(2),
                          $start->copy()->addMonths(6)->addMonths(2)
                      ]);
            })->exists();

        if ($diffMonths >= 6 && $diffMonths < 12 && !$hasM6) {
            return 'Perlu Cek VL (6 Bulan)';
        }

        // 2. 1-Year check (12 months)
        $hasM12 = $this->dataPengobatan()
            ->where(function($query) use ($start) {
                $query->where('kategori_viral_load', 'Viraload Tahunan Rutin')
                      ->orWhereBetween('tanggal', [
                          $start->copy()->addMonths(12)->subMonths(3),
                          $start->copy()->addMonths(12)->addMonths(3)
                      ]);
            })->exists();

        if ($diffMonths >= 12 && !$hasM12 && $diffMonths < 24) {
            return 'Perlu Cek VL (1 Tahun)';
        }

        // 3. Subsequent Annual checks (24, 36, 48...)
        $n = 2; // Start from 2 years (24 months)
        while (true) {
            $targetMonths = $n * 12;
            
            if ($diffMonths < $targetMonths) {
                break;
            }

            $hasCheck = $this->dataPengobatan()
                ->where('kategori_viral_load', 'Viraload Tahunan Rutin')
                ->whereBetween('tanggal', [
                    $start->copy()->addMonths($targetMonths)->subMonths(3), 
                    $start->copy()->addMonths($targetMonths)->addMonths(3)
                ])->exists();

            if (!$hasCheck) {
                return 'Perlu Cek VL (Tahunan Ke-' . $n . ')';
            }
            $n++;
            if ($n > 50) break; // Safety
        }

        if ($diffMonths < 6) return 'Belum Waktunya (6 Bln)';
        
        return 'Sudah Dilakukan';
    }

    public function getNextViralLoadDateAttribute()
    {
        $mulaiArt = $this->laporanEvaluasi()->where('kunjungan', 'Saat Mulai ART')->orderBy('tanggal', 'asc')->first();

        if (!$mulaiArt) {
            return null;
        }

        $start = \Carbon\Carbon::parse($mulaiArt->tanggal);
        $now = now();
        $diffMonths = $start->diffInMonths($now);

        // If not reached 6 months yet
        if ($diffMonths < 6) {
            return $start->copy()->addMonths(6);
        }

        // If between 6 and 12 months
        if ($diffMonths < 12) {
            return $start->copy()->addMonths(12);
        }

        // Subsequent 12-month intervals (24, 36, 48...)
        $n = 2;
        while (true) {
            $targetMonths = $n * 12;
            if ($diffMonths < $targetMonths) {
                return $start->copy()->addMonths($targetMonths);
            }
            $n++;
            if ($n > 50) break;
        }

        return null;
    }
}