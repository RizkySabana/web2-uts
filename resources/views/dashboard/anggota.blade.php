@extends('layouts.app')
@section('title', 'Dashboard Anggota')
@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">👋 Selamat Datang, {{ $anggota->nama ?? auth()->user()->name }}</h1>
            <p class="page-subtitle">No. Anggota: {{ $anggota->nomor_anggota ?? '-' }}</p>
        </div>
    </div>

    <div class="stat-cards" style="grid-template-columns:repeat(4,1fr)">
        <div class="stat-card">
            <div class="stat-icon">📚</div>
            <div class="stat-num">{{ $totalPinjam }}</div>
            <div class="stat-label">Total Pernah Pinjam</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">🔖</div>
            <div class="stat-num" style="color:#F59E0B">{{ $sedangDipinjam }}</div>
            <div class="stat-label">Sedang Dipinjam</div>
        </div>
        <div class="stat-card">
            <div class="stat-icon">✅</div>
            <div class="stat-num" style="color:#10B981">{{ $sudahKembali }}</div>
            <div class="stat-label">Sudah Dikembalikan</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-icon">⚠️</div>
            <div class="stat-num">{{ $terlambat }}</div>
            <div class="stat-label">Terlambat Kembali</div>
        </div>
    </div>

    <div class="card-box">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:16px">
            <h3 style="color:#1B6B5A;margin:0">📋 Riwayat Peminjaman Terakhir</h3>
            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-safir btn-sm">Lihat Semua</a>
        </div>
        <table class="perpus-table">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Batas Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayat as $item)
                    @php $terlambat = $item->status === 'dipinjam' && $item->tanggal_kembali_rencana < today(); @endphp
                    <tr>
                        <td>{{ $item->buku->judul ?? '-' }}</td>
                        <td>{{ $item->tanggal_pinjam?->format('d/m/Y') }}</td>
                        <td>{{ $item->tanggal_kembali_rencana?->format('d/m/Y') }}</td>
                        <td>
                            @if($terlambat)
                                <span class="badge-status badge-terlambat">⚠ Terlambat</span>
                            @else
                                <span class="badge-status badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#6B7280">Belum ada riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="card-box">
        <h3 style="color:#1B6B5A;margin-top:0">📖 Ingin Pinjam Buku?</h3>
        <p style="color:#6B7280">Jelajahi koleksi buku perpustakaan dan ajukan peminjaman langsung.</p>
        <div style="display:flex;gap:10px">
            <a href="{{ route('buku.index') }}" class="btn btn-safir"><i class="fas fa-book"></i> Lihat Koleksi Buku</a>
            <a href="{{ route('transaksi.create') }}" class="btn btn-outline-safir"><i class="fas fa-plus"></i> Pinjam
                Buku</a>
        </div>
    </div>
@endsection