@extends('layouts.app')

@section('title', 'Ajukan Adopsi '.$cat->name.' | EISD Meowdopt')
@section('page-class', 'page-form')

@section('content')
    <a class="back-link" href="{{ route('cats.show', $cat) }}">Kembali ke profil {{ $cat->name }}</a>
    <div class="page-head">
        <div>
            <h1>Ajukan Adopsi {{ $cat->name }}</h1>
            <p>Isi data kelayakan supaya shelter bisa memastikan {{ $cat->name }} pulang ke rumah yang tepat.</p>
        </div>
    </div>

    @include('adoptions._form', ['action' => route('adoptions.store'), 'submit' => 'Kirim Pengajuan'])
@endsection
