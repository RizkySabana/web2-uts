@extends('layouts.app')
@section('title', 'Tambah Buku')
@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Tambah Buku Baru</h1>
        </div>
        <a href="{{ route('buku.index') }}" class="btn btn-outline-safir">← Kembali</a>
    </div>
    <div class="card-box">
        <form method="POST" action="{{ route('buku.store') }}" enctype="multipart/form-data">
            @csrf
            @include('buku._form')
            <div style="margin-top:20px">
                <button type="submit" class="btn btn-safir"><i class="fas fa-save"></i> Simpan Buku</button>
            </div>
        </form>
    </div>
@endsection