@extends('layouts.app')

@section('title', 'Data Laporan')

@section('content')
    <style>
        .laporan-wrapper {
            max-width: 1180px;
        }

        .filter-card {
            background: #ffffff;
            border-radius: 8px;
            padding: 16px 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            margin-bottom: 18px;
        }

        .filter-title {
            color: #00b889;
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 10px;
        }

        .filter-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr 1fr 1fr;
            gap: 12px;
            align-items: end;
        }

        .filter-group label {
            display: block;
            font-size: 13px;
            font-weight: 600;
            margin-bottom: 5px;
            color: #111827;
        }

        .filter-group select,
        .filter-group input {
            width: 100%;
            height: 32px;
            border: 1px solid #cfcfcf;
            border-radius: 6px;
            padding: 0 10px;
            outline: none;
            font-size: 13px;
            background: #ffffff;
            color: #6b7280;
        }

        .filter-actions {
            display: flex;
            gap: 10px;
            margin-top: 12px;
        }

        .btn-filter {
            border: none;
            background: #00b889;
            color: #ffffff;
            height: 32px;
            padding: 0 18px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-reset {
            border: none;
            background: #d9d9d9;
            color: #222;
            height: 32px;
            padding: 0 18px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 12px;
            margin-bottom: 18px;
        }

        .summary-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 14px 16px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
            display: flex;
            align-items: center;
            gap: 14px;
            min-height: 74px;
        }

        .summary-icon {
            width: 54px;
            height: 54px;
            border-radius: 50%;
            background: #dffdec;
            color: #08ad59;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
            flex-shrink: 0;
        }

        .summary-text small {
            display: block;
            font-size: 12px;
            color: #a7a9b0;
            margin-bottom: 4px;
        }

        .summary-text h3 {
            font-size: 28px;
            color: #333;
            font-weight: 900;
        }

        .chart-grid {
            display: grid;
            grid-template-columns: 1.4fr 1fr 1fr;
            gap: 12px;
            margin-bottom: 18px;
        }

        .chart-card {
            background: #ffffff;
            min-height: 250px;
            padding: 18px 18px 14px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .chart-title {
            text-align: center;
            font-size: 13px;
            font-weight: 800;
            color: #4b5563;
            margin-bottom: 12px;
        }

        .line-chart {
            width: 100%;
            height: 190px;
        }

        .donut-wrap {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 160px;
        }

        .donut {
            width: 145px;
            height: 145px;
            border-radius: 50%;
            position: relative;
        }

        .donut.kepatuhan {
            background: conic-gradient(#4df45f 0 58%, #ff5a4f 58% 78%, #e5ff00 78% 100%);
        }

        .donut.status {
            background: conic-gradient(#4df45f 0 68%, #ff5a4f 68% 100%);
        }

        .donut::after {
            content: "";
            position: absolute;
            width: 74px;
            height: 74px;
            border-radius: 50%;
            background: #ffffff;
            left: 50%;
            top: 50%;
            transform: translate(-50%, -50%);
        }

        .legend {
            display: flex;
            justify-content: center;
            gap: 18px;
            font-size: 12px;
            color: #6b7280;
            margin-top: 10px;
            flex-wrap: wrap;
        }

        .legend-item {
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .dot {
            width: 9px;
            height: 9px;
            border-radius: 50%;
            display: inline-block;
        }

        .dot-green {
            background: #4df45f;
        }

        .dot-red {
            background: #ff5a4f;
        }

        .dot-yellow {
            background: #e5ff00;
        }

        .export-actions {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-bottom: 14px;
        }

        .btn-export {
            background: #ffffff;
            border: 1px solid #00a97d;
            color: #008a68;
            border-radius: 4px;
            height: 34px;
            padding: 0 18px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 2px 5px rgba(0,0,0,0.18);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .laporan-table-card {
            background: #ffffff;
            border-radius: 10px;
            padding: 18px 28px 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        }

        .laporan-table-title {
            color: #00b889;
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 22px;
        }

        @media (max-width: 1100px) {
            .filter-grid,
            .summary-grid,
            .chart-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 700px) {
            .filter-grid,
            .summary-grid,
            .chart-grid {
                grid-template-columns: 1fr;
            }

            .export-actions {
                justify-content: flex-start;
                flex-wrap: wrap;
            }
        }
    </style>

    <div class="laporan-wrapper">
        <h1 class="page-title">Data Laporan</h1>

        {{-- FILTER --}}
        <section class="filter-card">
            <div class="filter-title">Filter Laporan</div>

            <div class="filter-grid">
                <div class="filter-group">
                    <label>Jenis Laporan:</label>
                    <select>
                        <option>Jumlah Pasien Baru</option>
                        <option>Jumlah Pasien Mulai Pengobatan</option>
                        <option>Jumlah Pasien Active</option>
                        <option>Jumlah Pasien Inactive</option>
                        <option>Jumlah Pasien Lost Follow Up (LTFU)</option>
                        <option>Jumlah Pasien Berobat</option>
                        <option>Jumlah Pasien Meninggal</option>
                        <option>Jumlah Pasien Pindahan</option>
                        <option>Jumlah Pasien Pindah Pengobatan</option>
                    </select>
                </div>

                <div class="filter-group">
                    <label>Periode :</label>
                    <select>
                        <option>Bulan</option>
                        <option>Tahun</option>
                    </select>
                </div>

                <div class="filter-group">
    <label>Dari Tanggal :</label>
    <input type="date" name="dari_tanggal" value="2026-04-30">
</div>

<div class="filter-group">
    <label>Sampai Tanggal :</label>
    <input type="date" name="sampai_tanggal" value="2026-05-31">
</div>

                <div class="filter-group">
                    <label>Status Pasien :</label>
                    <select>
                        <option>Hidup</option>
                        <option>Meninggal</option>

                    </select>
                </div>
            </div>

            <div class="filter-actions">
                <button class="btn-filter">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    Tampilkan
                </button>

                <button class="btn-reset">
                    <i class="fa-solid fa-rotate-left"></i>
                    Reset
                </button>
            </div>
        </section>

        {{-- SUMMARY --}}
        <section class="summary-grid">
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="fa-solid fa-users"></i>
                </div>
                <div class="summary-text">
                    <small>Total Pasien</small>
                    <h3>100</h3>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon">
                    <i class="fa-solid fa-user-check"></i>
                </div>
                <div class="summary-text">
                    <small>Pasien Active</small>
                    <h3>70</h3>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon">
                    <i class="fa-solid fa-user-minus"></i>
                </div>
                <div class="summary-text">
                    <small>Pasien Inactive</small>
                    <h3>20</h3>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon">
                    <i class="fa-solid fa-user-slash"></i>
                </div>
                <div class="summary-text">
                    <small>Pasien LFO</small>
                    <h3>10</h3>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon">
                    <i class="fa-solid fa-user-plus"></i>
                </div>
                <div class="summary-text">
                    <small>Pasien Baru</small>
                    <h3>5</h3>
                </div>
            </div>
        </section>

        {{-- CHART --}}
        <section class="chart-grid">
            <div class="chart-card">
                <div class="chart-title">Jumlah Pasien Per Bulan (Tahun 2026)</div>

                <svg class="line-chart" viewBox="0 0 420 210">
                    <line x1="40" y1="20" x2="40" y2="180" stroke="#e5e7eb" />
                    <line x1="40" y1="180" x2="400" y2="180" stroke="#e5e7eb" />
                    <line x1="40" y1="140" x2="400" y2="140" stroke="#e5e7eb" />
                    <line x1="40" y1="100" x2="400" y2="100" stroke="#e5e7eb" />
                    <line x1="40" y1="60" x2="400" y2="60" stroke="#e5e7eb" />

                    <text x="15" y="183" font-size="11" fill="#6b7280">0</text>
                    <text x="10" y="143" font-size="11" fill="#6b7280">10</text>
                    <text x="10" y="103" font-size="11" fill="#6b7280">20</text>
                    <text x="10" y="63" font-size="11" fill="#6b7280">30</text>

                    <polyline
                        points="55,170 88,160 122,125 155,90 188,58 222,64 255,95 288,135 322,158 355,176"
                        fill="none"
                        stroke="#6bd12d"
                        stroke-width="6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                    <polyline
                        points="55,150 88,145 122,120 155,88 188,78 222,83 255,105 288,138 322,152 355,160"
                        fill="none"
                        stroke="#ff3b32"
                        stroke-width="6"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                    />

                    <text x="45" y="202" font-size="11" fill="#6b7280">Jan</text>
                    <text x="77" y="202" font-size="11" fill="#6b7280">Feb</text>
                    <text x="110" y="202" font-size="11" fill="#6b7280">Mar</text>
                    <text x="145" y="202" font-size="11" fill="#6b7280">Apr</text>
                    <text x="178" y="202" font-size="11" fill="#6b7280">May</text>
                    <text x="212" y="202" font-size="11" fill="#6b7280">Jun</text>
                    <text x="245" y="202" font-size="11" fill="#6b7280">Jul</text>
                    <text x="278" y="202" font-size="11" fill="#6b7280">Aug</text>
                    <text x="312" y="202" font-size="11" fill="#6b7280">Sep</text>
                    <text x="348" y="202" font-size="11" fill="#6b7280">Oct</text>
                </svg>
            </div>

            <div class="chart-card">
                <div class="chart-title">Tingkat Kepatuhan Pasien</div>

                <div class="donut-wrap">
                    <div class="donut kepatuhan"></div>
                </div>

                <div class="legend">
                    <span class="legend-item"><span class="dot dot-green"></span>Aktif</span>
                    <span class="legend-item"><span class="dot dot-yellow"></span>Tidak Aktif</span>
                    <span class="legend-item"><span class="dot dot-red"></span>LFO</span>
                </div>
            </div>

            <div class="chart-card">
                <div class="chart-title">Status Pasien</div>

                <div class="donut-wrap">
                    <div class="donut status"></div>
                </div>

                <div class="legend">
                    <span class="legend-item"><span class="dot dot-green"></span>Hidup</span>
                    <span class="legend-item"><span class="dot dot-red"></span>Meninggal</span>
                </div>
            </div>
        </section>

        {{-- EXPORT --}}
        <div class="export-actions">
            <button class="btn-export">
                <i class="fa-regular fa-file-pdf"></i>
                Export PDF
            </button>

            <button class="btn-export">
                <i class="fa-regular fa-file-excel"></i>
                Export Excel
            </button>
        </div>

        {{-- TABLE --}}
        <section class="laporan-table-card">
            <div class="laporan-table-title">Data Laporan Pasien</div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>No RM</th>
                            <th>No Regis Nasional</th>
                            <th>No Handphone</th>
                            <th>Jenis Kelamin</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Jane Cooper</td>
                            <td>Microsoft</td>
                            <td>(225) 555-0118</td>
                            <td>jane@microsoft.com</td>
                            <td>United States</td>
                            <td>
                                <button class="btn-detail">Detail</button>
                            </td>
                        </tr>

                        <tr>
                            <td>Floyd Miles</td>
                            <td>Yahoo</td>
                            <td>(205) 555-0100</td>
                            <td>floyd@yahoo.com</td>
                            <td>Kiribati</td>
                            <td>
                                <button class="btn-detail">Detail</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="table-footer">
                <span>Showing data 1 to 8 of 256K entries</span>

                <div class="pagination">
                    <button class="page-btn">&lt;</button>
                    <button class="page-btn active">1</button>
                    <button class="page-btn">2</button>
                    <button class="page-btn">3</button>
                    <button class="page-btn">4</button>
                    <span>...</span>
                    <button class="page-btn">40</button>
                    <button class="page-btn">&gt;</button>
                </div>
            </div>
        </section>
    </div>
@endsection