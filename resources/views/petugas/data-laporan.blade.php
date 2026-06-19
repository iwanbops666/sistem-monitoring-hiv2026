@extends('layouts.app')

@section('title', 'Data Laporan Statistik')

@section('content')
    <style>
        .laporan-container {
            max-width: 1200px;
            animation: fadeIn 0.5s ease;
        }

        .filter-section {
            background: #ffffff;
            border-radius: 24px;
            padding: 30px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(213, 224, 235, 0.3);
            border: 1px solid #f1f5f9;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr 1fr;
            gap: 20px;
            align-items: end;
        }

        .filter-group label {
            font-size: 13px;
            font-weight: 800;
            color: #64748b;
            margin-bottom: 8px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            height: 45px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 0 15px;
            font-size: 14px;
            background: #f8fafc;
            color: #1e293b;
        }

        .summary-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 25px;
            margin-bottom: 35px;
        }

        .summary-card-mini {
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

        .summary-card-mini:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(213, 224, 235, 0.5);
        }

        .mini-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .chart-row {
            display: grid;
            grid-template-columns: 1.5fr 1fr 1fr;
            gap: 20px;
            margin-bottom: 30px;
        }

        .chart-box {
            background: #ffffff;
            border-radius: 24px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(213, 224, 235, 0.3);
            border: 1px solid #f1f5f9;
            text-align: center;
        }

        .chart-box h4 {
            font-size: 15px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 20px;
        }

        .donut-container {
            width: 160px;
            height: 160px;
            margin: 0 auto 15px;
            position: relative;
            border-radius: 50%;
        }

        .donut-center {
            position: absolute;
            width: 80px;
            height: 80px;
            background: #ffffff;
            border-radius: 50%;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 900;
            font-size: 18px;
            color: #1e293b;
        }

        .export-btn {
            background: #ffffff;
            border: 1.5px solid #10b981;
            color: #10b981;
            padding: 10px 20px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }

        .export-btn:hover {
            background: #10b981;
            color: #ffffff;
        }

        @media (max-width: 1100px) {
            .chart-row { grid-template-columns: 1fr; }
            .summary-row { grid-template-columns: repeat(2, 1fr); }
            .filter-grid { grid-template-columns: 1fr 1fr; }
        }

        @media (max-width: 650px) {
            .summary-row { grid-template-columns: 1fr; }
        }
    </style>

    <div class="laporan-container">
        {{-- FILTER --}}
        <section class="filter-section">
            <h3 style="font-size: 18px; font-weight: 900; color: #111827; margin-bottom: 20px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-filter" style="color: #10b981;"></i> Filter Laporan
            </h3>
            <form action="{{ route('petugas.data-laporan') }}" method="GET">
                <div class="filter-grid" style="grid-template-columns: 2fr 1fr 1.2fr 1.2fr auto;">
                    <div class="filter-group">
                        <label>Jenis Laporan</label>
                        <select name="jenis_laporan">
                            <option value="Laporan Jumlah Pasien Baru" {{ request('jenis_laporan') == 'Laporan Jumlah Pasien Baru' ? 'selected' : '' }}>1. Laporan Jumlah Pasien Baru</option>
                            <option value="Jumlah Pasien Mulai Pengobatan" {{ request('jenis_laporan') == 'Jumlah Pasien Mulai Pengobatan' ? 'selected' : '' }}>2. Jumlah Pasien Mulai Pengobatan</option>
                            <option value="Jumlah Pasien Active" {{ request('jenis_laporan') == 'Jumlah Pasien Active' ? 'selected' : '' }}>3. Jumlah Pasien Active</option>
                            <option value="Jumlah Pasien Inactive" {{ request('jenis_laporan') == 'Jumlah Pasien Inactive' ? 'selected' : '' }}>4. Jumlah Pasien Inactive</option>
                            <option value="Jumlah Pasien Lost Follow Up (LTFU)" {{ request('jenis_laporan') == 'Jumlah Pasien Lost Follow Up (LTFU)' ? 'selected' : '' }}>5. Jumlah Pasien Lost Follow Up (LTFU)</option>
                            <option value="Jumlah Pasien Berobat" {{ request('jenis_laporan') == 'Jumlah Pasien Berobat' ? 'selected' : '' }}>6. Jumlah Pasien Berobat</option>
                            <option value="Jumlah Pasien Meninggal" {{ request('jenis_laporan') == 'Jumlah Pasien Meninggal' ? 'selected' : '' }}>7. Jumlah Pasien Meninggal</option>
                            <option value="Jumlah Pasien Pindahan" {{ request('jenis_laporan') == 'Jumlah Pasien Pindahan' ? 'selected' : '' }}>8. Jumlah Pasien Pindahan</option>
                            <option value="Jumlah Pasien Pindah Pengobatan" {{ request('jenis_laporan') == 'Jumlah Pasien Pindah Pengobatan' ? 'selected' : '' }}>9. Jumlah Pasien Pindah Pengobatan</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Periode</label>
                        <select name="periode">
                            <option value="Bulan" {{ request('periode') == 'Bulan' ? 'selected' : '' }}>Bulanan</option>
                            <option value="Tahun" {{ request('periode') == 'Tahun' ? 'selected' : '' }}>Tahunan</option>
                        </select>
                    </div>
                    <div class="filter-group">
                        <label>Mulai Tanggal</label>
                        <input type="date" name="dari_tanggal" value="{{ request('dari_tanggal', date('Y-m-01')) }}">
                    </div>
                    <div class="filter-group">
                        <label>Sampai Tanggal</label>
                        <input type="date" name="sampai_tanggal" value="{{ request('sampai_tanggal', date('Y-m-t')) }}">
                    </div>
                    <div class="filter-group" style="display: flex; gap: 10px;">
                        <button type="submit" style="height: 45px; padding: 0 25px; background: linear-gradient(135deg, #065f46 0%, #059669 100%); color: white; border: none; border-radius: 12px; font-weight: 800; font-size: 14px; cursor: pointer; transition: all 0.3s; display: flex; align-items: center; gap: 8px; box-shadow: 0 8px 20px rgba(6, 95, 70, 0.25);">
                            <i class="fa-solid fa-sync"></i> Terapkan
                        </button>
                        <a href="{{ route('petugas.data-laporan') }}" title="Reset Filter" style="height: 45px; width: 45px; background: #f1f5f9; color: #64748b; border-radius: 12px; display: flex; align-items: center; justify-content: center; text-decoration: none; transition: all 0.2s;">
                            <i class="fa-solid fa-rotate-left"></i>
                        </a>
                    </div>
                </div>
            </form>
        </section>

        {{-- SUMMARY --}}
        <section class="summary-row">
            <div class="summary-card-mini">
                <div class="mini-icon" style="background: #f1f5f9; color: #475569;"><i class="fa-solid fa-users"></i></div>
                <div>
                    <h3 style="font-size: 13px; font-weight: 700; color: #64748b; margin: 0 0 5px; text-transform: uppercase; letter-spacing: 0.5px;">Total Register</h3>
                    <p style="font-size: 24px; font-weight: 900; color: #1e293b; margin: 0;">{{ $total_semua }}</p>
                </div>
            </div>
            <div class="summary-card-mini">
                <div class="mini-icon" style="background: #ecfdf5; color: #10b981;"><i class="fa-solid fa-user-shield"></i></div>
                <div>
                    <h3 style="font-size: 13px; font-weight: 700; color: #64748b; margin: 0 0 5px; text-transform: uppercase; letter-spacing: 0.5px;">Pasien Hidup</h3>
                    <p style="font-size: 24px; font-weight: 900; color: #1e293b; margin: 0;">{{ $total_pasien }}</p>
                </div>
            </div>
            <div class="summary-card-mini">
                <div class="mini-icon" style="background: #eff6ff; color: #3b82f6;"><i class="fa-solid fa-user-check"></i></div>
                <div>
                    <h3 style="font-size: 13px; font-weight: 700; color: #64748b; margin: 0 0 5px; text-transform: uppercase; letter-spacing: 0.5px;">Aktif</h3>
                    <p style="font-size: 24px; font-weight: 900; color: #1e293b; margin: 0;">{{ $pasien_aktif }}</p>
                </div>
            </div>
            <div class="summary-card-mini">
                <div class="mini-icon" style="background: #fffbeb; color: #f59e0b;"><i class="fa-solid fa-user-minus"></i></div>
                <div>
                    <h3 style="font-size: 13px; font-weight: 700; color: #64748b; margin: 0 0 5px; text-transform: uppercase; letter-spacing: 0.5px;">Meninggal</h3>
                    <p style="font-size: 24px; font-weight: 900; color: #1e293b; margin: 0;">{{ $pasien_inactive }}</p>
                </div>
            </div>
            <div class="summary-card-mini">
                <div class="mini-icon" style="background: #fff1f2; color: #f43f5e;"><i class="fa-solid fa-user-slash"></i></div>
                <div>
                    <h3 style="font-size: 13px; font-weight: 700; color: #64748b; margin: 0 0 5px; text-transform: uppercase; letter-spacing: 0.5px;">Pasien Lost Follow Up</h3>
                    <p style="font-size: 24px; font-weight: 900; color: #1e293b; margin: 0;">{{ $pasien_ltfu }}</p>
                </div>
            </div>
            <div class="summary-card-mini">
                <div class="mini-icon" style="background: #f0fdf4; color: #15803d;"><i class="fa-solid fa-user-plus"></i></div>
                <div>
                    <h3 style="font-size: 13px; font-weight: 700; color: #64748b; margin: 0 0 5px; text-transform: uppercase; letter-spacing: 0.5px;">Pasien Baru</h3>
                    <p style="font-size: 24px; font-weight: 900; color: #1e293b; margin: 0;">{{ $pasien_baru }}</p>
                </div>
            </div>
        </section>

        {{-- CHARTS --}}
        <section class="chart-row">
            <div class="chart-box">
                <h4>Statistik Pasien Baru ({{ $tahun_grafik }})</h4>
                <div style="height: 200px; display: flex; align-items: flex-end; justify-content: space-between; gap: 8px; padding: 20px 10px; background: #f8fafc; border-radius: 18px; position: relative;">
                    @php
                        $maxVal = max($chart_data_baru) ?: 1;
                        $monthLabels = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    @endphp
                    @foreach($chart_data_baru as $idx => $val)
                        <div style="flex: 1; display: flex; flex-direction: column; align-items: center; gap: 8px; height: 100%; justify-content: flex-end;">
                            <div style="width: 100%; height: {{ ($val / $maxVal) * 100 }}%; background: linear-gradient(to top, #059669, #34d399); border-radius: 6px 6px 4px 4px; position: relative; min-height: 2px; transition: all 0.3s;" title="{{ $val }} Pasien">
                                @if($val > 0)
                                    <span style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); font-size: 10px; font-weight: 900; color: #065f46;">{{ $val }}</span>
                                @endif
                            </div>
                            <span style="font-size: 9px; font-weight: 800; color: #94a3b8; text-transform: uppercase;">{{ $monthLabels[$idx] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="chart-box">
                <h4>Tingkat Kepatuhan</h4>
                @php
                    $total = $total_pasien ?: 1;
                    $pAktif = ($pasien_aktif / $total) * 100;
                    $pLtfu = ($pasien_ltfu / $total) * 100;
                    $pInactive = ($pasien_inactive / $total) * 100;
                @endphp
                <div class="donut-container" style="background: conic-gradient(#10b981 0% {{ $pAktif }}%, #f43f5e {{ $pAktif }}% {{ $pAktif + $pLtfu }}%, #f59e0b {{ $pAktif + $pLtfu }}% 100%);">
                    <div class="donut-center">{{ round($pAktif) }}%</div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px; font-size: 12px; font-weight: 700; color: #64748b;">
                    <div style="display: flex; justify-content: space-between;"><span><i class="fa-solid fa-circle" style="color: #10b981; font-size: 10px;"></i> Aktif</span><span>{{ $pasien_aktif }}</span></div>
                    <div style="display: flex; justify-content: space-between;"><span><i class="fa-solid fa-circle" style="color: #f43f5e; font-size: 10px;"></i> LTFU</span><span>{{ $pasien_ltfu }}</span></div>
                    <div style="display: flex; justify-content: space-between;"><span><i class="fa-solid fa-circle" style="color: #f59e0b; font-size: 10px;"></i> Inaktif</span><span>{{ $pasien_inactive }}</span></div>
                </div>
            </div>

            <div class="chart-box">
                <h4>Status Kelangsungan</h4>
                @php
                    $p_hidup = ($total_pasien - $pasien_inactive) / $total * 100;
                    $p_mati = ($pasien_inactive / $total) * 100;
                @endphp
                <div class="donut-container" style="background: conic-gradient(#3b82f6 0% {{ $p_hidup }}%, #94a3b8 {{ $p_hidup }}% 100%);">
                    <div class="donut-center">{{ round($p_hidup) }}%</div>
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px; font-size: 12px; font-weight: 700; color: #64748b;">
                    <div style="display: flex; justify-content: space-between;"><span><i class="fa-solid fa-circle" style="color: #3b82f6; font-size: 10px;"></i> Hidup</span><span>{{ $total_pasien - $pasien_inactive }}</span></div>
                    <div style="display: flex; justify-content: space-between;"><span><i class="fa-solid fa-circle" style="color: #94a3b8; font-size: 10px;"></i> Meninggal</span><span>{{ $pasien_inactive }}</span></div>
                </div>
            </div>
        </section>

        {{-- TABLE --}}
        <section class="table-card">
            <div class="table-top" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px; gap: 20px;">
                <h2 style="font-size: 18px; font-weight: 900; color: #1e293b; margin: 0;">Rincian Data Pasien Terfilter</h2>
                <div style="display: flex; gap: 12px;">
                    <a href="{{ route('petugas.laporan.export', array_merge(request()->query(), ['format' => 'pdf'])) }}" target="_blank" class="export-btn" style="border-color: #ef4444; color: #ef4444;">
                        <i class="fa-solid fa-file-pdf"></i> Unduh PDF
                    </a>
                    <a href="{{ route('petugas.laporan.export', array_merge(request()->query(), ['format' => 'excel'])) }}" class="export-btn">
                        <i class="fa-solid fa-file-excel"></i> Unduh Excel
                    </a>
                </div>
            </div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Nama Pasien</th>
                            <th>No RM</th>
                            <th>Regis Nasional</th>
                            <th>Jenis Kelamin</th>
                            <th>Status Monitoring</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pasiens as $pasien)
                            <tr>
                                <td>{{ $pasien->nama }}</td>
                                <td><code style="background: #f1f5f9; padding: 3px 6px; border-radius: 5px;">{{ $pasien->nomor_rm }}</code></td>
                                <td>{{ $pasien->no_registrasi_nasional }}</td>
                                <td>{{ $pasien->jenis_kelamin }}</td>
                                <td>
                                    @php
                                        $status = $pasien->display_status;
                                        $bClass = 'badge-success';
                                        if ($status == 'Inactive') $bClass = 'badge-warning';
                                        if ($status == 'LTFU') $bClass = 'badge-danger';
                                        if ($status == 'Meninggal') $bClass = 'badge-danger';
                                    @endphp
                                    <span class="badge {{ $bClass }}">{{ $status }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="table-footer">
                <span style="font-weight: 600;">Data {{ $pasiens->firstItem() ?? 0 }} - {{ $pasiens->lastItem() ?? 0 }} dari {{ $pasiens->total() }}</span>
                <div class="pagination">
                    {{ $pasiens->appends(request()->query())->links('pagination::bootstrap-4') }}
                </div>
            </div>
        </section>
    </div>
@endsection