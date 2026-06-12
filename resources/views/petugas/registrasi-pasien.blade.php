@extends('layouts.app')

@section('title', 'Registrasi Pasien Baru')

@section('content')
    <style>
        .registrasi-container {
            max-width: 1100px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .registrasi-section {
            background: #ffffff;
            border-radius: 24px;
            padding: 35px;
            margin-bottom: 30px;
            box-shadow: 0 10px 25px rgba(213, 224, 235, 0.3);
            border: 1px solid #f1f5f9;
        }

        .section-header {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 18px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
        }

        .section-header i { color: #10b981; }

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
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .form-group input,
        .form-group select {
            height: 48px;
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 0 16px;
            font-size: 15px;
            color: #111827;
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
        }

        .actions-bar {
            display: flex;
            justify-content: flex-end;
            margin-top: 10px;
        }

        .btn-submit {
            background: #10b981;
            color: #ffffff;
            border: none;
            padding: 15px 40px;
            border-radius: 15px;
            font-weight: 800;
            font-size: 16px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 12px;
            box-shadow: 0 10px 25px rgba(16, 185, 129, 0.25);
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: #059669;
            transform: translateY(-3px);
            box-shadow: 0 15px 35px rgba(16, 185, 129, 0.35);
        }

        @media (max-width: 800px) {
            .form-grid { grid-template-columns: 1fr; }
        }
    </style>

    <div class="registrasi-container">
        @if ($errors->any())
            <div style="background: #fee2e2; border-left: 5px solid #ef4444; color: #991b1b; padding: 20px; border-radius: 15px; margin-bottom: 30px;">
                <h4 style="font-weight: 900; margin-bottom: 10px;">Mohon periksa kembali:</h4>
                <ul style="margin-left: 20px; font-weight: 600;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('petugas.pasien.store') }}" method="POST">
            @csrf

            {{-- SECTION 1: DATA IDENTITAS --}}
            <div class="registrasi-section">
                <div class="section-header">
                    <i class="fa-solid fa-id-card"></i>
                    Identitas Personal Pasien
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="nama" placeholder="Masukkan nama sesuai KTP" value="{{ old('nama') }}" required>
                    </div>
                    <div class="form-group">
                        <label>Nomor RM</label>
                        <input type="text" name="nomor_rm" placeholder="Contoh: RM-001" value="{{ old('nomor_rm') }}" required>
                    </div>
                    <div class="form-group">
                        <label>NIK (No. Induk Kependudukan)</label>
                        <input type="text" name="nik" placeholder="16 Digit NIK" value="{{ old('nik') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')" minlength="16" maxlength="16">
                    </div>
                    <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label>Tempat Lahir</label>
                            <input type="text" name="tempat_lahir" placeholder="Kota/Kab" value="{{ old('tempat_lahir') }}">
                        </div>
                        <div>
                            <label>Tanggal Lahir</label>
                            <input type="date" name="tanggal_lahir" value="{{ old('tanggal_lahir') }}">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Jenis Kelamin</label>
                        <select name="jenis_kelamin">
                            <option value="Laki-laki" {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>Laki-laki</option>
                            <option value="Perempuan" {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Agama</label>
                        <select name="agama">
                            <option value="Islam" {{ old('agama') == 'Islam' ? 'selected' : '' }}>Islam</option>
                            <option value="Kristen" {{ old('agama') == 'Kristen' ? 'selected' : '' }}>Kristen</option>
                            <option value="Katolik" {{ old('agama') == 'Katolik' ? 'selected' : '' }}>Katolik</option>
                            <option value="Hindu" {{ old('agama') == 'Hindu' ? 'selected' : '' }}>Hindu</option>
                            <option value="Buddha" {{ old('agama') == 'Buddha' ? 'selected' : '' }}>Buddha</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- SECTION 2: DOMISILI & KONTAK --}}
            <div class="registrasi-section">
                <div class="section-header">
                    <i class="fa-solid fa-map-location-dot"></i>
                    Domisili & Kontak Pasien
                </div>
                <div class="form-grid">
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Alamat Lengkap</label>
                        <input type="text" name="alamat_lengkap" placeholder="Jl. Nama Jalan, No. Rumah" value="{{ old('alamat_lengkap') }}">
                    </div>
                    <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; grid-column: span 2;">
                        <div>
                            <label>RT</label>
                            <input type="text" name="rt" placeholder="000" value="{{ old('rt') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <div>
                            <label>RW</label>
                            <input type="text" name="rw" placeholder="000" value="{{ old('rw') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <div>
                            <label>Kode Pos</label>
                            <input type="text" name="kode_pos" placeholder="12345" value="{{ old('kode_pos') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Provinsi</label>
                        <select name="provinsi" id="provinsi" required>
                            <option value="">Pilih Provinsi</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kabupaten / Kota</label>
                        <select name="kabupaten" id="kabupaten" required disabled>
                            <option value="">Pilih Kabupaten/Kota</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kecamatan</label>
                        <select name="kecamatan" id="kecamatan" required disabled>
                            <option value="">Pilih Kecamatan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Kelurahan / Desa</label>
                        <select name="kelurahan" id="kelurahan" required disabled>
                            <option value="">Pilih Kelurahan/Desa</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Nomor WhatsApp Pasien</label>
                        <div class="phone-input-wrapper">
                            <span>+62</span>
                            <input type="text" name="no_hp" placeholder="81234567890" value="{{ old('no_hp') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email / No. HP Pasien (Untuk Login)</label>
                        <input type="text" name="email_pasien" placeholder="email@pasien.com atau 0812..." value="{{ old('email_pasien') }}">
                    </div>
                    <div class="form-group">
                        <label>Password Akun Pasien</label>
                        <input type="password" name="password_pasien" placeholder="********" value="{{ old('password_pasien') }}">
                    </div>
                </div>
            </div>

            {{-- SECTION 3: DATA KELUARGA / PMO --}}
            <div class="registrasi-section">
                <div class="section-header">
                    <i class="fa-solid fa-users-viewfinder"></i>
                    Data Keluarga / PMO (Pendamping Minum Obat)
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>Nama Keluarga / PMO</label>
                        <input type="text" name="nama_keluarga" placeholder="Nama pendamping" value="{{ old('nama_keluarga') }}">
                    </div>
                    <div class="form-group">
                        <label>Nomor WhatsApp Keluarga</label>
                        <div class="phone-input-wrapper">
                            <span>+62</span>
                            <input type="text" name="no_hp_keluarga" placeholder="81234567890" value="{{ old('no_hp_keluarga') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>
                    <div class="form-group" style="grid-column: span 2;">
                        <label>Alamat Lengkap Keluarga</label>
                        <input type="text" name="alamat_keluarga" placeholder="Alamat lengkap keluarga" value="{{ old('alamat_keluarga') }}">
                    </div>
                    <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label>RT Keluarga</label>
                            <input type="text" name="rt_keluarga" placeholder="000" value="{{ old('rt_keluarga') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                        <div>
                            <label>RW Keluarga</label>
                            <input type="text" name="rw_keluarga" placeholder="000" value="{{ old('rw_keluarga') }}" inputmode="numeric" oninput="this.value = this.value.replace(/[^0-9]/g, '')">
                        </div>
                    </div>
                    <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label>Provinsi Keluarga</label>
                            <select name="provinsi_keluarga" id="provinsi_keluarga" required>
                                <option value="">Pilih Provinsi</option>
                            </select>
                        </div>
                        <div>
                            <label>Kabupaten Keluarga</label>
                            <select name="kabupaten_keluarga" id="kabupaten_keluarga" required disabled>
                                <option value="">Pilih Kabupaten</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group" style="display: grid; grid-template-columns: 1fr 1fr; gap: 15px;">
                        <div>
                            <label>Kecamatan Keluarga</label>
                            <select name="kecamatan_keluarga" id="kecamatan_keluarga" required disabled>
                                <option value="">Pilih Kecamatan</option>
                            </select>
                        </div>
                        <div>
                            <label>Kelurahan Keluarga</label>
                            <select name="kelurahan_keluarga" id="kelurahan_keluarga" required disabled>
                                <option value="">Pilih Kelurahan</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Email / No. HP Keluarga (Untuk Login)</label>
                        <input type="text" name="email_keluarga" placeholder="email@keluarga.com atau 0812..." value="{{ old('email_keluarga') }}">
                    </div>
                    <div class="form-group">
                        <label>Password Akun Keluarga</label>
                        <input type="password" name="password_keluarga" placeholder="********" value="{{ old('password_keluarga') }}">
                    </div>
                </div>
            </div>

            {{-- SECTION 4: DATA KLINIS --}}
            <div class="registrasi-section">
                <div class="section-header">
                    <i class="fa-solid fa-notes-medical"></i>
                    Informasi Klinis Pasien
                </div>
                <div class="form-grid">
                    <div class="form-group">
                        <label>No Registrasi Nasional</label>
                        <input type="text" name="no_registrasi_nasional" placeholder="Nomor Reg Nasional" value="{{ old('no_registrasi_nasional') }}">
                    </div>
                    <div class="form-group">
                        <label>Tanggal Awal Pengobatan</label>
                        <input type="date" name="tanggal_awal_pengobatan" value="{{ old('tanggal_awal_pengobatan') }}">
                    </div>
                    <div class="form-group">
                        <label>Lokasi Diagnosa</label>
                        <input type="text" name="lokasi_diagnosa" placeholder="Nama Faskes" value="{{ old('lokasi_diagnosa') }}">
                    </div>
                    <div class="form-group">
                        <label>Keterangan Pasien</label>
                        <select name="keterangan_pasien">
                            <option value="Baru" {{ old('keterangan_pasien') == 'Baru' ? 'selected' : '' }}>Baru</option>
                            <option value="Lama" {{ old('keterangan_pasien') == 'Lama' ? 'selected' : '' }}>Lama</option>
                            <option value="Pindahan" {{ old('keterangan_pasien') == 'Pindahan' ? 'selected' : '' }}>Pindahan</option>
                            <option value="Pindah Pengobatan" {{ old('keterangan_pasien') == 'Pindah Pengobatan' ? 'selected' : '' }}>Pindah Pengobatan</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Status Pasien</label>
                        <select name="status_pasien">
                            <option value="Hidup" {{ old('status_pasien') == 'Hidup' ? 'selected' : '' }}>Hidup</option>
                            <option value="Meninggal" {{ old('status_pasien') == 'Meninggal' ? 'selected' : '' }}>Meninggal</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="actions-bar">
                <button type="submit" class="btn-submit">
                    <i class="fa-solid fa-user-check"></i>
                    Simpan dan Daftarkan Pasien
                </button>
            </div>
        </form>
    </div>
    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const apiBase = 'https://www.emsifa.com/api-wilayah-indonesia/api';

            // Old values from Laravel
            const oldValues = {
                pasien: {
                    provinsi: "{{ old('provinsi') }}",
                    kabupaten: "{{ old('kabupaten') }}",
                    kecamatan: "{{ old('kecamatan') }}",
                    kelurahan: "{{ old('kelurahan') }}"
                },
                keluarga: {
                    provinsi: "{{ old('provinsi_keluarga') }}",
                    kabupaten: "{{ old('kabupaten_keluarga') }}",
                    kecamatan: "{{ old('kecamatan_keluarga') }}",
                    kelurahan: "{{ old('kelurahan_keluarga') }}"
                }
            };

            async function loadProvinces(selectId, oldVal, nextSelectId, type) {
                const response = await fetch(`${apiBase}/provinces.json`);
                const provinces = await response.json();
                const select = document.getElementById(selectId);
                
                provinces.forEach(p => {
                    const opt = document.createElement('option');
                    opt.value = p.name;
                    opt.dataset.id = p.id;
                    opt.textContent = p.name;
                    if(p.name === oldVal) opt.selected = true;
                    select.appendChild(opt);
                });

                if(oldVal && nextSelectId) {
                    const selectedOpt = select.options[select.selectedIndex];
                    if(selectedOpt && selectedOpt.dataset.id) {
                        loadRegencies(selectedOpt.dataset.id, nextSelectId, oldValues[type].kabupaten, type === 'pasien' ? 'kecamatan' : 'kecamatan_keluarga', type);
                    }
                }
            }

            async function loadRegencies(provId, selectId, oldVal, nextSelectId, type) {
                const response = await fetch(`${apiBase}/regencies/${provId}.json`);
                const regencies = await response.json();
                const select = document.getElementById(selectId);
                select.innerHTML = '<option value="">Pilih Kabupaten/Kota</option>';
                
                regencies.forEach(r => {
                    const opt = document.createElement('option');
                    opt.value = r.name;
                    opt.dataset.id = r.id;
                    opt.textContent = r.name;
                    if(r.name === oldVal) opt.selected = true;
                    select.appendChild(opt);
                });
                select.disabled = false;

                if(oldVal && nextSelectId) {
                    const selectedOpt = select.options[select.selectedIndex];
                    if(selectedOpt && selectedOpt.dataset.id) {
                        loadDistricts(selectedOpt.dataset.id, nextSelectId, oldValues[type].kecamatan, type === 'pasien' ? 'kelurahan' : 'kelurahan_keluarga', type);
                    }
                }
            }

            async function loadDistricts(regId, selectId, oldVal, nextSelectId, type) {
                const response = await fetch(`${apiBase}/districts/${regId}.json`);
                const districts = await response.json();
                const select = document.getElementById(selectId);
                select.innerHTML = '<option value="">Pilih Kecamatan</option>';
                
                districts.forEach(d => {
                    const opt = document.createElement('option');
                    opt.value = d.name;
                    opt.dataset.id = d.id;
                    opt.textContent = d.name;
                    if(d.name === oldVal) opt.selected = true;
                    select.appendChild(opt);
                });
                select.disabled = false;

                if(oldVal && nextSelectId) {
                    const selectedOpt = select.options[select.selectedIndex];
                    if(selectedOpt && selectedOpt.dataset.id) {
                        loadVillages(selectedOpt.dataset.id, nextSelectId, oldValues[type].kelurahan);
                    }
                }
            }

            async function loadVillages(distId, selectId, oldVal) {
                const response = await fetch(`${apiBase}/villages/${distId}.json`);
                const villages = await response.json();
                const select = document.getElementById(selectId);
                select.innerHTML = '<option value="">Pilih Kelurahan/Desa</option>';
                
                villages.forEach(v => {
                    const opt = document.createElement('option');
                    opt.value = v.name;
                    opt.dataset.id = v.id;
                    opt.textContent = v.name;
                    if(v.name === oldVal) opt.selected = true;
                    select.appendChild(opt);
                });
                select.disabled = false;
            }

            // Init Pasien
            loadProvinces('provinsi', oldValues.pasien.provinsi, 'kabupaten', 'pasien');
            document.getElementById('provinsi').addEventListener('change', function() {
                const id = this.options[this.selectedIndex].dataset.id;
                if(id) loadRegencies(id, 'kabupaten', null, 'kecamatan', 'pasien');
                else document.getElementById('kabupaten').disabled = true;
                document.getElementById('kecamatan').disabled = true;
                document.getElementById('kelurahan').disabled = true;
            });

            document.getElementById('kabupaten').addEventListener('change', function() {
                const id = this.options[this.selectedIndex].dataset.id;
                if(id) loadDistricts(id, 'kecamatan', null, 'kelurahan', 'pasien');
                else document.getElementById('kecamatan').disabled = true;
                document.getElementById('kelurahan').disabled = true;
            });

            document.getElementById('kecamatan').addEventListener('change', function() {
                const id = this.options[this.selectedIndex].dataset.id;
                if(id) loadVillages(id, 'kelurahan', null);
                else document.getElementById('kelurahan').disabled = true;
            });

            // Init Keluarga
            loadProvinces('provinsi_keluarga', oldValues.keluarga.provinsi, 'kabupaten_keluarga', 'keluarga');
            document.getElementById('provinsi_keluarga').addEventListener('change', function() {
                const id = this.options[this.selectedIndex].dataset.id;
                if(id) loadRegencies(id, 'kabupaten_keluarga', null, 'kecamatan_keluarga', 'keluarga');
                else document.getElementById('kabupaten_keluarga').disabled = true;
                document.getElementById('kecamatan_keluarga').disabled = true;
                document.getElementById('kelurahan_keluarga').disabled = true;
            });

            document.getElementById('kabupaten_keluarga').addEventListener('change', function() {
                const id = this.options[this.selectedIndex].dataset.id;
                if(id) loadDistricts(id, 'kecamatan_keluarga', null, 'kelurahan_keluarga', 'keluarga');
                else document.getElementById('kecamatan_keluarga').disabled = true;
                document.getElementById('kelurahan_keluarga').disabled = true;
            });

            document.getElementById('kecamatan_keluarga').addEventListener('change', function() {
                const id = this.options[this.selectedIndex].dataset.id;
                if(id) loadVillages(id, 'kelurahan_keluarga', null);
                else document.getElementById('kelurahan_keluarga').disabled = true;
            });
        });
    </script>
    @endpush
@endsection