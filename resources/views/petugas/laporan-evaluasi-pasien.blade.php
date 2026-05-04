@extends('layouts.app')

@section('title', 'Laporan Evaluasi Pasien')

@section('content')
    <style>
        .modal-box-evaluasi {
            background: #ffffff;
            width: 100%;
            max-width: 980px;
            border-radius: 18px;
            padding: 34px 40px 28px;
            position: relative;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.16);
            max-height: 95vh;
            overflow-y: auto;
        }

        .modal-title-evaluasi {
            font-size: 32px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 34px;
        }

        .evaluasi-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px 60px;
            margin-bottom: 22px;
        }

        .evaluasi-group label {
            display: block;
            font-size: 16px;
            color: #111;
            margin-bottom: 9px;
            font-weight: 500;
        }

        .evaluasi-group input,
        .evaluasi-group select,
        .evaluasi-group textarea {
            width: 100%;
            border: 1px solid #d6d6d6;
            border-radius: 7px;
            padding: 10px 12px;
            outline: none;
            font-size: 14px;
            background: #ffffff;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.08);
        }

        .evaluasi-group input,
        .evaluasi-group select {
            height: 44px;
        }

        .evaluasi-group input:focus,
        .evaluasi-group select:focus,
        .evaluasi-group textarea:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.14);
        }

        .evaluasi-group textarea {
            height: 105px;
            resize: none;
        }

        .catatan-action-row {
            display: grid;
            grid-template-columns: 1fr 150px;
            gap: 28px;
            align-items: end;
        }

        .evaluasi-group textarea.catatan {
            height: 135px;
        }

        .modal-actions-evaluasi {
            display: flex;
            flex-direction: column;
            gap: 12px;
            justify-content: flex-end;
        }

        @media (max-width: 900px) {
            .evaluasi-grid-2 {
                grid-template-columns: 1fr;
                gap: 20px;
            }

            .catatan-action-row {
                grid-template-columns: 1fr;
            }

            .modal-actions-evaluasi {
                flex-direction: row;
                justify-content: flex-end;
            }
        }
    </style>

    <h1 class="page-title">Laporan Evaluasi Pasien</h1>

    <section class="table-card">
        <div class="table-top">
            <span class="table-label">Status Kunjungan Pasien</span>

            <div class="table-actions">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search">
                </div>

                <select class="sort-box">
                    <option>Short by : Newest</option>
                    <option>Oldest</option>
                </select>
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>No RM</th>
                        <th>No Regis Nasional</th>
                        <th>No Handphone</th>
                        <th>Jenis Kelamin</th>
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ([
                        ['Jane Cooper', 'Perempuan'],
                        ['Floyd Miles', 'Perempuan'],
                        ['Ronald Richards', 'Perempuan'],
                        ['Marvin McKinney', 'Laki - Laki'],
                        ['Jerome Bell', 'Laki - Laki'],
                        ['Kathryn Murphy', 'Laki - Laki'],
                        ['Jacob Jones', 'Laki - Laki'],
                        ['Kristin Watson', 'Perempuan']
                    ] as $pasien)
                        <tr>
                            <td>{{ $pasien[0] }}</td>
                            <td>2343</td>
                            <td>(225) 555-0118</td>
                            <td>086786987664</td>
                            <td>{{ $pasien[1] }}</td>
                            <td>
                                <button type="button" class="btn-detail open-evaluasi-modal">
                                    Detail
                                </button>
                            </td>
                        </tr>
                    @endforeach
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

    {{-- MODAL LAPORAN EVALUASI --}}
    <div class="modal-overlay" id="evaluasiModal">
        <div class="modal-box-evaluasi">
            <button class="modal-close" id="closeEvaluasiModal">&times;</button>

            <h2 class="modal-title-evaluasi">Formulir Laporan Evaluasi Pasien</h2>

            <form action="#" method="POST">
                @csrf

                <div class="evaluasi-grid-2">
                    <div class="evaluasi-group">
                        <label>Kunjungan :</label>
                        <select name="kunjungan">
                            <option value="">Pilih Kunjungan</option>
                            <option value="Kunjungan Pertama">Kunjungan Pertama</option>
                            <option value="Memenuhi Syarat Medis ART">Memenuhi Syarat Medis ART</option>
                            <option value="Saat Mulai ART">Saat Mulai ART</option>
                            <option value="Setelah 6 Bulan ART">Setelah 6 Bulan ART</option>
                            <option value="Setelah 12 Bulan ART">Setelah 12 Bulan ART</option>
                        </select>
                    </div>

                    <div class="evaluasi-group">
                        <label>Tanggal :</label>
                        <input type="date" name="tanggal">
                    </div>
                </div>

                <div class="evaluasi-grid-2">
                    <div class="evaluasi-group">
                        <label>Standar Klinis :</label>
                        <textarea name="standar_klinis"></textarea>
                    </div>

                    <div class="evaluasi-group">
                        <label>Status Fungsional (K.Amb.B) :</label>
                        <textarea name="status_fungsional"></textarea>
                    </div>
                </div>

                <div class="evaluasi-grid-2">
                    <div class="evaluasi-group">
                        <label>Lain - Lain :</label>
                        <textarea name="lain_lain"></textarea>
                    </div>

                    <div class="evaluasi-group">
                        <label>Jumlah CD 4 :</label>
                        <textarea name="jumlah_cd4"></textarea>
                    </div>
                </div>

                <div class="catatan-action-row">
                    <div class="evaluasi-group">
                        <label>Catatan</label>
                        <textarea name="catatan" class="catatan"></textarea>
                    </div>

                    <div class="modal-actions-evaluasi">
                        <button type="button" class="btn-modal-edit btn-confirm-edit">
                            <i class="fa-regular fa-pen-to-square"></i>
                            Edit
                        </button>

                        <button type="submit" class="btn-modal-save">
                            <i class="fa-regular fa-square-check"></i>
                            Simpan
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const evaluasiModal = document.getElementById('evaluasiModal');
                const openEvaluasiButtons = document.querySelectorAll('.open-evaluasi-modal');
                const closeEvaluasiButton = document.getElementById('closeEvaluasiModal');

                openEvaluasiButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        evaluasiModal.classList.add('show');
                    });
                });

                closeEvaluasiButton.addEventListener('click', function () {
                    evaluasiModal.classList.remove('show');
                });

                evaluasiModal.addEventListener('click', function (e) {
                    if (e.target === evaluasiModal) {
                        evaluasiModal.classList.remove('show');
                    }
                });
            });
        </script>
    @endpush
@endsection