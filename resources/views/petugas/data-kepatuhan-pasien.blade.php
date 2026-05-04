@extends('layouts.app')

@section('title', 'Data Kepatuhan Pengobatan Pasien')

@section('content')
    <h1 class="page-title">
        Data Kepatuhan<br>
        Pengobatan Pasien
    </h1>

    <section class="table-card">
        <div class="table-top">
            <span class="table-label">Status Kunjungan Pasien</span>

            <div class="table-actions">
                <div class="search-box">
                    <i class="fa-solid fa-magnifying-glass"></i>
                    <input type="text" placeholder="Search">
                </div>

                <select class="sort-box">
                    <option>Short by : Newest</option>
                    <option>Oldest</option>
                </select>
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
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ([
                        ['Jane Cooper', 'Perempuan', 'LTFU', 'danger'],
                        ['Floyd Miles', 'Perempuan', 'LTFU', 'danger'],
                        ['Ronald Richards', 'Perempuan', 'Inactive', 'warning'],
                        ['Marvin McKinney', 'Laki - Laki', 'Inactive', 'warning'],
                        ['Jerome Bell', 'Laki - Laki', 'Inactive', 'warning'],
                        ['Kathryn Murphy', 'Laki - Laki', 'Active', 'success'],
                        ['Jacob Jones', 'Laki - Laki', 'Active', 'success'],
                        ['Kristin Watson', 'Perempuan', 'Active', 'success']
                    ] as $pasien)
                        <tr>
                            <td>{{ $pasien[0] }}</td>
                            <td>2343</td>
                            <td>(225) 555-0118</td>
                            <td>086786987664</td>
                            <td>{{ $pasien[1] }}</td>
                            <td><i class="fa-regular fa-bell notif-icon"></i></td>
                            <td>
                                <span class="badge badge-{{ $pasien[3] }}">
                                    {{ $pasien[2] }}
                                </span>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="table-footer">
            <span>Showing data 1 to 8 of 256K entries</span>

            <div class="pagination">
                <button class="page-btn">&lt;</button>
                <button class="page-btn active">1</button>
                <button class="page-btn">2</button>
                <button class="page-btn">3</button>
                <button class="page-btn">4</button>
                <span>...</span>
                <button class="page-btn">40</button>
                <button class="page-btn">&gt;</button>
            </div>
        </div>
    </section>
@endsection