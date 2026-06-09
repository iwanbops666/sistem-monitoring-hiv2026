@extends('layouts.app')

@section('title', 'Dashboard Overview')

@section('content')
    <style>
        .welcome-banner {
            background: linear-gradient(135deg, #065f46 0%, #059669 100%);
            border-radius: 24px;
            padding: 40px;
            color: #ffffff;
            margin-bottom: 35px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(6, 95, 70, 0.2);
            animation: fadeIn 0.6s ease;
        }

        .welcome-banner::after {
            content: '';
            position: absolute;
            right: -50px;
            top: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 20px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(213, 224, 235, 0.3);
            border: 1px solid #f1f5f9;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(213, 224, 235, 0.5);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .icon-emerald { background: #ecfdf5; color: #10b981; }
        .icon-blue { background: #eff6ff; color: #3b82f6; }
        .icon-amber { background: #fffbeb; color: #f59e0b; }
        .icon-rose { background: #fff1f2; color: #f43f5e; }

        .stat-info h3 {
            font-size: 13px;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info p {
            font-size: 24px;
            font-weight: 900;
            color: #1e293b;
        }

        .chart-container {
            background: #ffffff;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(213, 224, 235, 0.3);
            border: 1px solid #f1f5f9;
            margin-bottom: 30px;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
        }

        .chart-header h2 {
            font-size: 20px;
            font-weight: 900;
            color: #1e293b;
        }
    </style>

    <div class="welcome-banner">
        <h1 style="font-size: 32px; font-weight: 900; margin-bottom: 10px;">Halo, {{ Auth::user()->name }}!</h1>
        <p style="font-size: 18px; opacity: 0.9; font-weight: 500;">
            Selamat datang di sistem monitoring kesehatan. Pantau dan kelola data pasien dengan mudah.
        </p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon icon-emerald">
                <i class="fa-solid fa-users"></i>
            </div>
            <div class="stat-info">
                <h3>Total Pasien</h3>
                <p>{{ $totalPasien }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div class="stat-info">
                <h3>Pasien Aktif</h3>
                <p>{{ $pasienAktif }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-amber">
                <i class="fa-solid fa-user-clock"></i>
            </div>
            <div class="stat-info">
                <h3>Pasien LTFU</h3>
                <p>{{ $pasienLtfu }}</p>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-rose">
                <i class="fa-solid fa-user-minus"></i>
            </div>
            <div class="stat-info">
                <h3>Pasien Meninggal</h3>
                <p>{{ $pasienMeninggal }}</p>
            </div>
        </div>
    </div>

    <div class="chart-container">
        <div class="chart-header">
            <h2 style="font-size: 20px; font-weight: 900; color: #1e293b;">
                <i class="fa-solid fa-bell" style="color: #f59e0b; margin-right: 8px;"></i>
                Pasien Belum Kontrol Minggu Ini
            </h2>
            <div class="badge badge-warning" style="background: #fffbeb; color: #d97706; border: 1px solid #fde68a; font-weight: 800; font-size: 11px; padding: 6px 12px; border-radius: 8px;">
                <i class="fa-solid fa-clock-rotate-left"></i> > 7 Hari Belum Update
            </div>
        </div>
        
        <div class="table-responsive" style="border: none; margin: 0; overflow: visible;">
            <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
                <thead>
                    <tr style="background: transparent;">
                        <th style="padding: 10px 15px; font-size: 12px; color: #64748b; font-weight: 800; border: none; text-transform: uppercase; letter-spacing: 0.5px;">Nama Pasien</th>
                        <th style="padding: 10px 15px; font-size: 12px; color: #64748b; font-weight: 800; border: none; text-transform: uppercase; letter-spacing: 0.5px;">Nomor RM</th>
                        <th style="padding: 10px 15px; font-size: 12px; color: #64748b; font-weight: 800; border: none; text-transform: uppercase; letter-spacing: 0.5px;">Kunjungan Terakhir</th>
                        <th style="padding: 10px 15px; font-size: 12px; color: #64748b; font-weight: 800; border: none; text-align: right; text-transform: uppercase; letter-spacing: 0.5px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pasienBelumKontrol as $pbk)
                        <tr style="background: #f8fafc; transition: all 0.2s; border-radius: 12px;">
                            <td style="padding: 15px; border-radius: 15px 0 0 15px; border: none; font-weight: 800; color: #1e293b;">
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <div style="width: 32px; height: 32px; background: #ffffff; border-radius: 8px; display: flex; align-items: center; justify-content: center; color: #64748b; font-size: 12px; border: 1px solid #e2e8f0;">
                                        {{ substr($pbk->nama, 0, 1) }}
                                    </div>
                                    {{ $pbk->nama }}
                                </div>
                            </td>
                            <td style="padding: 15px; border: none;"><code style="background: #ffffff; padding: 4px 8px; border-radius: 6px; font-weight: 700; border: 1.5px solid #e2e8f0; color: #475569;">{{ $pbk->nomor_rm }}</code></td>
                            <td style="padding: 15px; border: none; color: #64748b; font-weight: 700; font-size: 13px;">
                                @php
                                    $lastVisit = $pbk->kartuKendali()->orderByDesc('tanggal_kunjungan')->first();
                                @endphp
                                <i class="fa-regular fa-calendar-check" style="margin-right: 5px; opacity: 0.5;"></i>
                                {{ $lastVisit ? \Carbon\Carbon::parse($lastVisit->tanggal_kunjungan)->translatedFormat('d F Y') : 'Belum Ada Data' }}
                            </td>
                            <td style="padding: 15px; border-radius: 0 15px 15px 0; border: none; text-align: right;">
                                <a href="{{ route('petugas.data-kepatuhan-pasien', ['search' => $pbk->nomor_rm]) }}" class="badge badge-warning" style="background: #fff7ed; color: #ea580c; padding: 8px 14px; border-radius: 10px; font-size: 11px; font-weight: 800; text-decoration: none; border: 1px solid #ffedd5; transition: all 0.2s;">
                                    <i class="fa-solid fa-arrow-right"></i> Cek Pasien
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" style="text-align: center; padding: 60px; color: #94a3b8; background: #f8fafc; border-radius: 20px; border: 2px dashed #e2e8f0;">
                                <div style="width: 60px; height: 60px; background: #f0fdf4; color: #10b981; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 15px; font-size: 24px;">
                                    <i class="fa-solid fa-check-double"></i>
                                </div>
                                <h4 style="color: #1e293b; font-weight: 800; margin-bottom: 5px;">Semua Pasien Aman</h4>
                                <p style="font-size: 14px; font-weight: 500;">Semua pasien sudah melakukan kontrol dalam 7 hari terakhir.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection