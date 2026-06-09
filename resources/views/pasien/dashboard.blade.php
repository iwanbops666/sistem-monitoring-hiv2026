@extends('layouts.pasien')

@section('title', 'Dashboard Pasien')
@section('page-title', 'Dashboard')

@section('content')
    <style>
        .pasien-dashboard {
            max-width: 1080px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .welcome-banner {
            margin-bottom: 35px;
        }

        .welcome-banner h1 {
            font-size: 28px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 6px;
        }

        .welcome-banner p {
            color: #6b7280;
            font-size: 16px;
            font-weight: 500;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            margin-bottom: 40px;
        }

        .summary-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 28px;
            box-shadow: 0 10px 25px rgba(213, 224, 235, 0.3);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            border: 1px solid #f1f5f9;
        }

        .summary-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(213, 224, 235, 0.5);
        }

        .summary-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
        }

        .card-jadwal::before { background: #3b82f6; }
        .card-status::before { background: #10b981; }
        .card-vl::before { background: #f59e0b; }

        .summary-icon-box {
            width: 56px;
            height: 56px;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            margin-bottom: 20px;
        }

        .summary-info h3 {
            font-size: 14px;
            font-weight: 700;
            color: #9ca3af;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 8px;
        }

        .summary-info .main-val {
            font-size: 24px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 12px;
            display: block;
        }

        .summary-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 700;
        }

        .badge-blue { background: #eff6ff; color: #2563eb; }
        .badge-green { background: #ecfdf5; color: #10b981; }
        .badge-red { background: #fef2f2; color: #ef4444; }
        .badge-amber { background: #fffbeb; color: #d97706; }

        .riwayat-section {
            background: #ffffff;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(213, 224, 235, 0.3);
            border: 1px solid #f1f5f9;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
        }

        .section-header h2 {
            font-size: 20px;
            font-weight: 900;
            color: #111827;
        }

        .btn-view-all {
            color: #10b981;
            font-weight: 700;
            font-size: 14px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px;
            transition: gap 0.2s;
        }

        .btn-view-all:hover { gap: 10px; }

        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .custom-table th {
            text-align: left;
            padding: 0 15px 10px;
            color: #9ca3af;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .custom-table tr td {
            background: #f8fafc;
            padding: 18px 15px;
            color: #374151;
            font-size: 14px;
            transition: background 0.2s;
        }

        .custom-table tr td:first-child { border-radius: 12px 0 0 12px; font-weight: 700; }
        .custom-table tr td:last-child { border-radius: 0 12px 12px 0; text-align: right; }

        .custom-table tr:hover td { background: #f1f5f9; }

        .kunjungan-type {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: #6366f1;
            font-weight: 600;
        }

        @media (max-width: 1024px) {
            .summary-grid { grid-template-columns: repeat(2, 1fr); }
        }

        @media (max-width: 640px) {
            .summary-grid { grid-template-columns: 1fr; }
            .section-header { flex-direction: column; align-items: flex-start; gap: 15px; }
        }
    </style>

    <div class="pasien-dashboard">
        <div class="welcome-banner">
            <h1>Halo, {{ explode(' ', Auth::user()->name)[0] }}! 👋</h1>
            <p>Selamat datang kembali. Berikut adalah rangkuman kesehatan Anda hari ini.</p>
        </div>

        <div class="summary-grid">
            {{-- CARD JADWAL --}}
            <div class="summary-card card-jadwal">
                <div class="summary-icon-box" style="background: #eff6ff; color: #3b82f6;">
                    <i class="fa-regular fa-calendar-check"></i>
                </div>
                <div class="summary-info">
                    <h3>Jadwal Berikutnya</h3>
                    <span class="main-val">{{ $jadwal_mendatang }}</span>
                    @if ($selisih_hari !== null)
                        @if ($selisih_hari > 0)
                            <span class="summary-badge badge-blue"><i class="fa-solid fa-clock"></i> {{ $selisih_hari }} Hari Lagi</span>
                        @elseif ($selisih_hari < 0)
                            <span class="summary-badge badge-red"><i class="fa-solid fa-circle-exclamation"></i> Terlewat {{ abs($selisih_hari) }} Hari</span>
                        @else
                            <span class="summary-badge badge-amber"><i class="fa-solid fa-star"></i> Hari Ini</span>
                        @endif
                    @else
                        <span class="summary-badge" style="background: #f1f5f9; color: #9ca3af;">Belum ada jadwal</span>
                    @endif
                </div>
            </div>

            {{-- CARD STATUS --}}
            <div class="summary-card card-status">
                <div class="summary-icon-box" style="background: #ecfdf5; color: #10b981;">
                    <i class="fa-solid fa-shield-heart"></i>
                </div>
                <div class="summary-info">
                    <h3>Status Pengobatan</h3>
                    <span class="main-val">{{ $pasien->display_status }}</span>
                    @if($pasien->display_status == 'Active')
                        <span class="summary-badge badge-green"><i class="fa-solid fa-circle-check"></i> Kondisi Stabil</span>
                    @else
                        <span class="summary-badge badge-red"><i class="fa-solid fa-circle-xmark"></i> Perlu Perhatian</span>
                    @endif
                </div>
            </div>

            {{-- CARD VL STATUS --}}
            <div class="summary-card card-vl">
                <div class="summary-icon-box" style="background: #fffbeb; color: #f59e0b;">
                    <i class="fa-solid fa-vial-virus"></i>
                </div>
                <div class="summary-info">
                    <h3>Status Viral Load</h3>
                    <span class="main-val" style="font-size: 18px;">{{ $pasien->viral_load_status }}</span>
                    <span class="summary-badge badge-amber"><i class="fa-solid fa-microscope"></i> Pemeriksaan Rutin</span>
                </div>
            </div>

            </div>
        </div>

        <section class="riwayat-section">
            <div class="section-header">
                <h2>Aktivitas Kunjungan Terakhir</h2>
                <a href="{{ url('/pasien/kartu-kendali') }}" class="btn-view-all">
                    Lihat Semua Riwayat <i class="fa-solid fa-arrow-right-long"></i>
                </a>
            </div>

            <div style="overflow-x: auto;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Tanggal Kunjungan</th>
                            <th>Keterangan</th>
                            <th>Status Catatan</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($riwayats as $riwayat)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($riwayat->tanggal_kunjungan)->format('d M Y') }}</td>
                                <td data-label="Keterangan">
                                    <span class="kunjungan-type">
                                        <i class="fa-solid fa-pills"></i> Kontrol & Obat
                                    </span>
                                </td>
                                <td data-label="Catatan">{{ Str::limit($riwayat->catatan ?? '-', 40) }}</td>
                                <td>
                                    <i class="fa-solid fa-chevron-right" style="color: #cbd5e1; font-size: 12px;"></i>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; padding: 40px; background: #ffffff; color: #9ca3af;">
                                    Belum ada riwayat aktivitas.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>
@endsection