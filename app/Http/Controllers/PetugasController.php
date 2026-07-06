<?php

namespace App\Http\Controllers;

use App\Services\PasienService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetugasController extends Controller
{
    protected $pasienService;

    public function __construct(PasienService $pasienService)
    {
        $this->pasienService = $pasienService;
    }

    public function dashboard()
    {
        $allPasien = \App\Models\Pasien::all();
        
        $totalPasien = $allPasien->count();
        $pasienAktif = $allPasien->filter(fn($p) => $p->display_status == 'Active')->count();
        $pasienLtfu = $allPasien->filter(fn($p) => $p->display_status == 'LTFU')->count();
        $pasienMeninggal = \App\Models\Pasien::where('status_pasien', 'Meninggal')->count();

        // Pasien Belum Kontrol (Tidak ada kartu kendali dalam 7 hari terakhir)
        $pasienBelumKontrol = \App\Models\Pasien::where('status_pasien', 'Hidup')
            ->where(function($q) {
                $q->whereDoesntHave('kartuKendali', function($sq) {
                    $sq->where('tanggal_kunjungan', '>=', now()->subDays(7));
                });
            })
            ->latest()
            ->take(5)
            ->get();

        return view('petugas.dashboard', compact(
            'totalPasien', 'pasienAktif', 'pasienLtfu', 'pasienMeninggal', 'pasienBelumKontrol'
        ));
    }

    public function dataPasien(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('limit', 10);
        $pasiens = $this->pasienService->paginate($perPage, $search);
        return view('petugas.data-pasien', compact('pasiens'));
    }

    public function dataViralLoad(Request $request)
    {
        $search = $request->get('search');
        
        // Ambil semua pasien lalu filter berdasarkan statusnya
        $allPasiens = \App\Models\Pasien::with(['dataPengobatan', 'user'])
            ->when($search, function($q) use ($search) {
                $q->where(function($sq) use ($search) {
                    $sq->where('nama', 'like', "%$search%")
                      ->orWhere('nomor_rm', 'like', "%$search%");
                });
            })
            ->get();
            
        // Filter: Hanya yang statusnya "Perlu Cek VL"
        $filtered = $allPasiens->filter(function($p) {
            return strpos($p->viral_load_status, 'Perlu Cek') !== false;
        });

        // Manual Pagination agar tetap bisa menggunakan ->links() di view
        $perPage = 10;
        $page = $request->get('page', 1);
        $pasiens = new \Illuminate\Pagination\LengthAwarePaginator(
            $filtered->forPage($page, $perPage),
            $filtered->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('petugas.data-viral-load', compact('pasiens'));
    }

    public function registrasiPasien()
    {
        return view('petugas.registrasi-pasien');
    }

    public function kartuKendaliPasien(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('limit', 10);
        $pasiens = $this->pasienService->paginate($perPage, $search);
        return view('petugas.kartu-kendali-pasien', compact('pasiens'));
    }

    public function laporanEvaluasiPasien(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('limit', 10);
        $pasiens = $this->pasienService->paginate($perPage, $search);
        return view('petugas.laporan-evaluasi-pasien', compact('pasiens'));
    }

    public function dataLaporan(Request $request)
    {
        $query = \App\Models\Pasien::with(['user']);
        
        // 1. Filter Dasar (Search)
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('nomor_rm', 'like', "%{$request->search}%");
            });
        }

        // 2. Filter Berdasarkan Jenis Laporan
        $jenis = $request->jenis_laporan;
        if ($jenis) {
            switch ($jenis) {
                case 'Laporan Jumlah Pasien Baru':
                    if ($request->dari_tanggal && $request->sampai_tanggal) {
                        $query->whereBetween('created_at', [$request->dari_tanggal . ' 00:00:00', $request->sampai_tanggal . ' 23:59:59']);
                    }
                    break;
                case 'Jumlah Pasien Mulai Pengobatan':
                    $query->whereNotNull('tanggal_awal_pengobatan');
                    if ($request->dari_tanggal && $request->sampai_tanggal) {
                        $query->whereBetween('tanggal_awal_pengobatan', [$request->dari_tanggal, $request->sampai_tanggal]);
                    }
                    break;
                case 'Jumlah Pasien Active':
                    $query->where('status_pasien', 'Hidup')
                          ->where(function($q) {
                              $q->where('tanggal_kunjungan_terakhir', '>=', now()->subDays(30))
                                ->orWhere(function($sq) {
                                    $sq->whereNull('tanggal_kunjungan_terakhir')
                                       ->where('created_at', '>=', now()->subDays(30));
                                });
                          });
                    break;
                case 'Jumlah Pasien Inactive':
                    $query->where('status_pasien', 'Hidup')
                          ->where(function($q) {
                              $q->whereBetween('tanggal_kunjungan_terakhir', [now()->subDays(61), now()->subDays(30)])
                                ->orWhere(function($sq) {
                                    $sq->whereNull('tanggal_kunjungan_terakhir')
                                       ->whereBetween('created_at', [now()->subDays(61), now()->subDays(30)]);
                                });
                          });
                    break;
                case 'Jumlah Pasien LTFU':
                case 'Jumlah Pasien Lost Follow Up (LTFU)':
                    $query->where('status_pasien', 'Hidup')
                          ->where(function($q) {
                              $q->where('tanggal_kunjungan_terakhir', '<', now()->subDays(61))
                                ->orWhere(function($sq) {
                                    $sq->whereNull('tanggal_kunjungan_terakhir')
                                       ->where('created_at', '<', now()->subDays(61));
                                });
                          });
                    break;
                    break;
                case 'Jumlah Pasien Berobat':
                    $query->where('status_pasien', 'Hidup')
                          ->whereNotNull('tanggal_awal_pengobatan');
                    break;
                case 'Jumlah Pasien Meninggal':
                    $query->where('status_pasien', 'Meninggal');
                    break;
                case 'Jumlah Pasien Pindahan':
                    $query->where('keterangan_pasien', 'Pindahan');
                    break;
                case 'Jumlah Pasien Pindah Pengobatan':
                    $query->where('keterangan_pasien', 'Pindah Pengobatan');
                    break;
            }
        }

        // 3. Filter Status Tambahan
        if ($request->status_pasien) {
            $query->where('status_pasien', $request->status_pasien);
        }

        $pasiens = $query->paginate($request->get('limit', 10))->withQueryString();
        
        // Summary counts (Real-time)
        $all_pasien = \App\Models\Pasien::all();
        $total_semua = $all_pasien->count();
        $total_pasien = $all_pasien->where('status_pasien', '!=', 'Meninggal')->count();
        $pasien_aktif = $all_pasien->filter(fn($p) => $p->display_status == 'Active')->count();
        $pasien_inactive = \App\Models\Pasien::where('status_pasien', 'Meninggal')->count();
        $pasien_ltfu = $all_pasien->filter(fn($p) => $p->display_status == 'LTFU')->count();
        $pasien_baru = ($request->dari_tanggal && $request->sampai_tanggal) 
            ? \App\Models\Pasien::whereBetween('created_at', [$request->dari_tanggal . ' 00:00:00', $request->sampai_tanggal . ' 23:59:59'])->count()
            : \App\Models\Pasien::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
        
        // Tentukan tahun grafik berdasarkan filter (default ke tahun sekarang)
        $tahun_grafik = date('Y');
        if ($request->dari_tanggal) {
            try {
                $tahun_grafik = \Carbon\Carbon::parse($request->dari_tanggal)->year;
            } catch (\Exception $e) {
                $tahun_grafik = date('Y');
            }
        }

        // 3. Statistik Pasien Baru per Bulan berdasarkan tahun grafik
        $statistik_baru = \App\Models\Pasien::selectRaw('MONTH(created_at) as bulan, COUNT(*) as jumlah')
            ->whereYear('created_at', $tahun_grafik)
            ->groupBy('bulan')
            ->orderBy('bulan')
            ->get()
            ->pluck('jumlah', 'bulan')
            ->toArray();
            
        $chart_data_baru = [];
        for ($m = 1; $m <= 12; $m++) {
            $chart_data_baru[] = $statistik_baru[$m] ?? 0;
        }

        return view('petugas.data-laporan', compact(
            'total_semua', 'total_pasien', 'pasien_aktif', 'pasien_inactive', 'pasien_ltfu', 'pasien_baru', 'pasiens', 'chart_data_baru', 'tahun_grafik'
        ));
    }

    public function exportLaporan(Request $request)
    {
        $query = \App\Models\Pasien::query();
        
        // Apply same filters as dataLaporan
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', "%{$request->search}%")
                  ->orWhere('nomor_rm', 'like', "%{$request->search}%");
            });
        }

        $jenis = $request->jenis_laporan;
        if ($jenis) {
            switch ($jenis) {
                case 'Laporan Jumlah Pasien Baru':
                    if ($request->dari_tanggal && $request->sampai_tanggal) {
                        $query->whereBetween('created_at', [$request->dari_tanggal . ' 00:00:00', $request->sampai_tanggal . ' 23:59:59']);
                    }
                    break;
                case 'Jumlah Pasien Mulai Pengobatan':
                    $query->whereNotNull('tanggal_awal_pengobatan');
                    if ($request->dari_tanggal && $request->sampai_tanggal) {
                        $query->whereBetween('tanggal_awal_pengobatan', [$request->dari_tanggal, $request->sampai_tanggal]);
                    }
                    break;
                case 'Jumlah Pasien Meninggal':
                    $query->where('status_pasien', 'Meninggal');
                    break;
                case 'Jumlah Pasien Active':
                    $query->where('status_pasien', 'Hidup')
                          ->where(function($q) {
                              $q->where('tanggal_kunjungan_terakhir', '>=', now()->subDays(30))
                                ->orWhere(function($sq) {
                                    $sq->whereNull('tanggal_kunjungan_terakhir')
                                       ->where('created_at', '>=', now()->subDays(30));
                                });
                          });
                    break;
                case 'Jumlah Pasien Inactive':
                    $query->where('status_pasien', 'Hidup')
                          ->where(function($q) {
                              $q->whereBetween('tanggal_kunjungan_terakhir', [now()->subDays(61), now()->subDays(30)])
                                ->orWhere(function($sq) {
                                    $sq->whereNull('tanggal_kunjungan_terakhir')
                                       ->whereBetween('created_at', [now()->subDays(61), now()->subDays(30)]);
                                });
                          });
                    break;
                case 'Jumlah Pasien Lost Follow Up (LTFU)':
                case 'Jumlah Pasien LTFU':
                    $query->where('status_pasien', 'Hidup')
                          ->where(function($q) {
                              $q->where('tanggal_kunjungan_terakhir', '<', now()->subDays(61))
                                ->orWhere(function($sq) {
                                    $sq->whereNull('tanggal_kunjungan_terakhir')
                                       ->where('created_at', '<', now()->subDays(61));
                                });
                          });
                    break;
                case 'Jumlah Pasien Berobat':
                    $query->whereNotNull('tanggal_awal_pengobatan')
                          ->where('status_pasien', 'Hidup');
                    break;
                case 'Jumlah Pasien Pindahan':
                    $query->where('keterangan_pasien', 'Pindahan');
                    break;
                case 'Jumlah Pasien Pindah Pengobatan':
                    $query->where('keterangan_pasien', 'Pindah Pengobatan');
                    break;
            }
        }

        if ($request->status_pasien) {
            $query->where('status_pasien', $request->status_pasien);
        }
        
        $pasiens = $query->get();
        $dari = $request->dari_tanggal;
        $sampai = $request->sampai_tanggal;

        $format = $request->get('format', 'excel');

        if ($format == 'excel') {
            $filename = "laporan_pasien_" . date('Ymd_His') . ".csv";
            $headers = [
                "Content-type" => "text/csv",
                "Content-Disposition" => "attachment; filename=$filename",
                "Pragma" => "no-cache",
                "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
                "Expires" => "0"
            ];

            $callback = function() use ($pasiens, $jenis, $dari, $sampai) {
                $file = fopen('php://output', 'w');
                
                // Kop Surat & Judul Laporan
                fputcsv($file, ['PEMERINTAH KABUPATEN BANYUWANGI']);
                fputcsv($file, ['DINAS KESEHATAN PUSKESMAS BENCULUK']);
                fputcsv($file, ['Jl. Raya Benculuk No.1, Benculuk, Cluring, Kabupaten Banyuwangi, Jawa Timur']);
                fputcsv($file, []);
                fputcsv($file, [$jenis ? strtoupper($jenis) : 'LAPORAN REKAPITULASI DATA PASIEN HIV']);
                fputcsv($file, []);
                
                // Metadata Laporan
                fputcsv($file, ['Unit', ': PUSKESMAS']);
                fputcsv($file, ['Nama Unit', ': PUSKESMAS BENCULUK']);
                $tglStr = ($dari && $sampai) ? \Carbon\Carbon::parse($dari)->format('d-m-Y') . ' s/d ' . \Carbon\Carbon::parse($sampai)->format('d-m-Y') : 'Hingga ' . date('d-m-Y');
                fputcsv($file, ['Tanggal', ': ' . $tglStr]);
                fputcsv($file, ['Nama Poli', ': Layanan HIV']);
                fputcsv($file, []);

                // Header Tabel
                fputcsv($file, ['No', 'Nama Pasien', 'No RM', 'NIK', 'No Regis Nasional', 'No HP', 'Jenis Kelamin', 'Status Pasien', 'Tanggal Awal Pengobatan']);
                
                foreach ($pasiens as $index => $p) {
                    fputcsv($file, [
                        $index + 1,
                        strtoupper($p->nama),
                        $p->nomor_rm,
                        $p->nik,
                        $p->no_registrasi_nasional,
                        $p->no_hp,
                        $p->jenis_kelamin,
                        $p->display_status,
                        $p->tanggal_awal_pengobatan ? \Carbon\Carbon::parse($p->tanggal_awal_pengobatan)->format('d-m-Y') : '-'
                    ]);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        } else {
            // PDF Export via simple view
            return view('petugas.export-pdf', compact('pasiens', 'jenis', 'dari', 'sampai'));
        }
    }

    public function dataKepatuhanPasien(Request $request)
    {
        $search = $request->get('search');
        $perPage = $request->get('limit', 10);
        
        $query = \App\Models\Pasien::where('status_pasien', '!=', 'Meninggal');

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('nama', 'like', "%$search%")
                  ->orWhere('nomor_rm', 'like', "%$search%");
            });
        }

        // Fetch and Sort by Priority using the new display_status rules
        $allPasiens = $query->get()->sortBy(function($pasien) {
            $status = $pasien->display_status;
            
            if ($status === 'LTFU') return 1;
            if ($status === 'Inactive') return 2;
            return 10; // Active
        })->values();

        // Manual Pagination
        $page = $request->get('page', 1);
        $paginated = new \Illuminate\Pagination\LengthAwarePaginator(
            $allPasiens->forPage($page, $perPage),
            $allPasiens->count(),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        return view('petugas.data-kepatuhan-pasien', ['pasiens' => $paginated]);
    }

    public function sendNotification(Request $request)
    {
        \App\Models\Notifikasi::sendToPatientAndFamily(
            $request->user_id,
            $request->title ?? 'Pesan dari Petugas',
            $request->message ?? 'Harap segera melakukan kontrol rutin.',
            'info'
        );

        return response()->json(['success' => true]);
    }

    public function sendBulkNotification(Request $request)
    {
        $userIds = \App\Models\Pasien::pluck('user_id');
        
        foreach ($userIds as $id) {
            \App\Models\Notifikasi::sendToPatientAndFamily(
                $id,
                $request->title ?? 'Pesan untuk Semua Pasien',
                $request->message ?? 'Harap tetap rutin melakukan kontrol dan minum obat.',
                'warning'
            );
        }

        return response()->json(['success' => true]);
    }

    public function profile()
    {
        $petugas = \Illuminate\Support\Facades\Auth::user()->petugas;
        return view('petugas.profile', compact('petugas'));
    }

    public function deletePasien($id)
    {
        $this->pasienService->delete($id);
        return back()->with('success', 'Data pasien berhasil dihapus');
    }

    public function showPasien($id)
    {
        $pasien = \App\Models\Pasien::with(['user', 'keluarga.user'])->findOrFail($id);
        return response()->json($pasien);
    }

    public function storePasien(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'email_pasien' => 'required|string',
            'password_pasien' => 'required|min:6',
            'email_keluarga' => 'required|string',
            'password_keluarga' => 'required|min:6',
            'nomor_rm' => 'nullable|unique:pasien,nomor_rm',
            'nik' => 'nullable|digits:16|unique:pasien,nik',
        ], [
            'nomor_rm.unique' => 'Nomor RM sudah terdaftar.',
            'nik.unique' => 'NIK sudah terdaftar.',
            'nik.digits' => 'NIK harus terdiri dari 16 angka.',
        ]);

        // Custom validation for unique email or phone number
        $formatPhone = function($phone) {
            if (!$phone) return null;
            // Hanya sisakan angka
            $phone = preg_replace('/[^0-9]/', '', $phone);
            
            // Standarisasi ke format 08...
            if (str_starts_with($phone, '62')) {
                $phone = '0' . substr($phone, 2);
            } elseif (!str_starts_with($phone, '0')) {
                $phone = '0' . $phone;
            }
            
            return $phone;
        };

        // Validate Pasien Identifier
        $loginPasien = $request->email_pasien;
        $isEmailPasien = filter_var($loginPasien, FILTER_VALIDATE_EMAIL);
        $formattedLoginPasien = $isEmailPasien ? $loginPasien : $formatPhone($loginPasien);
        
        if ($isEmailPasien) {
            if (\App\Models\User::where('email', $formattedLoginPasien)->exists()) {
                return back()->withErrors(['email_pasien' => 'Email pasien sudah digunakan.'])->withInput();
            }
        } else {
            if (\App\Models\User::where('phone_number', $formattedLoginPasien)->exists()) {
                return back()->withErrors(['email_pasien' => 'Nomor HP pasien sudah digunakan.'])->withInput();
            }
        }

        // Validate Keluarga Identifier
        $loginKeluarga = $request->email_keluarga;
        if ($loginKeluarga === $loginPasien) {
            return back()->withErrors(['email_keluarga' => 'Login keluarga tidak boleh sama dengan login pasien.'])->withInput();
        }

        $isEmailKeluarga = filter_var($loginKeluarga, FILTER_VALIDATE_EMAIL);
        $formattedLoginKeluarga = $isEmailKeluarga ? $loginKeluarga : $formatPhone($loginKeluarga);

        if ($isEmailKeluarga) {
            if (\App\Models\User::where('email', $formattedLoginKeluarga)->exists()) {
                return back()->withErrors(['email_keluarga' => 'Email keluarga sudah digunakan.'])->withInput();
            }
        } else {
            if (\App\Models\User::where('phone_number', $formattedLoginKeluarga)->exists()) {
                return back()->withErrors(['email_keluarga' => 'Nomor HP keluarga sudah digunakan.'])->withInput();
            }
        }

        // Validate Additional Phone Numbers (no_hp and no_hp_keluarga)
        $hpPasien = $formatPhone($request->no_hp);
        $hpKeluarga = $formatPhone($request->no_hp_keluarga);

        if ($hpPasien && \App\Models\User::where('phone_number', $hpPasien)->exists()) {
            return back()->withErrors(['no_hp' => 'Nomor HP pasien sudah terdaftar di sistem.'])->withInput();
        }

        if ($hpKeluarga && \App\Models\User::where('phone_number', $hpKeluarga)->exists()) {
            return back()->withErrors(['no_hp_keluarga' => 'Nomor HP keluarga sudah terdaftar di sistem.'])->withInput();
        }

        if ($hpPasien && $hpKeluarga && $hpPasien === $hpKeluarga) {
            return back()->withErrors(['no_hp_keluarga' => 'Nomor HP keluarga tidak boleh sama dengan nomor HP pasien.'])->withInput();
        }

        try {
            \Illuminate\Support\Facades\DB::beginTransaction();

            // 1. Create Pasien User
            $userPasienData = [
                'name' => $request->nama,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password_pasien),
                'role' => 'pasien',
            ];
            if ($isEmailPasien) {
                $userPasienData['email'] = $formattedLoginPasien;
                $userPasienData['phone_number'] = $hpPasien;
            } else {
                $userPasienData['email'] = null;
                $userPasienData['phone_number'] = $formattedLoginPasien;
            }
            $userPasien = \App\Models\User::create($userPasienData);

            // 2. Create Keluarga User
            $userKeluargaData = [
                'name' => $request->nama_keluarga ?: 'Keluarga ' . $request->nama,
                'password' => \Illuminate\Support\Facades\Hash::make($request->password_keluarga),
                'role' => 'keluarga',
            ];
            if ($isEmailKeluarga) {
                $userKeluargaData['email'] = $formattedLoginKeluarga;
                $userKeluargaData['phone_number'] = $hpKeluarga;
            } else {
                $userKeluargaData['email'] = null;
                $userKeluargaData['phone_number'] = $formattedLoginKeluarga;
            }
            $userKeluarga = \App\Models\User::create($userKeluargaData);

            // 3. Create Pasien Profile
            \App\Models\Pasien::create([
                'user_id' => $userPasien->id,
                'petugas_id' => \Illuminate\Support\Facades\Auth::id(),
                'nama' => $request->nama,
                'nomor_rm' => $request->nomor_rm,
                'nik' => $request->nik,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'status_perkawinan' => $request->status_perkawinan,
                'alamat_lengkap' => $request->alamat_lengkap,
                'rt' => $request->rt,
                'rw' => $request->rw,
                'kabupaten' => $request->kabupaten,
                'kecamatan' => $request->kecamatan,
                'kode_pos' => $request->kode_pos,
                'provinsi' => $request->provinsi,
                'kelurahan' => $request->kelurahan,
                'no_hp' => $hpPasien,
                'no_registrasi_nasional' => $request->no_registrasi_nasional,
                'status_pasien' => $request->status_pasien ?: 'Hidup',
                'tanggal_awal_pengobatan' => $request->tanggal_awal_pengobatan,
                'lokasi_diagnosa' => $request->lokasi_diagnosa,
                'keterangan_pasien' => $request->keterangan_pasien,
            ]);

            // 4. Create Keluarga Profile
            \App\Models\Keluarga::create([
                'user_id' => $userKeluarga->id,
                'pasien_id' => $userPasien->id,
                'nama' => $request->nama_keluarga ?: 'Keluarga ' . $request->nama,
                'status_hubungan' => $request->status_hubungan,
                'no_hp' => $hpKeluarga,
                'alamat' => $request->alamat_keluarga,
                'rt' => $request->rt_keluarga,
                'rw' => $request->rw_keluarga,
                'kabupaten' => $request->kabupaten_keluarga,
                'kecamatan' => $request->kecamatan_keluarga,
                'kelurahan' => $request->kelurahan_keluarga,
                'provinsi' => $request->provinsi_keluarga,
            ]);

            \Illuminate\Support\Facades\DB::commit();
            return redirect()->route('petugas.data-pasien')->with('success', 'Selamat! Pasien ' . $request->nama . ' dan keluarganya telah berhasil didaftarkan ke dalam sistem.');

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mendaftarkan pasien: ' . $e->getMessage()])->withInput();
        }
    }



    public function updatePasien(Request $request, $id)
    {
        $pasien = \App\Models\Pasien::with(['user', 'keluarga'])->findOrFail($id);
        
        $formatPhone = function($phone) {
            if (!$phone) return null;
            $phone = trim($phone);
            if (substr($phone, 0, 1) !== '0' && substr($phone, 0, 1) !== '+') {
                $phone = '0' . $phone;
            }
            return $phone;
        };

        // Validasi Email / No HP Pasien
        if ($pasien->user && $request->email_pasien) {
            $loginPasien = $request->email_pasien;
            $isEmailPasien = filter_var($loginPasien, FILTER_VALIDATE_EMAIL);
            $formattedLoginPasien = $isEmailPasien ? $loginPasien : $formatPhone($loginPasien);
            
            if ($isEmailPasien) {
                if (\App\Models\User::where('email', $formattedLoginPasien)->where('id', '!=', $pasien->user_id)->exists()) {
                    return back()->withErrors(['email_pasien' => 'Email pasien telah digunakan.'])->withInput();
                }
            } else {
                if (\App\Models\User::where('phone_number', $formattedLoginPasien)->where('id', '!=', $pasien->user_id)->exists()) {
                    return back()->withErrors(['email_pasien' => 'Nomor HP pasien telah digunakan.'])->withInput();
                }
            }
        }

        // Validasi Email / No HP Keluarga
        if ($pasien->keluarga && $pasien->keluarga->user_id && $request->email_keluarga) {
            $loginKeluarga = $request->email_keluarga;
            $isEmailKeluarga = filter_var($loginKeluarga, FILTER_VALIDATE_EMAIL);
            $formattedLoginKeluarga = $isEmailKeluarga ? $loginKeluarga : $formatPhone($loginKeluarga);
            
            if ($isEmailKeluarga) {
                if (\App\Models\User::where('email', $formattedLoginKeluarga)->where('id', '!=', $pasien->keluarga->user_id)->exists()) {
                    return back()->withErrors(['email_keluarga' => 'Email keluarga telah digunakan.'])->withInput();
                }
            } else {
                if (\App\Models\User::where('phone_number', $formattedLoginKeluarga)->where('id', '!=', $pasien->keluarga->user_id)->exists()) {
                    return back()->withErrors(['email_keluarga' => 'Nomor HP keluarga telah digunakan.'])->withInput();
                }
            }
        }

        // 1. Update Pasien Profile
        $pasien->update($request->all());
        $pasien->update(['no_hp' => $formatPhone($request->no_hp)]);

        // 2. Update Pasien User (Login Identifier)
        if ($pasien->user) {
            $userData = ['name' => $request->nama];
            
            $loginPasien = $request->email_pasien;
            if ($loginPasien) {
                $isEmailPasien = filter_var($loginPasien, FILTER_VALIDATE_EMAIL);
                $formattedLogin = $isEmailPasien ? $loginPasien : $formatPhone($loginPasien);
                
                if ($isEmailPasien) {
                    $userData['email'] = $formattedLogin;
                    $userData['phone_number'] = $formatPhone($request->no_hp);
                } else {
                    $userData['email'] = null;
                    $userData['phone_number'] = $formattedLogin;
                }
            }
            
            if ($request->filled('password_pasien')) {
                $userData['password'] = \Illuminate\Support\Facades\Hash::make($request->password_pasien);
            }
            
            $pasien->user->update($userData);
        }

        // 3. Update Keluarga Profile
        if ($pasien->keluarga) {
            $pasien->keluarga->update([
                'nama' => $request->nama_keluarga,
                'status_hubungan' => $request->status_hubungan,
                'no_hp' => $formatPhone($request->no_hp_keluarga),
                'alamat' => $request->alamat_keluarga,
                'rt' => $request->rt_keluarga,
                'rw' => $request->rw_keluarga,
                'kabupaten' => $request->kabupaten_keluarga,
                'kecamatan' => $request->kecamatan_keluarga,
                'kelurahan' => $request->kelurahan_keluarga,
                'provinsi' => $request->provinsi_keluarga,
            ]);

            // Update Keluarga User (Login Identifier)
            if ($pasien->keluarga->user) {
                $userKData = ['name' => $request->nama_keluarga ?: 'Keluarga ' . $request->nama];
                
                $loginKeluarga = $request->email_keluarga;
                if ($loginKeluarga) {
                    $isEmailKeluarga = filter_var($loginKeluarga, FILTER_VALIDATE_EMAIL);
                    $formattedLoginK = $isEmailKeluarga ? $loginKeluarga : $formatPhone($loginKeluarga);
                    
                    if ($isEmailKeluarga) {
                        $userKData['email'] = $formattedLoginK;
                        $userKData['phone_number'] = $formatPhone($request->no_hp_keluarga);
                    } else {
                        $userKData['email'] = null;
                        $userKData['phone_number'] = $formattedLoginK;
                    }
                }
                
                if ($request->filled('password_keluarga')) {
                    $userKData['password'] = \Illuminate\Support\Facades\Hash::make($request->password_keluarga);
                }
                
                $pasien->keluarga->user->update($userKData);
            }
        }

        return redirect()->route('petugas.data-pasien')->with('success', 'Data pasien berhasil diperbarui');
    }


    public function storeKartuKendali(Request $request)
    {
        // Process medications with quantities
        $obat_diberikan = [];
        if ($request->has('obat_selected')) {
            foreach ($request->obat_selected as $nama) {
                $obat_diberikan[] = [
                    'nama' => $nama,
                    'jumlah' => $request->obat_jumlah[$nama] ?? 0
                ];
            }
        }

        \App\Models\KartuKendali::updateOrCreate(
            [
                'id_pasien' => $request->id_pasien,
                'tanggal_kunjungan' => $request->tanggal_kunjungan,
            ],
            [
                'id_petugas' => \Illuminate\Support\Facades\Auth::id(),
                'rencana_tanggal_kunjungan_selanjutnya' => $request->rencana_tanggal_kunjungan_selanjutnya,
                'obat_yang_diberikan' => $obat_diberikan,
                'rejimen_arv' => null, // No longer used as separate field
                'jumlah_arv_tersisa' => null, // No longer used as separate field
                'jumlah_inh_yang_tersisa' => $request->jumlah_inh_tersisa,
                'jumlah_inh_yang_diberikan_untuk_bulan_berikutnya' => $request->jumlah_inh_diberikan_untuk_bulan_berikutnya,
                'efek_samping_dan_lab_profilaksis' => $request->efek_samping_arv_io_proflaksis,
                'catatan' => $request->catatan,
            ]
        );

        // Sync to Pasien table for faster querying/sorting
        $pasien = \App\Models\Pasien::find($request->id_pasien);
        if ($pasien) {
            $pasien->update([
                'tanggal_kunjungan_terakhir' => $request->tanggal_kunjungan,
                'rencana_kunjungan_berikutnya' => $request->rencana_tanggal_kunjungan_selanjutnya,
                'status_kunjungan' => 'Active',
            ]);
        }

        // Kirim Notifikasi ke Pasien & Keluarga (Hanya jika ada rencana kunjungan selanjutnya)
        if ($request->rencana_tanggal_kunjungan_selanjutnya) {
            \App\Models\Notifikasi::sendToPatientAndFamily(
                $request->id_pasien,
                'Jadwal Kontrol Terupdate',
                'Data kunjungan hari ini telah disimpan/diperbarui. Rencana kunjungan berikutnya: ' . \Carbon\Carbon::parse($request->rencana_tanggal_kunjungan_selanjutnya)->translatedFormat('d F Y') . '.',
                'info'
            );
        }

        return back()->with('success', 'Kartu kendali berhasil disimpan/diperbarui');
    }

    public function storeLaporanEvaluasi(Request $request)
    {
        \App\Models\LaporanEvaluasi::updateOrCreate(
            [
                'id_pasien' => $request->id_pasien,
                'kunjungan' => $request->kunjungan,
            ],
            [
                'id_petugas' => \Illuminate\Support\Facades\Auth::id(),
                'tanggal' => $request->tanggal,
                'standar_klinis' => $request->standar_klinis,
                'hasil_arv_terakhir' => $request->hasil_arv_terakhir,
                'status_viral_load' => $request->status_viral_load,
                'status_fungsional' => $request->status_fungsional,
                'jumlah_cd4' => $request->jumlah_cd4,
                'berat_badan' => $request->berat_badan,
                'catatan' => $request->catatan,
            ]
        );

        return back()->with('success', 'Laporan evaluasi berhasil disimpan/diperbarui');
    }

    public function storeViralLoad(Request $request)
    {
        \App\Models\DataPengobatan::create([
            'id_pasien' => $request->id_pasien,
            'id_petugas' => \Illuminate\Support\Facades\Auth::id(),
            'kategori_viral_load' => $request->kategori_viral_load,
            'tanggal' => $request->tanggal,
            'nilai_viral_load' => $request->nilai_viral_load,
            'status_viral_load' => $request->nilai_viral_load < 50 ? 'Terdeteksi Rendah (TND)' : 'Terdeteksi',
            'keterangan' => $request->keterangan,
        ]);

        // Kirim Notifikasi ke Pasien & Keluarga
        \App\Models\Notifikasi::sendToPatientAndFamily(
            $request->id_pasien,
            'Hasil Viral Load Terbit',
            'Hasil pemeriksaan Viral Load tanggal ' . \Carbon\Carbon::parse($request->tanggal)->translatedFormat('d F Y') . ' telah tersedia di sistem. Nilai: ' . $request->nilai_viral_load . ' copies/mL.',
            'success'
        );

        return back()->with('success', 'Data Viral Load berhasil disimpan dan notifikasi telah dikirim');
    }

    public function updateProfile(Request $request)
    {
        $user = \Illuminate\Support\Facades\Auth::user();
        $petugas = $user->petugas;

        $request->validate([
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'no_hp' => 'required|string|max:20',
            'alamat' => 'nullable|string|max:500',
            'nip' => 'nullable|string|max:50',
            'jenis_kelamin' => 'nullable|string',
            'tanggal_lahir' => 'nullable|date',
        ]);

        $user->update([
            'name' => $request->nama,
            'email' => $request->email,
        ]);

        if ($request->hasFile('foto_profil')) {
            // Hapus foto lama jika ada
            if ($user->foto_profil) {
                Storage::disk('public')->delete($user->foto_profil);
            }
            
            $file = $request->file('foto_profil');
            $path = $file->store('profile-photos', 'public');
            $user->update(['foto_profil' => $path]);
        }

        $petugas->update([
            'nama' => $request->nama,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'nip' => $request->nip,
            'jenis_kelamin' => $request->jenis_kelamin,
            'tanggal_lahir' => $request->tanggal_lahir,
        ]);

        return back()->with('success', 'Profil berhasil diperbarui');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'old_password' => 'required',
            'new_password' => 'required|min:6|confirmed',
        ]);

        $user = \Illuminate\Support\Facades\Auth::user();

        if (!\Illuminate\Support\Facades\Hash::check($request->old_password, $user->password)) {
            return back()->withErrors(['old_password' => 'Password lama tidak sesuai']);
        }

        $user->update([
            'password' => \Illuminate\Support\Facades\Hash::make($request->new_password),
        ]);

        return back()->with('success', 'Password berhasil diubah');
    }

    public function riwayatKartuKendali($id)
    {
        $pasien = \App\Models\Pasien::with(['kartuKendali' => function($q) {
            $q->orderBy('tanggal_kunjungan', 'desc');
        }, 'user'])->findOrFail($id);

        return response()->json([
            'pasien' => $pasien,
            'riwayat' => $pasien->kartuKendali
        ]);
    }

    public function riwayatLaporanEvaluasi($id)
    {
        $pasien = \App\Models\Pasien::with(['laporanEvaluasi' => function($q) {
            $q->orderBy('tanggal', 'desc');
        }, 'user'])->findOrFail($id);

        return response()->json([
            'pasien' => $pasien,
            'riwayat' => $pasien->laporanEvaluasi
        ]);
    }
}
