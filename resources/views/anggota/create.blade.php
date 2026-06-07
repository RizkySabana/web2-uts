@extends('layouts.app')
@section('title', 'Tambah Anggota')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Tambah Anggota Baru</h1>
        <a href="{{ route('anggota.index') }}" class="btn btn-outline-safir">← Kembali</a>
    </div>
    <div class="card-box">
        <form method="POST" action="{{ route('anggota.store') }}">
            @csrf
            @include('anggota._form')
            <div style="margin-top:20px">
                <button type="submit" class="btn btn-safir"><i class="fas fa-save"></i> Simpan Anggota</button>
            </div>
        </form>
    </div>
@endsection