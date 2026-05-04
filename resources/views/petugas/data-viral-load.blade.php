@extends('layouts.app')

@section('title', 'Data Viral Load Pasien')

@section('content')
    <h1 class="page-title">Data Viral Load Pasien</h1>

    <section class="table-card">
        <div class="table-top">
            <span class="table-label">Data Pasien</span>

            <div class="search-box">
                <i class="fa-solid fa-magnifying-glass"></i>
                <input type="text" placeholder="Search">
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>No RM</th>
                        <th>No Regis Nasional</th>
                        <th>No Handphone</th>
                        <th>Jenis Kelamin</th>
                        <th>Notifikasi</th>
                        <th>Status ViralLoad</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ([
                        ['Jane Cooper', 'Perempuan'],
                        ['Floyd Miles', 'Perempuan'],
                        ['Ronald Richards', 'Perempuan'],
                        ['Marvin McKinney', 'Laki - Laki'],
                        ['Jerome Bell', 'Laki - Laki'],
                        ['Kathryn Murphy', 'Laki - Laki'],
                        ['Jacob Jones', 'Laki - Laki'],
                        ['Kristin Watson', 'Perempuan']
                    ] as $pasien)
                        <tr>
                            <td>{{ $pasien[0] }}</td>
                            <td>234323420004</td>
                            <td>(225) 555-0118</td>
                            <td>086786987664</td>
                            <td>{{ $pasien[1] }}</td>
                            <td><i class="fa-regular fa-bell notif-icon"></i></td>
                            <td><span class="badge-viral">Viralload</span></td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection