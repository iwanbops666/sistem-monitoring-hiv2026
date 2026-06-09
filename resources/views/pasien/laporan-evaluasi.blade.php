@extends('layouts.pasien')

@section('title', 'Laporan Evaluasi Pasien')
@section('page-title', 'Laporan Evaluasi Pasien')

@section('content')
    <style>
        .evaluasi-container {
            max-width: 1080px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .evaluasi-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 35px;
            box-shadow: 0 10px 25px rgba(213, 224, 235, 0.3);
            border: 1px solid #f1f5f9;
        }

        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .section-header h2 {
            font-size: 22px;
            font-weight: 900;
            color: #111827;
        }

        .custom-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 12px;
        }

        .custom-table th {
            text-align: left;
            padding: 0 15px 10px;
            color: #9ca3af;
            font-size: 13px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .custom-table tr td {
            background: #f8fafc;
            padding: 20px 15px;
            color: #374151;
            font-size: 14px;
            transition: background 0.2s;
        }

        .custom-table tr td:first-child { border-radius: 12px 0 0 12px; font-weight: 700; }
        .custom-table tr td:last-child { border-radius: 0 12px 12px 0; }

        .custom-table tr:hover td { background: #f1f5f9; }

        .btn-detail {
            background: #ffffff;
            color: #10b981;
            border: 1.5px solid #10b981;
            padding: 8px 20px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.2s;
        }

        .btn-detail:hover {
            background: #10b981;
            color: #ffffff;
            box-shadow: 0 4px 12px rgba(16, 185, 129, 0.25);
        }

        /* MODAL */
        .modal-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.35);
            display: none;
            justify-content: center;
            align-items: center;
            padding: 20px;
            z-index: 10000;
            backdrop-filter: blur(4px);
        }

        .modal-overlay.show { display: flex; }

        .modal-box {
            width: 100%;
            max-width: 900px;
            background: #ffffff;
            border-radius: 24px;
            padding: 40px;
            position: relative;
            box-shadow: 0 25px 50px rgba(0,0,0,0.25);
            max-height: 85vh;
            overflow-y: auto;
            animation: modalPop 0.3s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        @keyframes modalPop {
            from { transform: scale(0.9); opacity: 0; }
            to { transform: scale(1); opacity: 1; }
        }

        .modal-close {
            position: absolute;
            right: 25px;
            top: 25px;
            width: 40px;
            height: 40px;
            border-radius: 12px;
            border: none;
            background: #f1f5f9;
            color: #64748b;
            font-size: 20px;
            cursor: pointer;
            transition: all 0.2s;
        }

        .modal-close:hover { background: #fee2e2; color: #ef4444; }

        .modal-header h2 {
            font-size: 24px;
            font-weight: 900;
            color: #111827;
            margin-bottom: 30px;
        }

        .modal-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 25px 35px;
        }

        .field-group label {
            display: block;
            font-size: 14px;
            font-weight: 700;
            color: #64748b;
            margin-bottom: 10px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .field-val {
            background: #f8fafc;
            border-radius: 12px;
            padding: 16px;
            border: 1.5px solid #e2e8f0;
            color: #1e293b;
            font-size: 15px;
            line-height: 1.5;
            min-height: 52px;
        }

        .grid-span-2 {
            grid-column: span 2;
        }

        @media (max-width: 900px) {
            .modal-box {
                padding: 25px 20px;
                max-height: 90vh;
                border-radius: 20px;
            }
            .modal-close {
                right: 15px;
                top: 15px;
                width: 36px;
                height: 36px;
                font-size: 18px;
            }
            .modal-header h2 {
                font-size: 20px;
                margin-bottom: 20px;
                padding-right: 30px;
            }
            .modal-grid { 
                grid-template-columns: 1fr; 
                gap: 15px;
            }
            .grid-span-2 {
                grid-column: span 1;
            }
            .section-header { 
                flex-direction: column; 
                align-items: flex-start; 
                gap: 15px; 
            }
        }
    </style>

    <div class="evaluasi-container">
        <section class="evaluasi-card">
            <div class="section-header">
                <h2>Laporan Evaluasi & Klinis</h2>
            </div>

            <div style="overflow-x: auto;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Tipe Laporan</th>
                            <th>Kunjungan / Agenda</th>
                            <th>Tanggal Periksa</th>
                            <th>Hasil / Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr>
                                <td>
                                    @if($record->record_type == 'clinical')
                                        <span style="padding: 4px 10px; background: #eff6ff; border-radius: 6px; font-size: 11px; font-weight: 800; color: #3b82f6; text-transform: uppercase;">
                                            <i class="fa-solid fa-stethoscope"></i> Evaluasi Klinis
                                        </span>
                                    @else
                                        <span style="padding: 4px 10px; background: #fef2f2; border-radius: 6px; font-size: 11px; font-weight: 800; color: #ef4444; text-transform: uppercase;">
                                            <i class="fa-solid fa-vial"></i> Viral Load
                                        </span>
                                    @endif
                                </td>
                                <td data-label="Kunjungan / Agenda" style="font-weight: 800; color: #1e293b;">
                                    {{ $record->record_type == 'clinical' ? '#' . $record->kunjungan : $record->kunjungan }}
                                </td>
                                <td data-label="Tanggal Periksa">{{ \Carbon\Carbon::parse($record->tanggal)->format('d M Y') }}</td>
                                <td data-label="Hasil / Status">
                                    @if($record->record_type == 'clinical')
                                        @php
                                            $statusMap = [
                                                'K' => 'K (Kerja)',
                                                'Amb' => 'Amb (Ambulatory)',
                                                'B' => 'B (Bedridden)'
                                            ];
                                            $statusLabel = $statusMap[$record->status_fungsional] ?? $record->status_fungsional ?? '-';
                                        @endphp
                                         <div style="display: flex; flex-direction: column; gap: 4px;">
                                            <div style="display: flex; gap: 8px;">
                                                <span style="padding: 2px 8px; background: #ecfdf5; border-radius: 6px; font-size: 11px; font-weight: 700; color: #059669; width: fit-content;">
                                                    CD4: {{ $record->jumlah_cd4 ?? '-' }}
                                                </span>
                                                <span style="padding: 2px 8px; background: #fdf2f8; border-radius: 6px; font-size: 11px; font-weight: 700; color: #db2777; width: fit-content;">
                                                    BB: {{ $record->berat_badan ?? '-' }} kg
                                                </span>
                                            </div>
                                            @if($record->status_viral_load)
                                                <span style="padding: 2px 8px; background: #eef2ff; border-radius: 6px; font-size: 11px; font-weight: 700; color: #4f46e5; width: fit-content;">
                                                    VL: {{ $record->status_viral_load }}
                                                </span>
                                            @endif
                                            <span style="font-size: 11px; font-weight: 600; color: #64748b;">
                                                Status: {{ $statusLabel }}
                                            </span>
                                         </div>
                                    @else
                                        <span style="padding: 4px 10px; background: #fff7ed; border-radius: 6px; font-size: 12px; font-weight: 700; color: #f97316;">
                                            VL: {{ $record->nilai_viral_load }}
                                        </span>
                                    @endif
                                </td>
                                <td style="text-align: right;">
                                    <button 
                                        type="button" 
                                        class="btn-detail"
                                         data-type="{{ $record->record_type }}"
                                         data-kunjungan="{{ $record->record_type == 'clinical' ? $record->kunjungan : 'Pemeriksaan Viral Load' }}"
                                         data-tanggal="{{ $record->tanggal }}"
                                         data-standart="{{ $record->standar_klinis ?? '-' }}"
                                         data-status="{{ $record->status_fungsional ?? '-' }}"
                                         data-arv="{{ $record->hasil_arv_terakhir ?? '-' }}"
                                         data-cd4="{{ $record->jumlah_cd4 ?? '-' }}"
                                         data-bb="{{ $record->berat_badan ?? '-' }}"
                                         data-catatan="{{ $record->catatan ?? $record->keterangan ?? '-' }}"
                                         data-vl-nilai="{{ $record->nilai_viral_load ?? '-' }}"
                                         data-vl-status="{{ $record->status_viral_load ?? '-' }}"
                                    >
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 60px; background: #ffffff; color: #9ca3af;">
                                    Belum ada laporan evaluasi klinis.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    {{-- MODAL DETAIL --}}
    <div class="modal-overlay" id="evaluasiModal">
        <div class="modal-box">
            <button type="button" class="modal-close" id="closeModal"><i class="fa-solid fa-xmark"></i></button>
            
            <div class="modal-header">
                <h2 id="modalTitle">Rincian Laporan Evaluasi</h2>
                <div style="display: flex; gap: 20px; margin-bottom: 30px; background: #f8fafc; padding: 15px; border-radius: 12px; border: 1px solid #e2e8f0;">
                    <div>
                        <label style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 4px;">Kunjungan / Agenda</label>
                        <span id="modalKunjungan" style="font-weight: 800; color: #10b981;">-</span>
                    </div>
                    <div style="width: 1px; background: #e2e8f0;"></div>
                    <div>
                        <label style="font-size: 11px; font-weight: 700; color: #94a3b8; text-transform: uppercase; display: block; margin-bottom: 4px;">Tanggal Periksa</label>
                        <span id="modalTanggal" style="font-weight: 700; color: #1e293b;">-</span>
                    </div>
                </div>
            </div>
            
            <div class="modal-grid" id="clinicalFields">
                <div class="field-group">
                    <label>Standar Klinis (WHO)</label>
                    <div class="field-val" id="modalStandart">-</div>
                </div>
                <div class="field-group">
                    <label>Hasil ARV Terakhir</label>
                    <div class="field-val" id="modalArv">-</div>
                </div>
                <div class="field-group">
                    <label>Jumlah CD4</label>
                    <div class="field-val" id="modalCd4">-</div>
                </div>
                <div class="field-group">
                    <label>Berat Badan (kg)</label>
                    <div class="field-val" id="modalBb">-</div>
                </div>
                <div class="field-group">
                    <label>Status Viral Load</label>
                    <div class="field-val" id="modalClinicalVlStatus">-</div>
                </div>
                <div class="field-group">
                    <label>Status Fungsional (K.Amb.B)</label>
                    <div class="field-val" id="modalStatus">-</div>
                </div>
            </div>

            <div class="modal-grid" id="vlFields" style="display: none;">
                <div class="field-group">
                    <label>Nilai Viral Load (copies/mL)</label>
                    <div class="field-val" id="modalVlNilai" style="font-weight: 800; color: #ef4444;">-</div>
                </div>
                <div class="field-group">
                    <label>Status Viral Load</label>
                    <div class="field-val" id="modalVlStatus" style="font-weight: 800;">-</div>
                </div>
            </div>

            <div class="field-group" style="margin-top: 25px;">
                <label>Catatan Klinis / Keterangan</label>
                <div class="field-val" id="modalCatatan" style="min-height: 100px;">-</div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('evaluasiModal');
            const closeBtn = document.getElementById('closeModal');
            const detailBtns = document.querySelectorAll('.btn-detail');

            detailBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const formatDate = (dateStr) => {
                        if(!dateStr) return '-';
                        const date = new Date(dateStr);
                        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                    };

                    const type = this.dataset.type;
                    const clinicalFields = document.getElementById('clinicalFields');
                    const vlFields = document.getElementById('vlFields');
                    const modalTitle = document.getElementById('modalTitle');

                    document.getElementById('modalKunjungan').textContent = this.dataset.kunjungan;
                    document.getElementById('modalTanggal').textContent = formatDate(this.dataset.tanggal);
                    document.getElementById('modalCatatan').textContent = this.dataset.catatan || '-';

                    if (type === 'clinical') {
                        clinicalFields.style.display = 'grid';
                        vlFields.style.display = 'none';
                        modalTitle.textContent = 'Rincian Evaluasi Klinis';
                        
                        document.getElementById('modalStandart').textContent = this.dataset.standart || '-';
                        
                        const statusMap = {
                            'K': 'K (Kerja/Working)',
                            'Amb': 'Amb (Ambulatory)',
                            'B': 'B (Bedridden/Tidur)'
                        };
                        document.getElementById('modalStatus').textContent = statusMap[this.dataset.status] || this.dataset.status || '-';
                        
                        document.getElementById('modalArv').textContent = this.dataset.arv || '-';
                        document.getElementById('modalCd4').textContent = this.dataset.cd4 || '-';
                        document.getElementById('modalBb').textContent = (this.dataset.bb || '-') + ' kg';
                        document.getElementById('modalClinicalVlStatus').textContent = this.dataset.vlStatus || '-';
                    } else {
                        clinicalFields.style.display = 'none';
                        vlFields.style.display = 'grid';
                        modalTitle.textContent = 'Hasil Pemeriksaan Viral Load';
                        
                        document.getElementById('modalVlNilai').textContent = this.dataset.vlNilai + ' copies/mL';
                        document.getElementById('modalVlStatus').textContent = this.dataset.vlStatus || '-';
                        
                        const vlStatusVal = document.getElementById('modalVlStatus');
                        if (this.dataset.vlStatus.includes('TND') || this.dataset.vlStatus.includes('Rendah')) {
                            vlStatusVal.style.color = '#10b981';
                        } else {
                            vlStatusVal.style.color = '#ef4444';
                        }
                    }
                    
                    modal.classList.add('show');
                });
            });

            closeBtn.addEventListener('click', () => modal.classList.remove('show'));
            modal.addEventListener('click', (e) => { if(e.target === modal) modal.classList.remove('show'); });
        });
    </script>
    @endpush
@endsection