<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| Halaman Umum
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
});

Route::get('/login', function () {
    return view('login');
});

Route::post('/login', function (Request $request) {
    /*
    |--------------------------------------------------------------------------
    | Login Sementara
    |--------------------------------------------------------------------------
    | Karena kita belum pakai database/auth asli, setelah klik login
    | langsung diarahkan ke dashboard petugas.
    */

    return redirect('/dashboard');
});

Route::get('/logout', function () {
    return redirect('/login');
});


/*
|--------------------------------------------------------------------------
| Halaman Petugas
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('petugas.dashboard');
});

Route::get('/manajemen-pasien/data-viral-load', function () {
    return view('petugas.data-viral-load');
});

Route::get('/manajemen-pasien/registrasi-pasien', function () {
    return view('petugas.registrasi-pasien');
});

Route::get('/manajemen-data-pasien/data-pasien', function () {
    return view('petugas.data-pasien');
});

Route::get('/manajemen-data-pasien/data-kepatuhan-pasien', function () {
    return view('petugas.data-kepatuhan-pasien');
});

Route::get('/kartu-kendali-pasien', function () {
    return view('petugas.kartu-kendali-pasien');
});

Route::get('/laporan-evaluasi-pasien', function () {
    return view('petugas.laporan-evaluasi-pasien');
});

Route::get('/data-laporan', function () {
    return view('petugas.data-laporan');
});

Route::get('/profile', function () {
    return view('petugas.profile');
});


/*
|--------------------------------------------------------------------------
| Halaman Pasien
|--------------------------------------------------------------------------
*/

Route::get('/pasien/dashboard', function () {
    return view('pasien.dashboard');
});

Route::get('/pasien/profile', function () {
    return view('pasien.profile');
});

Route::get('/pasien/kartu-kendali', function () {
    return view('pasien.kartu-kendali');
});

Route::get('/pasien/laporan-evaluasi', function () {
    return view('pasien.laporan-evaluasi');
});


/*
|--------------------------------------------------------------------------
| Halaman Keluarga Pasien
|--------------------------------------------------------------------------
*/

Route::get('/keluarga/dashboard', function () {
    return view('keluarga.dashboard');
});

Route::get('/keluarga/profile', function () {
    return view('keluarga.profile');
});