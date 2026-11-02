@extends('layouts.app')

@section('title', $cat->name.' | EISD Meowdopt')
@section('page-class', 'page-form')

@section('content')
    <a class="back-link" href="{{ route('cats.index') }}">Kembali ke katalog</a>
    <div class="page-head">
        <div>
            <h1>{{ $cat->name }}</h1>
            <p>Ditemukan di {{ $cat->found_at }}</p>
        </div>
        <a class="btn btn-ghost" href="{{ route('cats.edit', $cat) }}">Edit</a>
    </div>

    <div class="panel">
        <dl class="detail-list">
            <div><dt>Ras</dt><dd>{{ $cat->breed }}</dd></div>
            <div><dt>Sifat</dt><dd>{{ $cat->temper }}</dd></div>
            <div><dt>Umur</dt><dd>{{ $cat->age }} bulan</dd></div>
            <div><dt>Vaksin</dt><dd>{{ $cat->vaccinated ? 'Sudah Vaksin' : 'Belum Vaksin' }}</dd></div>
        </dl>
    </div>
@endsection
