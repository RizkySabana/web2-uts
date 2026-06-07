@extends('layouts.app')
@section('title', 'Laporan Peminjaman')
@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-file-alt"></i> Laporan Peminjaman</h1>
            <p class="page-subtitle">Filter dan ekspor data peminjaman ke PDF atau Excel</p>
        </div>
    </div>
    <div class="card-box">
        <form method="GET">
            <div class="form-row">
                <div class="form-group">
                    <label>Keyword</label>
                    <input type="text" name="keyword" value="{{ request('keyword') }}"
                        placeholder="Judul buku / nama anggota">
                </div>
                <div class="form-group">
                    <label>Status</label>
                    <select name="status">
                        <option value="">Semua</option>
                        <option value="dipinjam" @selected(request('status') === 'dipinjam')>Dipinjam</option>
                        <option value="dikembalikan" @selected(request('status') === 'dikembalikan')>Dikembalikan</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label>Tanggal Pinjam Mulai</label>
                    <input type="date" name="tanggal_mulai" value="{{ request('tanggal_mulai') }}">
                </div>
                <div class="form-group">
                    <label>Tanggal Pinjam Selesai</label>
                    <input type="date" name="tanggal_selesai" value="{{ request('tanggal_selesai') }}">
                </div>
            </div>
            <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:12px">
                <button type="submit" class="btn btn-safir"><i class="fas fa-filter"></i> Filter</button>
                <a href="{{ route('laporan.index') }}" class="btn btn-outline-safir">Reset</a>
                <a href="{{ route('laporan.pdf', request()->query()) }}" class="btn btn-danger-custom" target="_blank"><i
                        class="fas fa-file-pdf"></i> Export PDF</a>
                <a href="{{ route('laporan.excel', request()->query()) }}" class="btn btn-success-custom"><i
                        class="fas fa-file-excel"></i> Export Excel</a>
            </div>
        </form>
    </div>

    <div class="stat-cards" style="grid-template-columns:repeat(4,1fr)">
        <div class="stat-card">
            <div class="stat-num">{{ $summary['total'] }}</div>
            <div class="stat-label">Total Transaksi</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#F59E0B">{{ $summary['dipinjam'] }}</div>
            <div class="stat-label">Dipinjam</div>
        </div>
        <div class="stat-card">
            <div class="stat-num" style="color:#10B981">{{ $summary['dikembalikan'] }}</div>
            <div class="stat-label">Dikembalikan</div>
        </div>
        <div class="stat-card danger">
            <div class="stat-num">{{ $summary['terlambat'] }}</div>
            <div class="stat-label">Terlambat</div>
        </div>
    </div>

    <div class="card-box">
        <div class="table-box">
            <table class="perpus-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Buku</th>
                        <th>Anggota</th>
                        <th>Tgl Pinjam</th>
                        <th>Batas Kembali</th>
                        <th>Tgl Kembali</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $i => $item)
                        <tr>
                            <td>{{ $transaksis->firstItem() + $i }}</td>
                            <td>{{ $item->buku->judul ?? '-' }}</td>
                            <td>{{ $item->anggota->nama ?? '-' }}</td>
                            <td>{{ $item->tanggal_pinjam?->format('d/m/Y') }}</td>
                            <td>{{ $item->tanggal_kembali_rencana?->format('d/m/Y') }}</td>
                            <td>{{ $item->tanggal_kembali_aktual?->format('d/m/Y') ?? '-' }}</td>
                            <td><span class="badge-status badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;color:#6B7280;padding:30px">Tidak ada data.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-box">
            @if($transaksis->onFirstPage()) <span class="page-disabled">« Prev</span>
            @else <a href="{{ $transaksis->previousPageUrl() }}">« Prev</a> @endif
            @foreach($transaksis->getUrlRange(1, $transaksis->lastPage()) as $page => $url)
                @if($page == $transaksis->currentPage()) <span class="page-active">{{ $page }}</span>
                @else <a href="{{ $url }}">{{ $page }}</a> @endif
            @endforeach
            @if($transaksis->hasMorePages()) <a href="{{ $transaksis->nextPageUrl() }}">Next »</a>
            @else <span class="page-disabled">Next »</span> @endif
        </div>
    </div>
@endsection