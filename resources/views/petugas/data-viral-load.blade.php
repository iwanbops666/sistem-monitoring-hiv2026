@extends('layouts.app')

@section('title', 'Data Viral Load')

@section('content')
    <section class="table-card">
        <div class="table-top" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
            <h2 style="font-size: 20px; font-weight: 900; color: #1e293b; margin: 0;">Monitoring Viral Load Pasien</h2>

            <form action="{{ route('petugas.data-viral-load') }}" method="GET" class="table-actions" style="margin: 0;">
                <div class="search-box" style="width: 300px;">
                    <i class="fa-solid fa-magnifying-glass" style="color: #94a3b8;"></i>
                    <input type="text" name="search" placeholder="Cari Pasien..." value="{{ request('search') }}" style="border: none; background: transparent; outline: none; width: 100%; padding: 8px 0;">
                </div>
            </form>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th style="padding-left: 20px; width: 25%;">Nama Pasien</th>
                        <th style="text-align: center; width: 12%;">No RM</th>
                        <th style="text-align: center; width: 15%;">Regis Nasional</th>
                        <th style="text-align: center; width: 160px;">Jadwal VL</th>
                        <th style="text-align: center; width: 100px;">Notif</th>
                        <th style="text-align: center;">Status & Riwayat</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($pasiens as $pasien)
                        <tr>
                            <td style="white-space: nowrap;">
                                <div style="display: flex; align-items: center; gap: 12px;">
                                    <div style="width: 32px; height: 32px; background: #f0fdf4; color: #10b981; border-radius: 8px; display: flex; align-items: center; justify-content: center; font-weight: 800; font-size: 13px; border: 1px solid #dcfce7;">
                                        {{ substr($pasien->nama, 0, 1) }}
                                    </div>
                                    <span style="font-weight: 700; color: #1e293b;">{{ $pasien->nama }}</span>
                                </div>
                            </td>
                            <td style="text-align: center;"><code style="background: #f8fafc; padding: 4px 8px; border-radius: 6px; font-weight: 700; color: #64748b; font-size: 12px; border: 1px solid #e2e8f0; white-space: nowrap;">{{ $pasien->nomor_rm }}</code></td>
                            <td style="text-align: center;"><span style="color: #94a3b8; font-weight: 600; font-size: 13px;">{{ $pasien->no_registrasi_nasional ?? '-' }}</span></td>
                            <td style="text-align: center;">
                                @if($pasien->next_viral_load_date)
                                    <div style="display: inline-flex; align-items: center; gap: 8px; background: #f0f7ff; padding: 6px 12px; border-radius: 10px; border: 1px solid #e0f2fe; white-space: nowrap;">
                                        <i class="fa-solid fa-calendar-check" style="color: #0ea5e9;"></i>
                                        <span style="color: #0369a1; font-weight: 700; font-size: 13px;">
                                            {{ \Carbon\Carbon::parse($pasien->next_viral_load_date)->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                @else
                                    <span style="color: #cbd5e1;">-</span>
                                @endif
                            </td>
                             <td style="text-align: center;">
                                <button type="button" class="btn-send-notif" 
                                        data-user-id="{{ $pasien->user_id }}" 
                                        data-nama="{{ $pasien->nama }}"
                                        title="Kirim Notifikasi"
                                        style="width: 32px; height: 32px; border-radius: 8px; border: none; background: #f0fdf4; color: #10b981; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center;">
                                    <i class="fa-solid fa-bell" style="font-size: 14px;"></i>
                                </button>
                            </td>
                             <td style="text-align: center;">
                                 @php
                                     $vlStatus = $pasien->viral_load_status;
                                 @endphp

                                 <div style="display: flex; align-items: center; justify-content: center; gap: 8px;">
                                     @if(strpos($vlStatus, 'Perlu Cek') !== false)
                                         <span style="background: #fee2e2; color: #ef4444; padding: 6px 12px; border-radius: 8px; font-size: 10px; font-weight: 900; text-transform: uppercase; border: 1px solid #fecaca; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;">
                                             <i class="fa-solid fa-triangle-exclamation" style="font-size: 11px;"></i> {{ $vlStatus }}
                                         </span>
                                     @elseif(strpos($vlStatus, 'Belum Waktunya') !== false || strpos($vlStatus, 'Kosong') !== false)
                                         <span style="background: #fff7ed; color: #f97316; padding: 6px 12px; border-radius: 8px; font-size: 10px; font-weight: 900; text-transform: uppercase; border: 1px solid #ffedd5; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;">
                                             <i class="fa-solid fa-clock" style="font-size: 11px;"></i> {{ $vlStatus }}
                                         </span>
                                     @else
                                         <span style="background: #f0fdf4; color: #10b981; padding: 6px 12px; border-radius: 8px; font-size: 10px; font-weight: 900; text-transform: uppercase; border: 1px solid #dcfce7; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;">
                                             <i class="fa-solid fa-circle-check" style="font-size: 11px;"></i> {{ $vlStatus }}
                                         </span>
                                     @endif

                                     <button type="button" class="btn-detail open-history-modal" 
                                             data-id="{{ $pasien->user_id }}" 
                                             data-nama="{{ $pasien->nama }}"
                                             title="Lihat Riwayat"
                                             style="width: 32px; height: 32px; border-radius: 8px; border: 1px solid #e2e8f0; background: #ffffff; color: #64748b; cursor: pointer; transition: all 0.2s; display: inline-flex; align-items: center; justify-content: center;">
                                         <i class="fa-solid fa-eye" style="font-size: 14px;"></i>
                                     </button>
                                 </div>
                             </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" style="text-align:center; padding: 50px; color: #94a3b8;">
                                <i class="fa-solid fa-user-slash" style="font-size: 30px; display: block; margin-bottom: 10px;"></i>
                                Data tidak ditemukan
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span style="font-weight: 600;">Menampilkan {{ $pasiens->firstItem() ?? 0 }} sampai {{ $pasiens->lastItem() ?? 0 }} dari {{ $pasiens->total() }} Entri</span>

            <div class="pagination">
                {{ $pasiens->appends(request()->query())->links('pagination::bootstrap-4') }}
            </div>
        </div>
    </section>

    {{-- MODAL RIWAYAT VIRAL LOAD --}}
    <div class="modal-overlay" id="historyModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.4); backdrop-filter: blur(8px); z-index: 1000; justify-content: center; align-items: center; padding: 20px;">
        <div style="background: white; width: 100%; max-width: 800px; border-radius: 24px; padding: 40px; position: relative; box-shadow: 0 25px 50px rgba(0,0,0,0.2); max-height: 90vh; overflow-y: auto;">
            <button id="closeHistoryModal" style="position: absolute; top: 25px; right: 25px; border: none; background: #f1f5f9; width: 35px; height: 35px; border-radius: 10px; cursor: pointer; color: #64748b;">&times;</button>
            
            <h2 style="font-size: 22px; font-weight: 900; color: #1e293b; margin-bottom: 10px; display: flex; align-items: center; gap: 12px;">
                <i class="fa-solid fa-history" style="color: #6366f1;"></i>
                Riwayat Pemeriksaan Viral Load
            </h2>
            <p style="color: #64748b; margin-bottom: 30px; font-weight: 500;">Pasien: <span id="history_patient_name" style="color: #1e293b; font-weight: 800;">-</span></p>

            <div class="table-responsive">
                <table style="width: 100%; border-collapse: separate; border-spacing: 0 10px;">
                    <thead>
                        <tr>
                            <th style="text-align: left; padding: 15px; color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Tanggal</th>
                            <th style="text-align: left; padding: 15px; color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Tahap Kunjungan</th>
                            <th style="text-align: left; padding: 15px; color: #64748b; font-size: 12px; text-transform: uppercase; letter-spacing: 1px;">Status Viral Load</th>
                        </tr>
                    </thead>
                    <tbody id="history_table_body">
                        {{-- Data loaded via AJAX --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const historyModal = document.getElementById('historyModal');
            const openHistoryBtns = document.querySelectorAll('.open-history-modal');
            const closeHistoryBtn = document.getElementById('closeHistoryModal');
            const historyTableBody = document.getElementById('history_table_body');
            const historyPatientName = document.getElementById('history_patient_name');

            openHistoryBtns.forEach(btn => {
                btn.addEventListener('click', async function() {
                    const id = this.getAttribute('data-id');
                    const nama = this.getAttribute('data-nama');
                    
                    historyPatientName.textContent = nama;
                    historyTableBody.innerHTML = '<tr><td colspan="3" style="text-align: center; padding: 40px;"><i class="fa-solid fa-spinner fa-spin" style="font-size: 24px; color: #6366f1;"></i></td></tr>';
                    historyModal.style.display = 'flex';

                    try {
                        const response = await fetch(`/laporan-evaluasi/riwayat-laporan-evaluasi/${id}`);
                        const data = await response.json();
                        
                        // Filter records that have viral load info
                        const vlHistory = data.riwayat.filter(item => item.status_viral_load);
                        
                        historyTableBody.innerHTML = '';
                        if (vlHistory.length === 0) {
                            historyTableBody.innerHTML = '<tr><td colspan="3" style="text-align: center; padding: 40px; color: #94a3b8;">Belum ada riwayat Viral Load tercatat di laporan evaluasi.</td></tr>';
                        } else {
                            vlHistory.forEach(item => {
                                const row = `
                                    <tr style="background: #f8fafc; border-radius: 12px;">
                                        <td style="padding: 15px; font-weight: 700; color: #1e293b;">${new Date(item.tanggal).toLocaleDateString('id-ID', {day: '2-digit', month: 'long', year: 'numeric'})}</td>
                                        <td style="padding: 15px; color: #64748b; font-weight: 600;">${item.kunjungan}</td>
                                        <td style="padding: 15px;">
                                            <span style="background: #eef2ff; color: #4f46e5; padding: 6px 12px; border-radius: 8px; font-size: 13px; font-weight: 700; border: 1px solid #e0e7ff;">
                                                ${item.status_viral_load}
                                            </span>
                                        </td>
                                    </tr>
                                `;
                                historyTableBody.insertAdjacentHTML('beforeend', row);
                            });
                        }
                    } catch (error) {
                        historyTableBody.innerHTML = '<tr><td colspan="3" style="text-align: center; padding: 40px; color: #ef4444;">Gagal memuat data.</td></tr>';
                    }
                });
            });

            if (closeHistoryBtn) {
                closeHistoryBtn.addEventListener('click', () => historyModal.style.display = 'none');
            }

            window.addEventListener('click', (e) => {
                if (e.target === historyModal) historyModal.style.display = 'none';
            });

            // Existing notification logic
            document.querySelectorAll('.btn-send-notif').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Kirim Notifikasi?',
                    text: `Kirim pengingat viral load ke ${nama}?`,
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Ya, Kirim',
                    cancelButtonText: 'Batal',
                    confirmButtonColor: '#10b981',
                    borderRadius: '20px'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('{{ route("notif.send") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: JSON.stringify({
                                user_id: userId,
                                title: 'Pengingat Viral Load',
                                message: 'Pasien Waktunya Melakukan Viraload'
                            })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if(data.success) {
                                Swal.fire({
                                    title: 'Terkirim!',
                                    text: 'Notifikasi berhasil dikirim.',
                                    icon: 'success',
                                    confirmButtonColor: '#10b981'
                                });
                            }
                        });
                    }
                });
            });
            });
        });
    </script>
    @endpush
@endsection