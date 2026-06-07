@extends('layouts.app')
@section('title', 'Edit Anggota')
@section('content')
    <div class="page-header">
        <h1 class="page-title">Edit Anggota: {{ $anggota->nama }}</h1>
        <a href="{{ route('anggota.index') }}" class="btn btn-outline-safir">← Kembali</a>
    </div>
    <div class="card-box">
        <form method="POST" action="{{ route('anggota.update', $anggota) }}">
            @csrf @method('PUT')
            @include('anggota._form')
            <div style="margin-top:20px">
                <button type="submit" class="btn btn-safir"><i class="fas fa-save"></i> Update Anggota</button>
            </div>
        </form>
    </div>
@endsection