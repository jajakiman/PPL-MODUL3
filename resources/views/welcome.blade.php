@extends('layouts.app')

@section('page-class', 'page-full')

@section('content')
    <section class="hero">
        <div class="hero-copy">
            <h1>Setiap kucing kampus layak punya rumah</h1>
            <p class="hero-lede">Relawan shelter mencatat kucing yang ditemukan di sekitar kampus, merawatnya, lalu mempertemukannya dengan pengadopsi.</p>
            <div class="capsule">
                <span>Gabung jadi relawan</span>
                <a class="btn" href="{{ route('register') }}">Register</a>
            </div>
            <p class="hero-alt">Sudah punya akun? <a href="{{ route('login') }}">Login</a></p>
        </div>

        <div class="hero-panel" aria-label="Kondisi shelter saat ini">
            <p class="cell stat"><span>Menunggu adopsi</span><strong>{{ $total }} kucing</strong></p>
            <div class="cell"></div>
            <div class="cell block" aria-hidden="true">
                <svg viewBox="0 0 24 24"><path d="M4 3l4 4h8l4-4v9a8 8 0 0 1-16 0z" fill="currentColor"/></svg>
            </div>
            <p class="cell stat">
                <span>Sudah divaksin</span>
                <strong>{{ $vaccinated }} dari {{ $total }}</strong>
                <span class="bar" role="presentation"><span style="width: {{ $total ? round($vaccinated / $total * 100) : 0 }}%"></span></span>
            </p>
            <p class="cell stat"><span>Terakhir ditemukan</span><strong>{{ $latest?->found_at ?? 'Belum ada' }}</strong></p>
            <div class="cell"></div>
        </div>
    </section>
@endsection
