<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class KeluargaController extends Controller
{
    public function dashboard()
    {
        $keluarga = Auth::user()->keluarga;
        $pasien = $keluarga->pasien;
        $riwayats = $pasien->kartuKendali()->latest('tanggal_kunjungan')->take(10)->get();
        
        $lastJadwal = $pasien->kartuKendali()->whereNotNull('rencana_tanggal_kunjungan_selanjutnya')
            ->orderByDesc('rencana_tanggal_kunjungan_selanjutnya')
            ->first();
            
        $jadwal_mendatang = $lastJadwal ? \Carbon\Carbon::parse($lastJadwal->rencana_tanggal_kunjungan_selanjutnya)->format('d F Y') : '-';
        
        $selisih_hari = null;
        if ($lastJadwal) {
            $selisih_hari = (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($lastJadwal->rencana_tanggal_kunjungan_selanjutnya)->startOfDay(), false);
        }

        $vl_riwayats = $pasien->laporanEvaluasi()
            ->whereNotNull('status_viral_load')
            ->orderByDesc('tanggal')
            ->get();

        return view('keluarga.dashboard', compact('keluarga', 'pasien', 'jadwal_mendatang', 'riwayats', 'vl_riwayats', 'selisih_hari'));
    }

    public function profile()
    {
        $keluarga = Auth::user()->keluarga;
        return view('keluarga.profile', compact('keluarga'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $keluarga = $user->keluarga;

        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        if ($request->hasFile('foto_profil')) {
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            $file = $request->file('foto_profil');
            $path = $file->store('profile-photos', 'public');
            $user->update(['foto_profil' => $path]);
        }

        $keluarga->update($request->all());

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai']);
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }

    public function kartuKendali()
    {
        $pasien = Auth::user()->keluarga->pasien;
        $records = $pasien->kartuKendali()->latest('tanggal_kunjungan')->get();
        return view('pasien.kartu-kendali', compact('records'));
    }

    public function laporanEvaluasi()
    {
        $pasien = Auth::user()->keluarga->pasien;
        $records = $pasien->laporanEvaluasi()->latest('tanggal')->get();
        return view('pasien.laporan-evaluasi', compact('records'));
    }
}
