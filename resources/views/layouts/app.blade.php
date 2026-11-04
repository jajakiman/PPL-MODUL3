<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="EISD Meowdopt, katalog adopsi kucing daerah Bandung.">
    <title>@yield('title', 'EISD Meowdopt')</title>
    <link rel="icon" type="image/png" href="{{ asset('images/Vertical Logo 5.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600..800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="@yield('body-class', auth()->check() ? 'theme-board' : '')">
    <div class="floral-bg" id="floral-bg" aria-hidden="true"></div>
    <a class="skip-link" href="#konten">Lewati ke konten</a>

    <header class="topbar">
        <div class="topbar-inner">
            <a class="brand" href="{{ auth()->check() ? route('cats.index') : url('/') }}">
                <svg class="brand-mark" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 3l4 4h8l4-4v9a8 8 0 0 1-16 0z" fill="currentColor"/></svg>
                EISD Meowdopt
            </a>

            @auth
                <nav class="tabs" aria-label="Menu utama">
                    <a class="tab" href="{{ route('cats.index') }}" @if (request()->routeIs('cats.*')) aria-current="page" @endif>Katalog</a>
                    <a class="tab" href="{{ route('adoptions.index') }}" @if (request()->routeIs('adoptions.*')) aria-current="page" @endif>{{ auth()->user()->isStaff() ? 'Pengajuan Masuk' : 'Pengajuan Saya' }}</a>
                </nav>

                <div class="menu-wrap">
                    <button type="button" class="user-icon-btn" aria-label="Menu akun" aria-expanded="false" aria-controls="user-menu" data-menu-toggle>
                        {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
                    </button>
                    <div class="menu user-menu" id="user-menu" hidden>
                        <div class="menu-head">
                            <span class="menu-avatar" aria-hidden="true">{{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                            <div class="menu-meta">
                                <strong>{{ auth()->user()->name }}</strong>
                                <span>{{ auth()->user()->email }}</span>
                            </div>
                        </div>
                        <div class="menu-role">
                            <span>{{ auth()->user()->isStaff() ? 'Staff Shelter' : 'Adopter' }}</span>
                            <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="menu-item menu-item-danger">
                                <span>Logout</span>
                                <svg width="16" height="16" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3-3H9m9 0l-3-3m3 3l-3 3"/></svg>
                            </button>
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
            <p class="flash" id="flash-banner" role="status">{{ session('status') }}</p>
        @endif

        @yield('content')
    </main>
</body>
</html>
