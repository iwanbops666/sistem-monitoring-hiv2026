@extends('layouts.keluarga')

@section('title', 'Profile Keluarga Pasien')
@section('page-title', 'Profile')

@push('styles')
<style>
    .family-profile-page {
        width: 100%;
    }

    .family-profile-card {
        width: 100%;
        background: #ffffff;
        border-radius: 28px;
        padding: 42px 44px 38px;
        box-shadow: 0 14px 34px rgba(22, 49, 80, 0.10);
    }

    .family-profile-form {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 24px 70px;
    }

    .family-field {
        display: grid;
        grid-template-columns: 150px 1fr;
        align-items: center;
        gap: 18px;
    }

    .family-field label {
        color: #07592f;
        font-size: 16px;
        font-weight: 900;
    }

    .family-field input {
        width: 100%;
        height: 46px;
        border: 1px solid #4b5563;
        border-radius: 8px;
        padding: 0 16px;
        background: #f8fafc;
        color: #064e3b;
        font-size: 15px;
        outline: none;
    }

    .family-field input:focus {
        border-color: #16a34a;
        box-shadow: 0 0 0 3px rgba(22, 163, 74, 0.15);
    }

    .family-profile-actions {
        grid-column: 1 / 3;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-top: 18px;
    }

    .family-actions-right {
        display: flex;
        align-items: center;
        gap: 18px;
    }

    .family-btn-password,
    .family-btn-edit,
    .family-btn-save,
    .family-btn-password-submit {
        height: 46px;
        border: none;
        border-radius: 8px;
        padding: 0 32px;
        color: #ffffff;
        font-size: 15px;
        font-weight: 900;
        cursor: pointer;
        box-shadow: 0 8px 16px rgba(0,0,0,0.17);
    }

    .family-btn-password,
    .family-btn-password-submit {
        background: #5d5d5d;
    }

    .family-btn-edit {
        background: #ff2020;
    }

    .family-btn-save {
        background: #19b56b;
    }

    .family-password-overlay {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.22);
        display: none;
        justify-content: center;
        align-items: center;
        padding: 20px;
        z-index: 99999;
    }

    .family-password-overlay.show {
        display: flex;
    }

    .family-password-box {
        width: 100%;
        max-width: 580px;
        background: #ffffff;
        border: 1px solid #222222;
        border-radius: 8px;
        padding: 32px 36px 30px;
        box-shadow: 0 14px 34px rgba(0,0,0,0.18);
    }

    .family-password-box h2 {
        color: #07592f;
        font-size: 24px;
        font-weight: 900;
        margin-bottom: 28px;
    }

    .family-password-row {
        display: grid;
        grid-template-columns: 190px 1fr;
        align-items: center;
        gap: 18px;
        margin-bottom: 18px;
    }

    .family-password-row label {
        color: #07592f;
        font-size: 15px;
        font-weight: 900;
        font-style: italic;
    }

    .family-password-row input {
        height: 44px;
        border: 1px solid #4b5563;
        border-radius: 8px;
        padding: 0 16px;
        background: #f8fafc;
        font-size: 14px;
        outline: none;
    }

    .family-password-row input::placeholder {
        color: #9ca3af;
        font-style: italic;
    }

    .family-password-actions {
        display: flex;
        justify-content: flex-end;
        margin-top: 24px;
    }

    .family-edit-alert {
        position: fixed;
        inset: 0;
        background: rgba(0, 0, 0, 0.32);
        display: none;
        justify-content: center;
        align-items: center;
        z-index: 100000;
    }

    .family-edit-alert.show {
        display: flex;
    }

    .family-edit-box {
        width: 420px;
        background: #ffffff;
        border-radius: 7px;
        padding: 32px 28px 28px;
        text-align: center;
        box-shadow: 0 14px 35px rgba(0,0,0,0.18);
    }

    .family-edit-icon {
        width: 86px;
        height: 76px;
        margin: 0 auto 20px;
        position: relative;
    }

    .family-edit-icon::before {
        content: "";
        position: absolute;
        inset: 0;
        background: #ff1f2d;
        clip-path: polygon(50% 0%, 100% 100%, 0% 100%);
    }

    .family-edit-icon::after {
        content: "!";
        position: absolute;
        left: 50%;
        top: 58%;
        transform: translate(-50%, -50%);
        color: #ffffff;
        font-size: 46px;
        font-weight: 900;
    }

    .family-edit-text {
        font-size: 18px;
        color: #4b4b4b;
        font-weight: 600;
        line-height: 1.35;
        margin-bottom: 28px;
    }

    .family-edit-actions {
        display: flex;
        justify-content: center;
        gap: 28px;
    }

    .family-edit-yes,
    .family-edit-no {
        border: none;
        color: #ffffff;
        padding: 9px 42px;
        border-radius: 18px;
        font-weight: 800;
        cursor: pointer;
    }

    .family-edit-yes {
        background: #23ad5c;
    }

    .family-edit-no {
        background: #ff1f2d;
    }

    .family-toast {
        position: fixed;
        top: 30px;
        right: 40px;
        width: 285px;
        min-height: 74px;
        background: #65a87d;
        color: #ffffff;
        border-radius: 3px;
        padding: 14px 18px;
        display: none;
        align-items: center;
        gap: 12px;
        z-index: 100001;
        box-shadow: 0 10px 28px rgba(0, 0, 0, 0.18);
    }

    .family-toast.show {
        display: flex;
        animation: familyToastSlide 0.25s ease;
    }

    @keyframes familyToastSlide {
        from {
            opacity: 0;
            transform: translateY(-12px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .family-toast-icon {
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

    .family-toast h4 {
        font-size: 14px;
        font-weight: 900;
        margin-bottom: 3px;
    }

    .family-toast p {
        font-size: 11px;
        margin: 0;
    }

    @media (max-width: 900px) {
        .family-profile-form {
            grid-template-columns: 1fr;
        }

        .family-profile-actions {
            grid-column: 1;
            flex-direction: column;
            align-items: flex-start;
            gap: 18px;
        }

        .family-actions-right {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 600px) {
        .family-profile-card {
            padding: 30px 22px;
        }

        .family-field,
        .family-password-row {
            grid-template-columns: 1fr;
            gap: 8px;
        }
    }
</style>
@endpush

@section('content')
<div class="family-profile-page">
    <section class="family-profile-card">
        <form action="#" method="POST" id="familyProfileForm">
            @csrf

            <div class="family-profile-form">
                <div class="family-field">
                    <label>Keluarga Dari</label>
                    <input type="text" name="keluarga_dari" value="0000">
                </div>

                <div class="family-field">
                    <label>No. Telepon</label>
                    <input type="text" name="no_telepon" value="081342564533">
                </div>

                <div class="family-field">
                    <label>Nama</label>
                    <input type="text" name="nama" value="Yuliartini">
                </div>

                <div class="family-field">
                    <label>Email</label>
                    <input type="email" name="email" value="yuliartini@gmail.com">
                </div>

                <div class="family-field">
                    <label>Alamat</label>
                    <input type="text" name="alamat" value="Ni Kadek Yuliartini">
                </div>

                <div class="family-field">
                    <label>Status</label>
                    <input type="text" name="status" value="Keluarga Pasien">
                </div>

                <div class="family-profile-actions">
                    <button type="button" class="family-btn-password" id="openFamilyPassword">
                        Ubah Password
                    </button>

                    <div class="family-actions-right">
                        <button type="button" class="family-btn-edit" id="openFamilyEdit">
                            Edit Data
                        </button>

                        <button type="submit" class="family-btn-save">
                            Simpan
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </section>
</div>

<div class="family-password-overlay" id="familyPasswordModal">
    <div class="family-password-box">
        <h2>Ubah Password</h2>

        <form action="#" method="POST" id="familyPasswordForm">
            @csrf

            <div class="family-password-row">
                <label>Password Lama</label>
                <input type="password" name="password_lama" placeholder="Password Lama">
            </div>

            <div class="family-password-row">
                <label>Password Baru</label>
                <input type="password" name="password_baru" placeholder="Password Baru">
            </div>

            <div class="family-password-row">
                <label>Konfirmasi Password</label>
                <input type="password" name="konfirmasi_password" placeholder="Konfirmasi Password">
            </div>

            <div class="family-password-actions">
                <button type="submit" class="family-btn-password-submit">
                    Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>

<div class="family-edit-alert" id="familyEditAlert">
    <div class="family-edit-box">
        <div class="family-edit-icon"></div>

        <div class="family-edit-text">
            Perubahan akan disimpan.<br>
            Lanjutkan edit data ini?
        </div>

        <div class="family-edit-actions">
            <button type="button" class="family-edit-yes" id="familyEditYes">Ya</button>
            <button type="button" class="family-edit-no" id="familyEditNo">Tidak</button>
        </div>
    </div>
</div>

<div class="family-toast" id="familySuccessToast">
    <div class="family-toast-icon">
        <i class="fa-regular fa-circle-check"></i>
    </div>

    <div>
        <h4>Berhasil Tersimpan</h4>
        <p>Telah Tersimpan</p>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const profileForm = document.getElementById('familyProfileForm');
        const passwordForm = document.getElementById('familyPasswordForm');

        const passwordButton = document.getElementById('openFamilyPassword');
        const passwordModal = document.getElementById('familyPasswordModal');

        const editButton = document.getElementById('openFamilyEdit');
        const editAlert = document.getElementById('familyEditAlert');
        const editYes = document.getElementById('familyEditYes');
        const editNo = document.getElementById('familyEditNo');

        const toast = document.getElementById('familySuccessToast');
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

        if (passwordButton && passwordModal) {
            passwordButton.addEventListener('click', function () {
                passwordModal.classList.add('show');
            });
        }

        if (passwordModal) {
            passwordModal.addEventListener('click', function (event) {
                if (event.target === passwordModal) {
                    passwordModal.classList.remove('show');
                }
            });
        }

        if (passwordForm) {
            passwordForm.addEventListener('submit', function (event) {
                event.preventDefault();
                passwordModal.classList.remove('show');
                showToast();
            });
        }

        if (profileForm) {
            profileForm.addEventListener('submit', function (event) {
                event.preventDefault();
                showToast();
            });
        }

        if (editButton && editAlert) {
            editButton.addEventListener('click', function () {
                editAlert.classList.add('show');
            });
        }

        if (editYes && editAlert) {
            editYes.addEventListener('click', function () {
                editAlert.classList.remove('show');
            });
        }

        if (editNo && editAlert) {
            editNo.addEventListener('click', function () {
                editAlert.classList.remove('show');
            });
        }

        if (editAlert) {
            editAlert.addEventListener('click', function (event) {
                if (event.target === editAlert) {
                    editAlert.classList.remove('show');
                }
            });
        }
    });
</script>
@endpush