@extends('layouts.pasien')

@section('title', 'Kartu Kendali Pasien')
@section('page-title', 'Data Kartu Kendali Pasien')

@section('content')
    <style>
        .kartu-container {
            max-width: 1080px;
            animation: fadeIn 0.5s ease;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .kartu-card {
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

    <div class="kartu-container">
        <section class="kartu-card">
            <div class="section-header">
                <h2>Kartu Kendali & Riwayat</h2>
            </div>

            <div style="overflow-x: auto;">
                <table class="custom-table">
                    <thead>
                        <tr>
                            <th>Tanggal Kunjungan</th>
                            <th>Jadwal Berikutnya</th>
                            <th>Catatan</th>
                            <th>Status</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($records as $record)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($record->tanggal_kunjungan)->format('d M Y') }}</td>
                                <td data-label="Rencana Kontrol">
                                    <span style="color: #3b82f6; font-weight: 600;">
                                        {{ $record->rencana_tanggal_kunjungan_selanjutnya ? \Carbon\Carbon::parse($record->rencana_tanggal_kunjungan_selanjutnya)->format('d M Y') : '-' }}
                                    </span>
                                </td>
                                <td data-label="Catatan">{{ Str::limit($record->catatan, 30) }}</td>
                                <td data-label="Status">
                                    <span style="padding: 4px 10px; background: #f1f5f9; border-radius: 6px; font-size: 12px; font-weight: 700; color: #475569;">
                                        Tercatat
                                    </span>
                                </td>
                                <td style="text-align: right;">
                                    <button 
                                        type="button" 
                                        class="btn-detail"
                                         data-tgl="{{ $record->tanggal_kunjungan }}"
                                         data-rencana="{{ $record->rencana_tanggal_kunjungan_selanjutnya }}"
                                         data-obat-diberikan="{{ json_encode($record->obat_yang_diberikan) }}"
                                         data-inh="{{ $record->jumlah_inh_yang_tersisa }}"
                                         data-inh-next="{{ $record->jumlah_inh_yang_diberikan_untuk_bulan_berikutnya }}"
                                         data-efek="{{ $record->efek_samping_dan_lab_profilaksis }}"
                                         data-catatan="{{ $record->catatan }}"
                                    >
                                        <i class="fa-solid fa-eye"></i> Detail
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" style="text-align: center; padding: 60px; background: #ffffff; color: #9ca3af;">
                                    Belum ada data kunjungan yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>
    </div>

    {{-- MODAL DETAIL --}}
    <div class="modal-overlay" id="kartuModal">
        <div class="modal-box">
            <button type="button" class="modal-close" id="closeModal"><i class="fa-solid fa-xmark"></i></button>
            
            <div class="modal-header">
                <h2>Rincian Kartu Kendali</h2>
            </div>
            
            <div class="modal-grid">
                <div class="field-group">
                    <label>Tanggal Kunjungan</label>
                    <div class="field-val" id="modalTgl">-</div>
                </div>
                <div class="field-group">
                    <label>Jadwal Kontrol Berikutnya</label>
                    <div class="field-val" id="modalRencana" style="color: #3b82f6; font-weight: 700;">-</div>
                </div>
                <div class="field-group grid-span-2">
                    <label>Rejiman dan Jumlah Obat ARV yang tersisa</label>
                    <div class="field-val" id="modalObat" style="color: #10b981; font-weight: 700; min-height: 80px;">-</div>
                </div>
                <div class="field-group">
                    <label>Jumlah INH Tersisa</label>
                    <div class="field-val" id="modalInh">-</div>
                </div>
                <div class="field-group">
                    <label>INH Untuk Bulan Depan</label>
                    <div class="field-val" id="modalInhNext">-</div>
                </div>
                <div class="field-group">
                    <label>Efek Samping / Lab</label>
                    <div class="field-val" id="modalEfek">-</div>
                </div>
                <div class="field-group grid-span-2">
                    <label>Catatan Tambahan</label>
                    <div class="field-val" id="modalCatatan" style="min-height: 100px;">-</div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const modal = document.getElementById('kartuModal');
            const closeBtn = document.getElementById('closeModal');
            const detailBtns = document.querySelectorAll('.btn-detail');

            detailBtns.forEach(btn => {
                btn.addEventListener('click', function() {
                    const formatDate = (dateStr) => {
                        if(!dateStr) return '-';
                        const date = new Date(dateStr);
                        return date.toLocaleDateString('id-ID', { day: 'numeric', month: 'long', year: 'numeric' });
                    };

                    document.getElementById('modalTgl').textContent = formatDate(this.dataset.tgl);
                    document.getElementById('modalRencana').textContent = formatDate(this.dataset.rencana);
                    
                    // Handle Medication List
                    const obatData = JSON.parse(this.dataset.obatDiberikan || '[]');
                    const modalObat = document.getElementById('modalObat');
                    
                    if (obatData.length > 0) {
                        modalObat.innerHTML = obatData.map(o => {
                            if (typeof o === 'string') return `<div style="margin-bottom: 5px;">• ${o}</div>`;
                            return `<div style="margin-bottom: 8px; display: flex; flex-direction: column; border-bottom: 1px dashed #e2e8f0; padding-bottom: 6px;">
                                        <span style="font-weight: 700; color: #0f766e;">• ${o.nama}</span>
                                        <span style="color: #475569; font-size: 13px; padding-left: 12px; margin-top: 4px;">Sisa: <strong style="color: #0d9488;">${o.jumlah || 0}</strong></span>
                                    </div>`;
                        }).join('');
                    } else {
                        modalObat.textContent = '-';
                    }

                    document.getElementById('modalInh').textContent = this.dataset.inh || '0';
                    document.getElementById('modalInhNext').textContent = this.dataset.inhNext || '0';
                    document.getElementById('modalEfek').textContent = this.dataset.efek || '-';
                    document.getElementById('modalCatatan').textContent = this.dataset.catatan || '-';
                    
                    modal.classList.add('show');
                });
            });

            closeBtn.addEventListener('click', () => modal.classList.remove('show'));
            modal.addEventListener('click', (e) => { if(e.target === modal) modal.classList.remove('show'); });
        });
    </script>
    @endpush
@endsection