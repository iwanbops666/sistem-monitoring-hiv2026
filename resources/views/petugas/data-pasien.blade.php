@extends('layouts.app')

@section('title', 'Data Pasien')

@section('content')
    <style>
        .modal-box-identitas {
            background: #ffffff;
            width: 95%;
            max-width: 1200px;
            border-radius: 30px;
            padding: 0;
            position: relative;
            box-shadow: 0 30px 60px -12px rgba(0, 0, 0, 0.25);
            max-height: 92vh;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            animation: modalFadeUp 0.5s cubic-bezier(0.16, 1, 0.3, 1);
        }

        @keyframes modalFadeUp {
            from { transform: translateY(40px) scale(0.98); opacity: 0; }
            to { transform: translateY(0) scale(1); opacity: 1; }
        }

        .modal-header-identitas {
            padding: 30px 40px;
            background: #ffffff;
            border-bottom: 1px solid #f1f5f9;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 10;
        }

        .modal-title-identitas {
            font-size: 24px;
            font-weight: 900;
            color: #0f172a;
            display: flex;
            align-items: center;
            gap: 15px;
            margin: 0;
        }

        .modal-title-identitas i {
            width: 45px;
            height: 45px;
            background: #f0fdf4;
            color: #10b981;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
        }

        .modal-body-identitas {
            padding: 40px;
            overflow-y: auto;
            flex: 1;
            background: #f8fafc;
        }

        .identitas-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            align-items: start;
        }

        .identitas-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 24px;
            padding: 30px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .identitas-section-title {
            font-size: 14px;
            font-weight: 800;
            color: #047857;
            margin-bottom: 25px;
            display: flex;
            align-items: center;
            gap: 12px;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .identitas-section-title i {
            font-size: 18px;
            color: #10b981;
        }

        .identitas-group {
            margin-bottom: 22px;
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .identitas-group label {
            font-size: 11px;
            font-weight: 800;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.8px;
            padding-left: 2px;
        }

        .identitas-group input,
        .identitas-group select {
            width: 100%;
            height: 50px;
            border: 1.5px solid #e2e8f0;
            border-radius: 12px;
            padding: 0 18px;
            font-size: 14px;
            color: #1e293b;
            background: #ffffff;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
            font-weight: 500;
        }

        .identitas-group input::placeholder {
            color: #cbd5e1;
        }

        .identitas-group input:focus,
        .identitas-group select:focus {
            border-color: #10b981;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            outline: none;
        }

        .phone-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
        }

        .phone-input-wrapper span {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            font-weight: 800;
            color: #10b981;
            font-size: 14px;
            z-index: 10;
            padding-right: 15px;
            border-right: 1.5px solid #e2e8f0;
            height: 22px;
            display: flex;
            align-items: center;
        }

        .phone-input-wrapper input {
            padding-left: 68px !important;
        }

        .modal-footer-identitas {
            padding: 25px 40px;
            background: #ffffff;
            border-top: 1px solid #f1f5f9;
            display: flex;
            justify-content: flex-end;
            gap: 15px;
        }

        .btn-modal-save {
            background: #10b981;
            color: #ffffff;
            border: none;
            padding: 14px 35px;
            border-radius: 14px;
            font-weight: 800;
            font-size: 15px;
            cursor: pointer;
            box-shadow: 0 10px 20px rgba(16, 185, 129, 0.2);
            transition: all 0.3s;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-modal-save:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(16, 185, 129, 0.3);
        }

        .btn-modal-cancel {
            background: #f1f5f9;
            color: #64748b;
            border: none;
            padding: 14px 25px;
            border-radius: 14px;
            font-weight: 700;
            font-size: 15px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-modal-cancel:hover {
            background: #e2e8f0;
            color: #1e293b;
        }

        @media (max-width: 1024px) {
            .identitas-grid { grid-template-columns: 1fr; }
            .modal-box-identitas { width: 98%; }
        }
    </style>

    <section class="table-card">
        <div class="table-top" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h2 style="font-size: 20px; font-weight: 900; color: #1e293b;">Data Pasien Tercatat</h2>

            <form action="{{ route('petugas.data-pasien') }}" method="GET" class="table-actions" style="display: flex; align-items: center; gap: 15px;">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass" style="color: #94a3b8;"></i>
                    <input type="text" name="search" placeholder="Cari Nama / No RM..." value="{{ request('search') }}">
                </div>

                <select name="limit" class="search-box" style="width: auto; cursor: pointer; padding-left: 15px; padding-right: 35px;" onchange="this.form.submit()">
                    <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10 Baris</option>
                    <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25 Baris</option>
                    <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50 Baris</option>
                </select>
            </form>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama Pasien</th>
                        <th>No RM</th>
                        <th>Regis Nasional</th>
                        <th>WhatsApp</th>
                        <th>Jenis Kelamin</th>
                        <th style="text-align: right;">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pasiens as $pasien)
                        <tr>
                            <td>
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 35px; height: 35px; background: #ecfdf5; color: #10b981; border-radius: 10px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 12px;">
                                        {{ substr($pasien->nama, 0, 1) }}
                                    </div>
                                    {{ $pasien->nama }}
                                </div>
                            </td>
                            <td><code style="background: #f1f5f9; padding: 4px 8px; border-radius: 6px; font-weight: 700;">{{ $pasien->nomor_rm }}</code></td>
                            <td>{{ $pasien->no_registrasi_nasional }}</td>
                            <td>{{ $pasien->no_hp }}</td>
                            <td>
                                <span class="badge {{ $pasien->jenis_kelamin == 'Laki-laki' ? 'badge-success' : 'badge-warning' }}">
                                    {{ $pasien->jenis_kelamin }}
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div style="display: flex; gap: 8px; justify-content: flex-end;">
                                    <button type="button" class="btn-detail open-identitas-modal" data-id="{{ $pasien->user_id }}">
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>

                                    <form action="{{ route('petugas.pasien.delete', $pasien->user_id) }}" method="POST" style="display:inline">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-delete" type="submit" onclick="return confirm('Yakin ingin menghapus pasien ini?')">
                                            <i class="fa-regular fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding: 50px; color: #94a3b8;">
                                <i class="fa-solid fa-user-slash" style="font-size: 30px; display: block; margin-bottom: 10px;"></i>
                                Data pasien tidak ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span style="font-weight: 600;">Menampilkan {{ $pasiens->firstItem() ?? 0 }} - {{ $pasiens->lastItem() ?? 0 }} dari {{ $pasiens->total() }} Pasien</span>

            <div class="pagination">
                {{ $pasiens->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>

    {{-- MODAL IDENTITAS PASIEN --}}
    <div class="modal-overlay" id="identitasModal">
        <div class="modal-box-identitas">
            <div class="modal-header-identitas">
                <h2 class="modal-title-identitas">
                    <i class="fa-solid fa-address-card"></i>
                    Manajemen Data Pasien
                </h2>
                <button class="modal-close" id="closeIdentitasModal" style="position: static; font-size: 32px;">&times;</button>
            </div>

            <form action="#" method="POST" id="editPasienForm" style="display: contents;">
                @csrf
                @method('PUT')

                <div class="modal-body-identitas">
                    <div class="identitas-grid">
                        {{-- SISI KIRI: DATA PASIEN --}}
                        <div class="identitas-column">
                            {{-- CARD 1: IDENTITAS UTAMA --}}
                            <div class="identitas-card">
                                <div class="identitas-section-title">
                                    <i class="fa-solid fa-user-tag"></i> Identitas Utama Pasien
                                </div>
                                
                                <div class="identitas-group">
                                    <label>Nama Lengkap Pasien</label>
                                    <input type="text" name="nama" placeholder="Masukkan nama lengkap">
                                </div>

                                <div class="identitas-group" style="display: grid; grid-template-columns: 1fr 1.2fr; gap: 20px;">
                                    <div>
                                        <label>Nomor RM</label>
                                        <input type="text" name="nomor_rm" placeholder="00.00.00">
                                    </div>
                                    <div>
                                        <label>NIK Sesuai KTP</label>
                                        <input type="text" name="nik" placeholder="16 Digit NIK">
                                    </div>
                                </div>

                                <div class="identitas-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div>
                                        <label>Tempat Lahir</label>
                                        <input type="text" name="tempat_lahir" placeholder="Kota/Kab">
                                    </div>
                                    <div>
                                        <label>Tanggal Lahir</label>
                                        <input type="date" name="tanggal_lahir">
                                    </div>
                                </div>

                                <div class="identitas-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div>
                                        <label>Jenis Kelamin</label>
                                        <select name="jenis_kelamin">
                                            <option value="Laki-laki">Laki-laki</option>
                                            <option value="Perempuan">Perempuan</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label>Agama</label>
                                        <select name="agama">
                                            <option value="Islam">Islam</option>
                                            <option value="Kristen">Kristen</option>
                                            <option value="Katolik">Katolik</option>
                                            <option value="Hindu">Hindu</option>
                                            <option value="Buddha">Buddha</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="identitas-group">
                                    <label>Status Perkawinan</label>
                                    <select name="status_perkawinan">
                                        <option value="Belum Kawin">Belum Kawin</option>
                                        <option value="Kawin">Kawin</option>
                                        <option value="Cerai Hidup">Cerai Hidup</option>
                                        <option value="Cerai Mati">Cerai Mati</option>
                                    </select>
                                </div>
                            </div>

                            {{-- CARD 2: ALAMAT & KONTAK --}}
                            <div class="identitas-card">
                                <div class="identitas-section-title">
                                    <i class="fa-solid fa-map-location-dot"></i> Kontak & Domisili
                                </div>

                                <div class="identitas-group">
                                    <label>Alamat Lengkap</label>
                                    <input type="text" name="alamat_lengkap" placeholder="Jl. Contoh No. 123">
                                </div>

                                <div class="identitas-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div>
                                        <label>RT</label>
                                        <input type="text" name="rt" placeholder="000">
                                    </div>
                                    <div>
                                        <label>RW</label>
                                        <input type="text" name="rw" placeholder="000">
                                    </div>
                                </div>

                                <div class="identitas-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div>
                                        <label>Kecamatan</label>
                                        <input type="text" name="kecamatan" placeholder="Kecamatan">
                                    </div>
                                    <div>
                                        <label>Kabupaten / Kota</label>
                                        <input type="text" name="kabupaten" placeholder="Kabupaten">
                                    </div>
                                </div>

                                <div class="identitas-group">
                                    <label>Nomor WhatsApp Pasien</label>
                                    <div class="phone-input-wrapper">
                                        <span>+62</span>
                                        <input type="text" name="no_hp" placeholder="812xxxx">
                                    </div>
                                </div>
                            </div>

                            {{-- CARD 3: AKSES LOGIN --}}
                            <div class="identitas-card" style="border-left: 5px solid #10b981;">
                                <div class="identitas-section-title">
                                    <i class="fa-solid fa-key"></i> Kredensial Login Pasien
                                </div>
                                <div class="identitas-group">
                                    <label>Username / Email / No. HP Login</label>
                                    <input type="text" name="email_pasien" placeholder="Gunakan Email atau No HP">
                                </div>
                                <div class="identitas-group">
                                    <label>Ganti Password (Kosongkan jika tidak diubah)</label>
                                    <input type="password" name="password_pasien" placeholder="********">
                                </div>
                            </div>
                        </div>

                        {{-- SISI KANAN: KLINIS & KELUARGA --}}
                        <div class="identitas-column">
                            {{-- CARD 4: DATA MEDIS --}}
                            <div class="identitas-card">
                                <div class="identitas-section-title">
                                    <i class="fa-solid fa-notes-medical"></i> Informasi Klinis
                                </div>

                                <div class="identitas-group">
                                    <label>Nomor Registrasi Nasional</label>
                                    <input type="text" name="no_registrasi_nasional" placeholder="Regis Nasional">
                                </div>

                                <div class="identitas-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div>
                                        <label>Status Pasien</label>
                                        <select name="status_pasien">
                                            <option value="Hidup">Hidup</option>
                                            <option value="Meninggal">Meninggal</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label>Tanggal Awal Pengobatan</label>
                                        <input type="date" name="tanggal_awal_pengobatan">
                                    </div>
                                </div>

                                <div class="identitas-group">
                                    <label>Keterangan Pasien</label>
                                    <select name="keterangan_pasien">
                                        <option value="Baru">Baru</option>
                                        <option value="Lama">Lama</option>
                                        <option value="Pindahan">Pindahan</option>
                                        <option value="Pindah Pengobatan">Pindah Pengobatan</option>
                                    </select>
                                </div>
                            </div>

                            {{-- CARD 5: DATA PMO --}}
                            <div class="identitas-card">
                                <div class="identitas-section-title">
                                    <i class="fa-solid fa-users"></i> Penanggung Jawab / PMO
                                </div>

                                <div class="identitas-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div>
                                        <label>Nama Lengkap PMO</label>
                                        <input type="text" name="nama_keluarga" placeholder="Nama Lengkap Penanggung Jawab" style="width: 100%;">
                                    </div>
                                    <div>
                                        <label>Status Hubungan</label>
                                        <input type="text" name="status_hubungan" list="edit_status_options" placeholder="Pilih atau ketik status..." style="width: 100%;" required autocomplete="off">
                                        <datalist id="edit_status_options">
                                            <option value="Suami">
                                            <option value="Istri">
                                            <option value="Saudara">
                                            <option value="Orangtua">
                                        </datalist>
                                    </div>
                                </div>


                                <div class="identitas-group">
                                    <label>Alamat Lengkap PMO</label>
                                    <input type="text" name="alamat_keluarga" placeholder="Alamat Lengkap PMO">
                                </div>

                                <div class="identitas-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                        <div>
                                            <label>RT PMO</label>
                                            <input type="text" name="rt_keluarga" placeholder="000">
                                        </div>
                                        <div>
                                            <label>RW PMO</label>
                                            <input type="text" name="rw_keluarga" placeholder="000">
                                        </div>
                                    </div>
                                    <div>
                                        <label>Nomor WhatsApp PMO</label>
                                        <div class="phone-input-wrapper">
                                            <span>+62</span>
                                            <input type="text" name="no_hp_keluarga" placeholder="812xxxx" style="width: 100%;">
                                        </div>
                                    </div>
                                </div>

                                <div class="identitas-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div>
                                        <label>Kecamatan PMO</label>
                                        <input type="text" name="kecamatan_keluarga" placeholder="Kecamatan">
                                    </div>
                                    <div>
                                        <label>Kabupaten PMO</label>
                                        <input type="text" name="kabupaten_keluarga" placeholder="Kabupaten">
                                    </div>
                                </div>

                                <div style="border-top: 1px dashed #e2e8f0; margin: 25px 0; padding-top: 25px;"></div>

                                <div class="identitas-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
                                    <div>
                                        <label>Username / Email PMO</label>
                                        <input type="text" name="email_keluarga" placeholder="Akses login PMO" style="width: 100%;">
                                    </div>
                                    <div>
                                        <label>Password PMO (Kosongkan jika tetap)</label>
                                        <input type="password" name="password_keluarga" placeholder="********" style="width: 100%;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer-identitas">
                    <button type="button" class="btn-modal-cancel" id="cancelIdentitas">Batal</button>
                    <button type="submit" class="btn-modal-save">
                        <i class="fa-solid fa-check-double"></i>
                        Simpan Perubahan Data
                    </button>
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
                const form = identitasModal.querySelector('form');

                openIdentitasButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        const id = this.getAttribute('data-id');
                        
                        fetch(`/manajemen-pasien/data-pasien/${id}`)
                            .then(response => response.json())
                            .then(data => {
                                form.action = `/manajemen-pasien/data-pasien/${id}`;
                                
                                form.querySelector('[name="nama"]').value = data.nama || '';
                                form.querySelector('[name="nomor_rm"]').value = data.nomor_rm || '';
                                form.querySelector('[name="nik"]').value = data.nik || '';
                                form.querySelector('[name="tempat_lahir"]').value = data.tempat_lahir || '';
                                form.querySelector('[name="tanggal_lahir"]').value = data.tanggal_lahir || '';
                                form.querySelector('[name="jenis_kelamin"]').value = data.jenis_kelamin || 'Laki-laki';
                                form.querySelector('[name="agama"]').value = data.agama || 'Islam';
                                form.querySelector('[name="status_perkawinan"]').value = data.status_perkawinan || 'Belum Kawin';
                                form.querySelector('[name="email_pasien"]').value = data.user ? (data.user.email || data.user.phone_number || '') : '';
                                form.querySelector('[name="alamat_lengkap"]').value = data.alamat_lengkap || '';
                                form.querySelector('[name="rt"]').value = data.rt || '';
                                form.querySelector('[name="rw"]').value = data.rw || '';
                                form.querySelector('[name="kabupaten"]').value = data.kabupaten || '';
                                form.querySelector('[name="kecamatan"]').value = data.kecamatan || '';
                                form.querySelector('[name="no_hp"]').value = data.no_hp ? data.no_hp.replace('+62', '') : '';
                                form.querySelector('[name="no_registrasi_nasional"]').value = data.no_registrasi_nasional || '';
                                form.querySelector('[name="status_pasien"]').value = data.status_pasien || 'Hidup';
                                form.querySelector('[name="tanggal_awal_pengobatan"]').value = data.tanggal_awal_pengobatan || '';
                                form.querySelector('[name="keterangan_pasien"]').value = data.keterangan_pasien || 'Baru';

                                if (data.keluarga) {
                                    form.querySelector('[name="nama_keluarga"]').value = data.keluarga.nama || '';
                                    form.querySelector('[name="status_hubungan"]').value = data.keluarga.status_hubungan || '';
                                    form.querySelector('[name="no_hp_keluarga"]').value = data.keluarga.no_hp ? data.keluarga.no_hp.replace('+62', '') : '';
                                    form.querySelector('[name="alamat_keluarga"]').value = data.keluarga.alamat || '';
                                    form.querySelector('[name="rt_keluarga"]').value = data.keluarga.rt || '';
                                    form.querySelector('[name="rw_keluarga"]').value = data.keluarga.rw || '';
                                    form.querySelector('[name="kecamatan_keluarga"]').value = data.keluarga.kecamatan || '';
                                    form.querySelector('[name="kabupaten_keluarga"]').value = data.keluarga.kabupaten || '';
                                    if (data.keluarga.user) {
                                        form.querySelector('[name="email_keluarga"]').value = data.keluarga.user.email || data.keluarga.user.phone_number || '';
                                    }
                                }

                                identitasModal.classList.add('show');
                            });
                    });
                });

                closeIdentitasButton.addEventListener('click', () => identitasModal.classList.remove('show'));
                document.getElementById('cancelIdentitas').addEventListener('click', () => identitasModal.classList.remove('show'));
                identitasModal.addEventListener('click', (e) => { if (e.target === identitasModal) identitasModal.classList.remove('show'); });

            });
        </script>
    @endpush
@endsection