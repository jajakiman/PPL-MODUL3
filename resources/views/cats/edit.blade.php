@extends('layouts.app')

@section('title', 'Edit '.$cat->name.' | EISD Meowdopt')
@section('page-class', 'page-form')

@section('content')
    <a class="back-link" href="{{ route('cats.index') }}">Kembali ke katalog</a>
    <div class="page-head">
        <div>
            <h1>Edit {{ $cat->name }}</h1>
            <p>Perbarui sifat, umur, atau status vaksinnya.</p>
        </div>
    </div>

    @include('cats._form', ['action' => route('cats.update', $cat), 'submit' => 'Perbarui Kucing'])
@endsection
