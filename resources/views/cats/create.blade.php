@extends('layouts.app')

@section('title', 'Tambah Kucing | EISD Meowdopt')
@section('page-class', 'page-form')

@section('content')
    <a class="back-link" href="{{ route('cats.index') }}">Kembali ke katalog</a>
    <div class="page-head">
        <div>
            <h1>Tambah Kucing</h1>
            <p>Catat kucing yang baru ditemukan di Bandung.</p>
        </div>
    </div>

    @include('cats._form', ['action' => route('cats.store'), 'submit' => 'Simpan Kucing'])
@endsection
