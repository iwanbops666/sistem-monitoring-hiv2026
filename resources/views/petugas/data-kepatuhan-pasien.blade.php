@extends('layouts.app')

@section('title', 'Kepatuhan Pengobatan')

@section('content')
    <style>
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.05); opacity: 0.8; }
            100% { transform: scale(1); opacity: 1; }
        }
    </style>

    <section class="table-card">
        <div class="table-top" style="display: block; position: relative;">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 25px;">
                <h2 style="font-size: 20px; font-weight: 900; color: #1e293b;">Status Kepatuhan Kunjungan</h2>
                
                <button type="button" class="btn-bulk-notif" style="height: 42px; padding: 0 25px; border-radius: 12px; background: linear-gradient(135deg, #065f46 0%, #059669 100%); color: #ffffff; border: none; font-weight: 800; font-size: 13px; display: flex; align-items: center; gap: 8px; cursor: pointer; transition: all 0.3s; box-shadow: 0 8px 20px rgba(6, 95, 70, 0.25);">
                    <i class="fa-solid fa-tower-broadcast" style="font-size: 14px;"></i>
                    Broadcast Pengingat
                </button>
            </div>

            <form action="{{ route('petugas.data-kepatuhan-pasien') }}" method="GET" class="table-actions" style="margin: 0; display: flex; gap: 12px; justify-content: flex-start;">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass" style="color: #94a3b8;"></i>
                    <input type="text" name="search" placeholder="Cari Pasien..." value="{{ request('search') }}">
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
                        <th style="text-align: center; width: 160px;">Jadwal Berikutnya</th>
                        <th style="text-align: center; width: 220px;">Status Kunjungan</th>
                        <th style="text-align: center; width: 100px;">Notifikasi</th>
                        <th style="text-align: center; width: 140px;">Status Klinis</th>
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
                            <td style="text-align: center;">
                                @php
                                    $nextVisit = $pasien->rencana_kunjungan_berikutnya;
                                    $isMissed = $nextVisit && \Carbon\Carbon::parse($nextVisit)->isPast();
                                @endphp
                                @if($nextVisit)
                                    <div style="display: inline-flex; align-items: center; gap: 6px; background: {{ $isMissed ? '#fef2f2' : '#eff6ff' }}; padding: 5px 10px; border-radius: 8px; border: 1px solid {{ $isMissed ? '#fee2e2' : '#dbeafe' }}; white-space: nowrap;">
                                        <i class="fa-solid {{ $isMissed ? 'fa-calendar-times' : 'fa-calendar-check' }}" style="color: {{ $isMissed ? '#ef4444' : '#3b82f6' }}; font-size: 11px;"></i>
                                        <span style="color: {{ $isMissed ? '#991b1b' : '#1e40af' }}; font-size: 12px; font-weight: 800;">
                                            {{ \Carbon\Carbon::parse($nextVisit)->translatedFormat('d M Y') }}
                                        </span>
                                    </div>
                                @else
                                    <span style="color: #e2e8f0;">-</span>
                                @endif
                            </td>
                            <td style="text-align: center;">
                                @php
                                    $kunjunganStatus = $pasien->kunjungan_status;
                                    $statusKlinis = $pasien->display_status;
                                @endphp

                                @if($kunjunganStatus === 'LTFU')
                                    <span style="background: #fee2e2; color: #ef4444; padding: 6px 12px; border-radius: 8px; font-size: 10px; font-weight: 900; text-transform: uppercase; border: 1px solid #fecaca; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;">
                                        <i class="fa-solid fa-triangle-exclamation" style="font-size: 11px;"></i> Belum Kontrol (>2 Bln)
                                    </span>
                                @elseif($kunjunganStatus === 'Late')
                                    <span style="background: #fff7ed; color: #f97316; padding: 6px 12px; border-radius: 8px; font-size: 10px; font-weight: 900; text-transform: uppercase; border: 1px solid #ffedd5; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;">
                                        <i class="fa-solid fa-clock" style="font-size: 11px;"></i> 
                                        {{ $statusKlinis === 'Active' ? 'Belum Kontrol (>7 Hari)' : 'Belum Kontrol (<2 Bln)' }}
                                    </span>
                                @else
                                    <span style="background: #f0fdf4; color: #10b981; padding: 6px 12px; border-radius: 8px; font-size: 10px; font-weight: 900; text-transform: uppercase; border: 1px solid #dcfce7; display: inline-flex; align-items: center; gap: 6px; white-space: nowrap;">
                                        <i class="fa-solid fa-circle-check" style="font-size: 11px;"></i> Sudah Kontrol
                                    </span>
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
                                    $status = $pasien->display_status;
                                    $color = '#10b981';
                                    $bg = '#f0fdf4';
                                    $border = '#dcfce7';
                                    if ($status == 'Inactive') { $color = '#f97316'; $bg = '#fff7ed'; $border = '#ffedd5'; }
                                    if ($status == 'LTFU') { $color = '#ef4444'; $bg = '#fef2f2'; $border = '#fee2e2'; }
                                @endphp
                                <span style="background: {{ $bg }}; color: {{ $color }}; padding: 5px 12px; border-radius: 8px; font-size: 11px; font-weight: 800; border: 1px solid {{ $border }}; text-transform: uppercase;">
                                    {{ $status }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align:center; padding: 50px; color: #94a3b8;">
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

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Individual Notification
        document.querySelectorAll('.btn-send-notif').forEach(btn => {
            btn.addEventListener('click', function() {
                const userId = this.getAttribute('data-user-id');
                const nama = this.getAttribute('data-nama');

                Swal.fire({
                    title: 'Kirim Pengingat?',
                    text: `Kirim notifikasi kepatuhan ke ${nama}?`,
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
                                title: 'Pengingat Kepatuhan',
                                message: 'Halo, jangan lupa minum obat dan kontrol rutin ya.'
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

        // Bulk Notification
        document.querySelector('.btn-bulk-notif').addEventListener('click', function() {
            Swal.fire({
                title: 'Broadcast ke Semua?',
                text: "Kirim notifikasi pengingat ke SELURUH pasien terdaftar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#4f46e5',
                confirmButtonText: 'Ya, Kirim Semua',
                cancelButtonText: 'Batal',
                borderRadius: '20px'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire({
                        title: 'Sedang Mengirim...',
                        allowOutsideClick: false,
                        didOpen: () => { Swal.showLoading(); }
                    });

                    fetch('{{ route("notif.send-bulk") }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify({
                            title: 'Pengingat Rutin Puskesmas',
                            message: 'Harap tetap rutin melakukan kontrol dan minum obat tepat waktu demi kesehatan Anda.'
                        })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if(data.success) {
                            Swal.fire({
                                title: 'Berhasil!',
                                text: 'Notifikasi telah dikirim ke semua pasien.',
                                icon: 'success',
                                confirmButtonColor: '#10b981'
                            });
                        }
                    });
                }
            });
        });
    </script>
    @endpush
@endsection