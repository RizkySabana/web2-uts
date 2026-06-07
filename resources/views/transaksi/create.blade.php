@extends('layouts.app')
@section('title', 'Form Peminjaman Buku')
@section('content')
    <div class="page-header">
        <h1 class="page-title"><i class="fas fa-book-reader"></i> Form Peminjaman Buku</h1>
        <a href="{{ route('transaksi.index') }}" class="btn btn-outline-safir">← Kembali</a>
    </div>
    <div class="card-box">
        <form method="POST" action="{{ route('transaksi.store') }}">
            @csrf
            <div class="form-group">
                <label>Pilih Buku (stok tersedia > 0) *</label>
                <select name="buku_id">
                    <option value="">-- Pilih Buku --</option>
                    @foreach($bukus as $buku)
                        <option value="{{ $buku->id }}" @selected(old('buku_id') == $buku->id)>
                            {{ $buku->judul }} — (Stok: {{ $buku->stok_tersedia }})
                        </option>
                    @endforeach
                </select>
                @error('buku_id') <div class="field-error">{{ $message }}</div> @enderror
            </div>

            @if($isAnggota)
                {{-- Anggota: otomatis pakai ID sendiri --}}
                <input type="hidden" name="anggota_id" value="{{ auth()->user()->anggota_id }}">
                <div class="form-group">
                    <label>Peminjam</label>
                    <input type="text" value="{{ auth()->user()->anggota->nama ?? auth()->user()->name }}" disabled
                        style="background:#F5F0E8;color:#6B7280">
                    <small style="color:#6B7280">Peminjaman otomatis atas nama Anda.</small>
                </div>
            @else
                {{-- Admin: bisa pilih anggota manapun --}}
                <div class="form-group">
                    <label>Pilih Anggota *</label>
                    <select name="anggota_id">
                        <option value="">-- Pilih Anggota --</option>
                        @foreach($anggota as $a)
                            <option value="{{ $a->id }}" @selected(old('anggota_id') == $a->id)>
                                {{ $a->nama }} ({{ $a->nomor_anggota }})
                            </option>
                        @endforeach
                    </select>
                    @error('anggota_id') <div class="field-error">{{ $message }}</div> @enderror
                </div>
            @endif

            <p style="color:#6B7280;font-size:13px;background:#F5F0E8;padding:10px;border-radius:6px;">
                <i class="fas fa-info-circle"></i> Tanggal pinjam otomatis hari ini. Batas kembali <strong>7 hari</strong>.
            </p>
            <button type="submit" class="btn btn-safir"><i class="fas fa-check"></i> Catat Peminjaman</button>
        </form>
    </div>
@endsection