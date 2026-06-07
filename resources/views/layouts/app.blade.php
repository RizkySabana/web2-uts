<!doctype html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Perpustakaan Digital')</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <style>
        :root {
            --krem: #F5F0E8;
            --krem-dark: #EDE4D0;
            --krem-border: #D4C9B0;
            --safir: #1B6B5A;
            --safir-dark: #145247;
            --safir-light: #2A8C75;
            --safir-pale: #E8F5F2;
            --text-dark: #2D2D2D;
            --text-muted: #6B7280;
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--krem);
            font-family: 'Segoe UI', Arial, sans-serif;
            color: var(--text-dark);
            margin: 0;
        }

        /* NAVBAR */
        nav.main-nav {
            background: var(--safir);
            color: white;
            padding: 0 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            height: 60px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, .15);
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-brand {
            font-size: 18px;
            font-weight: 700;
            color: white;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .nav-links {
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .nav-links a {
            color: rgba(255, 255, 255, .85);
            text-decoration: none;
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            transition: background .2s;
        }

        .nav-links a:hover,
        .nav-links a.active {
            background: var(--safir-light);
            color: white;
        }

        .nav-user {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            color: rgba(255, 255, 255, .9);
        }

        /* CONTAINER */
        .main-container {
            max-width: 1200px;
            margin: 28px auto;
            padding: 0 20px;
        }

        /* CARD */
        .card-box {
            background: white;
            border-radius: 12px;
            padding: 28px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .06);
            border: 1px solid var(--krem-border);
            margin-bottom: 20px;
        }

        /* STAT CARDS */
        .stat-cards {
            display: grid;
            grid-template-columns: repeat(5, 1fr);
            gap: 14px;
            margin-bottom: 24px;
        }

        .stat-card {
            background: white;
            border-radius: 10px;
            padding: 18px;
            border: 1px solid var(--krem-border);
            text-align: center;
            box-shadow: 0 1px 6px rgba(0, 0, 0, .05);
        }

        .stat-card .stat-icon {
            font-size: 26px;
            margin-bottom: 8px;
        }

        .stat-card .stat-num {
            font-size: 30px;
            font-weight: 700;
            color: var(--safir);
        }

        .stat-card .stat-label {
            font-size: 12px;
            color: var(--text-muted);
            margin-top: 4px;
        }

        .stat-card.danger .stat-num {
            color: #dc2626;
        }

        /* BUTTONS */
        .btn {
            display: inline-block;
            padding: 8px 16px;
            border-radius: 7px;
            text-decoration: none;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 500;
            transition: all .2s;
        }

        .btn-safir {
            background: var(--safir);
            color: white;
        }

        .btn-safir:hover {
            background: var(--safir-dark);
            color: white;
        }

        .btn-outline-safir {
            background: transparent;
            color: var(--safir);
            border: 1.5px solid var(--safir);
        }

        .btn-outline-safir:hover {
            background: var(--safir);
            color: white;
        }

        .btn-warning-custom {
            background: #F59E0B;
            color: white;
        }

        .btn-warning-custom:hover {
            background: #D97706;
            color: white;
        }

        .btn-danger-custom {
            background: #EF4444;
            color: white;
        }

        .btn-danger-custom:hover {
            background: #DC2626;
            color: white;
        }

        .btn-success-custom {
            background: #10B981;
            color: white;
        }

        .btn-success-custom:hover {
            background: #059669;
            color: white;
        }

        .btn-sm {
            padding: 5px 10px;
            font-size: 13px;
        }

        /* ALERTS */
        .alert-success-box {
            background: #D1FAE5;
            color: #065F46;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            border: 1px solid #A7F3D0;
        }

        .alert-error-box {
            background: #FEE2E2;
            color: #991B1B;
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 16px;
            border: 1px solid #FECACA;
        }

        .field-error {
            color: #DC2626;
            font-size: 12px;
            margin-top: 3px;
        }

        /* TABLE */
        .table-box {
            overflow-x: auto;
        }

        table.perpus-table {
            width: 100%;
            border-collapse: collapse;
        }

        table.perpus-table th {
            background: var(--safir);
            color: white;
            padding: 11px 14px;
            text-align: left;
            font-size: 13px;
        }

        table.perpus-table td {
            padding: 10px 14px;
            border-bottom: 1px solid var(--krem-border);
            font-size: 14px;
            vertical-align: middle;
        }

        table.perpus-table tr:hover td {
            background: var(--safir-pale);
        }

        /* FORMS */
        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            font-size: 14px;
            color: var(--text-dark);
            margin-bottom: 5px;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 9px 12px;
            border: 1.5px solid var(--krem-border);
            border-radius: 7px;
            font-size: 14px;
            background: white;
            color: var(--text-dark);
            transition: border-color .2s;
        }

        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: var(--safir);
            box-shadow: 0 0 0 3px rgba(27, 107, 90, .1);
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        /* BADGE */
        .badge-status {
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .badge-dipinjam {
            background: #FEF3C7;
            color: #92400E;
        }

        .badge-dikembalikan {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-terlambat {
            background: #FEE2E2;
            color: #991B1B;
        }

        .badge-aktif {
            background: #D1FAE5;
            color: #065F46;
        }

        .badge-nonaktif {
            background: #F3F4F6;
            color: #6B7280;
        }

        /* FILTER */
        .filter-bar {
            display: flex;
            gap: 10px;
            flex-wrap: wrap;
            align-items: flex-end;
            margin-bottom: 18px;
        }

        .filter-bar .filter-item {
            flex: 1;
            min-width: 150px;
        }

        .filter-bar input,
        .filter-bar select {
            width: 100%;
            padding: 8px 12px;
            border: 1.5px solid var(--krem-border);
            border-radius: 7px;
            font-size: 14px;
            background: white;
        }

        /* PAGINATION */
        .pagination-box {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            margin-top: 16px;
        }

        .pagination-box a,
        .pagination-box span {
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 13px;
            text-decoration: none;
        }

        .pagination-box .page-active {
            background: var(--safir);
            color: white;
        }

        .pagination-box .page-disabled {
            background: var(--krem-dark);
            color: var(--text-muted);
        }

        .pagination-box a:not(.page-active) {
            background: var(--krem-dark);
            color: var(--text-dark);
        }

        .pagination-box a:hover:not(.page-active) {
            background: var(--safir-pale);
        }

        /* CHARTS */
        .grid-chart {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 18px;
        }

        .chart-box {
            background: white;
            border-radius: 10px;
            padding: 18px;
            border: 1px solid var(--krem-border);
        }

        /* PAGE TITLE */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }

        .page-title {
            font-size: 22px;
            font-weight: 700;
            color: var(--safir-dark);
            margin: 0;
        }

        .page-subtitle {
            font-size: 14px;
            color: var(--text-muted);
            margin: 2px 0 0 0;
        }

        .footer {
            text-align: center;
            color: var(--text-muted);
            padding: 20px;
            font-size: 13px;
            border-top: 1px solid var(--krem-border);
            margin-top: 30px;
        }

        @media (max-width: 768px) {

            .stat-cards,
            .form-row,
            .grid-chart {
                grid-template-columns: 1fr;
            }

            .nav-links {
                display: none;
            }
        }
    </style>
</head>

<body>
    <nav class="main-nav">
        <a href="{{ route('dashboard') }}" class="nav-brand">
            <i class="fas fa-book-open"></i> Perpustakaan Digital
        </a>
        @auth
            <div class="nav-links">
                <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fas fa-chart-line"></i> Dashboard
                </a>
                <a href="{{ route('buku.index') }}" class="{{ request()->routeIs('buku.*') ? 'active' : '' }}">
                    <i class="fas fa-book"></i> Buku
                </a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('anggota.index') }}" class="{{ request()->routeIs('anggota.*') ? 'active' : '' }}">
                        <i class="fas fa-users"></i> Anggota
                    </a>
                @endif

                <a href="{{ route('transaksi.index') }}" class="{{ request()->routeIs('transaksi.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-receipt"></i> Transaksi
                </a>

                @if(auth()->user()->isAdmin())
                    <a href="{{ route('ajax.transaksi.index') }}" class="{{ request()->routeIs('ajax.*') ? 'active' : '' }}">
                        <i class="fas fa-bolt"></i> AJAX
                    </a>
                    <a href="{{ route('laporan.index') }}" class="{{ request()->routeIs('laporan.*') ? 'active' : '' }}">
                        <i class="fas fa-file-alt"></i> Laporan
                    </a>
                @endif
            </div>
            <div class="nav-user">
                <i class="fas fa-user-circle"></i>
                {{ auth()->user()->name }} ({{ auth()->user()->role }})
                <form method="POST" action="{{ route('logout') }}" style="margin:0">
                    @csrf
                    <button type="submit" class="btn btn-sm"
                        style="background:rgba(255,255,255,.2);color:white;border:1px solid rgba(255,255,255,.4);">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        @endauth
    </nav>

    <div class="main-container">
        @if(session('success'))
            <div class="alert-success-box"><i class="fas fa-check-circle"></i> {{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="alert-error-box"><i class="fas fa-exclamation-circle"></i> {{ session('error') }}</div>
        @endif
        @yield('content')
    </div>

    <div class="footer">
        <i class="fas fa-book"></i> Sistem Peminjaman Buku Perpustakaan &mdash; Praktikum Pemrograman Web 2
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>

</html>