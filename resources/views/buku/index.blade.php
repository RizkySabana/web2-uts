@extends('layouts.app')
@section('title', 'Data Buku')
@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-book"></i> Data Buku</h1>
            <p class="page-subtitle">Kelola koleksi buku perpustakaan</p>
        </div>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('buku.create') }}" class="btn btn-safir"><i class="fas fa-plus"></i> Tambah Buku</a>
        @endif
    </div>

    <div class="card-box">
        <form class="filter-bar" method="GET">
            <div class="filter-item">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari judul / pengarang...">
            </div>
            <div class="filter-item" style="flex:0 0 160px">
                <select name="kategori">
                    <option value="">Semua Kategori</option>
                    @foreach($kategoris as $kat)
                        <option value="{{ $kat }}" @selected(request('kategori') === $kat)>{{ $kat }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-safir">Filter</button>
            <a href="{{ route('buku.index') }}" class="btn btn-outline-safir">Reset</a>
        </form>

        <div class="table-box">
            <table class="perpus-table">
                <thead>
                    <tr>
                        <th>Cover</th>
                        <th>Kode</th>
                        <th>Judul</th>
                        <th>Pengarang</th>
                        <th>Kategori</th>
                        <th>Stok Total</th>
                        <th>Tersedia</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($bukus as $item)
                        <tr>
                            <td>
                                @if($item->cover_path)
                                    <img src="{{ route('storage.file', $item->cover_path) }}" width="50" style="border-radius:4px;">
                                @else
                                    <span style="color:#9CA3AF;font-size:12px;">—</span>
                                @endif
                            </td>
                            <td>{{ $item->kode_buku }}</td>
                            <td><strong>{{ $item->judul }}</strong><br><small
                                    style="color:#6B7280">{{ $item->penerbit ?? '' }}</small></td>
                            <td>{{ $item->pengarang }}</td>
                            <td>{{ $item->kategori }}</td>
                            <td>{{ $item->stok_total }}</td>
                            <td>
                                <span style="color:{{ $item->stok_tersedia > 0 ? '#065F46' : '#991B1B' }};font-weight:600;">
                                    {{ $item->stok_tersedia }}
                                </span>
                            </td>
                            <td>
                                <div style="display:flex;gap:5px;flex-wrap:wrap;">
                                    <a href="{{ route('buku.show', $item) }}" class="btn btn-sm btn-outline-safir">Detail</a>
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('buku.edit', $item) }}" class="btn btn-sm btn-warning-custom">Edit</a>
                                        <form method="POST" action="{{ route('buku.destroy', $item) }}"
                                            onsubmit="return confirm('Hapus buku ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger-custom">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" style="text-align:center;color:#6B7280;padding:30px">Data buku belum tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-box">
            @if($bukus->onFirstPage())
                <span class="page-disabled">« Prev</span>
            @else
                <a href="{{ $bukus->previousPageUrl() }}">« Prev</a>
            @endif
            @foreach($bukus->getUrlRange(1, $bukus->lastPage()) as $page => $url)
                @if($page == $bukus->currentPage())
                    <span class="page-active">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach
            @if($bukus->hasMorePages())
                <a href="{{ $bukus->nextPageUrl() }}">Next »</a>
            @else
                <span class="page-disabled">Next »</span>
            @endif
        </div>
    </div>
@endsection