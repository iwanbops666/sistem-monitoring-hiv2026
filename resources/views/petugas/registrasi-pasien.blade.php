@extends('layouts.app')

@section('title', 'Registrasi Pasien')

@section('content')
    <style>
        .registrasi-card {
            width: 100%;
            max-width: 980px;
            background: #ffffff;
            border-radius: 22px;
            padding: 26px 30px 28px;
            box-shadow: 0 4px 10px rgba(0,0,0,0.16);
        }

        .registrasi-title {
            font-size: 36px;
            font-weight: 900;
            color: #202633;
            margin-bottom: 24px;
        }

        .registrasi-grid {
            display: grid;
            grid-template-columns: 1.15fr 1.15fr 1fr;
            gap: 22px 30px;
        }

        .form-column {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .form-group label {
            display: block;
            font-size: 15px;
            color: #111;
            margin-bottom: 4px;
        }

        .form-group input,
        .form-group select {
            width: 100%;
            height: 34px;
            border: 1px solid #d5d5d5;
            border-radius: 7px;
            padding: 0 10px;
            font-size: 14px;
            outline: none;
            background: #ffffff;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.08);
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.14);
        }

        .inline-row {
            display: grid;
            grid-template-columns: auto 54px auto 54px;
            align-items: center;
            gap: 8px;
        }

        .inline-address {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .phone-group {
            position: relative;
        }

        .phone-group span {
            position: absolute;
            left: 10px;
            top: 29px;
            font-size: 14px;
            color: #111;
        }

        .phone-group input {
            padding-left: 42px;
        }

        .button-area {
            display: flex;
            justify-content: flex-end;
            align-items: flex-end;
            margin-top: auto;
            padding-top: 18px;
        }

        .btn-simpan-form {
            background: #00b889;
            color: #ffffff;
            border: none;
            padding: 10px 24px;
            border-radius: 4px;
            font-weight: 700;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            box-shadow: 0 3px 6px rgba(0,0,0,0.18);
        }

        @media (max-width: 1100px) {
            .registrasi-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 800px) {
            .registrasi-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <section class="registrasi-card">
        <h1 class="registrasi-title">Registrasi Pasien</h1>

        <form action="#" method="POST">
            @csrf

            <div class="registrasi-grid">
                <div class="form-column">
                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama">
                    </div>

                    <div class="form-group">
                        <label>Nomor RM</label>
                        <input type="text" name="nomor_rm">
                    </div>

                    <div class="form-group">
                        <label>NIK</label>
                        <input type="text" name="nik">
                    </div>

                    <div class="form-group">
                        <label>Tempat Lahir</label>
                        <input type="text" name="tempat_lahir">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir">
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                            <option value=""></option>
                            <option value="Laki-laki">Laki-laki</option>
                            <option value="Perempuan">Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Agama</label>
                        <select name="agama">
                            <option value=""></option>
                            <option>Islam</option>
                            <option>Kristen</option>
                            <option>Katolik</option>
                            <option>Hindu</option>
                            <option>Buddha</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Status Perkawinan</label>
                        <select name="status_perkawinan">
                            <option value=""></option>
                            <option>Belum Kawin</option>
                            <option>Kawin</option>
                            <option>Cerai Hidup</option>
                            <option>Cerai Mati</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Email Pasien</label>
                        <input type="email" name="email_pasien">
                    </div>

                    <div class="form-group">
                        <label>Email Keluarga Pasien</label>
                        <input type="email" name="email_keluarga">
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label>Alamat Lengkap</label>
                        <input type="text" name="alamat_lengkap">
                    </div>

                    <div class="form-group inline-row">
                        <label>RT:</label>
                        <input type="text" name="rt">
                        <label>RW:</label>
                        <input type="text" name="rw">
                    </div>

                    <div class="form-group inline-address">
                        <div>
                            <label>Kab:</label>
                            <input type="text" name="kabupaten">
                        </div>
                        <div>
                            <label>Kec:</label>
                            <input type="text" name="kecamatan">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Alamat Keluarga</label>
                        <input type="text" name="alamat_keluarga">
                    </div>

                    <div class="form-group inline-row">
                        <label>RT:</label>
                        <input type="text" name="rt_keluarga">
                        <label>RW:</label>
                        <input type="text" name="rw_keluarga">
                    </div>

                    <div class="form-group inline-address">
                        <div>
                            <label>Kab:</label>
                            <input type="text" name="kabupaten_keluarga">
                        </div>
                        <div>
                            <label>Kec:</label>
                            <input type="text" name="kecamatan_keluarga">
                        </div>
                    </div>

                    <div class="form-group phone-group">
                        <label>No.HP</label>
                        <span>+62</span>
                        <input type="text" name="no_hp">
                    </div>

                    <div class="form-group phone-group">
                        <label>No.HP Keluarga</label>
                        <span>+62</span>
                        <input type="text" name="no_hp_keluarga">
                    </div>

                    <div class="form-group">
                        <label>No Registrasi Nasional</label>
                        <input type="text" name="no_registrasi_nasional">
                    </div>

                    <div class="form-group">
                        <label>Status Pasien</label>
                        <select name="status_pasien">
                            <option value=""></option>
                            <option>Aktif</option>
                            <option>Inactive</option>
                            <option>LTFU</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Password Pasien</label>
                        <input type="password" name="password_pasien">
                    </div>

                    <div class="form-group">
                        <label>Password Keluarga Pasien</label>
                        <input type="password" name="password_keluarga">
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <label>Kode Pos :</label>
                        <input type="text" name="kode_pos">
                    </div>

                    <div class="form-group">
                        <label>Prov:</label>
                        <input type="text" name="provinsi">
                    </div>

                    <div class="form-group">
                        <label>Prov:</label>
                        <input type="text" name="provinsi_keluarga">
                    </div>

                    <div class="form-group">
                        <label>Tanggal Awal Pengobatan</label>
                        <input type="date" name="tanggal_awal_pengobatan">
                    </div>

                    <div class="form-group">
                        <label>Nama Keluarga</label>
                        <input type="text" name="nama_keluarga">
                    </div>

                    <div class="form-group">
                        <label>Lokasi Diagnosa</label>
                        <input type="text" name="lokasi_diagnosa">
                    </div>

                    <div class="form-group">
                        <label>Keterangan Pasien</label>
                        <select name="keterangan_pasien">
                            <option value=""></option>
                            <option>Baru</option>
                            <option>Lama</option>
                            <option>Pindahan</option>
                        </select>
                    </div>

                    <div class="button-area">
                        <button type="submit" class="btn-simpan-form">
                            <i class="fa-regular fa-square-check"></i>
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>
@endsection