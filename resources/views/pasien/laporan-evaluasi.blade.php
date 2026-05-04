@extends('layouts.pasien')

@section('title', 'Laporan Evaluasi Pasien')
@section('page-title', 'Laporan Evaluasi Pasien')

@section('content')
    <style>
        .evaluasi-page {
            width: 100%;
            max-width: 1080px;
            margin-top: -20px;
        }

        .evaluasi-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 36px 42px 26px;
            box-shadow: 0 18px 35px rgba(213, 224, 235, 0.68);
        }

        .evaluasi-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 48px;
        }

        .evaluasi-card-title {
            font-size: 20px;
            font-weight: 900;
            color: #111827;
        }

        .sort-box {
            height: 42px;
            border: none;
            outline: none;
            background: #f8faff;
            border-radius: 9px;
            padding: 0 14px;
            font-size: 13px;
            color: #6b7280;
        }

        .evaluasi-table-wrapper {
            overflow-x: auto;
        }

        .evaluasi-table {
            width: 100%;
            border-collapse: collapse;
        }

        .evaluasi-table th {
            text-align: left;
            color: #a8adb8;
            font-size: 13px;
            font-weight: 700;
            padding-bottom: 18px;
        }

        .evaluasi-table td {
            color: #111827;
            font-size: 13px;
            padding: 17px 0;
            border-bottom: 1px solid #f1f1f1;
            vertical-align: middle;
        }

        .btn-detail-evaluasi {
            background: #78dfc3;
            color: #08785c;
            border: 1px solid #17ac87;
            padding: 7px 18px;
            border-radius: 5px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
        }

        .btn-detail-evaluasi:hover {
            background: #62d6b6;
        }

        .evaluasi-footer {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-top: 24px;
            color: #a9aebb;
            font-size: 13px;
        }

        .pagination {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .page-btn {
            width: 26px;
            height: 26px;
            border-radius: 6px;
            border: none;
            background: #f3f4f8;
            color: #757b87;
            font-size: 13px;
            cursor: pointer;
        }

        .page-btn.active {
            background: #5a45df;
            color: #ffffff;
        }

        /* MODAL */
        .evaluasi-modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.22);
            display: none;
            justify-content: center;
            align-items: center;
            padding: 20px;
            z-index: 9999;
        }

        .evaluasi-modal-overlay.show {
            display: flex;
        }

        .evaluasi-modal-box {
            width: 100%;
            max-width: 920px;
            background: #ffffff;
            border-radius: 14px;
            padding: 34px 44px 30px;
            position: relative;
            box-shadow: 0 16px 38px rgba(0,0,0,0.18);
            max-height: 95vh;
            overflow-y: auto;
        }

        .evaluasi-modal-close {
            position: absolute;
            right: 16px;
            top: 14px;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            border: none;
            background: #ff1f1f;
            color: #ffffff;
            font-size: 24px;
            font-weight: 900;
            cursor: pointer;
            line-height: 34px;
        }

        .evaluasi-modal-title {
            font-size: 34px;
            font-weight: 900;
            color: #000000;
            margin-bottom: 42px;
            line-height: 1;
        }

        .modal-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 26px 52px;
            margin-bottom: 24px;
        }

        .modal-group label {
            display: block;
            font-size: 16px;
            color: #111827;
            font-weight: 500;
            margin-bottom: 10px;
        }

        .modal-group input,
        .modal-group textarea {
            width: 100%;
            border: 1px solid #d8d8d8;
            border-radius: 8px;
            background: #ffffff;
            outline: none;
            font-size: 15px;
            color: #111827;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.06);
        }

        .modal-group input {
            height: 46px;
            padding: 0 14px;
        }

        .modal-group textarea {
            height: 98px;
            padding: 14px;
            resize: none;
            line-height: 1.5;
        }

        .modal-group input:disabled,
        .modal-group textarea:disabled {
            background: #ffffff;
            color: #111827;
            cursor: not-allowed;
            opacity: 1;
        }

        .modal-catatan textarea {
            height: 135px;
        }

        @media (max-width: 900px) {
            .evaluasi-page {
                margin-top: 0;
            }

            .evaluasi-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 18px;
            }

            .modal-grid-2 {
                grid-template-columns: 1fr;
                gap: 22px;
            }

            .evaluasi-footer {
                flex-direction: column;
                align-items: flex-start;
                gap: 18px;
            }
        }
    </style>

    <div class="evaluasi-page">
        <section class="evaluasi-card">
            <div class="evaluasi-card-header">
                <h2 class="evaluasi-card-title">Pemeriksaan Klinis Dan Laboratorium</h2>

                <select class="sort-box">
                    <option>Short by : Newest</option>
                    <option>Oldest</option>
                </select>
            </div>

            <div class="evaluasi-table-wrapper">
                <table class="evaluasi-table">
                    <thead>
                        <tr>
                            <th>Kunjungan</th>
                            <th>Tanggal</th>
                            <th>Standart Klinis</th>
                            <th>Status Fungsional (K.Amb.B)</th>
                            <th>Jumlah CD 4</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Kunjungan Pertama</td>
                            <td>16/04/2027</td>
                            <td>Batuk ringan</td>
                            <td>Mandiri</td>
                            <td>450</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn-detail-evaluasi"
                                    data-kunjungan="Kunjungan Pertama"
                                    data-tanggal="2027-04-16"
                                    data-standart="Batuk ringan, kondisi umum baik."
                                    data-status="Mandiri, dapat beraktivitas normal."
                                    data-lain="Tidak ada keluhan tambahan."
                                    data-cd4="450"
                                    data-catatan="Pasien dianjurkan menjaga pola makan dan kontrol sesuai jadwal."
                                >
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>Memenuhi Syarat Medis ART</td>
                            <td>20/05/2027</td>
                            <td>Kondisi stabil</td>
                            <td>Mandiri</td>
                            <td>430</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn-detail-evaluasi"
                                    data-kunjungan="Memenuhi Syarat Medis ART"
                                    data-tanggal="2027-05-20"
                                    data-standart="Pasien memenuhi syarat medis untuk ART."
                                    data-status="Mandiri, tidak membutuhkan bantuan."
                                    data-lain="Tidak ada infeksi oportunistik berat."
                                    data-cd4="430"
                                    data-catatan="Lanjutkan edukasi kepatuhan minum obat."
                                >
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>Saat Mulai ART</td>
                            <td>10/06/2027</td>
                            <td>Mulai terapi</td>
                            <td>Mandiri</td>
                            <td>420</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn-detail-evaluasi"
                                    data-kunjungan="Saat Mulai ART"
                                    data-tanggal="2027-06-10"
                                    data-standart="Pasien mulai terapi ART."
                                    data-status="Mandiri."
                                    data-lain="Pasien diberi edukasi jadwal minum obat."
                                    data-cd4="420"
                                    data-catatan="Pantau efek samping obat pada kunjungan berikutnya."
                                >
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>Setelah 6 Bulan ART</td>
                            <td>10/12/2027</td>
                            <td>Evaluasi 6 bulan</td>
                            <td>Mandiri</td>
                            <td>510</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn-detail-evaluasi"
                                    data-kunjungan="Setelah 6 Bulan ART"
                                    data-tanggal="2027-12-10"
                                    data-standart="Kondisi klinis membaik setelah 6 bulan ART."
                                    data-status="Mandiri dan aktif."
                                    data-lain="Tidak ada keluhan serius."
                                    data-cd4="510"
                                    data-catatan="Kepatuhan baik, lanjutkan terapi sesuai jadwal."
                                >
                                    Detail
                                </button>
                            </td>
                        </tr>

                        <tr>
                            <td>Setelah 12 Bulan ART</td>
                            <td>10/06/2028</td>
                            <td>Evaluasi 12 bulan</td>
                            <td>Mandiri</td>
                            <td>590</td>
                            <td>
                                <button
                                    type="button"
                                    class="btn-detail-evaluasi"
                                    data-kunjungan="Setelah 12 Bulan ART"
                                    data-tanggal="2028-06-10"
                                    data-standart="Kondisi stabil setelah 12 bulan ART."
                                    data-status="Mandiri."
                                    data-lain="Pasien tetap patuh pengobatan."
                                    data-cd4="590"
                                    data-catatan="Lanjutkan kontrol berkala dan pemantauan viral load."
                                >
                                    Detail
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="evaluasi-footer">
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

    {{-- MODAL DETAIL LAPORAN EVALUASI --}}
    <div class="evaluasi-modal-overlay" id="evaluasiModal">
        <div class="evaluasi-modal-box">
            <button type="button" class="evaluasi-modal-close" id="closeEvaluasiModal">&times;</button>

            <h2 class="evaluasi-modal-title">Laporan Evaluasi Pasien</h2>

            <form>
                <div class="modal-grid-2">
                    <div class="modal-group">
                        <label>Kunjungan :</label>
                        <input type="text" id="modalKunjungan" disabled>
                    </div>

                    <div class="modal-group">
                        <label>Tanggal :</label>
                        <input type="date" id="modalTanggal" disabled>
                    </div>
                </div>

                <div class="modal-grid-2">
                    <div class="modal-group">
                        <label>Standart Klinis :</label>
                        <textarea id="modalStandart" disabled></textarea>
                    </div>

                    <div class="modal-group">
                        <label>Status Fungsional (K.Amb.B)</label>
                        <textarea id="modalStatus" disabled></textarea>
                    </div>
                </div>

                <div class="modal-grid-2">
                    <div class="modal-group">
                        <label>Lain - Lain :</label>
                        <textarea id="modalLain" disabled></textarea>
                    </div>

                    <div class="modal-group">
                        <label>Jumlah CD 4 :</label>
                        <textarea id="modalCd4" disabled></textarea>
                    </div>
                </div>

                <div class="modal-group modal-catatan">
                    <label>Catatan</label>
                    <textarea id="modalCatatan" disabled></textarea>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('evaluasiModal');
                const closeButton = document.getElementById('closeEvaluasiModal');
                const detailButtons = document.querySelectorAll('.btn-detail-evaluasi');

                const modalKunjungan = document.getElementById('modalKunjungan');
                const modalTanggal = document.getElementById('modalTanggal');
                const modalStandart = document.getElementById('modalStandart');
                const modalStatus = document.getElementById('modalStatus');
                const modalLain = document.getElementById('modalLain');
                const modalCd4 = document.getElementById('modalCd4');
                const modalCatatan = document.getElementById('modalCatatan');

                detailButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        modalKunjungan.value = this.dataset.kunjungan;
                        modalTanggal.value = this.dataset.tanggal;
                        modalStandart.value = this.dataset.standart;
                        modalStatus.value = this.dataset.status;
                        modalLain.value = this.dataset.lain;
                        modalCd4.value = this.dataset.cd4;
                        modalCatatan.value = this.dataset.catatan;

                        modal.classList.add('show');
                    });
                });

                closeButton.addEventListener('click', function () {
                    modal.classList.remove('show');
                });

                modal.addEventListener('click', function (event) {
                    if (event.target === modal) {
                        modal.classList.remove('show');
                    }
                });
            });
        </script>
    @endpush
@endsection