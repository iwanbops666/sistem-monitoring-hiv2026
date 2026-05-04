@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <style>
        .dashboard-topbar {
            max-width: 1120px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 35px;
        }

        .dashboard-topbar .page-title {
            margin-bottom: 0;
        }

        .dashboard-user-area {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .notification-bell-btn {
            position: relative;
            border: none;
            background: transparent;
            font-size: 28px;
            color: #000000;
            cursor: pointer;
        }

        .notification-bell-btn::after {
            content: "";
            position: absolute;
            right: 1px;
            top: 2px;
            width: 9px;
            height: 9px;
            background: #22c55e;
            border-radius: 50%;
            border: 2px solid #ffffff;
        }

        .dashboard-profile {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .dashboard-profile img {
            width: 68px;
            height: 68px;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 8px 18px rgba(0,0,0,0.18);
        }

        .dashboard-profile h4 {
            font-size: 17px;
            font-weight: 800;
            color: #1f2937;
            margin-bottom: 4px;
        }

        .dashboard-profile span {
            font-size: 14px;
            color: #777;
        }

        .dashboard-stats {
            background: #ffffff;
            border-radius: 24px;
            padding: 34px 46px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            max-width: 1040px;
            box-shadow: 0 18px 35px rgba(213, 224, 235, 0.58);
            margin-bottom: 42px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 24px;
            padding: 0 34px;
            border-right: 1px solid #edf0f3;
        }

        .stat-item:first-child {
            padding-left: 0;
        }

        .stat-item:last-child {
            border-right: none;
        }

        .stat-icon {
            width: 82px;
            height: 82px;
            min-width: 82px;
            border-radius: 50%;
            background: #dffdec;
            color: #08ad59;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 34px;
        }

        .stat-text small {
            display: block;
            color: #a7a9b0;
            font-size: 15px;
            margin-bottom: 5px;
        }

        .stat-text h2 {
            font-size: 32px;
            font-weight: 900;
            color: #222;
            line-height: 1;
            margin-bottom: 7px;
        }

        .stat-change {
            font-size: 14px;
            font-weight: 800;
        }

        .up {
            color: #00a95a;
        }

        .down {
            color: #ff3b67;
        }

        @media (max-width: 1000px) {
            .dashboard-topbar {
                flex-direction: column;
                align-items: flex-start;
                gap: 20px;
            }

            .dashboard-stats {
                grid-template-columns: 1fr;
                gap: 24px;
            }

            .stat-item {
                border-right: none;
                border-bottom: 1px solid #edf0f3;
                padding: 0 0 22px;
            }

            .stat-item:last-child {
                border-bottom: none;
                padding-bottom: 0;
            }
        }
    </style>

    <div class="dashboard-topbar">
        <h1 class="page-title">Dashboard</h1>

        <div class="dashboard-user-area">
            <button type="button" class="notification-bell-btn">
                <i class="fa-regular fa-bell"></i>
            </button>

            <div class="dashboard-profile">
                <img src="https://i.pravatar.cc/150?img=12" alt="Profile Admin">
                <div>
                    <h4>Andri</h4>
                    <span>Admin</span>
                </div>
            </div>
        </div>
    </div>

    <section class="dashboard-stats">
        <div class="stat-item">
            <div class="stat-icon">
                <i class="fa-solid fa-users"></i>
            </div>

            <div class="stat-text">
                <small>Total Pasien</small>
                <h2>5,423</h2>
                <div class="stat-change up">
                    <i class="fa-solid fa-arrow-up"></i>
                    16% this month
                </div>
            </div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <i class="fa-solid fa-user-clock"></i>
            </div>

            <div class="stat-text">
                <small>Pasien Belum Kontrol</small>
                <h2>1,893</h2>
                <div class="stat-change down">
                    <i class="fa-solid fa-arrow-down"></i>
                    1% this month
                </div>
            </div>
        </div>

        <div class="stat-item">
            <div class="stat-icon">
                <i class="fa-solid fa-desktop"></i>
            </div>

            <div class="stat-text">
                <small>Pasien Baru</small>
                <h2>189</h2>
            </div>
        </div>
    </section>

    <section class="table-card">
        <div class="table-header">
            <div class="table-title">
                <h3>Pasien Belum Kontrol</h3>
                <span>Data Pasien</span>
            </div>

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
                        <th>Status</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach ([
                        ['Jane Cooper', '1234567', '(225) 555-0118', '085xxxxxxxxx', 'Laki-laki', 'LTFU', 'danger'],
                        ['Floyd Miles', '1234', '(205) 555-0100', '085xxxxxxxxx', 'Laki-laki', 'Inactive', 'warning'],
                        ['Ronald Richards', '1234', '(302) 555-0107', '085xxxxxxxxx', 'Laki-laki', 'Inactive', 'warning'],
                        ['Marvin McKinney', '1234', '(252) 555-0126', '085xxxxxxxxx', 'Laki-laki', 'Active', 'success'],
                        ['Jerome Bell', '1234', '(629) 555-0129', '085xxxxxxxxx', 'Laki-laki', 'Active', 'success'],
                    ] as $pasien)
                        <tr>
                            <td>{{ $pasien[0] }}</td>
                            <td>{{ $pasien[1] }}</td>
                            <td>{{ $pasien[2] }}</td>
                            <td>{{ $pasien[3] }}</td>
                            <td>{{ $pasien[4] }}</td>
                            <td>
                                <span class="badge badge-{{ $pasien[6] }}">
                                    {{ $pasien[5] }}
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