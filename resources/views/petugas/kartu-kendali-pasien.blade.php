@extends('layouts.app')

@section('title', 'Kartu Kendali Pasien')

@section('content')
    <style>
        .modal-box-kartu {
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

        .modal-title-kartu {
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

        .modal-title-kartu i { color: #10b981; }

        .kartu-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px;
            margin-bottom: 25px;
        }

        .kartu-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
        }

        .kartu-group label {
            font-size: 14px;
            font-weight: 700;
            color: #374151;
        }

        .kartu-group input,
        .kartu-group textarea {
            border: 1.5px solid #e5e7eb;
            border-radius: 12px;
            padding: 12px 16px;
            font-size: 14px;
            color: #1e293b;
            background: #f8fafc;
            transition: all 0.2s;
        }

        .kartu-group input:focus,
        .kartu-group textarea:focus {
            border-color: #10b981;
            background: #ffffff;
            box-shadow: 0 0 0 4px rgba(16, 185, 129, 0.1);
            outline: none;
        }

        .kartu-group textarea {
            height: 100px;
            resize: none;
        }

        .modal-actions-kartu {
            display: flex;
            justify-content: flex-end;
            gap: 15px;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1.5px solid #f1f5f9;
        }

        .obat-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 12px;
            background: #f8fafc;
            padding: 20px;
            border-radius: 16px;
            border: 1.5px solid #e5e7eb;
            margin-bottom: 25px;
        }

        .obat-item {
            display: flex;
            align-items: center;
            gap: 10px;
            cursor: pointer;
            padding: 8px;
            border-radius: 10px;
            transition: all 0.2s;
        }

        .obat-item:hover {
            background: rgba(16, 185, 129, 0.05);
        }

        .obat-item input[type="checkbox"] {
            width: 20px;
            height: 20px;
            cursor: pointer;
            accent-color: #10b981;
        }

        .obat-item span {
            font-size: 14px;
            font-weight: 600;
            color: #475569;
            flex: 1;
        }

        .obat-qty-input {
            width: 80px;
            padding: 6px 10px;
            border: 1.5px solid #e2e8f0;
            border-radius: 8px;
            font-size: 13px;
            text-align: center;
            background: #ffffff;
            transition: all 0.2s;
        }

        .obat-qty-input:focus {
            border-color: #10b981;
            outline: none;
            box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.1);
        }

        .obat-qty-label {
            font-size: 11px;
            font-weight: 700;
            color: #94a3b8;
            text-transform: uppercase;
            margin-right: 5px;
        }
    </style>

    <section class="table-card">
        <div class="table-top" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px; gap: 20px;">
            <h2 style="font-size: 20px; font-weight: 900; color: #1e293b; margin: 0;">Daftar Kontrol Kartu Kendali</h2>

            <form action="{{ route('petugas.kartu-kendali-pasien') }}" method="GET" style="display: flex; align-items: center; gap: 15px;">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass" style="color: #94a3b8;"></i>
                    <input type="text" name="search" placeholder="Cari Nama / RM..." value="{{ request('search') }}">
                </div>

                <select name="limit" class="search-box" style="width: auto; cursor: pointer;" onchange="this.form.submit()">
                    <option value="10" {{ request('limit') == 10 ? 'selected' : '' }}>10 Baris</option>
                    <option value="25" {{ request('limit') == 25 ? 'selected' : '' }}>25 Baris</option>
                    <option value="50" {{ request('limit') == 50 ? 'selected' : '' }}>50 Baris</option>
                    <option value="100" {{ request('limit') == 100 ? 'selected' : '' }}>100 Baris</option>
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
                                    <button type="button" class="btn-compact-action open-kartu-modal" data-id="{{ $pasien->user_id }}" style="height: 32px; padding: 0 12px; border-radius: 8px; font-size: 12px;">
                                        <i class="fa-solid fa-file-pen" style="font-size: 12px;"></i> Isi Kartu
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
                                <i class="fa-solid fa-folder-open" style="font-size: 30px; display: block; margin-bottom: 10px;"></i>
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

    {{-- MODAL FORMULIR KARTU KENDALI --}}
    <div class="modal-overlay" id="kartuModal">
        <div class="modal-box-kartu">
            <button class="modal-close" id="closeKartuModal">&times;</button>

            <h2 class="modal-title-kartu">
                <i class="fa-solid fa-book-medical"></i>
                Formulir Kartu Kendali
            </h2>

            <form action="{{ route('petugas.kartu-kendali.store') }}" method="POST">
                @csrf
                <input type="hidden" name="id_pasien" id="modal_id_pasien">

                <div class="kartu-grid">
                    <div class="kartu-group">
                        <label>Tanggal Kunjungan</label>
                        <input type="date" name="tanggal_kunjungan" id="input_tanggal_kunjungan" required>
                    </div>

                    <div class="kartu-group">
                        <label>Rencana Kunjungan Selanjutnya</label>
                        <input type="date" name="rencana_tanggal_kunjungan_selanjutnya" id="input_rencana_kunjungan">
                    </div>
                </div>

                <div class="kartu-group" style="margin-bottom: 25px;">
                    <label>Rejiman dan Jumlah Obat ARV yang tersisa</label>
                    <div class="obat-grid" id="obat_grid_container">
                        @php
                            $daftar_obat = [
                                'TDF(300)/3TC(300)/EFV(600)',
                                'TDF(300)/3TC(300)/DTG(50)',
                                'OAT KDT Kategori 1',
                                'TPT 3HP KDT',
                                'Sulfamethoxazole: 800 mg / Trimethoprim: 160 mg'
                            ];
                        @endphp
                        @foreach($daftar_obat as $obat)
                            <div class="obat-item static-obat-item">
                                <input type="checkbox" name="obat_selected[]" value="{{ $obat }}" class="obat-cb">
                                <span>{{ $obat }}</span>
                                <div style="display: flex; align-items: center;">
                                    <span class="obat-qty-label">Sisa:</span>
                                    <input type="number" name="obat_jumlah[{{ $obat }}]" class="obat-qty-input" placeholder="0" min="0">
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" id="btn_add_obat" style="background: #f8fafc; border: 1.5px dashed #cbd5e1; color: #475569; padding: 10px 15px; border-radius: 12px; font-weight: 700; font-size: 13px; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; gap: 8px; margin-top: -10px;">
                        <i class="fa-solid fa-plus"></i> Tambah Jenis Obat Lainnya
                    </button>
                </div>

                <div class="kartu-grid">
                    <div class="kartu-group">
                        <label>Jumlah INH Tersisa</label>
                        <input type="number" name="jumlah_inh_tersisa" id="input_inh_sisa" placeholder="0">
                    </div>

                    <div class="kartu-group">
                        <label>INH yang Diberikan (Bulan Depan)</label>
                        <input type="number" name="jumlah_inh_diberikan_untuk_bulan_berikutnya" id="input_inh_diberikan" placeholder="0">
                    </div>
                </div>

                <div class="kartu-group">
                    <label>Efek Samping ARV / IO / Proflaksis</label>
                    <textarea name="efek_samping_arv_io_proflaksis" id="input_efek_samping" placeholder="Catatan efek samping..."></textarea>
                </div>

                <div class="kartu-group">
                    <label>Catatan Petugas (Update ke Pasien)</label>
                    <textarea name="catatan" id="input_catatan" style="height: 120px;" placeholder="Pesan untuk pasien..."></textarea>
                </div>

                <div class="modal-actions-kartu">
                    <button type="submit" class="btn-modal-save" id="btn_save_kartu">
                        <i class="fa-solid fa-circle-check"></i>
                        <span id="text_save_kartu">Simpan Kartu Kendali</span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL RIWAYAT KARTU KENDALI --}}
    <div class="modal-overlay" id="riwayatModal">
        <div class="modal-box-kartu" style="max-width: 1200px;">
            <button class="modal-close" id="closeRiwayatModal">&times;</button>

            <h2 class="modal-title-kartu">
                <i class="fa-solid fa-eye"></i>
                Detail & Riwayat Kartu Kendali
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
                Log Riwayat Kunjungan
            </h3>

            <div class="table-responsive" style="margin-top: 20px; max-height: 60vh; overflow-y: auto;">
                <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
                    <thead style="position: sticky; top: 0; background: white; z-index: 10;">
                        <tr>
                            <th style="padding: 15px; border-bottom: 2px solid #f1f5f9; text-align: left;">Tanggal</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f1f5f9; text-align: left;">Rencana Kembali</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f1f5f9; text-align: left;">Rejiman dan Jumlah Obat ARV yang tersisa</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f1f5f9; text-align: left;">INH Sisa/Diberikan</th>
                            <th style="padding: 15px; border-bottom: 2px solid #f1f5f9; text-align: left;">Efek Samping</th>
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
                const kartuModal = document.getElementById('kartuModal');
                const riwayatModal = document.getElementById('riwayatModal');
                const openButtons = document.querySelectorAll('.open-kartu-modal');
                const openRiwayatButtons = document.querySelectorAll('.open-riwayat-modal');
                const closeButton = document.getElementById('closeKartuModal');
                const closeRiwayatButton = document.getElementById('closeRiwayatModal');
                const riwayatTableBody = document.getElementById('riwayat_table_body');
                const riwayatNamaPasien = document.getElementById('riwayat_nama_pasien');

                // State untuk menyimpan riwayat pasien yang sedang dibuka
                let currentPatientHistory = [];

                // Elements form kartu
                const inputTanggal = document.getElementById('input_tanggal_kunjungan');
                const inputRencana = document.getElementById('input_rencana_kunjungan');
                const inputRejimen = document.getElementById('input_rejimen_arv');
                const inputArvSisa = document.getElementById('input_arv_sisa');
                const inputInhSisa = document.getElementById('input_inh_sisa');
                const inputInhBeri = document.getElementById('input_inh_diberikan');
                const inputEfek = document.getElementById('input_efek_samping');
                const inputCatatan = document.getElementById('input_catatan');
                
                const textSave = document.getElementById('text_save_kartu');
                const btnAddObat = document.getElementById('btn_add_obat');
                const obatGrid = document.getElementById('obat_grid_container');
                let customObatCount = 0;

                btnAddObat.addEventListener('click', function() {
                    customObatCount++;
                    const id = 'custom_obat_' + customObatCount;
                    const valName = 'Obat_Baru_' + customObatCount;
                    const html = `
                        <div class="obat-item custom-obat-item" id="${id}_container">
                            <input type="checkbox" name="obat_selected[]" value="${valName}" class="obat-cb" id="${id}_cb" checked>
                            <input type="text" id="${id}_name" placeholder="Ketik nama obat..." style="flex: 1; border: 1.5px solid #e2e8f0; border-radius: 8px; padding: 6px 10px; font-size: 13px;" value="${valName}">
                            <div style="display: flex; align-items: center;">
                                <span class="obat-qty-label">Sisa:</span>
                                <input type="number" name="obat_jumlah[${valName}]" id="${id}_qty" class="obat-qty-input" placeholder="0" min="0">
                            </div>
                            <button type="button" onclick="document.getElementById('${id}_container').remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; margin-left: 5px;" title="Hapus Obat"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    `;
                    obatGrid.insertAdjacentHTML('beforeend', html);

                    const nameInput = document.getElementById(`${id}_name`);
                    const cbInput = document.getElementById(`${id}_cb`);
                    const qtyInput = document.getElementById(`${id}_qty`);

                    nameInput.addEventListener('input', function() {
                        const val = this.value || valName;
                        cbInput.value = val;
                        qtyInput.name = `obat_jumlah[${val}]`;
                    });
                });

                function resetForm() {
                    inputRencana.value = '';
                    inputInhSisa.value = '';
                    inputInhBeri.value = '';
                    inputEfek.value = '';
                    inputCatatan.value = '';
                    
                    document.querySelectorAll('.static-obat-item').forEach(item => {
                        item.querySelector('.obat-cb').checked = false;
                        item.querySelector('.obat-qty-input').value = '';
                    });
                    
                    document.querySelectorAll('.custom-obat-item').forEach(el => el.remove());
                    
                    textSave.textContent = 'Simpan Kartu Kendali';
                }

                openButtons.forEach(button => {
                    button.addEventListener('click', async function () {
                        const id = this.getAttribute('data-id');
                        document.getElementById('modal_id_pasien').value = id;
                        
                        // Reset form dan set tanggal hari ini
                        resetForm();
                        const today = new Date().toISOString().split('T')[0];
                        inputTanggal.value = today;

                        // Fetch riwayat untuk auto-fill
                        try {
                            const response = await fetch(`/kartu-kendali/riwayat-kartu-kendali/${id}`);
                            const data = await response.json();
                            currentPatientHistory = data.riwayat;
                            
                            // Cek jika ada data untuk tanggal hari ini
                            checkAndFillData(today);
                        } catch (error) {
                            console.error('Gagal mengambil riwayat:', error);
                        }

                        kartuModal.classList.add('show');
                    });
                });

                inputTanggal.addEventListener('change', function() {
                    checkAndFillData(this.value);
                });

                function checkAndFillData(date) {
                    const existing = currentPatientHistory.find(item => {
                        const itemDate = new Date(item.tanggal_kunjungan).toISOString().split('T')[0];
                        return itemDate === date;
                    });

                    if (existing) {
                        inputInhSisa.value = existing.jumlah_inh_yang_tersisa || '';
                        inputInhBeri.value = existing.jumlah_inh_yang_diberikan_untuk_bulan_berikutnya || '';
                        inputEfek.value = existing.efek_samping_dan_lab_profilaksis || '';
                        inputCatatan.value = existing.catatan || '';
                        
                        // Fill static medications
                        const obats = existing.obat_yang_diberikan || [];
                        const standardObats = Array.from(document.querySelectorAll('.static-obat-item span')).map(span => span.textContent);
                        
                        document.querySelectorAll('.custom-obat-item').forEach(el => el.remove());
                        
                        document.querySelectorAll('.static-obat-item').forEach(item => {
                            const cb = item.querySelector('.obat-cb');
                            const qtyInput = item.querySelector('.obat-qty-input');
                            
                            const found = obats.find(o => (typeof o === 'string' ? o : o.nama) === cb.value);
                            
                            if (found) {
                                cb.checked = true;
                                qtyInput.value = typeof found === 'object' ? found.jumlah : '';
                            } else {
                                cb.checked = false;
                                qtyInput.value = '';
                            }
                        });

                        // Append dynamic custom medications if any
                        obats.forEach(o => {
                            const nama = typeof o === 'string' ? o : o.nama;
                            const jumlah = typeof o === 'object' ? (o.jumlah || '') : '';
                            
                            if (!standardObats.includes(nama)) {
                                customObatCount++;
                                const id = 'custom_obat_' + customObatCount;
                                const html = `
                                    <div class="obat-item custom-obat-item" id="${id}_container">
                                        <input type="checkbox" name="obat_selected[]" value="${nama}" class="obat-cb" id="${id}_cb" checked>
                                        <input type="text" id="${id}_name" style="flex: 1; border: 1.5px solid #e2e8f0; border-radius: 8px; padding: 6px 10px; font-size: 13px;" value="${nama}">
                                        <div style="display: flex; align-items: center;">
                                            <span class="obat-qty-label">Sisa:</span>
                                            <input type="number" name="obat_jumlah[${nama}]" id="${id}_qty" class="obat-qty-input" value="${jumlah}" min="0">
                                        </div>
                                        <button type="button" onclick="document.getElementById('${id}_container').remove()" style="background: none; border: none; color: #ef4444; cursor: pointer; margin-left: 5px;" title="Hapus Obat"><i class="fa-solid fa-trash"></i></button>
                                    </div>
                                `;
                                document.getElementById('obat_grid_container').insertAdjacentHTML('beforeend', html);
                                
                                const nameInput = document.getElementById(`${id}_name`);
                                const cbInput = document.getElementById(`${id}_cb`);
                                const qtyInput = document.getElementById(`${id}_qty`);

                                nameInput.addEventListener('input', function() {
                                    const val = this.value || `Obat_Baru_${customObatCount}`;
                                    cbInput.value = val;
                                    qtyInput.name = `obat_jumlah[${val}]`;
                                });
                            }
                        });

                        textSave.textContent = 'Update Kartu Kendali';
                        
                        // Highlight effect
                        [inputRencana, inputInhSisa, inputInhBeri, inputEfek, inputCatatan].forEach(el => {
                            el.style.backgroundColor = '#ecfdf5';
                            setTimeout(() => el.style.backgroundColor = '#f8fafc', 1000);
                        });
                    } else {
                        resetForm();
                    }
                }

                openRiwayatButtons.forEach(button => {
                    button.addEventListener('click', async function () {
                        const id = this.getAttribute('data-id');
                        riwayatTableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px;"><i class="fa-solid fa-spinner fa-spin" style="font-size: 24px; color: #10b981;"></i><br><br>Memuat data...</td></tr>';
                        riwayatModal.classList.add('show');

                        try {
                            const response = await fetch(`/kartu-kendali/riwayat-kartu-kendali/${id}`);
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
                                riwayatTableBody.innerHTML = '<tr><td colspan="6" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada riwayat kartu kendali.</td></tr>';
                            } else {
                                data.riwayat.forEach(item => {
                                    let obatsHtml = '-';
                                    if (item.obat_yang_diberikan && item.obat_yang_diberikan.length > 0) {
                                        obatsHtml = item.obat_yang_diberikan.map(o => {
                                            if (typeof o === 'string') return `• ${o}`;
                                            return `• ${o.nama} (Sisa: ${o.jumlah || 0})`;
                                        }).join('<br>');
                                    }
                                    const row = `
                                        <tr style="background: #f8fafc; border-radius: 12px;">
                                            <td style="padding: 15px; font-weight: 700; color: #1e293b;">${new Date(item.tanggal_kunjungan).toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric'})}</td>
                                            <td style="padding: 15px; color: #64748b;">${item.rencana_tanggal_kunjungan_selanjutnya ? new Date(item.rencana_tanggal_kunjungan_selanjutnya).toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric'}) : '-'}</td>
                                            <td style="padding: 15px;"><div style="max-width: 300px; font-size: 13px; font-weight: 600; color: #10b981;">${obatsHtml}</div></td>
                                            <td style="padding: 15px;"><div style="font-size: 13px; color: #475569;">Sisa: ${item.jumlah_inh_yang_tersisa || '0'}<br>Diberikan: ${item.jumlah_inh_yang_diberikan_untuk_bulan_berikutnya || '0'}</div></td>
                                            <td style="padding: 15px;"><div style="max-width: 200px; font-size: 13px; color: #475569;">${item.efek_samping_dan_lab_profilaksis || '-'}</div></td>
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

                closeButton.addEventListener('click', () => kartuModal.classList.remove('show'));
                closeRiwayatButton.addEventListener('click', () => riwayatModal.classList.remove('show'));
                
                window.addEventListener('click', (e) => { 
                    if (e.target === kartuModal) kartuModal.classList.remove('show'); 
                    if (e.target === riwayatModal) riwayatModal.classList.remove('show'); 
                });
            });
        </script>
    @endpush
@endsection