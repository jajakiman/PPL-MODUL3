<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="EISD Meowdopt, katalog adopsi kucing shelter kampus.">
    <title>@yield('title', 'EISD Meowdopt')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="@yield('body-class')">
    <div class="floral-bg" id="floral-bg" aria-hidden="true"></div>
    <a class="skip-link" href="#konten">Lewati ke konten</a>

    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="{{ auth()->check() ? route('cats.index') : url('/') }}">
                <svg class="brand-mark" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 3l4 4h8l4-4v9a8 8 0 0 1-16 0z" fill="currentColor"/></svg>
                EISD Meowdopt
            </a>

            @auth
                <div class="menu-wrap">
                    <button type="button" class="user-icon-btn" aria-label="Menu akun" aria-expanded="false" aria-controls="user-menu" data-menu-toggle>
                        {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                    </button>
                    <div class="menu user-menu" id="user-menu" hidden>
                        <p class="menu-meta">
                            <strong>{{ auth()->user()->name }}</strong>
                            <span>{{ auth()->user()->email }}</span>
                        </p>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="menu-item">Logout</button>
                        </form>
                    </div>
                </div>
            @elseif (! View::hasSection('body-class'))
                <nav class="guest-nav" aria-label="Akun">
                    <a class="nav-link" href="{{ route('login') }}">Login</a>
                    <a class="btn btn-small" href="{{ route('register') }}">Register</a>
                </nav>
            @endauth
        </div>
    </header>

    <main id="konten" class="page @yield('page-class')">
        @if (session('status'))
            <p class="flash" role="status">{{ session('status') }}</p>
        @endif

        @yield('content')
    </main>
</body>
</html>
