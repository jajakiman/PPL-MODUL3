@extends('layouts.app')

@section('title', 'Edit Pengajuan | EISD Meowdopt')
@section('page-class', 'page-form')

@section('content')
    <a class="back-link" href="{{ route('adoptions.index') }}">Kembali ke pengajuan saya</a>
    <div class="page-head">
        <div>
            <h1>Edit Pengajuan {{ $adoption->cat->name }}</h1>
            <p>Perbarui data selama pengajuan belum dikonfirmasi.</p>
        </div>
    </div>

    @include('adoptions._form', ['action' => route('adoptions.update', $adoption), 'submit' => 'Perbarui Pengajuan', 'cat' => $adoption->cat])
@endsection
