@extends('layouts.pasien')

@section('title', 'Profile Pasien')
@section('page-title', '')

@section('content')
    <style>
        .pasien-topbar {
            display: none;
        }

        .profile-page {
            width: 100%;
            max-width: 1120px;
            margin-top: -18px;
        }

        .profile-card {
            width: 100%;
            background: #ffffff;
            border-radius: 24px;
            padding: 34px 50px 34px;
            box-shadow: 0 18px 35px rgba(213, 224, 235, 0.68);
        }

        .profile-card-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 42px;
        }

        .profile-title {
            font-size: 38px;
            font-weight: 900;
            color: #1f2937;
            line-height: 1;
        }

        .profile-header-right {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .profile-bell-btn {
            border: none;
            background: transparent;
            font-size: 30px;
            color: #000000;
            cursor: pointer;
            position: relative;
        }

        .profile-bell-btn::after {
            content: "";
            position: absolute;
            right: 0;
            top: 3px;
            width: 10px;
            height: 10px;
            background: #22c55e;
            border-radius: 50%;
            border: 2px solid #ffffff;
        }

        .profile-mini-user {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .profile-mini-user img {
            width: 66px;
            height: 66px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 8px 18px rgba(0,0,0,0.18);
        }

        .profile-mini-user h4 {
            font-size: 16px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 4px;
        }

        .profile-mini-user span {
            font-size: 14px;
            font-weight: 600;
            color: #8b8b8b;
        }

        .profile-form-grid {
            display: grid;
            grid-template-columns: 1.1fr 1.1fr 1fr;
            gap: 24px 36px;
            align-items: start;
        }

        .profile-column {
            display: flex;
            flex-direction: column;
            gap: 14px;
        }

        .profile-group label {
            display: block;
            font-size: 16px;
            font-weight: 500;
            color: #111827;
            margin-bottom: 7px;
        }

        .profile-group input,
        .profile-group select {
            width: 100%;
            height: 43px;
            border: 1px solid #d8d8d8;
            border-radius: 8px;
            padding: 0 13px;
            background: #ffffff;
            color: #111827;
            font-size: 15px;
            outline: none;
            box-shadow: inset 0 1px 2px rgba(0,0,0,0.06);
        }

        .profile-group input:focus,
        .profile-group select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.14);
        }

        .profile-group input:disabled,
        .profile-group select:disabled,
        .readonly-field {
            background: #bebaba !important;
            color: #111827 !important;
            cursor: not-allowed;
            opacity: 1;
        }

        .profile-inline-small {
            display: grid;
            grid-template-columns: auto 70px auto 70px;
            align-items: end;
            gap: 10px;
        }

        .profile-inline-small label {
            margin-bottom: 10px;
        }

        .profile-inline-two {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 14px;
        }

        .phone-wrapper {
            position: relative;
        }

        .phone-wrapper span {
            position: absolute;
            left: 13px;
            bottom: 11px;
            color: #111827;
            font-size: 15px;
        }

        .phone-wrapper input {
            padding-left: 48px;
        }

        .profile-actions {
            display: flex;
            justify-content: flex-end;
            align-items: center;
            gap: 14px;
            margin-top: 26px;
        }

        .btn-profile-edit,
        .btn-profile-save {
            border: none;
            min-width: 120px;
            height: 42px;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 800;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.16);
        }

        .btn-profile-edit {
            background: #ffc1c1;
            color: #ff1f1f;
        }

        .btn-profile-save {
            background: #00b889;
            color: #ffffff;
        }

        .profile-toast {
            position: fixed;
            top: 30px;
            right: 40px;
            width: 285px;
            min-height: 74px;
            background: #65a87d;
            color: #ffffff;
            border-radius: 2px;
            padding: 14px 18px;
            display: none;
            align-items: center;
            gap: 12px;
            z-index: 100000;
            box-shadow: 0 10px 28px rgba(0, 0, 0, 0.18);
        }

        .profile-toast.show {
            display: flex;
            animation: toastSlide 0.25s ease;
        }

        @keyframes toastSlide {
            from {
                opacity: 0;
                transform: translateY(-12px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .profile-toast-icon {
            width: 26px;
            height: 26px;
            border-radius: 50%;
            background: #2fd07c;
            color: #ffffff;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .profile-toast h4 {
            font-size: 14px;
            font-weight: 800;
            margin-bottom: 3px;
        }

        .profile-toast p {
            font-size: 11px;
            margin: 0;
        }

        .edit-confirm-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.32);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 100001;
        }

        .edit-confirm-overlay.show {
            display: flex;
        }

        .edit-confirm-box {
            width: 420px;
            background: #ffffff;
            border-radius: 4px;
            padding: 32px 28px 28px;
            text-align: center;
            box-shadow: 0 14px 35px rgba(0,0,0,0.18);
        }

        .edit-warning-icon {
            width: 86px;
            height: 76px;
            margin: 0 auto 20px;
            position: relative;
        }

        .edit-warning-icon::before {
            content: "";
            position: absolute;
            inset: 0;
            background: #ff1f2d;
            clip-path: polygon(50% 0%, 100% 100%, 0% 100%);
        }

        .edit-warning-icon::after {
            content: "!";
            position: absolute;
            left: 50%;
            top: 58%;
            transform: translate(-50%, -50%);
            color: #ffffff;
            font-size: 46px;
            font-weight: 900;
        }

        .edit-confirm-text {
            font-size: 18px;
            color: #4b4b4b;
            font-weight: 600;
            line-height: 1.35;
            margin-bottom: 28px;
        }

        .edit-confirm-actions {
            display: flex;
            justify-content: center;
            gap: 28px;
        }

        .edit-confirm-yes,
        .edit-confirm-no {
            border: none;
            color: #ffffff;
            padding: 9px 42px;
            border-radius: 18px;
            font-weight: 700;
            cursor: pointer;
        }

        .edit-confirm-yes {
            background: #23ad5c;
        }

        .edit-confirm-no {
            background: #ff1f2d;
        }

        @media (max-width: 1100px) {
            .profile-form-grid {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media (max-width: 760px) {
            .profile-card {
                padding: 32px 24px;
            }

            .profile-card-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 22px;
            }

            .profile-form-grid {
                grid-template-columns: 1fr;
            }

            .profile-inline-small,
            .profile-inline-two {
                grid-template-columns: 1fr;
            }

            .profile-actions {
                justify-content: flex-start;
                flex-wrap: wrap;
            }
        }
    </style>

    <div class="profile-page">
        <section class="profile-card">
            <div class="profile-card-header">
                <h1 class="profile-title">Profile Pasien</h1>

                <div class="profile-header-right">
                    <button type="button" class="profile-bell-btn" id="profileBellButton">
                        <i class="fa-regular fa-bell"></i>
                    </button>

                    <div class="profile-mini-user">
                        <img src="https://i.pravatar.cc/150?img=12" alt="Profile Pasien">
                        <div>
                            <h4>Jono Widodo</h4>
                            <span>Pasien</span>
                        </div>
                    </div>
                </div>
            </div>

            <form action="#" method="POST" id="profilePasienForm">
                @csrf

                <div class="profile-form-grid">
                    <div class="profile-column">
                        <div class="profile-group">
                            <label>Nama</label>
                            <input type="text" name="nama" value="Jono Widodo">
                        </div>

                        <div class="profile-group">
                            <label>Nomor RM</label>
                            <input type="text" name="nomor_rm" value="RM-0001" class="readonly-field" disabled>
                        </div>

                        <div class="profile-group">
                            <label>NIK</label>
                            <input type="text" name="nik" value="3510123456789001">
                        </div>

                        <div class="profile-group">
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" value="Banyuwangi">
                        </div>

                        <div class="profile-group">
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="1987-04-23">
                        </div>

                        <div class="profile-group">
                            <label>Jenis Kelamin</label>
                            <select name="jenis_kelamin">
                                <option value="Laki-laki" selected>Laki-laki</option>
                                <option value="Perempuan">Perempuan</option>
                            </select>
                        </div>

                        <div class="profile-group">
                            <label>Agama</label>
                            <select name="agama">
                                <option value="Islam" selected>Islam</option>
                                <option value="Kristen">Kristen</option>
                                <option value="Katolik">Katolik</option>
                                <option value="Hindu">Hindu</option>
                                <option value="Buddha">Buddha</option>
                            </select>
                        </div>

                        <div class="profile-group">
                            <label>Status Perkawinan</label>
                            <select name="status_perkawinan">
                                <option value="Belum Kawin">Belum Kawin</option>
                                <option value="Kawin" selected>Kawin</option>
                                <option value="Cerai Hidup">Cerai Hidup</option>
                                <option value="Cerai Mati">Cerai Mati</option>
                            </select>
                        </div>
                    </div>

                    <div class="profile-column">
                        <div class="profile-group">
                            <label>Alamat Lengkap</label>
                            <input type="text" name="alamat_lengkap" value="Benculuk">
                        </div>

                        <div class="profile-group profile-inline-small">
                            <label>RT:</label>
                            <input type="text" name="rt" value="01">

                            <label>RW:</label>
                            <input type="text" name="rw" value="02">
                        </div>

                        <div class="profile-group profile-inline-two">
                            <div>
                                <label>Kab:</label>
                                <input type="text" name="kabupaten" value="Banyuwangi">
                            </div>

                            <div>
                                <label>Kec:</label>
                                <input type="text" name="kecamatan" value="Cluring">
                            </div>
                        </div>

                        <div class="profile-group">
                            <label>Alamat Keluarga</label>
                            <input type="text" name="alamat_keluarga" value="Benculuk">
                        </div>

                        <div class="profile-group profile-inline-small">
                            <label>RT:</label>
                            <input type="text" name="rt_keluarga" value="01">

                            <label>RW:</label>
                            <input type="text" name="rw_keluarga" value="02">
                        </div>

                        <div class="profile-group profile-inline-two">
                            <div>
                                <label>Kab:</label>
                                <input type="text" name="kabupaten_keluarga" value="Banyuwangi">
                            </div>

                            <div>
                                <label>Kec:</label>
                                <input type="text" name="kecamatan_keluarga" value="Cluring">
                            </div>
                        </div>

                        <div class="profile-group phone-wrapper">
                            <label>No.HP</label>
                            <span>+62</span>
                            <input type="text" name="no_hp" value="81342564533">
                        </div>

                        <div class="profile-group phone-wrapper">
                            <label>No.HP Keluarga</label>
                            <span>+62</span>
                            <input type="text" name="no_hp_keluarga" value="81234567890">
                        </div>

                        <div class="profile-group">
                            <label>No Registrasi Nasional</label>
                            <input type="text" name="no_registrasi_nasional" value="REG-0001" class="readonly-field" disabled>
                        </div>

                        <div class="profile-group">
                            <label>Status Pasien :</label>
                            <select name="status_pasien" class="readonly-field" disabled>
                                <option value="Aktif" selected>Aktif</option>
                                <option value="Inactive">Inactive</option>
                                <option value="LTFU">LTFU</option>
                            </select>
                        </div>
                    </div>

                    <div class="profile-column">
                        <div class="profile-group">
                            <label>Kode Pos :</label>
                            <input type="text" name="kode_pos" value="68482">
                        </div>

                        <div class="profile-group">
                            <label>Kec:</label>
                            <input type="text" name="kec_kanan" value="Cluring">
                        </div>

                        <div class="profile-group">
                            <label>Prov:</label>
                            <input type="text" name="provinsi" value="Jawa Timur">
                        </div>

                        <div class="profile-group">
                            <label>Kec:</label>
                            <input type="text" name="kec_keluarga_kanan" value="Cluring">
                        </div>

                        <div class="profile-group">
                            <label>Prov:</label>
                            <input type="text" name="provinsi_keluarga" value="Jawa Timur">
                        </div>

                        <div class="profile-group">
                            <label>Tanggal Awal Pengobatan</label>
                            <input type="text" name="tanggal_awal_pengobatan" value="16/04/2026" class="readonly-field" disabled>
                        </div>

                        <div class="profile-group">
                            <label>Lokasi Diagnosa</label>
                            <input type="text" name="lokasi_diagnosa" value="Puskesmas Benculuk" class="readonly-field" disabled>
                        </div>

                        <div class="profile-group">
                            <label>Email</label>
                            <input type="email" name="email" value="jono@gmail.com">
                        </div>

                        <div class="profile-group">
                            <label>Password</label>
                            <input type="password" name="password" value="password">
                        </div>
                    </div>
                </div>

                <div class="profile-actions">
                    <button type="button" class="btn-profile-edit" id="btnEditProfilePasien">
                        <i class="fa-regular fa-pen-to-square"></i>
                        Edit
                    </button>

                    <button type="submit" class="btn-profile-save" id="btnSaveProfilePasien">
                        <i class="fa-regular fa-square-check"></i>
                        Simpan
                    </button>
                </div>
            </form>
        </section>
    </div>

    <div class="profile-toast" id="profileSuccessToast">
        <div class="profile-toast-icon">
            <i class="fa-regular fa-circle-check"></i>
        </div>

        <div>
            <h4>Berhasil Tersimpan</h4>
            <p>Telah Tersimpan</p>
        </div>
    </div>

    <div class="edit-confirm-overlay" id="profileEditConfirm">
        <div class="edit-confirm-box">
            <div class="edit-warning-icon"></div>

            <div class="edit-confirm-text">
                Perubahan akan disimpan.<br>
                Lanjutkan edit data ini?
            </div>

            <div class="edit-confirm-actions">
                <button type="button" class="edit-confirm-yes" id="profileEditYes">Ya</button>
                <button type="button" class="edit-confirm-no" id="profileEditNo">Tidak</button>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const form = document.getElementById('profilePasienForm');
                const toast = document.getElementById('profileSuccessToast');
                const editButton = document.getElementById('btnEditProfilePasien');
                const editConfirm = document.getElementById('profileEditConfirm');
                const editYes = document.getElementById('profileEditYes');
                const editNo = document.getElementById('profileEditNo');

                let toastTimer = null;

                function showToast() {
                    if (!toast) return;

                    toast.classList.add('show');

                    if (toastTimer) {
                        clearTimeout(toastTimer);
                    }

                    toastTimer = setTimeout(function () {
                        toast.classList.remove('show');
                    }, 1800);
                }

                if (form) {
                    form.addEventListener('submit', function (event) {
                        event.preventDefault();
                        showToast();
                    });
                }

                if (editButton && editConfirm) {
                    editButton.addEventListener('click', function () {
                        editConfirm.classList.add('show');
                    });
                }

                if (editYes && editConfirm) {
                    editYes.addEventListener('click', function () {
                        editConfirm.classList.remove('show');
                    });
                }

                if (editNo && editConfirm) {
                    editNo.addEventListener('click', function () {
                        editConfirm.classList.remove('show');
                    });
                }

                if (editConfirm) {
                    editConfirm.addEventListener('click', function (event) {
                        if (event.target === editConfirm) {
                            editConfirm.classList.remove('show');
                        }
                    });
                }

                const profileBellButton = document.getElementById('profileBellButton');
                const pasienBellButton = document.getElementById('pasienBellButton');

                if (profileBellButton && pasienBellButton) {
                    profileBellButton.addEventListener('click', function () {
                        pasienBellButton.click();
                    });
                }
            });
        </script>
    @endpush
@endsection