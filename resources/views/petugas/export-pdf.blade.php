<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $jenis ?? 'Laporan Data Pasien' }} - Puskesmas Benculuk</title>
    <style>
        @page { 
            size: A4; 
            margin: 1.5cm; 
        }
        
        body { 
            font-family: 'Helvetica', 'Arial', sans-serif; 
            color: #1e293b; 
            line-height: 1.4; 
            margin: 0; 
            padding: 0; 
            background: #ffffff;
        }

        /* HEADER / KOP SURAT */
        .header { 
            border-bottom: 3px double #065f46; 
            padding-bottom: 15px; 
            margin-bottom: 25px; 
            display: table; 
            width: 100%; 
        }
        
        .logo-container { 
            display: table-cell; 
            vertical-align: middle; 
            width: 80px; 
        }
        
        .logo { 
            width: 75px; 
            height: auto; 
        }
        
        .header-text { 
            display: table-cell; 
            vertical-align: middle; 
            text-align: center; 
        }
        
        .header-text h1 { 
            margin: 0; 
            font-size: 19px; 
            text-transform: uppercase; 
            color: #0f172a; 
            font-weight: 900; 
            letter-spacing: 1px;
        }
        
        .header-text h2 { 
            margin: 4px 0 0; 
            font-size: 16px; 
            text-transform: uppercase; 
            color: #065f46; 
            font-weight: 800; 
        }
        
        .header-text p { 
            margin: 5px 0 0; 
            font-size: 10.5px; 
            color: #475569; 
            font-weight: 500; 
        }

        /* CONTENT */
        .report-title { 
            text-align: center; 
            margin-bottom: 25px; 
        }
        
        .report-title h3 { 
            margin: 0; 
            font-size: 16px; 
            font-weight: 900; 
            text-decoration: none;
            color: #1e293b;
            text-transform: uppercase;
        }
        
        .report-title .line {
            width: 100px;
            height: 2px;
            background: #065f46;
            margin: 8px auto 0;
        }

        .report-meta { 
            font-size: 10px; 
            color: #1e293b; 
            margin-bottom: 20px; 
            display: block;
        }

        /* TABLE */
        table { 
            width: 100%; 
            border-collapse: collapse; 
            font-size: 10px; 
            margin-top: 10px;
        }
        
        th { 
            background-color: #f1f5f9; 
            color: #0f172a; 
            padding: 10px 8px; 
            text-align: center; 
            text-transform: uppercase; 
            font-weight: 800; 
            border: 1px solid #cbd5e1; 
        }
        
        td { 
            padding: 8px; 
            border: 1px solid #cbd5e1; 
            color: #334155; 
            vertical-align: middle;
        }
        
        tr:nth-child(even) { 
            background-color: #f8fafc; 
        }

        .status-badge {
            font-weight: 900;
            text-transform: uppercase;
            font-size: 8.5px;
        }

        /* FOOTER SIGNATURE */
        .footer-sig { 
            margin-top: 40px; 
            display: table; 
            width: 100%; 
            font-size: 12px; 
        }
        
        .sig-left { 
            display: table-cell; 
            width: 50%; 
        }
        
        .sig-right { 
            display: table-cell; 
            width: 50%; 
            text-align: center; 
        }
        
        .signature-space { 
            height: 70px; 
        }

        /* PRINT UI */
        .no-print { 
            position: fixed; 
            top: 20px; 
            right: 20px; 
            z-index: 1000; 
            display: flex;
            gap: 10px;
        }
        
        .btn-ui { 
            background: #0f172a; 
            color: white; 
            border: none; 
            padding: 10px 18px; 
            border-radius: 10px; 
            cursor: pointer; 
            font-weight: 700; 
            font-size: 13px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.2);
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .btn-ui:hover {
            background: #1e293b;
            transform: translateY(-1px);
        }

        .btn-back {
            background: #64748b;
        }
        
        @media print {
            .no-print { display: none !important; }
            body { padding: 0; }
            @page { margin: 1cm; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="no-print">
        <button onclick="window.history.back()" class="btn-ui btn-back">
            Kembali
        </button>
        <button onclick="window.print()" class="btn-ui">
            Cetak Ulang
        </button>
    </div>

    <div class="header">
        <div class="logo-container">
            <img src="{{ asset('assets/logo-banyuwangi.png') }}" class="logo">
        </div>
        <div class="header-text">
            <h1>PEMERINTAH KABUPATEN BANYUWANGI</h1>
            <h2>DINAS KESEHATAN PUSKESMAS BENCULUK</h2>
            <p>Jl. Raya Benculuk No.1, Benculuk, Cluring, Kabupaten Banyuwangi, Jawa Timur</p>
            <p>Email: puskesmas.benculuk@banyuwangikab.go.id | Telp: (0333) 123456</p>
        </div>
        <div class="logo-container" style="text-align: right;">
            <img src="{{ asset('assets/logo-puskesmas.png') }}" class="logo">
        </div>
    </div>

    <div class="report-title">
        <h3>{{ $jenis ? strtoupper($jenis) : 'LAPORAN REKAPITULASI DATA PASIEN HIV' }}</h3>
        <div class="line"></div>
    </div>

    <div class="report-meta">
        <table style="width: auto; border: none; box-shadow: none; margin-bottom: 20px; font-size: 11px;">
            <tr>
                <td style="border: none; padding: 2px 0; width: 100px;">Unit</td>
                <td style="border: none; padding: 2px 5px;">: PUSKESMAS</td>
            </tr>
            <tr>
                <td style="border: none; padding: 2px 0;">Nama Unit</td>
                <td style="border: none; padding: 2px 5px;">: PUSKESMAS BENCULUK</td>
            </tr>
            <tr>
                <td style="border: none; padding: 2px 0;">Tanggal</td>
                <td style="border: none; padding: 2px 5px;">: 
                    @if($dari && $sampai)
                        {{ \Carbon\Carbon::parse($dari)->format('d-m-Y') }} - {{ \Carbon\Carbon::parse($sampai)->format('d-m-Y') }}
                    @else
                        Hingga {{ date('d-m-Y') }}
                    @endif
                </td>
            </tr>
            <tr>
                <td style="border: none; padding: 2px 0;">Nama Poli</td>
                <td style="border: none; padding: 2px 5px;">: Layanan HIV</td>
            </tr>
        </table>
        
        <div style="font-size: 10px; color: #64748b; text-align: right; align-self: flex-end; margin-bottom: 5px;">
            Dicetak oleh: <strong>{{ Auth::user()->name }}</strong> | {{ date('d F Y, H:i') }}
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 20px; text-align: center;">No</th>
                <th>Nama Pasien</th>
                <th style="width: 80px; text-align: center;">No. RM</th>
                <th style="width: 90px; text-align: center;">NIK</th>
                <th style="width: 70px; text-align: center;">Jenis Kelamin</th>
                <th style="width: 60px; text-align: center;">Status</th>
                <th style="width: 100px; text-align: center;">Awal Obat</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pasiens as $index => $p)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td style="font-weight: 700; color: #0f172a; text-transform: uppercase;">{{ $p->nama }}</td>
                <td style="text-align: center; font-family: monospace; font-weight: 700;">{{ $p->nomor_rm }}</td>
                <td style="text-align: center;">{{ $p->nik ?? '-' }}</td>
                <td style="text-align: center;">{{ $p->jenis_kelamin }}</td>
                <td style="text-align: center;">
                    <span class="status-badge" style="color: {{ $p->display_status == 'Active' ? '#059669' : ($p->display_status == 'LTFU' ? '#dc2626' : '#d97706') }};">
                        {{ $p->display_status }}
                    </span>
                </td>
                <td style="text-align: center;">{{ $p->tanggal_awal_pengobatan ? \Carbon\Carbon::parse($p->tanggal_awal_pengobatan)->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer-sig">
        <table style="width: 100%; border: none;">
            <tr>
                <td style="border: none; width: 40%;"></td>
                <td style="border: none; width: 60%; text-align: center;">
                    <p>Benculuk, {{ date('d F Y') }}</p>
                    <p style="margin-top: 15px; font-weight: bold;">Mengetahui,</p>
                    <p style="margin-top: 5px; font-weight: bold;">Kepala PUSKESMAS BENCULUK</p>
                    <div class="signature-space" style="height: 80px;"></div>
                    <p style="font-weight: 900; text-decoration: underline; text-transform: uppercase; font-size: 13px; white-space: nowrap;">HJ. TATIEK SETYANINGSIH, S.ST.MM.Kes</p>
                    <p style="font-size: 11px; margin-top: 5px;">NIP. 196906151991032014</p>
                </td>
            </tr>
        </table>
    </div>
</body>
</html>
