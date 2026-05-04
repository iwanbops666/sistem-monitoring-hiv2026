@extends('layouts.app')

@section('title', 'Data Kartu Kendali Pasien')

@section('content')
    <style>
        .modal-box-kartu {
            background: #ffffff;
            width: 100%;
            max-width: 1100px;
            border-radius: 18px;
            padding: 34px 40px 28px;
            position: relative;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.16);
            max-height: 95vh;
            overflow-y: auto;
        }

        .modal-title-kartu {
            font-size: 32px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 34px;
        }

        .kartu-grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 28px 34px;
            margin-bottom: 22px;
        }

        .kartu-group label {
            display: block;
            font-size: 16px;
            color: #111827;
            margin-bottom: 9px;
            font-weight: 700;
        }

        .kartu-group input,
        .kartu-group textarea {
            width: 100%;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            padding: 10px 12px;
            outline: none;
            font-size: 14px;
            background: #ffffff;
        }

        .kartu-group input {
            height: 54px;
        }

        .kartu-group input[type="date"] {
            cursor: pointer;
        }

        .kartu-group input:focus,
        .kartu-group textarea:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.14);
        }

        .kartu-group textarea {
            height: 110px;
            resize: none;
        }

        .catatan-action-row {
            display: grid;
            grid-template-columns: 1fr 260px;
            gap: 28px;
            align-items: end;
        }

        .kartu-group textarea.catatan {
            height: 150px;
        }

        .modal-actions-kartu {
            display: flex;
            justify-content: flex-end;
            gap: 14px;
            align-items: center;
        }

        .modal-actions-kartu .btn-edit,
        .modal-actions-kartu .btn-save {
            min-width: 110px;
            height: 48px;
            border-radius: 7px;
            font-size: 16px;
        }

        @media (max-width: 900px) {
            .kartu-grid-2 {
                grid-template-columns: 1fr;
            }

            .catatan-action-row {
                grid-template-columns: 1fr;
            }

            .modal-actions-kartu {
                justify-content: flex-end;
            }
        }
    </style>

    <h1 class="page-title">Data Kartu Kendali Pasien</h1>

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
                        ['Jane Cooper', '1234', '(225) 555-0118', '086786987664', 'Perempuan'],
                        ['Floyd Miles', '1234', '(205) 555-0100', '086786987664', 'Perempuan'],
                        ['Ronald Richards', '1234', '(302) 555-0107', '086786987664', 'Perempuan'],
                        ['Marvin McKinney', '1234', '(252) 555-0126', '086786987664', 'Laki - Laki'],
                        ['Jerome Bell', '1234', '(629) 555-0129', '086786987664', 'Laki - Laki'],
                        ['Kathryn Murphy', '1234', '(406) 555-0120', '086786987664', 'Laki - Laki'],
                        ['Jacob Jones', '1234', '(208) 555-0112', '086786987664', 'Laki - Laki'],
                        ['Kristin Watson', '1234', '(704) 555-0127', '086786987664', 'Perempuan'],
                    ] as $pasien)
                        <tr>
                            <td>{{ $pasien[0] }}</td>
                            <td>{{ $pasien[1] }}</td>
                            <td>{{ $pasien[2] }}</td>
                            <td>{{ $pasien[3] }}</td>
                            <td>{{ $pasien[4] }}</td>
                            <td>
                                <button type="button" class="btn-detail open-kartu-modal">
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

    {{-- MODAL FORMULIR KARTU KENDALI --}}
    <div class="modal-overlay" id="kartuModal">
        <div class="modal-box-kartu">
            <button class="modal-close" id="closeKartuModal">&times;</button>

            <h2 class="modal-title-kartu">Formulir Kartu Kendali Pasien</h2>

            <form action="#" method="POST">
                @csrf

                <div class="kartu-grid-2">
                    <div class="kartu-group">
                        <label>Tanggal Kunjungan :</label>
                        <input type="date" name="tanggal_kunjungan">
                    </div>

                    <div class="kartu-group">
                        <label>Rencana Tanggal Kunjungan Selanjutnya:</label>
                        <input type="date" name="rencana_tanggal_kunjungan_selanjutnya">
                    </div>
                </div>

                <div class="kartu-grid-2">
                    <div class="kartu-group">
                        <label>Rejiman dan Jumlah Obat ARV yang : Tersisa :</label>
                        <textarea name="rejiman_jumlah_obat_arv_tersisa"></textarea>
                    </div>

                    <div class="kartu-group">
                        <label>Jumlah INH yang Tersisa :</label>
                        <textarea name="jumlah_inh_tersisa"></textarea>
                    </div>
                </div>

                <div class="kartu-grid-2">
                    <div class="kartu-group">
                        <label>Jumlah INH yang Diberikan Untuk Bulan Berikutnya :</label>
                        <textarea name="jumlah_inh_diberikan_bulan_berikutnya"></textarea>
                    </div>

                    <div class="kartu-group">
                        <label>Efek Samping ARV / IO / Proflaksis O :</label>
                        <textarea name="efek_samping_arv_io_proflaksis"></textarea>
                    </div>
                </div>

                <div class="catatan-action-row">
                    <div class="kartu-group">
                        <label>Catatan</label>
                        <textarea name="catatan" class="catatan"></textarea>
                    </div>

                    <div class="modal-actions-kartu">
                        <button type="button" class="btn-edit btn-confirm-edit">
                            <i class="fa-regular fa-pen-to-square"></i>
                            Edit
                        </button>

                        <button type="submit" class="btn-save">
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
                const kartuModal = document.getElementById('kartuModal');
                const openButtons = document.querySelectorAll('.open-kartu-modal');
                const closeButton = document.getElementById('closeKartuModal');

                openButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        kartuModal.classList.add('show');
                    });
                });

                closeButton.addEventListener('click', function () {
                    kartuModal.classList.remove('show');
                });

                kartuModal.addEventListener('click', function (event) {
                    if (event.target === kartuModal) {
                        kartuModal.classList.remove('show');
                    }
                });
            });
        </script>
    @endpush
@endsection