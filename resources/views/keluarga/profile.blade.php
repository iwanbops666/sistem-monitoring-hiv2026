@extends('layouts.keluarga')

@section('title', 'Profile Keluarga')
@section('page-title', 'Profile Settings')

@section('content')
    <style>
        .profile-container {
            max-width: 1000px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .profile-header-banner {
            background: linear-gradient(135deg, #065f46 0%, #059669 100%);
            border-radius: 24px;
            padding: 40px;
            color: #ffffff;
            margin-bottom: 35px;
            display: flex;
            align-items: center;
            gap: 30px;
            box-shadow: 0 15px 35px rgba(6, 95, 70, 0.2);
        }

        .profile-avatar-large {
            width: 120px;
            height: 120px;
            border-radius: 35px;
            border: 4px solid rgba(255, 255, 255, 0.4);
            object-fit: cover;
            cursor: pointer;
            transition: all 0.3s;
        }

        .profile-avatar-large:hover {
            transform: scale(1.05);
            border-color: rgba(255, 255, 255, 0.8);
        }

        .avatar-edit-badge {
            position: absolute;
            bottom: 0;
            right: 0;
            width: 38px;
            height: 38px;
            background: #ffffff;
            color: #065f46;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
            border: 2px solid #065f46;
        }

        .avatar-wrapper {
            position: relative;
        }

        .profile-info-text h1 {
            font-size: 26px;
            font-weight: 900;
            margin-bottom: 5px;
        }

        .profile-info-text p {
            font-size: 16px;
            opacity: 0.9;
        }

        .profile-section-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 35px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(213, 224, 235, 0.3);
            border: 1px solid #f1f5f9;
        }

        .section-title {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #f1f5f9;
        }

        .section-title i {
            color: #10b981;
            font-size: 20px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px 40px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .form-group input {
            height: 48px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 0 16px;
            font-size: 15px;
            color: #111827;
            background: #f8fafc;
            transition: all 0.2s;
            width: 100%;
        }

        .form-group input:focus {
            border-color: #10b981;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            outline: none;
        }

        .form-group input:disabled {
            background: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .phone-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
        }

        .phone-input-wrapper span {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 700;
            color: #475569;
            font-size: 15px;
            z-index: 10;
            padding-right: 12px;
            border-right: 1.5px solid #e2e8f0;
            height: 20px;
            display: flex;
            align-items: center;
        }

        .phone-input-wrapper input {
            padding-left: 65px !important;
            width: 100%;
        }

        .profile-actions {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 10px;
        }

        .btn-save {
            background: #10b981;
            color: #ffffff;
            border: none;
            padding: 12px 35px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: all 0.2s;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2);
        }

        .btn-save:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.3);
        }

        .grid-span-2 {
            grid-column: span 2;
        }

        @media (max-width: 900px) {
            .form-grid { 
                grid-template-columns: 1fr; 
                gap: 15px;
            }
            .grid-span-2 {
                grid-column: span 1;
            }
            .profile-header-banner { flex-direction: column; text-align: center; }
            .profile-actions { position: static; margin-top: 20px; }
        }
    </style>

    <div class="profile-container">
        <div class="profile-header-banner">
            <div class="avatar-wrapper" onclick="document.getElementById('foto_profil_input').click()">
                <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : 'https://i.pravatar.cc/150?img=12' }}" 
                     class="profile-avatar-large" id="profile_preview" alt="Avatar">
                <div class="avatar-edit-badge">
                    <i class="fa-solid fa-camera"></i>
                </div>
                <input type="file" name="foto_profil" form="profileForm" id="foto_profil_input" style="display: none;" accept="image/*">
            </div>
            <div class="profile-info-text">
                <h1>{{ Auth::user()->name }}</h1>
                <p>Keluarga Pasien • Pendamping: {{ $keluarga->pasien->nama }}</p>
            </div>
        </div>

        <form action="{{ route('keluarga.profile.update') }}" method="POST" id="profileForm" enctype="multipart/form-data">
            @csrf

            {{-- INFORMASI PRIBADI --}}
            <section class="profile-section-card">
                <div class="section-title">
                    <i class="fa-solid fa-user-gear"></i>
                    Informasi Pribadi
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ $keluarga->nama }}">
                    </div>
                    <div class="form-group">
                        <label>Email Utama</label>
                        <input type="email" name="email" value="{{ Auth::user()->email }}">
                    </div>
                    <div class="form-group">
                        <label>Nomor WhatsApp</label>
                        <div class="phone-input-wrapper">
                            <span>+62</span>
                            <input type="text" name="no_hp" value="{{ substr($keluarga->no_hp, 1) }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Alamat Domisili</label>
                        <input type="text" name="alamat" value="{{ $keluarga->alamat }}">
                    </div>
                </div>
            </section>

            {{-- DATA PASIEN TERKAIT --}}
            <section class="profile-section-card">
                <div class="section-title">
                    <i class="fa-solid fa-hospital-user"></i>
                    Data Pasien Terkait
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Pasien</label>
                        <input type="text" value="{{ $keluarga->pasien->nama }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Nomor RM Pasien</label>
                        <input type="text" value="{{ $keluarga->pasien->nomor_rm }}" disabled>
                    </div>
                    <div class="form-group">
                        <label>Status Hubungan</label>
                        <input type="text" value="{{ $keluarga->hubungan ?? 'Keluarga' }}" disabled>
                    </div>
                </div>
            </section>

            {{-- KEAMANAN --}}
            <section class="profile-section-card">
                <div class="section-title">
                    <i class="fa-solid fa-shield-halved"></i>
                    Keamanan Akun
                </div>
                <div class="form-grid">
                    <div class="form-group grid-span-2">
                        <label>Ganti Password (Kosongkan jika tidak ingin mengubah)</label>
                        <input type="password" name="password" placeholder="Masukkan password baru...">
                    </div>
                </div>
            </section>

            <div class="profile-actions">
                <button type="submit" class="btn-save">
                    <i class="fa-solid fa-floppy-disk"></i>
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Avatar Preview
            const avatarInput = document.getElementById('foto_profil_input');
            const avatarPreview = document.getElementById('profile_preview');

            if (avatarInput) {
                avatarInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            avatarPreview.src = e.target.result;
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>
@endsection