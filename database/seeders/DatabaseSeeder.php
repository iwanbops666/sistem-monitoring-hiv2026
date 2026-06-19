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
            'name' => 'ANDRIYONO',
            'email' => 'petugas@gmail.com',
            'password' => Hash::make('password'),
            'role' => 'petugas',
            'created_at' => now()->subMonths(4),
            'updated_at' => now()->subMonths(4),
        ]);

        Petugas::create([
            'user_id' => $userPetugas->id,
            'nama' => 'ANDRIYONO',
            'nip' => '123456789',
            'no_hp' => '08123456789',
            'jenis_kelamin' => 'Laki-laki',
            'tanggal_lahir' => '1985-05-15',
            'alamat' => 'Jl. Gajah Mada, Gang Kelapa Muda No. 7, RT 05 / RW 02, Dusun Kepatihan, Desa Cluring, Kecamatan Cluring, Kabupaten Banyuwangi, Jawa Timur, 68482',
        ]);

        // Seeder DummyPasienSeeder will generate all 11 patients and their related data

        $this->call(DummyPasienSeeder::class);
    }
}
