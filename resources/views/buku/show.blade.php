@extends('layouts.app')
@section('title', 'Detail Buku')
@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ $buku->judul }}</h1>
        <a href="{{ route('buku.index') }}" class="btn btn-outline-safir">← Kembali</a>
    </div>
    <div class="card-box">
        <div style="display:flex;gap:24px;flex-wrap:wrap">
            @if($buku->cover_path)
                <img src="{{ route('storage.file', $buku->cover_path) }}"
                    style="width:140px;border-radius:8px;border:1px solid #D4C9B0;object-fit:cover">
            @endif
            <div style="flex:1">
                <table class="perpus-table">
                    <tr>
                        <td><strong>Kode</strong></td>
                        <td>{{ $buku->kode_buku }}</td>
                    </tr>
                    <tr>
                        <td><strong>Pengarang</strong></td>
                        <td>{{ $buku->pengarang }}</td>
                    </tr>
                    <tr>
                        <td><strong>Penerbit</strong></td>
                        <td>{{ $buku->penerbit ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Tahun Terbit</strong></td>
                        <td>{{ $buku->tahun_terbit ?? '-' }}</td>
                    </tr>
                    <tr>
                        <td><strong>Kategori</strong></td>
                        <td>{{ $buku->kategori }}</td>
                    </tr>
                    <tr>
                        <td><strong>Stok Total</strong></td>
                        <td>{{ $buku->stok_total }}</td>
                    </tr>
                    <tr>
                        <td><strong>Stok Tersedia</strong></td>
                        <td><span
                                style="color:{{ $buku->stok_tersedia > 0 ? '#065F46' : '#991B1B' }};font-weight:600">{{ $buku->stok_tersedia }}</span>
                        </td>
                    </tr>
                    <tr>
                        <td><strong>Deskripsi</strong></td>
                        <td>{{ $buku->deskripsi ?? '-' }}</td>
                    </tr>
                </table>
            </div>
        </div>
        <h3 style="color:#1B6B5A;margin-top:24px">Riwayat Peminjaman</h3>
        <table class="perpus-table">
            <thead>
                <tr>
                    <th>Anggota</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali Rencana</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($buku->transaksis as $t)
                    <tr>
                        <td>{{ $t->anggota->nama ?? '-' }}</td>
                        <td>{{ $t->tanggal_pinjam?->format('d/m/Y') }}</td>
                        <td>{{ $t->tanggal_kembali_rencana?->format('d/m/Y') }}</td>
                        <td><span class="badge-status badge-{{ $t->status }}">{{ ucfirst($t->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#6B7280">Belum ada riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection