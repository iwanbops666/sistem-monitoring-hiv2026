@extends('layouts.pasien')

@section('title', 'Kartu Kendali Pasien')
@section('page-title', 'Data Kartu Kendali Pasien')

@section('content')
    <style>
        .kartu-page {
            width: 100%;
            max-width: 1080px;
            margin-top: -24px;
        }

        .kartu-subtitle {
            font-size: 18px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 46px;
        }

        .kartu-form {
            width: 100%;
        }

        .kartu-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px 68px;
            margin-bottom: 30px;
        }

        .kartu-group label {
            display: block;
            font-size: 16px;
            color: #111827;
            font-weight: 700;
            margin-bottom: 11px;
        }

        .kartu-group input,
        .kartu-group textarea {
            width: 100%;
            border: 1px solid #d8d8d8;
            border-radius: 8px;
            background: #ffffff;
            outline: none;
            font-size: 15px;
            color: #111827;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.06);
        }

        .kartu-group input {
            height: 54px;
            padding: 0 16px;
        }

        .kartu-group input[type="date"] {
            cursor: pointer;
        }

        .kartu-group textarea {
            height: 120px;
            resize: none;
            padding: 16px;
            line-height: 1.5;
        }

        .kartu-group input:focus,
        .kartu-group textarea:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.14);
        }

        .readonly-field,
        .kartu-group input:disabled,
        .kartu-group textarea:disabled {
            background: #f7f7f7 !important;
            color: #111827 !important;
            cursor: not-allowed;
            opacity: 1;
        }

        .kartu-catatan {
            margin-top: 4px;
        }

        .kartu-catatan textarea {
            height: 150px;
        }

        @media (max-width: 900px) {
            .kartu-page {
                margin-top: 0;
            }

            .kartu-grid-2 {
                grid-template-columns: 1fr;
                gap: 22px;
            }
        }
    </style>

    <div class="kartu-page">
        <p class="kartu-subtitle">
            Tanggal Perjanjian mengambil Obat, Konsultasi Dokter, Pemeriksaan Lain
        </p>

        <form action="#" method="POST" id="kartuKendaliPasienForm" class="kartu-form">
            @csrf

            <div class="kartu-grid-2">
                <div class="kartu-group">
                    <label>Tanggal Kunjungan :</label>
                    <input type="date" name="tanggal_kunjungan" value="2027-04-16">
                </div>

                <div class="kartu-group">
                    <label>Rencana Tanggal Kunjungan Selanjutnya:</label>
                    <input type="text" name="rencana_kunjungan" value="17/05/2027" class="readonly-field" disabled>
                </div>
            </div>

            <div class="kartu-grid-2">
                <div class="kartu-group">
                    <label>Rejiman dan Jumlah Obat ARV yang : Tersisa :</label>
                    <textarea name="rejiman_arv" class="readonly-field" disabled>ARV tersisa cukup sampai jadwal kunjungan berikutnya.</textarea>
                </div>

                <div class="kartu-group">
                    <label>Jumlah INH yang Tersisa :</label>
                    <textarea name="inh_tersisa" class="readonly-field" disabled>10 tablet</textarea>
                </div>
            </div>

            <div class="kartu-grid-2">
                <div class="kartu-group">
                    <label>Jumlah INH yang Diberikan Untuk Bulan Berikutnya :</label>
                    <textarea name="inh_diberikan" class="readonly-field" disabled>30 tablet</textarea>
                </div>

                <div class="kartu-group">
                    <label>Efek Samping ARV / IO / Proflaksis O :</label>
                    <textarea name="efek_samping" class="readonly-field" disabled>Tidak ada efek samping berat yang dilaporkan.</textarea>
                </div>
            </div>

            <div class="kartu-group kartu-catatan">
                <label>Catatan</label>
                <textarea name="catatan" class="readonly-field" disabled>Pasien diharapkan datang sesuai jadwal dan membawa kartu kendali saat kunjungan berikutnya.</textarea>
            </div>
        </form>
    </div>
@endsection