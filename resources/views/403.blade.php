@extends('layouts.app')
@section('title', '403 - Akses Ditolak')
@section('content')
    <div style="text-align:center;padding:60px 20px">
        <div style="font-size:64px">🔒</div>
        <h2 style="color:#1B6B5A">Akses Ditolak</h2>
        <p style="color:#6B7280">Anda tidak memiliki izin untuk mengakses halaman ini. Fitur ini hanya tersedia untuk Admin.
        </p>
        <a href="{{ route('dashboard') }}" class="btn btn-safir">← Kembali ke Dashboard</a>
    </div>
@endsection