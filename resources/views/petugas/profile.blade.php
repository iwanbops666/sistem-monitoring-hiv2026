@extends('layouts.app')

@section('title', 'Profil Petugas')

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

        .profile-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 40px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(213, 224, 235, 0.3);
            border: 1px solid #f1f5f9;
        }

        .profile-header {
            display: flex;
            align-items: center;
            gap: 25px;
            margin-bottom: 40px;
            padding-bottom: 30px;
            border-bottom: 2px solid #f1f5f9;
        }

        .profile-avatar-wrapper {
            position: relative;
        }

        .profile-avatar {
            width: 120px;
            height: 120px;
            border-radius: 35px;
            object-fit: cover;
            border: 4px solid #ecfdf5;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.15);
            cursor: pointer;
            transition: all 0.3s;
        }

        .profile-avatar:hover {
            transform: scale(1.05);
            border-color: #10b981;
        }

        .avatar-edit-badge {
            position: absolute;
            bottom: -5px;
            right: -5px;
            width: 35px;
            height: 35px;
            background: #10b981;
            color: white;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            border: 3px solid #ffffff;
            font-size: 14px;
            cursor: pointer;
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
        }

        .profile-info h2 {
            font-size: 24px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 5px;
        }

        .profile-info p {
            font-size: 15px;
            font-weight: 600;
            color: #64748b;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .form-section-title {
            font-size: 16px;
            font-weight: 800;
            color: #065f46;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 25px 40px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .form-group label {
            font-size: 13px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .form-group input,
        .form-group select {
            height: 48px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 0 16px;
            font-size: 15px;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.2s;
        }

        .form-group input:focus,
        .form-group select:focus {
            border-color: #10b981;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            outline: none;
        }

        .btn-update {
            background: #10b981;
            color: #ffffff;
            border: none;
            padding: 14px 35px;
            border-radius: 14px;
            font-weight: 800;
            font-size: 15px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 20px rgba(16, 185, 129, 0.2);
            transition: all 0.3s ease;
        }

        .btn-update:hover {
            transform: translateY(-2px);
            box-shadow: 0 12px 25px rgba(16, 185, 129, 0.3);
        }

        .btn-password {
            background: #f1f5f9;
            color: #475569;
            border: none;
            padding: 14px 25px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-password:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        /* MODAL */
        .password-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.4);
            backdrop-filter: blur(4px);
            display: none;
            justify-content: center;
            align-items: center;
            z-index: 10000;
        }

        .password-overlay.show { display: flex; }

        .password-modal {
            background: #ffffff;
            width: 100%;
            max-width: 500px;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 25px 50px rgba(0,0,0,0.2);
            animation: modalPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes modalPop {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }
    </style>

    <div class="profile-container">
        <form action="{{ route('petugas.profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="profile-card">
                <div class="profile-header">
                    <div class="profile-avatar-wrapper" onclick="document.getElementById('foto_profil_input').click()">
                        <img src="{{ Auth::user()->foto_profil ? asset('storage/' . Auth::user()->foto_profil) : 'https://i.pravatar.cc/150?img=12' }}" 
                             class="profile-avatar" id="profile_preview" alt="Avatar">
                        <div class="avatar-edit-badge">
                            <i class="fa-solid fa-camera"></i>
                        </div>
                        <input type="file" name="foto_profil" id="foto_profil_input" style="display: none;" accept="image/*">
                    </div>
                    <div class="profile-info">
                        <h2>{{ Auth::user()->name }}</h2>
                        <p>
                            <i class="fa-solid fa-user-shield" style="color: #10b981;"></i>
                            {{ ucfirst(Auth::user()->role) }} Puskesmas Benculuk
                        </p>
                    </div>
                    <div style="margin-left: auto;">
                        <button type="button" class="btn-password open-password-btn">
                            <i class="fa-solid fa-lock"></i> Keamanan Akun
                        </button>
                    </div>
                </div>

                <div class="form-section-title">
                    <i class="fa-solid fa-id-card-clip"></i>
                    Informasi Kepegawaian & Pribadi
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" value="{{ old('nama', $petugas->nama) }}" required>
                    </div>

                    <div class="form-group">
                        <label>NIP (Nomor Induk Pegawai)</label>
                        <input type="text" name="nip" value="{{ old('nip', $petugas->nip ?? '') }}" placeholder="Masukkan NIP">
                    </div>

                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                            <option value="Laki-laki" {{ old('jenis_kelamin', $petugas->jenis_kelamin ?? '') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin', $petugas->jenis_kelamin ?? '') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir', $petugas->tanggal_lahir ?? '') }}">
                    </div>

                    <div class="form-group">
                        <label>Email Dinas / Login</label>
                        <input type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required>
                    </div>

                    <div class="form-group">
                        <label>Nomor Telepon / WA</label>
                        <input type="text" name="no_hp" value="{{ old('no_hp', $petugas->no_hp) }}" required>
                    </div>

                    <div class="form-group" style="grid-column: span 2;">
                        <label>Alamat Instansi / Domisili</label>
                        <input type="text" name="alamat" value="{{ old('alamat', $petugas->alamat) }}">
                    </div>
                </div>

                <div style="margin-top: 40px; display: flex; justify-content: flex-end; gap: 15px;">
                    <button type="button" class="btn-password open-password-btn">
                         <i class="fa-solid fa-key"></i> Ubah Password
                    </button>
                    <button type="submit" class="btn-update">
                        <i class="fa-solid fa-floppy-disk"></i> Simpan Perubahan
                    </button>
                </div>
            </div>
        </form>
    </div>

    {{-- MODAL UBAH PASSWORD --}}
    <div class="password-overlay" id="passwordModal">
        <div class="password-modal">
            <h3 style="font-size: 20px; font-weight: 900; margin-bottom: 25px; color: #111827;">Ubah Kata Sandi</h3>

            <form action="{{ route('petugas.password.update') }}" method="POST">
                @csrf
                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Kata Sandi Saat Ini</label>
                    <input type="password" name="old_password" placeholder="••••••••" required>
                </div>

                <div class="form-group" style="margin-bottom: 15px;">
                    <label>Kata Sandi Baru</label>
                    <input type="password" name="new_password" placeholder="Min. 8 karakter" required>
                </div>

                <div class="form-group" style="margin-bottom: 25px;">
                    <label>Konfirmasi Kata Sandi Baru</label>
                    <input type="password" name="new_password_confirmation" placeholder="Ulangi kata sandi baru" required>
                </div>

                <div style="display: flex; gap: 10px; justify-content: flex-end;">
                    <button type="button" class="btn-password" id="closePasswordModal">Batal</button>
                    <button type="submit" class="btn-update">Perbarui Sandi</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const passwordModal = document.getElementById('passwordModal');
            const openBtns = document.querySelectorAll('.open-password-btn');
            const closeBtn = document.getElementById('closePasswordModal');

            openBtns.forEach(btn => {
                btn.addEventListener('click', () => passwordModal.classList.add('show'));
            });

            if (closeBtn) {
                closeBtn.addEventListener('click', () => passwordModal.classList.remove('show'));
            }

            passwordModal.addEventListener('click', (e) => {
                if (e.target === passwordModal) passwordModal.classList.remove('show');
            });

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