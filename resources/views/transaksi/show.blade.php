@extends('layouts.app')
@section('title', 'Detail Transaksi')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Detail Transaksi #{{ $transaksi->id }}</h1>
        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-safir">← Kembali</a>
    </div>
    <div class="card-box">
        <table class="perpus-table" style="max-width:500px">
            <tr>
                <td><strong>Buku</strong></td>
                <td>{{ $transaksi->buku->judul ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Pengarang</strong></td>
                <td>{{ $transaksi->buku->pengarang ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Anggota</strong></td>
                <td>{{ $transaksi->anggota->nama ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>No. Anggota</strong></td>
                <td>{{ $transaksi->anggota->nomor_anggota ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Tgl Pinjam</strong></td>
                <td>{{ $transaksi->tanggal_pinjam?->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>Batas Kembali</strong></td>
                <td>{{ $transaksi->tanggal_kembali_rencana?->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>Tgl Kembali</strong></td>
                <td>{{ $transaksi->tanggal_kembali_aktual?->format('d/m/Y') ?? '-' }}</td>
            </tr>
            <tr>
                <td><strong>Status</strong></td>
                <td><span class="badge-status badge-{{ $transaksi->status }}">{{ ucfirst($transaksi->status) }}</span></td>
            </tr>
        </table>
    </div>
@endsection