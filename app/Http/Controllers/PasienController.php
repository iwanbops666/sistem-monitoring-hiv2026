<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class PasienController extends Controller
{
    public function dashboard()
    {
        $pasien = Auth::user()->pasien;
        $riwayats = $pasien->kartuKendali()->latest('tanggal_kunjungan')->take(10)->get();
        
        $lastJadwal = $pasien->kartuKendali()->whereNotNull('rencana_tanggal_kunjungan_selanjutnya')
            ->orderByDesc('rencana_tanggal_kunjungan_selanjutnya')
            ->first();
            
        $jadwal_mendatang = $lastJadwal ? \Carbon\Carbon::parse($lastJadwal->rencana_tanggal_kunjungan_selanjutnya)->format('d F Y') : '-';
        
        $selisih_hari = null;
        if ($lastJadwal) {
            $selisih_hari = (int) now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($lastJadwal->rencana_tanggal_kunjungan_selanjutnya)->startOfDay(), false);
        }

        return view('pasien.dashboard', compact('pasien', 'jadwal_mendatang', 'riwayats', 'selisih_hari'));
    }

    public function profile()
    {
        $pasien = Auth::user()->pasien;
        return view('pasien.profile', compact('pasien'));
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $pasien = $user->pasien;

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'required|string|max:20',
            'nik' => 'nullable|digits:16',
            'tempat_lahir' => 'nullable|string|max:255',
            'tanggal_lahir' => 'nullable|date',
            'jenis_kelamin' => 'nullable|string',
            'agama' => 'nullable|string',
            'alamat_lengkap' => 'nullable|string|max:500',
        ]);

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

        $pasien->update($request->all());

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
        $pasien = Auth::user()->pasien;
        $records = $pasien->kartuKendali()->latest('tanggal_kunjungan')->get();
        return view('pasien.kartu-kendali', compact('records'));
    }

    public function laporanEvaluasi()
    {
        $pasien = Auth::user()->pasien;
        
        $clinical = $pasien->laporanEvaluasi()->get()->map(function($item) {
            $item->record_type = 'clinical';
            return $item;
        });

        $viralLoad = $pasien->dataPengobatan()->get()->map(function($item) {
            $item->record_type = 'viral_load';
            $item->kunjungan = 'Pemeriksaan Viral Load';
            return $item;
        });

        $records = $clinical->concat($viralLoad)->sortByDesc('tanggal');

        return view('pasien.laporan-evaluasi', compact('records'));
    }
}
