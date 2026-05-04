@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
    <style>
        .modal-box-identitas {
            background: #ffffff;
            width: 100%;
            max-width: 960px;
            border-radius: 18px;
            padding: 24px 28px 26px;
            position: relative;
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.16);
            max-height: 95vh;
            overflow-y: auto;
        }

        .modal-title-identitas {
            font-size: 34px;
            font-weight: 900;
            color: #1f2937;
            margin-bottom: 26px;
        }

        .identitas-grid {
            display: grid;
            grid-template-columns: 1.15fr 1.15fr 1fr;
            gap: 24px 28px;
        }

        .identitas-column {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .identitas-group label {
            display: block;
            font-size: 16px;
            color: #111;
            margin-bottom: 4px;
        }

        .identitas-group input,
        .identitas-group select {
            width: 100%;
            height: 35px;
            border: 1px solid #d6d6d6;
            border-radius: 7px;
            padding: 0 10px;
            outline: none;
            font-size: 14px;
            background: #ffffff;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.08);
        }

        .identitas-group input[type="date"] {
            padding-right: 10px;
        }

        .identitas-group input:focus,
        .identitas-group select:focus {
            border-color: #16b874;
            box-shadow: 0 0 0 3px rgba(22, 184, 116, 0.15);
        }

        .identitas-inline-row {
            display: grid;
            grid-template-columns: auto 52px auto 52px;
            align-items: center;
            gap: 8px;
        }

        .identitas-inline-address {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .phone-input {
            position: relative;
        }

        .phone-input span {
            position: absolute;
            left: 10px;
            top: 31px;
            font-size: 14px;
            color: #111;
        }

        .phone-input input {
            padding-left: 42px;
        }

        .modal-actions-identitas {
            display: flex;
            justify-content: flex-end;
            gap: 12px;
            margin-top: 14px;
        }

        @media (max-width: 900px) {
            .identitas-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <h1 class="page-title">Data Pasien</h1>

    <section class="table-card">
        <div class="table-top">
            <span class="table-label">Data Pasien</span>

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
                        <th>Aksi</th>
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
                                <button type="button" class="btn-detail open-identitas-modal">
                                    Detail
                                </button>

                                <button class="btn-delete" type="button">
                                    <i class="fa-regular fa-trash-can"></i>
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

    {{-- MODAL IDENTITAS PASIEN --}}
    <div class="modal-overlay" id="identitasModal">
        <div class="modal-box-identitas">
            <button class="modal-close" id="closeIdentitasModal">&times;</button>

            <h2 class="modal-title-identitas">Identitas Pasien</h2>

            <form action="#" method="POST">
                @csrf

                <div class="identitas-grid">

                    {{-- KOLOM 1 --}}
                    <div class="identitas-column">
                        <div class="identitas-group">
                            <label>Nama</label>
                            <input type="text" name="nama">
                        </div>

                        <div class="identitas-group">
                            <label>Nomor RM</label>
                            <input type="text" name="nomor_rm">
                        </div>

                        <div class="identitas-group">
                            <label>NIK</label>
                            <input type="text" name="nik">
                        </div>

                        <div class="identitas-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir">
                        </div>

                        <div class="identitas-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir">
                        </div>

                        <div class="identitas-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin">
                                <option value=""></option>
                                <option value="Laki-laki">Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="identitas-group">
                            <label>Agama</label>
                            <select name="agama">
                                <option value=""></option>
                                <option value="Islam">Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                            </select>
                        </div>

                        <div class="identitas-group">
                            <label>Status Perkawinan</label>
                            <select name="status_perkawinan">
                                <option value=""></option>
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin">Kawin</option>
                                <option value="Cerai Hidup">Cerai Hidup</option>
                                <option value="Cerai Mati">Cerai Mati</option>
                            </select>
                        </div>

                        <div class="identitas-group">
                            <label>Email Pasien</label>
                            <input type="email" name="email_pasien">
                        </div>

                        <div class="identitas-group">
                            <label>Email Keluarga Pasien</label>
                            <input type="email" name="email_keluarga">
                        </div>
                    </div>

                    {{-- KOLOM 2 --}}
                    <div class="identitas-column">
                        <div class="identitas-group">
                            <label>Alamat Lengkap</label>
                            <input type="text" name="alamat_lengkap">
                        </div>

                        <div class="identitas-group identitas-inline-row">
                            <label>RT:</label>
                            <input type="text" name="rt">
                            <label>RW:</label>
                            <input type="text" name="rw">
                        </div>

                        <div class="identitas-group identitas-inline-address">
                            <div>
                                <label>Kab:</label>
                                <input type="text" name="kabupaten">
                            </div>
                            <div>
                                <label>Kec:</label>
                                <input type="text" name="kecamatan">
                            </div>
                        </div>

                        <div class="identitas-group">
                            <label>Alamat Keluarga</label>
                            <input type="text" name="alamat_keluarga">
                        </div>

                        <div class="identitas-group identitas-inline-row">
                            <label>RT:</label>
                            <input type="text" name="rt_keluarga">
                            <label>RW:</label>
                            <input type="text" name="rw_keluarga">
                        </div>

                        <div class="identitas-group identitas-inline-address">
                            <div>
                                <label>Kab:</label>
                                <input type="text" name="kabupaten_keluarga">
                            </div>
                            <div>
                                <label>Kec:</label>
                                <input type="text" name="kecamatan_keluarga">
                            </div>
                        </div>

                        <div class="identitas-group phone-input">
                            <label>No.HP</label>
                            <span>+62</span>
                            <input type="text" name="no_hp">
                        </div>

                        <div class="identitas-group phone-input">
                            <label>No.HP Keluarga</label>
                            <span>+62</span>
                            <input type="text" name="no_hp_keluarga">
                        </div>

                        <div class="identitas-group">
                            <label>No Registrasi Nasional</label>
                            <input type="text" name="no_registrasi_nasional">
                        </div>

                        <div class="identitas-group">
                            <label>Status Pasien</label>
                            <select name="status_pasien">
                                <option value=""></option>
                                <option value="Aktif">Hidup</option>
                                <option value="Inactive">Meninggal</option>
                            </select>
                        </div>

                        <div class="identitas-group">
                            <label>Password Pasien</label>
                            <input type="password" name="password_pasien">
                        </div>

                        <div class="identitas-group">
                            <label>Password Keluarga Pasien</label>
                            <input type="password" name="password_keluarga">
                        </div>
                    </div>

                    {{-- KOLOM 3 --}}
                    <div class="identitas-column">
                        <div class="identitas-group">
                            <label>Kode Pos :</label>
                            <input type="text" name="kode_pos">
                        </div>

                        <div class="identitas-group">
                            <label>Kec:</label>
                            <input type="text" name="kec_kanan">
                        </div>

                        <div class="identitas-group">
                            <label>Prov:</label>
                            <input type="text" name="provinsi">
                        </div>

                        <div class="identitas-group">
                            <label>Kec:</label>
                            <input type="text" name="kec_keluarga_kanan">
                        </div>

                        <div class="identitas-group">
                            <label>Prov:</label>
                            <input type="text" name="provinsi_keluarga">
                        </div>

                        <div class="identitas-group">
                            <label>Tanggal Awal Pengobatan</label>
                            <input type="date" name="tanggal_awal_pengobatan">
                        </div>

                        <div class="identitas-group">
                            <label>Nama Keluarga</label>
                            <input type="text" name="nama_keluarga">
                        </div>

                        <div class="identitas-group">
                            <label>Lokasi Diagnosa</label>
                            <input type="text" name="lokasi_diagnosa">
                        </div>

                        <div class="identitas-group">
                            <label>Keterangan Pasien</label>
                            <select name="keterangan_pasien">
                                <option value=""></option>
                                <option value="Baru">Baru</option>
                                <option value="Lama">Lama</option>
                                <option value="Pindahan">Pindahan</option>
                                <option value="Pindahan">Pindah</option>
                            </select>
                        </div>

                        <div class="modal-actions-identitas">
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

                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const identitasModal = document.getElementById('identitasModal');
                const openIdentitasButtons = document.querySelectorAll('.open-identitas-modal');
                const closeIdentitasButton = document.getElementById('closeIdentitasModal');

                openIdentitasButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        identitasModal.classList.add('show');
                    });
                });

                closeIdentitasButton.addEventListener('click', function () {
                    identitasModal.classList.remove('show');
                });

                identitasModal.addEventListener('click', function (e) {
                    if (e.target === identitasModal) {
                        identitasModal.classList.remove('show');
                    }
                });
            });
        </script>
    @endpush
@endsection