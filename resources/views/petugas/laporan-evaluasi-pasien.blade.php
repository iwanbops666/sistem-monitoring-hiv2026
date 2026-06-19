@extends('layouts.app')

@section('title', 'Laporan Evaluasi')

@section('content')
    <style>
        .modal-box-evaluasi {
            background: #ffffff;
            width: 100%;
            max-width: 1000px;
            border-radius: 24px;
            padding: 40px;
            position: relative;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            max-height: 90vh;
            overflow-y: auto;
            animation: modalSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .modal-title-evaluasi {
            font-size: 28px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f1f5f9;
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .modal-title-evaluasi i { color: #10b981; }

        .evaluasi-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        .evaluasi-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .evaluasi-group label {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .evaluasi-group input,
        .evaluasi-group select,
        .evaluasi-group textarea {
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.2s;
        }

        .evaluasi-group input:focus,
        .evaluasi-group select:focus,
        .evaluasi-group textarea:focus {
            border-color: #10b981;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            outline: none;
        }

        .evaluasi-group textarea {
            height: 100px;
            resize: none;
        }

        .modal-actions-evaluasi {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1.5px solid #f1f5f9;
        }
    </style>

    <section class="table-card">
        <div class="table-top" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; gap: 20px;">
            <h2 style="font-size: 20px; font-weight: 900; color: #1e293b; margin: 0;">Daftar Evaluasi Klinis Pasien</h2>

            <form action="{{ route('petugas.laporan-evaluasi-pasien') }}" method="GET" style="display: flex; align-items: center; gap: 15px;">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass" style="color: #94a3b8;"></i>
                    <input type="text" name="search" placeholder="Cari Nama / RM..." value="{{ request('search') }}">
                </div>

                <select name="limit" class="search-box" style="width: auto; cursor: pointer;" onchange="this.form.submit()">
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
                        <th style="padding-left: 20px; width: 250px;">Nama Pasien</th>
                        <th style="text-align: center; width: 130px;">No RM</th>
                        <th style="text-align: center; width: 150px;">Regis Nasional</th>
                        <th style="text-align: center; width: 150px;">WhatsApp</th>
                        <th style="text-align: center; width: 180px;">Aksi</th>
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
                            <td style="text-align: center;"><code style="background: #f8fafc; padding: 4px 8px; border-radius: 6px; font-weight: 700; color: #64748b; font-size: 12px; border: 1px solid #e2e8f0; white-space: nowrap;">{{ $pasien->nomor_rm }}</code></td>
                            <td style="text-align: center;"><span style="color: #94a3b8; font-weight: 600; font-size: 13px;">{{ $pasien->no_registrasi_nasional ?? '-' }}</span></td>
                            <td style="text-align: center;"><span style="color: #64748b; font-weight: 600; font-size: 13px;">{{ $pasien->no_hp }}</span></td>
                            <td style="text-align: center;">
                                <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                    <button type="button" class="btn-compact-action open-evaluasi-modal" data-id="{{ $pasien->user_id }}" style="height: 32px; padding: 0 12px; border-radius: 8px; font-size: 12px;">
                                        <i class="fa-solid fa-clipboard-check" style="font-size: 12px;"></i> Evaluasi
                                    </button>
                                    <button type="button" class="btn-detail open-riwayat-modal" 
                                            data-id="{{ $pasien->user_id }}" 
                                            title="View Detail"
                                            style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid #e2e8f0; background: #ffffff; color: #64748b; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center;">
                                        <i class="fa-solid fa-eye" style="font-size: 14px;"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding: 50px; color: #94a3b8;">
                                <i class="fa-solid fa-notes-medical" style="font-size: 30px; display: block; margin-bottom: 10px;"></i>
                                Data tidak ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span style="font-weight: 600;">Menampilkan {{ $pasiens->firstItem() ?? 0 }} - {{ $pasiens->lastItem() ?? 0 }} dari {{ $pasiens->total() }} Entri</span>

            <div class="pagination">
                {{ $pasiens->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>

    {{-- MODAL LAPORAN EVALUASI --}}
    <div class="modal-overlay" id="evaluasiModal">
        <div class="modal-box-evaluasi">
            <button class="modal-close" id="closeEvaluasiModal">&times;</button>

            <h2 class="modal-title-evaluasi">
                <i class="fa-solid fa-file-waveform"></i>
                Laporan Evaluasi Klinis
            </h2>

            <form action="{{ route('petugas.laporan-evaluasi.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_pasien" id="modal_id_pasien">

                <div class="evaluasi-grid">
                    <div class="evaluasi-group">
                        <label>Tahap Kunjungan</label>
                        <select name="kunjungan" id="input_tahap_kunjungan" required>
                            <option value="">-- Pilih Tahap --</option>
                            <option value="Kunjungan Pertama">Kunjungan Pertama</option>
                            <option value="Memenuhi Syarat Medis ART">Memenuhi Syarat Medis ART</option>
                            <option value="Saat Mulai ART">Saat Mulai ART</option>
                            <option value="Setelah 6 Bulan ART">Setelah 6 Bulan ART</option>
                            <option value="Setelah 1 Tahun ART">Setelah 1 Tahun ART</option>
                            <option value="Setelah 2 Tahun ART">Setelah 2 Tahun ART</option>
                            <option value="Setelah 3 Tahun ART">Setelah 3 Tahun ART</option>
                            <option value="Setelah 4 Tahun ART">Setelah 4 Tahun ART</option>
                            <option value="Setelah 5 Tahun ART">Setelah 5 Tahun ART</option>
                            <option value="Setelah 6 Tahun ART">Setelah 6 Tahun ART</option>
                            <option value="Setelah 7 Tahun ART">Setelah 7 Tahun ART</option>
                            <option value="Setelah 8 Tahun ART">Setelah 8 Tahun ART</option>
                            <option value="Setelah 9 Tahun ART">Setelah 9 Tahun ART</option>
                            <option value="Setelah 10 Tahun ART">Setelah 10 Tahun ART</option>
                        </select>
                    </div>

                    <div class="evaluasi-group">
                        <label>Tanggal Evaluasi</label>
                        <input type="date" name="tanggal" id="input_tanggal_evaluasi" required>
                    </div>
                </div>

                <div class="evaluasi-grid">
                    <div class="evaluasi-group">
                        <label>Standar Klinis </label>
                        <textarea name="standar_klinis" id="input_standar_klinis" placeholder="Catatan standar klinis..."></textarea>
                    </div>

                    <div class="evaluasi-group">
                        <label>Hasil ARV Terakhir</label>
                        <textarea name="hasil_arv_terakhir" id="input_hasil_arv" placeholder="Catatan hasil ARV terakhir..."></textarea>
                    </div>
                </div>

                <div class="evaluasi-grid">
                    <div class="evaluasi-group">
                        <label>Jumlah CD4</label>
                        <input type="number" name="jumlah_cd4" id="input_cd4" placeholder="0">
                    </div>

                    <div class="evaluasi-group">
                        <label>Berat Badan (kg)</label>
                        <input type="number" name="berat_badan" id="input_berat_badan" step="0.1" placeholder="0.0">
                    </div>

                    <div class="evaluasi-group">
                        <label>Status Fungsional (K.Amb.B)</label>
                        <select name="status_fungsional" id="input_status_fungsional">
                            <option value="">-- Pilih Status --</option>
                            <option value="K">K (Kerja/Working)</option>
                            <option value="Amb">Amb (Ambulatory)</option>
                            <option value="B">B (Bedridden/Tidur)</option>
                        </select>
                    </div>

                    <div class="evaluasi-group">
                        <label>Status Viral Load</label>
                        <select name="status_viral_load" id="input_status_viral_load">
                            <option value="">-- Pilih Status Viral Load --</option>
                            <option value="Sudah Dilakukan Viraload 6 Bulan Awal">Sudah Dilakukan Viraload 6 Bulan Awal</option>
                            <option value="Sudah di lakukan Viraload Tahunan Rutin">Sudah di lakukan Viraload Tahunan Rutin</option>
                            <option value="Belum Dilakukan">Belum Dilakukan</option>
                        </select>
                    </div>
                </div>

                <div class="evaluasi-group">
                    <label>Catatan Petugas (Pesan untuk Pasien)</label>
                    <textarea name="catatan" id="input_catatan_evaluasi" style="height: 120px;" placeholder="Tulis catatan evaluasi di sini..."></textarea>
                </div>

                <div class="modal-actions-evaluasi">
                    <button type="submit" class="btn-modal-save" id="btn_save_evaluasi">
                        <i class="fa-solid fa-save"></i>
                        <span id="text_save_evaluasi">Simpan Hasil Evaluasi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL RIWAYAT EVALUASI --}}
    <div class="modal-overlay" id="riwayatModal">
        <div class="modal-box-evaluasi" style="max-width: 1200px;">
            <button class="modal-close" id="closeRiwayatModal">&times;</button>

            <h2 class="modal-title-evaluasi">
                <i class="fa-solid fa-eye"></i>
                Detail & Riwayat Evaluasi Klinis
            </h2>

            <div id="riwayat_pasien_info" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; background: #f8fafc; padding: 25px; border-radius: 20px; border: 1.5px solid #e2e8f0; margin-bottom: 30px;">
                <div class="info-item">
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 5px;">Nama Pasien</label>
                    <div id="info_nama" style="font-weight: 700; color: #1e293b;">-</div>
                </div>
                <div class="info-item">
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 5px;">No. Rekam Medis</label>
                    <div id="info_rm" style="font-weight: 700; color: #1e293b;">-</div>
                </div>
                <div class="info-item">
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 5px;">Regis Nasional</label>
                    <div id="info_regis" style="font-weight: 700; color: #1e293b;">-</div>
                </div>
                <div class="info-item">
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 5px;">Jenis Kelamin</label>
                    <div id="info_gender" style="font-weight: 700; color: #1e293b;">-</div>
                </div>
                <div class="info-item">
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 5px;">WhatsApp</label>
                    <div id="info_hp" style="font-weight: 700; color: #1e293b;">-</div>
                </div>
                <div class="info-item">
                    <label style="display: block; font-size: 11px; font-weight: 800; color: #94a3b8; text-transform: uppercase; margin-bottom: 5px;">Status Pasien</label>
                    <div id="info_status" style="font-weight: 700; color: #1e293b;">-</div>
                </div>
            </div>

            <h3 style="font-size: 16px; font-weight: 800; color: #1e293b; margin-bottom: 15px; display: flex; align-items: center; gap: 10px;">
                <i class="fa-solid fa-clock-rotate-left" style="color: #10b981;"></i>
                Log Riwayat Evaluasi
            </h3>

            <div class="table-responsive" style="margin-top: 20px; max-height: 60vh; overflow-y: auto;">
                <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
                    <thead style="position: sticky; top: 0; background: white; z-index: 10;">
                        <tr>
                             <th style="padding: 15px; border-bottom: 2px solid #f1f5f9; text-align: left;">Tanggal</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f1f5f9; text-align: left;">Tahap</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f1f5f9; text-align: left;">Viral Load</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f1f5f9; text-align: left;">BB / CD4 / ARV</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f1f5f9; text-align: left;">Fungsional</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f1f5f9; text-align: left;">Catatan</th>
                        </tr>
                    </thead>
                    <tbody id="riwayat_table_body">
                        {{-- Data will be loaded here via AJAX --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const evaluasiModal = document.getElementById('evaluasiModal');
                const riwayatModal = document.getElementById('riwayatModal');
                const openEvaluasiButtons = document.querySelectorAll('.open-evaluasi-modal');
                const openRiwayatButtons = document.querySelectorAll('.open-riwayat-modal');
                const closeEvaluasiButton = document.getElementById('closeEvaluasiModal');
                const closeRiwayatButton = document.getElementById('closeRiwayatModal');
                const riwayatTableBody = document.getElementById('riwayat_table_body');
                const riwayatNamaPasien = document.getElementById('riwayat_nama_pasien');

                // State
                let currentPatientHistory = [];

                // Elements
                const inputTahap = document.getElementById('input_tahap_kunjungan');
                const inputTanggal = document.getElementById('input_tanggal_evaluasi');
                const inputStandar = document.getElementById('input_standar_klinis');
                const inputStatus = document.getElementById('input_status_fungsional');
                const inputCd4 = document.getElementById('input_cd4');
                const inputBb = document.getElementById('input_berat_badan');
                const inputArv = document.getElementById('input_hasil_arv');
                const inputViralLoad = document.getElementById('input_status_viral_load');
                const inputCatatan = document.getElementById('input_catatan_evaluasi');
                const textSave = document.getElementById('text_save_evaluasi');

                function resetForm() {
                    inputTahap.value = '';
                    inputStandar.value = '';
                    inputStatus.value = '';
                    inputCd4.value = '';
                    inputBb.value = '';
                    inputArv.value = '';
                    inputViralLoad.value = '';
                    inputCatatan.value = '';
                    textSave.textContent = 'Simpan Hasil Evaluasi';
                }

                openEvaluasiButtons.forEach(button => {
                    button.addEventListener('click', async function () {
                        const id = this.getAttribute('data-id');
                        document.getElementById('modal_id_pasien').value = id;
                        
                        resetForm();
                        const today = new Date().toISOString().split('T')[0];
                        inputTanggal.value = today;

                        evaluasiModal.classList.add('show');

                        try {
                            const response = await fetch(`/laporan-evaluasi/riwayat-laporan-evaluasi/${id}`);
                            const data = await response.json();
                            currentPatientHistory = data.riwayat;
                            checkAndFillData(inputTahap.value);
                        } catch (error) {
                            console.error('Gagal mengambil riwayat:', error);
                        }
                    });
                });

                inputTahap.addEventListener('change', function() {
                    checkAndFillData(this.value);
                });

                function checkAndFillData(stage) {
                    if (!stage) {
                        resetForm();
                        const today = new Date().toISOString().split('T')[0];
                        inputTanggal.value = today;
                        return;
                    }

                    const existing = currentPatientHistory.find(item => item.kunjungan === stage);

                    if (existing) {
                        inputTanggal.value = existing.tanggal ? new Date(existing.tanggal).toISOString().split('T')[0] : '';
                        inputStandar.value = existing.standar_klinis || '';
                        inputStatus.value = existing.status_fungsional || '';
                        inputCd4.value = existing.jumlah_cd4 || '';
                        inputBb.value = existing.berat_badan || '';
                        inputArv.value = existing.hasil_arv_terakhir || '';
                        inputViralLoad.value = existing.status_viral_load || '';
                        inputCatatan.value = existing.catatan || '';
                        textSave.textContent = 'Update Hasil Evaluasi';

                        [inputTanggal, inputStandar, inputStatus, inputCd4, inputBb, inputArv, inputViralLoad, inputCatatan].forEach(el => {
                            el.style.backgroundColor = '#ecfdf5';
                            setTimeout(() => el.style.backgroundColor = '#f8fafc', 1000);
                        });
                    } else {
                        // Reset everything except stage
                        inputStandar.value = '';
                        inputStatus.value = '';
                        inputCd4.value = '';
                        inputBb.value = '';
                        inputArv.value = '';
                        inputViralLoad.value = '';
                        inputCatatan.value = '';
                        const today = new Date().toISOString().split('T')[0];
                        inputTanggal.value = today;
                        textSave.textContent = 'Simpan Hasil Evaluasi';
                    }
                }

                openRiwayatButtons.forEach(button => {
                    button.addEventListener('click', async function () {
                        const id = this.getAttribute('data-id');
                        riwayatTableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px;"><i class="fa-solid fa-spinner fa-spin" style="font-size: 24px; color: #10b981;"></i><br><br>Memuat data...</td></tr>';
                        riwayatModal.classList.add('show');

                        try {
                            const response = await fetch(`/laporan-evaluasi/riwayat-laporan-evaluasi/${id}`);
                            const data = await response.json();

                            // Populate Patient Info
                            document.getElementById('info_nama').textContent = data.pasien.nama;
                            document.getElementById('info_rm').textContent = data.pasien.nomor_rm;
                            document.getElementById('info_regis').textContent = data.pasien.no_registrasi_nasional || '-';
                            document.getElementById('info_gender').textContent = data.pasien.jenis_kelamin;
                            document.getElementById('info_hp').textContent = data.pasien.no_hp;
                            document.getElementById('info_status').textContent = data.pasien.status_pasien;

                            riwayatTableBody.innerHTML = '';

                            if (data.riwayat.length === 0) {
                                riwayatTableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada riwayat evaluasi klinis.</td></tr>';
                            } else {
                                data.riwayat.forEach(item => {
                                    const statusMap = {
                                        'K': '<span style="padding: 4px 8px; background: #dcfce7; color: #166534; border-radius: 6px; font-size: 11px; font-weight: 800; border: 1px solid #bbf7d0;">K (Kerja/Working)</span>',
                                        'Amb': '<span style="padding: 4px 8px; background: #fff7ed; color: #9a3412; border-radius: 6px; font-size: 11px; font-weight: 800; border: 1px solid #fed7aa;">Amb (Ambulatory)</span>',
                                        'B': '<span style="padding: 4px 8px; background: #fee2e2; color: #991b1b; border-radius: 6px; font-size: 11px; font-weight: 800; border: 1px solid #fecaca;">B (Bedridden/Tidur)</span>'
                                    };
                                    const statusDisp = statusMap[item.status_fungsional] || item.status_fungsional || '-';

                                    const row = `
                                         <tr style="background: #f8fafc; border-radius: 12px;">
                                            <td style="padding: 15px; font-weight: 700; color: #1e293b;">${new Date(item.tanggal).toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric'})}</td>
                                            <td style="padding: 15px; color: #10b981; font-weight: 600;">${item.kunjungan}</td>
                                            <td style="padding: 15px;"><div style="font-size: 13px; color: #475569;">${item.status_viral_load || '-'}</div></td>
                                            <td style="padding: 15px;"><div style="font-size: 13px; color: #475569;">BB: ${item.berat_badan || '-'} kg<br>CD4: ${item.jumlah_cd4 || '-'}<br>ARV: ${item.hasil_arv_terakhir || '-'}</div></td>
                                            <td style="padding: 15px;"><div style="max-width: 200px; font-size: 13px; color: #475569;">${statusDisp}</div></td>
                                            <td style="padding: 15px;"><div style="max-width: 250px; font-size: 13px; font-style: italic; color: #64748b;">${item.catatan || '-'}</div></td>
                                        </tr>
                                    `;
                                    riwayatTableBody.insertAdjacentHTML('beforeend', row);
                                });
                            }
                        } catch (error) {
                            riwayatTableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px; color: #ef4444;">Gagal memuat data.</td></tr>';
                        }
                    });
                });

                closeEvaluasiButton.addEventListener('click', () => evaluasiModal.classList.remove('show'));
                closeRiwayatButton.addEventListener('click', () => riwayatModal.classList.remove('show'));
                
                window.addEventListener('click', (e) => { 
                    if (e.target === evaluasiModal) evaluasiModal.classList.remove('show'); 
                    if (e.target === riwayatModal) riwayatModal.classList.remove('show'); 
                });
            });
        </script>
    @endpush
@endsection