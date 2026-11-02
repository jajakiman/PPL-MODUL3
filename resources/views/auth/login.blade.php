@extends('layouts.app')

@section('title', 'Login | EISD Meowdopt')
@section('body-class', 'theme-dusk')
@section('page-class', 'page-auth')

@section('content')
    <h1>Login ke akun<br>EISD Meowdopt</h1>

    <form class="auth-form" method="POST" action="{{ route('login') }}" novalidate>
        @csrf

        @error('email')
            <p class="error-box" role="alert">{{ $message }}</p>
        @enderror

        <div class="field">
            <label class="sr-only" for="email">Email</label>
            <input class="input" id="email" type="email" name="email" value="{{ old('email') }}" placeholder="Alamat email" autocomplete="email" required>
        </div>

        <div class="field">
            <label class="sr-only" for="password">Password</label>
            <input class="input" id="password" type="password" name="password" placeholder="Password" autocomplete="current-password" required @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
            @error('password')
                <p class="error" id="password-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-block">Login</button>
    </form>

    <p class="auth-sep"><span>atau</span></p>
    <a class="btn btn-ghost btn-block" href="{{ route('register') }}">Register</a>
@endsection
