<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyPasienSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');
        
        // 1. Clean old dummy data
        \App\Models\User::where('email', 'like', 'pasien.dummy%')->delete();
        \App\Models\User::where('email', 'like', 'keluarga.dummy%')->delete();
        
        $petugas = \App\Models\Petugas::first();
        $petugasId = $petugas ? $petugas->user_id : 1;

        // Configuration for varied data
        $scenarios = [
            // [Count, status_pasien, keterangan_pasien, activity_type, treatment_start_offset_months]
            [5, 'Hidup', 'Baru', 'active', 0],    // 1 & 2 & 3: New Active Patients
            [5, 'Hidup', 'Baru', 'ltfu', 4],      // 5: LTFU Patients (2-6 months ago)
            [5, 'Hidup', 'Baru', 'inactive', 8],  // 4: Inactive Patients (> 6 months ago)
            [3, 'Meninggal', 'Lama', 'none', 12], // 7: Deceased Patients
            [2, 'Hidup', 'Pindahan', 'active', 3],// 8: Active Transferred In Patients
            [2, 'Hidup', 'Pindah', 'none', 1],   // 9: Patients Transferred Out
            [3, 'Hidup', 'Baru', 'none', null],   // Mixed: Patients without treatment yet
        ];

        $totalCount = 0;
        foreach ($scenarios as $scenario) {
            [$count, $status, $keterangan, $activity, $startOffset] = $scenario;

            for ($i = 0; $i < $count; $i++) {
                $totalCount++;
                
                // A. Create User
                $userPasien = \App\Models\User::create([
                    'name' => $faker->name,
                    'email' => "pasien.dummy{$totalCount}@example.com",
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'pasien',
                ]);

                // B. Create Pasien Profile
                $tglAwal = $startOffset !== null ? now()->subMonths($startOffset)->format('Y-m-d') : null;
                
                $pasien = \App\Models\Pasien::create([
                    'user_id' => $userPasien->id,
                    'petugas_id' => $petugasId,
                    'nama' => $userPasien->name,
                    'nomor_rm' => 'RM-' . str_pad($totalCount, 4, '0', STR_PAD_LEFT),
                    'nik' => $faker->nik,
                    'tempat_lahir' => $faker->city,
                    'tanggal_lahir' => $faker->date('Y-m-d', '2000-01-01'),
                    'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                    'agama' => 'Islam',
                    'status_perkawinan' => 'Kawin',
                    'alamat_lengkap' => $faker->address,
                    'rt' => $faker->numberBetween(1, 10),
                    'rw' => $faker->numberBetween(1, 10),
                    'kabupaten' => $faker->city,
                    'kecamatan' => $faker->city,
                    'provinsi' => 'Jawa Timur',
                    'no_hp' => '8' . $faker->numberBetween(100000000, 999999999),
                    'no_registrasi_nasional' => 'REG-' . rand(10000, 99999),
                    'status_pasien' => $status,
                    'tanggal_awal_pengobatan' => $tglAwal,
                    'lokasi_diagnosa' => 'Puskesmas Benculuk',
                    'keterangan_pasien' => $keterangan,
                ]);

                // C. Create Keluarga
                $userKeluarga = \App\Models\User::create([
                    'name' => 'Keluarga ' . $userPasien->name,
                    'email' => "keluarga.dummy{$totalCount}@example.com",
                    'password' => \Illuminate\Support\Facades\Hash::make('password'),
                    'role' => 'keluarga',
                ]);

                \App\Models\Keluarga::create([
                    'user_id' => $userKeluarga->id,
                    'pasien_id' => $userPasien->id,
                    'nama' => $userKeluarga->name,
                    'no_hp' => '8' . $faker->numberBetween(100000000, 999999999),
                    'alamat' => $pasien->alamat_lengkap,
                    'kabupaten' => $pasien->kabupaten,
                    'kecamatan' => $pasien->kecamatan,
                    'provinsi' => $pasien->provinsi,
                ]);

                // D. Simulate Activity
                if ($activity == 'active') {
                    // Recent visit (last 2 weeks)
                    \App\Models\KartuKendali::create([
                        'id_pasien' => $userPasien->id,
                        'id_petugas' => $petugasId,
                        'tanggal_kunjungan' => now()->subDays(rand(1, 14)),
                        'catatan' => 'Kunjungan rutin (Test Data)',
                    ]);
                } elseif ($activity == 'ltfu') {
                    // Old visit (4 months ago)
                    \App\Models\KartuKendali::create([
                        'id_pasien' => $userPasien->id,
                        'id_petugas' => $petugasId,
                        'tanggal_kunjungan' => now()->subMonths(4),
                        'catatan' => 'Kunjungan terakhir LTFU (4 bln lalu)',
                    ]);
                } elseif ($activity == 'inactive') {
                    // Very old visit (8 months ago)
                    \App\Models\KartuKendali::create([
                        'id_pasien' => $userPasien->id,
                        'id_petugas' => $petugasId,
                        'tanggal_kunjungan' => now()->subMonths(8),
                        'catatan' => 'Kunjungan terakhir Inactive (8 bln lalu)',
                    ]);
                }

                // E. Viral Load Data for some
                if ($totalCount % 2 == 0 && $tglAwal) {
                    \App\Models\DataPengobatan::create([
                        'id_pasien' => $userPasien->id,
                        'id_petugas' => $petugasId,
                        'tanggal' => now()->subDays(rand(1, 60)),
                        'nilai_viral_load' => rand(10, 1000),
                        'status_viral_load' => 'Terdeteksi',
                    ]);
                }
            }
        }
    }
}
