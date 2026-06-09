<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PetugasController;
use App\Http\Controllers\PasienController;
use App\Http\Controllers\KeluargaController;
use App\Http\Controllers\PushSubscriptionController;

/*
|--------------------------------------------------------------------------
| Halaman Umum & Auth
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
});

Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::post('/send-notification', [PetugasController::class, 'sendNotification'])->name('notif.send');
Route::post('/send-bulk-notification', [PetugasController::class, 'sendBulkNotification'])->name('notif.send-bulk');

/*
|--------------------------------------------------------------------------
| Halaman Petugas
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:petugas,admin'])->group(function () {
    Route::get('/dashboard', [PetugasController::class, 'dashboard'])->name('petugas.dashboard');
    
    Route::prefix('manajemen-pasien')->group(function () {
        Route::get('/registrasi-pasien', [PetugasController::class, 'registrasiPasien'])->name('petugas.registrasi-pasien');
        Route::post('/registrasi-pasien', [PetugasController::class, 'storePasien'])->name('petugas.pasien.store');
        Route::get('/data-pasien', [PetugasController::class, 'dataPasien'])->name('petugas.data-pasien');
        Route::get('/data-pasien/{id}', [PetugasController::class, 'showPasien'])->name('petugas.pasien.detail');
        Route::put('/data-pasien/{id}', [PetugasController::class, 'updatePasien'])->name('petugas.pasien.update');
        Route::delete('/data-pasien/{id}', [PetugasController::class, 'deletePasien'])->name('petugas.pasien.delete');
    });

    Route::prefix('kartu-kendali')->group(function () {
        Route::get('/kartu-kendali', [PetugasController::class, 'kartuKendaliPasien'])->name('petugas.kartu-kendali-pasien');
        Route::post('/kartu-kendali', [PetugasController::class, 'storeKartuKendali'])->name('petugas.kartu-kendali.store');
        Route::get('/kepatuhan-pasien', [PetugasController::class, 'dataKepatuhanPasien'])->name('petugas.data-kepatuhan-pasien');
        Route::get('/riwayat-kartu-kendali/{id}', [PetugasController::class, 'riwayatKartuKendali'])->name('petugas.riwayat-kartu-kendali');
    });

    Route::prefix('laporan-evaluasi')->group(function () {
        Route::get('/laporan-evaluasi', [PetugasController::class, 'laporanEvaluasiPasien'])->name('petugas.laporan-evaluasi-pasien');
        Route::post('/laporan-evaluasi', [PetugasController::class, 'storeLaporanEvaluasi'])->name('petugas.laporan-evaluasi.store');
        Route::get('/data-viral-load', [PetugasController::class, 'dataViralLoad'])->name('petugas.data-viral-load');
        Route::post('/data-viral-load', [PetugasController::class, 'storeViralLoad'])->name('petugas.viral-load.store');
        Route::get('/riwayat-laporan-evaluasi/{id}', [PetugasController::class, 'riwayatLaporanEvaluasi'])->name('petugas.riwayat-laporan-evaluasi');
    });
    
    Route::get('/data-laporan', [PetugasController::class, 'dataLaporan'])->name('petugas.data-laporan');
    Route::get('/export-laporan', [PetugasController::class, 'exportLaporan'])->name('petugas.laporan.export');
    Route::get('/profile', [PetugasController::class, 'profile'])->name('petugas.profile');
    Route::post('/profile', [PetugasController::class, 'updateProfile'])->name('petugas.profile.update');
    Route::post('/change-password', [PetugasController::class, 'updatePassword'])->name('petugas.password.update');
});

/*
|--------------------------------------------------------------------------
| Halaman Pasien
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:pasien'])->prefix('pasien')->group(function () {
    Route::get('/dashboard', [PasienController::class, 'dashboard'])->name('pasien.dashboard');
    Route::get('/profile', [PasienController::class, 'profile'])->name('pasien.profile');
    Route::get('/kartu-kendali', [PasienController::class, 'kartuKendali'])->name('pasien.kartu-kendali');
    Route::get('/laporan-evaluasi', [PasienController::class, 'laporanEvaluasi'])->name('pasien.laporan-evaluasi');
    Route::post('/profile', [PasienController::class, 'updateProfile'])->name('pasien.profile.update');
    Route::post('/change-password', [PasienController::class, 'updatePassword'])->name('pasien.password.update');
});

/*
|--------------------------------------------------------------------------
| Halaman Keluarga Pasien
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'role:keluarga'])->prefix('keluarga')->group(function () {
    Route::get('/dashboard', [KeluargaController::class, 'dashboard'])->name('keluarga.dashboard');
    Route::get('/profile', [KeluargaController::class, 'profile'])->name('keluarga.profile');
    Route::get('/kartu-kendali', [KeluargaController::class, 'kartuKendali'])->name('keluarga.kartu-kendali');
    Route::get('/laporan-evaluasi', [KeluargaController::class, 'laporanEvaluasi'])->name('keluarga.laporan-evaluasi');
    Route::post('/profile', [KeluargaController::class, 'updateProfile'])->name('keluarga.profile.update');
    Route::post('/change-password', [KeluargaController::class, 'updatePassword'])->name('keluarga.password.update');
});

Route::middleware('auth')->group(function () {
    Route::post('/push-subscriptions', [PushSubscriptionController::class, 'update']);
    Route::delete('/push-subscriptions', [PushSubscriptionController::class, 'destroy']);
});