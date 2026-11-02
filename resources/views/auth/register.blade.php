@extends('layouts.app')

@section('title', 'Register | EISD Meowdopt')
@section('body-class', 'theme-dusk')
@section('page-class', 'page-auth')

@section('content')
    <h1>Daftar akun relawan<br>EISD Meowdopt</h1>

    <form class="auth-form" method="POST" action="{{ route('register') }}" novalidate>
        @csrf

        @foreach (['name' => ['Nama lengkap', 'text', 'name'], 'email' => ['Alamat email', 'email', 'email']] as $field => [$label, $type, $auto])
            <div class="field">
                <label class="sr-only" for="{{ $field }}">{{ $label }}</label>
                <input class="input" id="{{ $field }}" type="{{ $type }}" name="{{ $field }}" value="{{ old($field) }}" placeholder="{{ $label }}" autocomplete="{{ $auto }}" required @error($field) aria-invalid="true" aria-describedby="{{ $field }}-error" @enderror>
                @error($field)
                    <p class="error" id="{{ $field }}-error">{{ $message }}</p>
                @enderror
            </div>
        @endforeach

        <div class="field">
            <label class="sr-only" for="password">Password</label>
            <input class="input" id="password" type="password" name="password" placeholder="Password (minimal 8 karakter)" autocomplete="new-password" required @error('password') aria-invalid="true" aria-describedby="password-error" @enderror>
            @error('password')
                <p class="error" id="password-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="sr-only" for="password_confirmation">Konfirmasi Password</label>
            <input class="input" id="password_confirmation" type="password" name="password_confirmation" placeholder="Konfirmasi password" autocomplete="new-password" required>
        </div>

        <div class="field">
            <label class="check">
                <input type="checkbox" name="cat_lover" value="1" @checked(old('cat_lover')) @error('cat_lover') aria-invalid="true" aria-describedby="cat_lover-error" @enderror>
                <span>Saya pecinta kucing dan siap membantu shelter.</span>
            </label>
            @error('cat_lover')
                <p class="error" id="cat_lover-error">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="btn btn-block">Register</button>
    </form>

    <p class="auth-sep"><span>atau</span></p>
    <a class="btn btn-ghost btn-block" href="{{ route('login') }}">Login</a>
@endsection
