@extends('layouts.pasien')

@section('title', 'Dashboard Pasien')
@section('page-title', 'Dashboard')

@section('content')
    <style>
        .pasien-dashboard {
            max-width: 1050px;
        }

        .summary-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 32px;
            margin-bottom: 36px;
        }

        .summary-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 34px 38px;
            min-height: 150px;
            display: flex;
            align-items: center;
            gap: 34px;
            box-shadow: 0 18px 35px rgba(213, 224, 235, 0.58);
        }

        .summary-icon {
            width: 105px;
            height: 105px;
            min-width: 105px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000000;
            font-size: 72px;
        }

        .summary-icon img {
            width: 92px;
            height: 92px;
            object-fit: contain;
        }

        .summary-content small {
            display: block;
            color: #a7a9b0;
            font-size: 15px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .summary-content h2 {
            font-size: 30px;
            font-weight: 900;
            color: #2f2f2f;
            margin-bottom: 8px;
        }

        .status-badge-large {
            width: 170px;
            height: 36px;
            border-radius: 4px;
            background: #9be7d1;
            border: 1px solid #1aad86;
            color: #08785c;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 10px;
        }

        .summary-note {
            color: #00a95a;
            font-size: 14px;
            font-weight: 900;
        }

        .riwayat-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 20px 42px 24px;
            box-shadow: 0 18px 35px rgba(213, 224, 235, 0.58);
        }

        .riwayat-table {
            width: 100%;
            border-collapse: collapse;
        }

        .riwayat-table th {
            text-align: left;
            color: #b0b5c0;
            font-size: 14px;
            font-weight: 700;
            padding: 18px 0;
            border-bottom: 1px solid #eeeeee;
        }

        .riwayat-table td {
            color: #111827;
            font-size: 14px;
            font-weight: 500;
            padding: 17px 0;
            border-bottom: 1px solid #eeeeee;
        }

        @media (max-width: 1000px) {
            .summary-row {
                grid-template-columns: 1fr;
            }

            .summary-card {
                align-items: flex-start;
            }
        }

        @media (max-width: 600px) {
            .summary-card {
                flex-direction: column;
            }

            .summary-icon {
                width: 80px;
                height: 80px;
                min-width: 80px;
                font-size: 56px;
            }
        }
    </style>

    <div class="pasien-dashboard">
        <div class="summary-row">
            <div class="summary-card">
                <div class="summary-icon">
                    <i class="fa-regular fa-calendar-days"></i>
                </div>

                <div class="summary-content">
                    <small>Jadwal Kontol Rutin Dan Pengambilan Obat</small>
                    <h2>17 Mei 2027</h2>
                    <div class="summary-note">
                        <i class="fa-solid fa-arrow-up"></i>
                        3 Hari Lagi
                    </div>
                </div>
            </div>

            <div class="summary-card">
                <div class="summary-icon">
                    <i class="fa-solid fa-capsules"></i>
                </div>

                <div class="summary-content">
                    <small>Status Pengobatan</small>
                    <div class="status-badge-large">Active</div>

                    <div class="summary-note">
                        <i class="fa-solid fa-arrow-up"></i>
                        Tepat Waktu
                    </div>
                </div>
            </div>
        </div>

        <section class="riwayat-card">
            <table class="riwayat-table">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jenis Kunjungan</th>
                        <th>Keluhan</th>
                        <th>Catatan</th>
                    </tr>
                </thead>

                <tbody>
                    <tr>
                        <td>16 - 04 - 2027</td>
                        <td>Pengambilan Obat</td>
                        <td>Demam</td>
                        <td>Kurangi aktifitas</td>
                    </tr>

                    <tr>
                        <td>16 - 04 - 2027</td>
                        <td>Kontrol</td>
                        <td>Demam</td>
                        <td>Kurangi aktifitas</td>
                    </tr>

                    <tr>
                        <td>16 - 04 - 2027</td>
                        <td>Pengambilan Obat</td>
                        <td>Demam</td>
                        <td>Kurangi aktifitas</td>
                    </tr>

                    <tr>
                        <td>16 - 04 - 2027</td>
                        <td>Kontrol</td>
                        <td>Demam</td>
                        <td>Kurangi aktifitas</td>
                    </tr>

                    <tr>
                        <td>16 - 04 - 2027</td>
                        <td>Kontrol</td>
                        <td>Demam</td>
                        <td>Istirahat 3 hari</td>
                    </tr>

                    <tr>
                        <td>16 - 04 - 2027</td>
                        <td>Kontrol</td>
                        <td>Demam</td>
                        <td>Istirahat 3 hari</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
@endsection