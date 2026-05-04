@extends('layouts.keluarga')

@section('title', 'Dashboard Keluarga Pasien')
@section('page-title', 'Dashboard')

@push('styles')
<style>
    .family-dashboard {
        width: 100%;
    }

    .family-summary-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(320px, 1fr));
        gap: 32px;
        margin-bottom: 38px;
    }

    .family-summary-card {
        background: #ffffff;
        border-radius: 28px;
        min-height: 188px;
        padding: 30px 34px;
        display: flex;
        align-items: center;
        gap: 28px;
        box-shadow: 0 14px 34px rgba(22, 49, 80, 0.10);
    }

    .family-summary-icon {
        width: 120px;
        min-width: 120px;
        height: 120px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #000000;
        font-size: 76px;
    }

    .family-summary-label {
        color: #9aa3af;
        font-size: 15px;
        font-weight: 800;
        line-height: 1.35;
        margin-bottom: 10px;
    }

    .family-summary-value {
        font-size: 32px;
        font-weight: 900;
        color: #202638;
        margin-bottom: 10px;
    }

    .family-summary-note {
        color: #0da04d;
        font-size: 14px;
        font-weight: 900;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .family-status-box {
        width: 185px;
        max-width: 100%;
        height: 39px;
        border-radius: 6px;
        background: #9ee3cf;
        border: 1px solid #22aa83;
        color: #08785c;
        font-size: 16px;
        font-weight: 900;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-bottom: 10px;
    }

    .family-table-card {
        background: #ffffff;
        border-radius: 28px;
        padding: 24px 34px;
        box-shadow: 0 14px 34px rgba(22, 49, 80, 0.10);
        overflow-x: auto;
    }

    .family-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 760px;
    }

    .family-table th {
        text-align: left;
        color: #a7afbd;
        font-size: 15px;
        font-weight: 800;
        padding: 18px 12px;
        border-bottom: 1px solid #edf0f4;
    }

    .family-table td {
        color: #172236;
        font-size: 16px;
        font-weight: 600;
        padding: 18px 12px;
        border-bottom: 1px solid #edf0f4;
    }

    .family-table tr:last-child td {
        border-bottom: none;
    }

    @media (max-width: 1100px) {
        .family-summary-grid {
            grid-template-columns: 1fr;
        }
    }

    @media (max-width: 768px) {
        .family-summary-card {
            flex-direction: column;
            align-items: flex-start;
        }

        .family-summary-icon {
            width: 90px;
            min-width: 90px;
            height: 90px;
            font-size: 56px;
        }
    }
</style>
@endpush

@section('content')
<div class="family-dashboard">
    <div class="family-summary-grid">
        <div class="family-summary-card">
            <div class="family-summary-icon">
                <i class="fa-regular fa-calendar-days"></i>
            </div>

            <div>
                <div class="family-summary-label">
                    Jadwal Kontrol Rutin Dan Pengambilan Obat
                </div>
                <div class="family-summary-value">17 Mei 2027</div>
                <div class="family-summary-note">
                    <i class="fa-solid fa-arrow-up"></i>
                    <span>3 Hari Lagi</span>
                </div>
            </div>
        </div>

        <div class="family-summary-card">
            <div class="family-summary-icon">
                <i class="fa-solid fa-capsules"></i>
            </div>

            <div>
                <div class="family-summary-label">Status Pengobatan</div>
                <div class="family-status-box">Active</div>
                <div class="family-summary-note">
                    <i class="fa-solid fa-arrow-up"></i>
                    <span>Tepat Waktu</span>
                </div>
            </div>
        </div>
    </div>

    <div class="family-table-card">
        <table class="family-table">
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
    </div>
</div>
@endsection