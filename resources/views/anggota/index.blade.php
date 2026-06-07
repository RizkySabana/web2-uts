@extends('layouts.app')
@section('title', 'Data Anggota')
@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title"><i class="fas fa-users"></i> Data Anggota</h1>
            <p class="page-subtitle">Kelola anggota perpustakaan</p>
        </div>
        @if(auth()->user()->role === 'admin')
            <a href="{{ route('anggota.create') }}" class="btn btn-safir"><i class="fas fa-plus"></i> Tambah Anggota</a>
        @endif
    </div>
    <div class="card-box">
        <form class="filter-bar" method="GET">
            <div class="filter-item">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari nama / nomor anggota...">
            </div>
            <button type="submit" class="btn btn-safir">Cari</button>
            <a href="{{ route('anggota.index') }}" class="btn btn-outline-safir">Reset</a>
        </form>
        <div class="table-box">
            <table class="perpus-table">
                <thead>
                    <tr>
                        <th>No. Anggota</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Telepon</th>
                        <th>Tgl Daftar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($anggota as $item)
                        <tr>
                            <td>{{ $item->nomor_anggota }}</td>
                            <td><strong>{{ $item->nama }}</strong></td>
                            <td>{{ $item->email ?? '-' }}</td>
                            <td>{{ $item->telepon ?? '-' }}</td>
                            <td>{{ $item->tanggal_daftar?->format('d/m/Y') ?? '-' }}</td>
                            <td><span class="badge-status badge-{{ $item->status }}">{{ ucfirst($item->status) }}</span></td>
                            <td>
                                <div style="display:flex;gap:5px">
                                    <a href="{{ route('anggota.show', $item) }}" class="btn btn-sm btn-outline-safir">Detail</a>
                                    @if(auth()->user()->role === 'admin')
                                        <a href="{{ route('anggota.edit', $item) }}" class="btn btn-sm btn-warning-custom">Edit</a>
                                        <form method="POST" action="{{ route('anggota.destroy', $item) }}"
                                            onsubmit="return confirm('Hapus anggota ini?')">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger-custom">Hapus</button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align:center;color:#6B7280;padding:30px">Data anggota belum tersedia.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="pagination-box">
            @if($anggota->onFirstPage()) <span class="page-disabled">« Prev</span>
            @else <a href="{{ $anggota->previousPageUrl() }}">« Prev</a> @endif
            @foreach($anggota->getUrlRange(1, $anggota->lastPage()) as $page => $url)
                @if($page == $anggota->currentPage()) <span class="page-active">{{ $page }}</span>
                @else <a href="{{ $url }}">{{ $page }}</a> @endif
            @endforeach
            @if($anggota->hasMorePages()) <a href="{{ $anggota->nextPageUrl() }}">Next »</a>
            @else <span class="page-disabled">Next »</span> @endif
        </div>
    </div>
@endsection