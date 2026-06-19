@extends('layouts.keluarga')

@section('title', 'Dashboard Keluarga')
@section('page-title', 'Overview')

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

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 30px;
            display: flex;
            align-items: center;
            gap: 22px;
            transition: all 0.3s ease;
            box-shadow: 0 10px 25px rgba(213, 224, 235, 0.3);
            border: 1px solid #f1f5f9;
        }

        .stat-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(213, 224, 235, 0.5);
        }

        .stat-icon {
            width: 65px;
            height: 65px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            flex-shrink: 0;
        }

        .icon-blue { background: #eff6ff; color: #2563eb; }
        .icon-green { background: #f0fdf4; color: #16a34a; }
        .icon-purple { background: #faf5ff; color: #9333ea; }

        .stat-info h3 {
            font-size: 14px;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 5px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .stat-info p {
            font-size: 22px;
            font-weight: 900;
            color: #1e293b;
        }

        .history-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(213, 224, 235, 0.3);
            border: 1px solid #f1f5f9;
        }

        .card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .card-header h2 {
            font-size: 20px;
            font-weight: 900;
            color: #1e293b;
        }

        .modern-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .modern-table th {
            padding: 0 20px 10px;
            text-align: left;
            font-size: 13px;
            font-weight: 800;
            color: #94a3b8;
            text-transform: uppercase;
        }

        .modern-table tr td {
            background: #f8fafc;
            padding: 20px;
            font-size: 15px;
            font-weight: 600;
            color: #334155;
            transition: all 0.2s;
        }

        .modern-table tr td:first-child { border-radius: 15px 0 0 15px; }
        .modern-table tr td:last-child { border-radius: 0 15px 15px 0; }

        .modern-table tr:hover td {
            background: #f1f5f9;
            transform: scale(1.002);
        }

        .badge {
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
        }

        .badge-success { background: #dcfce7; color: #166534; }
        .badge-warning { background: #fef9c3; color: #854d0e; }
        .badge-danger { background: #fee2e2; color: #991b1b; }

        @media (max-width: 768px) {
            .welcome-banner { padding: 30px; }
            .welcome-banner h1 { font-size: 24px; }
            .pasien-main { padding: 25px; }
        }
    </style>

    <div class="welcome-banner">
        <h1 style="font-size: 32px; font-weight: 900; margin-bottom: 10px;">Halo, {{ Auth::user()->name }}!</h1>
        <p style="font-size: 18px; opacity: 0.9; font-weight: 500;">
            Pantau terus kondisi kesehatan <strong>{{ $pasien->nama }}</strong> melalui portal ini.
        </p>
    </div>

    <div class="summary-grid">
        <div class="stat-card">
            <div class="stat-icon icon-blue">
                <i class="fa-solid fa-calendar-check"></i>
            </div>
            <div class="stat-info">
                <h3>Jadwal Berikutnya</h3>
                <p>{{ $jadwal_mendatang }}</p>
                <small style="color: #10b981; font-weight: 700;">
                    @if($selisih_hari !== null)
                        @if($selisih_hari > 0) {{ $selisih_hari }} Hari Lagi
                        @elseif($selisih_hari < 0) Terlewat {{ abs($selisih_hari) }} Hari
                        @else Hari Ini @endif
                    @else - @endif
                </small>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-green">
                <i class="fa-solid fa-virus-covid"></i>
            </div>
            <div class="stat-info">
                <h3>Status Pengobatan</h3>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <span class="badge 
                        {{ $pasien->display_status == 'Active' ? 'badge-success' : ($pasien->display_status == 'LTFU' ? 'badge-danger' : 'badge-warning') }}">
                        {{ $pasien->display_status }}
                    </span>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-icon icon-purple">
                <i class="fa-solid fa-dna"></i>
            </div>
            <div class="stat-info">
                <h3>Status Viral Load</h3>
                <p style="font-size: 16px;">{{ $pasien->viral_load_status ?? 'Terpantau' }}</p>
            </div>
        </div>
    </div>

    <div class="history-card">
        <div class="card-header">
            <h2>Riwayat Kunjungan Terakhir (Pasien)</h2>
        </div>

        <table class="modern-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Jenis Kunjungan</th>
                    <th>Catatan Petugas</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($riwayats as $riwayat)
                    <tr>
                        <td>
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fa-regular fa-calendar" style="color: #10b981;"></i>
                                {{ \Carbon\Carbon::parse($riwayat->tanggal_kunjungan)->format('d M Y') }}
                            </div>
                        </td>
                        <td data-label="Jenis Kunjungan">Kontrol & Pengambilan Obat</td>
                        <td data-label="Catatan Petugas">{{ $riwayat->catatan ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #94a3b8; padding: 40px;">
                            Belum ada riwayat kunjungan.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- RIWAYAT VIRAL LOAD -->
    <div class="history-card" style="margin-top: 30px;">
        <div class="card-header">
            <h2 style="display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-vial-circle-check" style="color: #6366f1;"></i>
                Riwayat Pemeriksaan Viral Load
            </h2>
        </div>

        <table class="modern-table">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Tahap Kunjungan</th>
                    <th>Status Viral Load</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($vl_riwayats as $vl)
                    <tr>
                        <td data-label="Tanggal">
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <i class="fa-regular fa-calendar" style="color: #6366f1;"></i>
                                {{ \Carbon\Carbon::parse($vl->tanggal)->format('d M Y') }}
                            </div>
                        </td>
                        <td data-label="Tahap Kunjungan">{{ $vl->kunjungan }}</td>
                        <td data-label="Status Viral Load">
                            @php
                                $statusText = $vl->status_viral_load;
                                $badgeStyle = 'background: #eef2ff; color: #4f46e5; border: 1px solid #e0e7ff;';
                                
                                if (str_contains($statusText, 'Sudah')) {
                                    $statusText = str_replace('Sudah Dilakukan Viraload ', 'Selesai (', $statusText);
                                    if (str_contains($statusText, 'Selesai (')) $statusText .= ')';
                                    $badgeStyle = 'background: #ecfdf5; color: #059669; border: 1px solid #a7f3d0;';
                                } elseif (str_contains($statusText, 'Belum')) {
                                    $badgeStyle = 'background: #fffbeb; color: #d97706; border: 1px solid #fde68a;';
                                }
                            @endphp
                            <span style="display: inline-block; padding: 6px 12px; border-radius: 8px; font-size: 12px; font-weight: 700; {{ $badgeStyle }}">
                                {{ $statusText }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" style="text-align: center; color: #94a3b8; padding: 40px;">
                            Belum ada data riwayat Viral Load.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

@endsection