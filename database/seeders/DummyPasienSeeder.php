<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Pasien;
use App\Models\Keluarga;
use App\Models\Petugas;
use App\Models\KartuKendali;
use App\Models\LaporanEvaluasi;
use App\Models\DataPengobatan;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class DummyPasienSeeder extends Seeder
{
    public function run(): void
    {
        $faker = \Faker\Factory::create('id_ID');

        // Bersihkan data dummy sebelumnya
        User::where('email', 'like', 'pasien%@test.com')->delete();
        User::where('email', 'like', 'keluarga%@test.com')->delete();
        // Since cascading might not be set up perfectly in raw scripts, let's explicitly clean
        KartuKendali::truncate();
        LaporanEvaluasi::truncate();
        DataPengobatan::truncate();

        $petugas = Petugas::first();
        $petugasId = $petugas ? $petugas->user_id : 1;

        $keterangan_options = ['Baru', 'Lama', 'Pindahan', 'Pindah Pengobatan'];
        $daftar_obat = [
            'TDF(300)/3TC(300)/EFV(600)',
            'TDF(300)/3TC(300)/DTG(50)',
            'OAT KDT Kategori 1',
            'TPT 3HP KDT',
            'Sulfamethoxazole: 800 mg / Trimethoprim: 160 mg'
        ];

        // [ 'status_kehadiran', 'bulan_mulai_art', 'eval_records', 'status_pasien' ]
        $scenarios = [
            // 4 Active
            ['active', 14.5, ['M6', 'Y1'], 'Hidup'], // 2025 -> Not due
            ['active', 6.5, [], 'Hidup'],            // 2026 -> Due for 6 Bulan VL (6.5 months)
            ['active', 4.0, [], 'Hidup'],            // 2026
            ['active', 2.0, [], 'Hidup'],            // 2026
            
            // 3 Inactive
            ['inactive', 14.0, ['M6'], 'Hidup'],       // 2025 -> Due for Y1 VL (14 months, no Y1)
            ['inactive', 5.2, [], 'Hidup'],            // 2026
            ['inactive', 3.0, [], 'Hidup'],            // 2026

            // 1 LTFU & 2 Meninggal
            ['ltfu', 4.5, [], 'Meninggal'],          // 2026 (Meninggal)
            ['ltfu', 7.5, [], 'Hidup'],              // 2026 (LTFU) -> Due for 6 Bulan VL
            ['ltfu', 10.0, ['M6'], 'Meninggal'],     // 2025 (Meninggal)
            
            // 11th Patient (Active)
            ['active', 3.5, [], 'Hidup'],            // 2026
        ];

        for ($i = 0; $i < 11; $i++) {
            $count = $i + 1;
            $conf = $scenarios[$i];

            // 1. Create User
            $tanggal_mulai_art = Carbon::now()->subMonthsNoOverflow($conf[1])->startOfDay();

            $userPasien = User::create([
                'name' => 'Pasien ' . $count,
                'email' => "pasien{$count}@test.com",
                'password' => Hash::make('password'),
                'role' => 'pasien',
                'created_at' => clone $tanggal_mulai_art,
                'updated_at' => clone $tanggal_mulai_art,
            ]);

            // 2. Create Pasien
            // 2. Create Pasien
            $pasien = Pasien::create([
                'user_id' => $userPasien->id,
                'petugas_id' => $petugasId,
                'nama' => $userPasien->name,
                'nomor_rm' => str_pad(rand(0, 9999999), 7, '0', STR_PAD_LEFT), // 7 digit RM
                'nik' => $faker->numerify('################'), // 16 digit NIK
                'tempat_lahir' => $faker->city,
                'tanggal_lahir' => $faker->date('Y-m-d', '2000-01-01'),
                'jenis_kelamin' => $faker->randomElement(['Laki-laki', 'Perempuan']),
                'agama' => 'Islam',
                'status_perkawinan' => 'Kawin',
                'alamat_lengkap' => $faker->address,
                'rt' => rand(1, 15),
                'rw' => rand(1, 15),
                'kabupaten' => 'Banyuwangi',
                'kecamatan' => 'Benculuk',
                'provinsi' => 'Jawa Timur',
                'no_hp' => '08' . $faker->numerify('##########'),
                'no_registrasi_nasional' => 'P3510060201-' . str_pad($count, 4, '0', STR_PAD_LEFT),
                'status_pasien' => $conf[3],
                'tanggal_awal_pengobatan' => $tanggal_mulai_art->format('Y-m-d'),
                'lokasi_diagnosa' => 'Puskesmas Benculuk',
                'keterangan_pasien' => $count <= 4 ? 'Baru' : ['Lama', 'Pindahan', 'Pindah Pengobatan'][array_rand(['Lama', 'Pindahan', 'Pindah Pengobatan'])],
                'created_at' => clone $tanggal_mulai_art,
                'updated_at' => clone $tanggal_mulai_art,
            ]);

            // 3. Create Keluarga
            $userKeluarga = User::create([
                'name' => 'Keluarga ' . $userPasien->name,
                'email' => "keluarga{$count}@test.com",
                'password' => Hash::make('password'),
                'role' => 'keluarga',
            ]);

            Keluarga::create([
                'user_id' => $userKeluarga->id,
                'pasien_id' => $userPasien->id,
                'nama' => $userKeluarga->name,
                'no_hp' => '08' . $faker->numerify('##########'),
                'alamat' => $pasien->alamat_lengkap,
                'kabupaten' => $pasien->kabupaten,
                'kecamatan' => $pasien->kecamatan,
                'provinsi' => $pasien->provinsi,
            ]);

            // 4. Create Kartu Kendali (5-10 visits per patient)
            $numVisits = rand(5, 10);
            
            // Tentukan tanggal kunjungan terakhir berdasarkan target status
            $lastVisitDate = Carbon::now();
            if ($conf[0] == 'active') {
                $lastVisitDate->subDays(rand(1, 20)); // < 30 days
            } elseif ($conf[0] == 'inactive') {
                $lastVisitDate->subDays(rand(35, 60)); // > 30 and < 60 days
            } elseif ($conf[0] == 'ltfu') {
                $lastVisitDate->subDays(rand(65, 200)); // > 61 days
            }

            // Update kolom tanggal_kunjungan_terakhir di tabel Pasien agar status otomatis terhitung!
            $pasien->tanggal_kunjungan_terakhir = clone $lastVisitDate;
            $pasien->rencana_kunjungan_berikutnya = (clone $lastVisitDate)->addDays(30);
            $pasien->save();

            for ($v = 0; $v < $numVisits; $v++) {
                // Generate sequential past dates
                $visitDate = clone $lastVisitDate;
                $visitDate->subDays(($numVisits - $v - 1) * 30); // space them out by ~30 days

                // Generate random obats for this visit
                $numObat = rand(1, 2);
                $keys = array_rand($daftar_obat, $numObat);
                if (!is_array($keys)) $keys = [$keys];
                
                $obatArray = [];
                foreach ($keys as $key) {
                    $obatArray[] = [
                        'nama' => $daftar_obat[$key],
                        'jumlah' => rand(1, 10)
                    ];
                }

                KartuKendali::create([
                    'id_pasien' => $userPasien->id,
                    'id_petugas' => $petugasId,
                    'tanggal_kunjungan' => $visitDate->format('Y-m-d'),
                    'rencana_tanggal_kunjungan_selanjutnya' => clone $visitDate->addDays(30),
                    'rejimen_arv' => 'TDF/3TC/EFV',
                    'jumlah_arv_tersisa' => rand(0, 5),
                    'jumlah_inh_yang_tersisa' => rand(0, 5),
                    'jumlah_inh_yang_diberikan_untuk_bulan_berikutnya' => 30,
                    'efek_samping_dan_lab_profilaksis' => '-',
                    'obat_yang_diberikan' => $obatArray,
                    'catatan' => 'Kunjungan rutin test seeder',
                ]);
            }

            // 5. Create Laporan Evaluasi & Viral Load Data
            
            // A. Kunjungan Pertama
            LaporanEvaluasi::create([
                'id_pasien' => $userPasien->id,
                'id_petugas' => $petugasId,
                'kunjungan' => 'Kunjungan Pertama',
                'tanggal' => $tanggal_mulai_art->copy()->subDays(14)->format('Y-m-d'),
                'standar_klinis' => 'Pasien datang dengan keluhan.',
                'hasil_arv_terakhir' => '-',
                'status_viral_load' => 'Belum Dilakukan',
                'status_fungsional' => 'A',
                'jumlah_cd4' => rand(200, 800),
                'berat_badan' => rand(45, 85),
                'catatan' => 'Tes HIV awal dilakukan.',
            ]);

            // B. Memenuhi Syarat Medis ART
            LaporanEvaluasi::create([
                'id_pasien' => $userPasien->id,
                'id_petugas' => $petugasId,
                'kunjungan' => 'Memenuhi Syarat Medis ART',
                'tanggal' => $tanggal_mulai_art->copy()->subDays(7)->format('Y-m-d'),
                'standar_klinis' => 'Hasil tes positif, konseling dilakukan.',
                'hasil_arv_terakhir' => '-',
                'status_viral_load' => 'Belum Dilakukan',
                'status_fungsional' => 'A',
                'jumlah_cd4' => rand(200, 800),
                'berat_badan' => rand(45, 85),
                'catatan' => 'Persiapan ART.',
            ]);

            // C. Base Evaluasi (Saat Mulai ART)
            LaporanEvaluasi::create([
                'id_pasien' => $userPasien->id,
                'id_petugas' => $petugasId,
                'kunjungan' => 'Saat Mulai ART',
                'tanggal' => $tanggal_mulai_art->format('Y-m-d'),
                'standar_klinis' => 'Kondisi stabil awal.',
                'hasil_arv_terakhir' => '-',
                'status_viral_load' => 'Belum Dilakukan',
                'status_fungsional' => 'K',
                'jumlah_cd4' => rand(200, 800),
                'berat_badan' => rand(45, 85),
                'catatan' => 'Mulai Pengobatan',
            ]);

            // D. Follow-up VL tests
            foreach ($conf[2] as $rec) {
                $tgl_tes = clone $tanggal_mulai_art;
                $kategori = '';
                
                if ($rec === 'M6') {
                    $tgl_tes->addMonthsNoOverflow(6);
                    $kunjungan = 'Setelah 6 Bulan ART';
                    $kategori = 'Viraload 6 Bulan Awal';
                } elseif ($rec === 'Y1') {
                    $tgl_tes->addMonthsNoOverflow(12);
                    $kunjungan = 'Setelah 1 Tahun ART';
                    $kategori = 'Viraload Tahunan Rutin';
                } elseif ($rec === 'Y2') {
                    $tgl_tes->addMonthsNoOverflow(24);
                    $kunjungan = 'Setelah 2 Tahun ART';
                    $kategori = 'Viraload Tahunan Rutin';
                }

                $isTnd = rand(0, 1) === 1;

                LaporanEvaluasi::create([
                    'id_pasien' => $userPasien->id,
                    'id_petugas' => $petugasId,
                    'kunjungan' => $kunjungan,
                    'tanggal' => $tgl_tes->format('Y-m-d'),
                    'standar_klinis' => 'Evaluasi rutin.',
                    'hasil_arv_terakhir' => 'Toleransi baik.',
                    'status_viral_load' => 'Sudah Dilakukan ' . $kategori,
                    'status_fungsional' => 'K',
                    'jumlah_cd4' => rand(200, 800),
                    'berat_badan' => rand(45, 85),
                    'catatan' => 'Evaluasi rutin ' . $kunjungan,
                ]);

                DataPengobatan::create([
                    'id_pasien' => $userPasien->id,
                    'id_petugas' => $petugasId,
                    'kategori_viral_load' => $kategori,
                    'tanggal' => $tgl_tes->format('Y-m-d'),
                    'status_viral_load' => $isTnd ? 'TND' : 'Terdeteksi',
                    'nilai_viral_load' => $isTnd ? 0 : rand(50, 1000),
                    'keterangan' => 'Pemeriksaan VL ' . $kategori,
                ]);
            }
        }
    }
}
