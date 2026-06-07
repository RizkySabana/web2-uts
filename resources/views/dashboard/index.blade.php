@extends('layouts.app')
@section('title', 'Dashboard Perpustakaan')
@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-chart-line"></i> Dashboard</h1>
            <p class="page-subtitle">Ringkasan data sistem peminjaman buku perpustakaan</p>
        </div>
    </div>

    <div class="stat-cards">
        <div class="stat-card">
            <div class="stat-icon" style="color:#1B6B5A">📚</div>
            <div class="stat-num">{{ $totalBuku }}</div>
            <div class="stat-label">Total Buku</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="color:#1B6B5A">👥</div>
            <div class="stat-num">{{ $totalAnggota }}</div>
            <div class="stat-label">Total Anggota</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="color:#F59E0B">🔖</div>
            <div class="stat-num">{{ $totalDipinjam }}</div>
            <div class="stat-label">Sedang Dipinjam</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="color:#10B981">✅</div>
            <div class="stat-num">{{ $totalDikembalikan }}</div>
            <div class="stat-label">Sudah Dikembalikan</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-icon" style="color:#EF4444">⚠️</div>
            <div class="stat-num">{{ $terlambat }}</div>
            <div class="stat-label">Terlambat Kembali</div>
        </div>
    </div>

    <div class="grid-chart">
        <div class="chart-box">
            <h3 style="color:#1B6B5A;margin-top:0">Transaksi per Bulan</h3>
            <canvas id="chartBulan"></canvas>
        </div>
        <div class="chart-box">
            <h3 style="color:#1B6B5A;margin-top:0">Status Peminjaman</h3>
            <canvas id="chartStatus"></canvas>
        </div>
    </div>

    <div class="card-box" style="margin-top:18px">
        <h3 style="color:#1B6B5A;margin-top:0">📊 Buku Terpopuler</h3>
        <table class="perpus-table">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Pengarang</th>
                    <th>Kategori</th>
                    <th>Total Dipinjam</th>
                </tr>
            </thead>
            <tbody>
                @forelse($popularBuku as $buku)
                    <tr>
                        <td>{{ $buku->judul }}</td>
                        <td>{{ $buku->pengarang }}</td>
                        <td>{{ $buku->kategori }}</td>
                        <td><strong>{{ $buku->transaksis_count }}</strong></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#6B7280">Belum ada data transaksi.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        new Chart(document.getElementById('chartBulan'), {
            type: 'bar',
            data: {
                labels: @json($bulanLabels),
                datasets: [{ label: 'Peminjaman', data: @json($bulanValues), backgroundColor: '#1B6B5A', borderRadius: 5 }]
            },
            options: { plugins: { legend: { display: false } } }
        });
        new Chart(document.getElementById('chartStatus'), {
            type: 'doughnut',
            data: {
                labels: @json($statusLabels),
                datasets: [{ data: @json($statusValues), backgroundColor: ['#F59E0B', '#10B981'] }]
            }
        });
    </script>
@endsection