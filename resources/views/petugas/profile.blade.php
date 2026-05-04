@extends('layouts.app')

@section('title', 'Profile')

@section('content')
    <style>
        .profile-page {
            max-width: 1050px;
        }

        .profile-topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 70px;
        }

        .profile-title {
            font-size: 42px;
            font-weight: 900;
            color: #1f2937;
        }

        .profile-user-area {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .profile-bell {
            font-size: 28px;
            color: #000;
        }

        .profile-mini {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .profile-mini img {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 8px 18px rgba(0,0,0,0.18);
        }

        .profile-mini h4 {
            font-size: 16px;
            font-weight: 800;
            margin-bottom: 3px;
            color: #1f2937;
        }

        .profile-mini span {
            font-size: 14px;
            color: #777;
        }

        .profile-form {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 34px 42px;
            align-items: start;
        }

        .profile-column {
            display: flex;
            flex-direction: column;
            gap: 18px;
        }

        .profile-row {
            display: grid;
            grid-template-columns: 120px 1fr;
            align-items: center;
            gap: 22px;
        }

        .profile-row label {
            font-size: 18px;
            font-weight: 800;
            color: #14532d;
        }

        .profile-row input,
        .profile-row select {
            width: 100%;
            height: 46px;
            border: 1px solid #111;
            border-radius: 8px;
            padding: 0 28px;
            font-size: 17px;
            color: #14532d;
            background: #f9fafb;
            outline: none;
        }

        .profile-date {
            position: relative;
        }

        .profile-date i {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 21px;
            color: #111;
        }

        .profile-actions {
            margin-top: 18px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            grid-column: 1 / 3;
        }

        .btn-change-password {
            border: none;
            background: #5b5d5c;
            color: #ffffff;
            padding: 14px 30px;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 5px 12px rgba(0,0,0,0.18);
        }

        .right-actions {
            display: flex;
            gap: 16px;
        }

        .btn-edit-profile {
            border: none;
            background: #ff1f1f;
            color: #ffffff;
            padding: 14px 34px;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 5px 12px rgba(0,0,0,0.18);
        }

        .btn-save-profile {
            border: none;
            background: #22b463;
            color: #ffffff;
            padding: 14px 40px;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 5px 12px rgba(0,0,0,0.18);
        }

        /* MODAL PASSWORD */
        .password-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.22);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            padding: 20px;
        }

        .password-overlay.show {
            display: flex;
        }

        .password-modal {
            width: 100%;
            max-width: 620px;
            background: #ffffff;
            border: 1px solid #111;
            border-radius: 8px;
            padding: 34px 34px 32px;
            box-shadow: 0 14px 32px rgba(0,0,0,0.18);
        }

        .password-modal h2 {
            font-size: 24px;
            font-weight: 900;
            color: #14532d;
            font-style: italic;
            margin-bottom: 28px;
        }

        .password-row {
            display: grid;
            grid-template-columns: 200px 1fr;
            align-items: center;
            gap: 22px;
            margin-bottom: 18px;
        }

        .password-row label {
            font-size: 17px;
            font-weight: 900;
            color: #14532d;
            font-style: italic;
        }

        .password-row input {
            height: 46px;
            border: 1px solid #111;
            border-radius: 8px;
            padding: 0 28px;
            font-size: 17px;
            color: #14532d;
            background: #f9fafb;
            outline: none;
        }

        .password-row input::placeholder {
            color: #8baa9a;
            font-style: italic;
        }

        .password-action {
            display: flex;
            justify-content: flex-end;
            margin-top: 28px;
        }

        .btn-submit-password {
            border: none;
            background: #5b5d5c;
            color: #ffffff;
            padding: 14px 32px;
            border-radius: 8px;
            font-size: 17px;
            font-weight: 900;
            cursor: pointer;
            box-shadow: 0 5px 12px rgba(0,0,0,0.18);
        }

        @media (max-width: 900px) {
            .profile-form {
                grid-template-columns: 1fr;
            }

            .profile-actions {
                grid-column: 1;
                flex-direction: column;
                align-items: flex-start;
                gap: 18px;
            }

            .profile-row {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .password-row {
                grid-template-columns: 1fr;
                gap: 8px;
            }
        }
    </style>

    <div class="profile-page">
        <div class="profile-topbar">
            <h1 class="profile-title">Profile</h1>

            <div class="profile-user-area">
                <i class="fa-regular fa-bell profile-bell"></i>

                <div class="profile-mini">
                    <img src="https://i.pravatar.cc/150?img=12" alt="Profile">
                    <div>
                        <h4>Andri</h4>
                        <span>Admin</span>
                    </div>
                </div>
            </div>
        </div>

        <form action="#" method="POST">
            @csrf

            <div class="profile-form">
                <div class="profile-column">
                    <div class="profile-row">
                        <label>ID</label>
                        <input type="text" value="0000">
                    </div>

                    <div class="profile-row">
                        <label>Nama</label>
                        <input type="text" value="Andri">
                    </div>

                    <div class="profile-row">
                        <label>Jenis Kelamin</label>
                        <select>
                            <option>Laki-Laki</option>
                            <option>Perempuan</option>
                        </select>
                    </div>

                    <div class="profile-row">
                        <label>Jabatan</label>
                        <input type="text" value="Penanggung Jawab HIV">
                    </div>

                    <div class="profile-row">
                        <label>Alamat</label>
                        <input type="text" value="Benculuk">
                    </div>
                </div>

                <div class="profile-column">
                    <div class="profile-row">
                        <label>NIK</label>
                        <input type="text" value="5175645287987779">
                    </div>

                    <div class="profile-row">
                        <label>Tgl. Lahir</label>
                        <div class="profile-date">
                        <input type="date" name="tanggal_lahir" value="1987-04-23">
                        </div>
                    </div>

                    <div class="profile-row">
                        <label>Email</label>
                        <input type="email" value="Andri@gmail.com">
                    </div>

                    <div class="profile-row">
                        <label>No. Telepon</label>
                        <input type="text" value="081342564533">
                    </div>

                    <div class="profile-row">
                        <label>Status</label>
                        <input type="text" value="PNS">
                    </div>
                </div>

                <div class="profile-actions">
                    <button type="button" class="btn-change-password" id="openPasswordModal">
                        Ubah Password
                    </button>

                    <div class="right-actions">
<button type="button" class="btn-edit-profile btn-confirm-edit">
    Edit Data
</button>

                        <button type="submit" class="btn-save-profile">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    {{-- POPUP UBAH PASSWORD --}}
    <div class="password-overlay" id="passwordModal">
        <div class="password-modal">
            <h2>Ubah Password</h2>

            <form action="#" method="POST">
                @csrf

                <div class="password-row">
                    <label>Password Lama</label>
                    <input type="password" placeholder="Password Lama">
                </div>

                <div class="password-row">
                    <label>Password Baru</label>
                    <input type="password" placeholder="Password Baru">
                </div>

                <div class="password-row">
                    <label>Konfirmasi Password</label>
                    <input type="password" placeholder="Konfirmasi Password">
                </div>

                <div class="password-action">
                    <button type="submit" class="btn-submit-password">
                        Ubah Password
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const passwordModal = document.getElementById('passwordModal');
        const openPasswordModal = document.getElementById('openPasswordModal');

        openPasswordModal.addEventListener('click', function () {
            passwordModal.classList.add('show');
        });

        passwordModal.addEventListener('click', function (e) {
            if (e.target === passwordModal) {
                passwordModal.classList.remove('show');
            }
        });
    </script>
@endsection