@extends('layouts.app')
@section('title', 'Transaksi Peminjaman')
@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-exchange-alt"></i> Transaksi Peminjaman</h1>
            <p class="page-subtitle">Data peminjaman dan pengembalian buku</p>
        </div>
        <a href="{{ route('transaksi.create') }}" class="btn btn-safir">
            <i class="fas fa-plus"></i> Pinjam Buku
        </a>
    </div>
    <div class="card-box">
        <form class="filter-bar" method="GET">
            <div class="filter-item">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul buku / nama anggota...">
            </div>
            <div class="filter-item" style="flex:0 0 160px">
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" @selected(request('status') === 'dipinjam')>Dipinjam</option>
                    <option value="dikembalikan" @selected(request('status') === 'dikembalikan')>Dikembalikan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-safir">Filter</button>
            <a href="{{ route('transaksi.index') }}" class="btn btn-outline-safir">Reset</a>
        </form>
        <div class="table-box">
            <table class="perpus-table">
                <thead>
                    <tr>
                        <th>Buku</th>
                        <th>Anggota</th>
                        <th>Tgl Pinjam</th>
                        <th>Tgl Kembali</th>
                        <th>Kembali Aktual</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($transaksis as $item)
                        @php $terlambat = $item->status === 'dipinjam' && $item->tanggal_kembali_rencana < today(); @endphp
                        <tr style="{{ $terlambat ? 'background:#FEF2F2' : '' }}">
                            <td>{{ $item->buku->judul ?? '-' }}</td>
                            <td>{{ $item->anggota->nama ?? '-' }}</td>
                            <td>{{ $item->tanggal_pinjam?->format('d/m/Y') }}</td>
                            <td>{{ $item->tanggal_kembali_rencana?->format('d/m/Y') }}</td>
                            <td>{{ $item->tanggal_kembali_aktual?->format('d/m/Y') ?? '-' }}</td>
                            <td>
                                @if($terlambat)
                                    <span class="badge-status badge-terlambat">⚠ Terlambat</span>
                                @else
                                    <span class="badge-status badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span>
                                @endif
                            </td>
                            <td>
                                <div style="display:flex;gap:5px;flex-wrap:wrap">
                                    <a href="{{ route('transaksi.show', $item) }}"
                                        class="btn btn-sm btn-outline-safir">Detail</a>

                                    {{-- Kembalikan: SEMUA user boleh, bukan hanya admin --}}
                                    @if($item->status === 'dipinjam')
                                        <form method="POST" action="{{ route('transaksi.kembali', $item) }}">
                                            @csrf @method('PATCH')
                                            <button type="submit" class="btn btn-sm btn-success-custom">Kembalikan</button>
                                        </form>
                                    @endif

                                    {{-- Hapus: tetap hanya admin --}}
                                    @if(auth()->user()->role === 'admin')
                                        <form method="POST" action="{{ route('transaksi.destroy', $item) }}"
                                            onsubmit="return confirm('Hapus data ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger-custom">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;color:#6B7280;padding:30px">Belum ada data transaksi.</td>
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