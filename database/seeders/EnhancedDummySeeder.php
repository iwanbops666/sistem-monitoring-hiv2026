<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Petugas;
use App\Models\Keluarga;
use App\Models\KartuKendali;
use App\Models\LaporanEvaluasi;
use App\Models\DataPengobatan;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;
use Faker\Factory as Faker;

class EnhancedDummySeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        
        // 1. Ambil ID Petugas (Default 1 jika tidak ada)
        $petugas = Petugas::first();
        $petugasId = $petugas ? $petugas->user_id : 1;

        // 2. Bersihkan data dummy lama agar tidak menumpuk (optional tapi disarankan)
        // Kita gunakan prefix email 'dummy.' agar mudah dihapus
        User::where('email', 'like', 'dummy.%')->delete();

        // 3. Definisikan Skenario untuk Test Fitur
        $scenarios = [
            // [Jumlah, Status Pasien, Keterangan, Pengobatan Sejak (Bulan Lalu), Kunjungan Terakhir (Hari Lalu), Punya VL?]
            
            // --- KATEGORI: STATUS AKTIF / LTFU / INACTIVE ---
            [5, 'Hidup', 'Baru', 1, 5, true],    // Aktif & OnTime (Baru berobat 1 bln, kunjungan 5 hr lalu)
            [5, 'Hidup', 'Baru', 1, 10, true],   // Aktif tapi TELAT (>7 hari, di sini 10 hari)
            [5, 'Hidup', 'Lama', 12, 45, true],  // Inactive (Kunjungan 45 hari lalu - antara 30-61)
            [5, 'Hidup', 'Lama', 24, 70, true],  // LTFU (Kunjungan > 61 hari lalu)
            [3, 'Meninggal', 'Lama', 36, 100, false], // Pasien Meninggal

            // --- KATEGORI: VIRAL LOAD CHECKING ---
            [3, 'Hidup', 'Baru', 7, 10, false],  // Perlu Cek VL 6 Bulan (Sudah 7 bln berobat tapi belum ada data VL)
            [3, 'Hidup', 'Baru', 4, 5, false],   // Belum Waktunya VL 6 Bulan (Baru 4 bln)
            [2, 'Hidup', 'Lama', 20, 10, true],  // Perlu Cek VL Rutin Thn 1 (Sudah 20 bln, target 18 bln belum ada data VL di range tsb)
            
            // --- KATEGORI: KETERANGAN PASIEN ---
            [2, 'Hidup', 'Pindahan', 2, 10, false], // Pasien Pindahan
            [2, 'Hidup', 'Pindah Pengobatan', 5, 15, true], // Pindah Pengobatan
            
            // --- KATEGORI: DATA CAMPURAN ---
            [10, 'Hidup', 'Baru', rand(1, 48), rand(1, 90), rand(0, 1)], 
        ];

        $index = 1;
        foreach ($scenarios as $scenario) {
            [$count, $status, $ket, $startMonths, $lastVisitDays, $hasVl] = $scenario;

            for ($i = 0; $i < $count; $i++) {
                $tglMulai = Carbon::now()->subMonths($startMonths);
                $tglKunjunganTerakhir = Carbon::now()->subDays($lastVisitDays);

                // A. User Pasien
                $userPasien = new User([
                    'name' => $faker->name,
                    'email' => "dummy.pasien.{$index}@test.com",
                    'password' => Hash::make('password'),
                    'role' => 'pasien',
                ]);
                $userPasien->created_at = $tglMulai;
                $userPasien->updated_at = $tglMulai;
                $userPasien->save();

                // B. Profil Pasien
                $pasien = new Pasien([
                    'user_id' => $userPasien->id,
                    'petugas_id' => $petugasId,
                    'nama' => $userPasien->name,
                    'nomor_rm' => 'RM-' . $tglMulai->year . '-' . str_pad($index, 4, '0', STR_PAD_LEFT),
                    'nik' => $faker->nik,
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->date('Y-m-d', '2005-01-01'),
                    'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                    'agama' => $faker->randomElement(['Islam', 'Kristen', 'Katolik', 'Hindu', 'Buddha']),
                    'status_perkawinan' => $faker->randomElement(['Belum Kawin', 'Kawin', 'Cerai Hidup', 'Cerai Mati']),
                    'alamat_lengkap' => $faker->address,
                    'rt' => $faker->numberBetween(1, 20),
                    'rw' => $faker->numberBetween(1, 10),
                    'kabupaten' => 'Banyuwangi',
                    'kecamatan' => $faker->randomElement(['Genteng', 'Gambiran', 'Benculuk', 'Cluring']),
                    'kelurahan' => $faker->word,
                    'provinsi' => 'Jawa Timur',
                    'no_hp' => '8' . $faker->numberBetween(100000000, 999999999),
                    'no_registrasi_nasional' => 'REG-' . $faker->numberBetween(10000, 99999),
                    'status_pasien' => $status,
                    'tanggal_awal_pengobatan' => $tglMulai->format('Y-m-d'),
                    'lokasi_diagnosa' => $faker->randomElement(['RSUD Genteng', 'RSUD Blambangan', 'Puskesmas Benculuk']),
                    'keterangan_pasien' => $ket,
                    'tanggal_kunjungan_terakhir' => $tglKunjunganTerakhir->format('Y-m-d'),
                ]);
                $pasien->created_at = $tglMulai;
                $pasien->updated_at = $tglMulai;
                $pasien->save();

                // C. User Keluarga
                $userKeluarga = User::create([
                    'name' => 'Keluarga ' . $userPasien->name,
                    'email' => "dummy.keluarga.{$index}@test.com",
                    'password' => Hash::make('password'),
                    'role' => 'keluarga',
                ]);

                Keluarga::create([
                    'user_id' => $userKeluarga->id,
                    'pasien_id' => $userPasien->id,
                    'nama' => $userKeluarga->name,
                    'no_hp' => '8' . $faker->numberBetween(100000000, 999999999),
                    'alamat' => $pasien->alamat_lengkap,
                    'kabupaten' => $pasien->kabupaten,
                    'kecamatan' => $pasien->kecamatan,
                    'provinsi' => $pasien->provinsi,
                ]);

                // D. Riwayat Kartu Kendali (Beberapa record)
                $visitCount = rand(1, 5);
                for ($v = 0; $v < $visitCount; $v++) {
                    $vDate = $tglKunjunganTerakhir->copy()->subMonths($v);
                    KartuKendali::create([
                        'id_pasien' => $userPasien->id,
                        'id_petugas' => $petugasId,
                        'tanggal_kunjungan' => $vDate->format('Y-m-d'),
                        'rencana_tanggal_kunjungan_selanjutnya' => $vDate->copy()->addMonth()->format('Y-m-d'),
                        'obat_yang_diberikan' => [
                            ['nama' => 'TDF(300)/3TC(300)/DTG(50)', 'jumlah' => rand(20, 30)],
                            ['nama' => 'OAT KDT Kategori 1', 'jumlah' => rand(5, 10)]
                        ],
                        'jumlah_inh_yang_tersisa' => rand(0, 10),
                        'jumlah_inh_yang_diberikan_untuk_bulan_berikutnya' => 30,
                        'efek_samping_dan_lab_profilaksis' => $faker->randomElement(['Pusing', 'Mual', '-', 'Gatal-gatal']),
                        'catatan' => 'Pemeriksaan rutin bulan ke-' . ($v + 1),
                    ]);
                }

                // E. Laporan Evaluasi (Jika sudah lama berobat)
                if ($startMonths >= 6) {
                    $stages = ['Kunjungan Pertama', 'Memenuhi Syarat Medis ART', 'Saat Mulai ART', 'Setelah 6 Bulan ART'];
                    foreach ($stages as $sIndex => $stage) {
                        LaporanEvaluasi::create([
                            'id_pasien' => $userPasien->id,
                            'id_petugas' => $petugasId,
                            'kunjungan' => $stage,
                            'tanggal' => $tglMulai->copy()->addMonths($sIndex * 2)->format('Y-m-d'),
                            'standar_klinis' => 'Normal',
                            'hasil_arv_terakhir' => 'Baik',
                            'jumlah_cd4' => rand(200, 800),
                            'status_fungsional' => $faker->randomElement(['K', 'Amb', 'B']),
                            'catatan' => 'Evaluasi tahap ' . $stage,
                        ]);
                    }
                }

                // F. Data Viral Load (DataPengobatan)
                if ($hasVl) {
                    // Buat 1-2 data VL
                    DataPengobatan::create([
                        'id_pasien' => $userPasien->id,
                        'id_petugas' => $petugasId,
                        'tanggal' => $tglKunjunganTerakhir->copy()->subDays(5)->format('Y-m-d'),
                        'nilai_viral_load' => rand(0, 1000),
                        'status_viral_load' => $faker->randomElement(['Terdeteksi', 'Tidak Terdeteksi']),
                    ]);
                }

                $index++;
            }
        }
    }
}
