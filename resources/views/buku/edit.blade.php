@extends('layouts.app')
@section('title', 'Edit Buku')
@section('content')
    <div class="page-header">
        <div>
            <h1 class="page-title">Edit Buku: {{ $buku->judul }}</h1>
        </div>
        <a href="{{ route('buku.index') }}" class="btn btn-outline-safir">← Kembali</a>
    </div>
    <div class="card-box">
        <form method="POST" action="{{ route('buku.update', $buku) }}" enctype="multipart/form-data">
            @csrf @method('PUT')
            @include('buku._form')
            <div style="margin-top:20px">
                <button type="submit" class="btn btn-safir"><i class="fas fa-save"></i> Update Buku</button>
            </div>
        </form>
    </div>
@endsection