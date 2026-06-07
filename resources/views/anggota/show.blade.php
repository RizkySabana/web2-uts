@extends('layouts.app')
@section('title', 'Detail Anggota')
@section('content')
    <div class="page-header">
        <h1 class="page-title">{{ $anggota->nama }}</h1>
        <a href="{{ route('anggota.index') }}" class="btn btn-outline-safir">← Kembali</a>
    </div>
    <div class="card-box">
        <table class="perpus-table" style="max-width:500px">
            <tr>
                <td><strong>No. Anggota</strong></td>
                <td>{{ $anggota->nomor_anggota }}</td>
            </tr>
            <tr>
                <td><strong>Email</strong></td>
                <td>{{ $anggota->email ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Telepon</strong></td>
                <td>{{ $anggota->telepon ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Alamat</strong></td>
                <td>{{ $anggota->alamat ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Tgl Daftar</strong></td>
                <td>{{ $anggota->tanggal_daftar?->format('d/m/Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td><span class="badge-status badge-{{ $anggota->status }}">{{ ucfirst($anggota->status) }}</span></td>
            </tr>
        </table>
        <h3 style="color:#1B6B5A;margin-top:24px">Riwayat Peminjaman</h3>
        <table class="perpus-table">
            <thead>
                <tr>
                    <th>Judul Buku</th>
                    <th>Tgl Pinjam</th>
                    <th>Tgl Kembali</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse($anggota->transaksis as $t)
                    <tr>
                        <td>{{ $t->buku->judul ?? '-' }}</td>
                        <td>{{ $t->tanggal_pinjam?->format('d/m/Y') }}</td>
                        <td>{{ $t->tanggal_kembali_rencana?->format('d/m/Y') }}</td>
                        <td><span class="badge-status badge-{{ $t->status }}">{{ ucfirst($t->status) }}</span></td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="text-align:center;color:#6B7280">Belum ada riwayat.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection