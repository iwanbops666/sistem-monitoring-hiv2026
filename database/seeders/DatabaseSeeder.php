<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Petugas;
use App\Models\Pasien;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Admin/Petugas User
        $userPetugas = User::create([
            'name' => 'Petugas Satu',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
        ]);

        Petugas::create([
            'user_id' => $userPetugas->id,
            'nama' => 'Petugas Satu',
            'nip' => '123456789',
            'no_hp' => '08123456789',
            'alamat' => 'Alamat Petugas',
        ]);

        // Pasien User
        $userPasien = User::create([
            'name' => 'Jono Widodo',
            'email' => 'pasien@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'pasien',
        ]);

        Pasien::create([
            'user_id' => $userPasien->id,
            'petugas_id' => $userPetugas->id,
            'nama' => 'Jane Cooper',
            'nomor_rm' => '2343',
            'nik' => '3201010101010001',
            'jenis_kelamin' => 'Perempuan',
            'no_hp' => '086786987664',
            'no_registrasi_nasional' => '(225) 555-0118',
            'status_pasien' => 'Hidup',
        ]);

        $this->call(DummyPasienSeeder::class);
    }
}
