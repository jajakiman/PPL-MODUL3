{{-- Mirrors the .topbar in layouts/app.blade.php (detail page) for Tailwind pages. --}}
@php($isStaff = auth()->user()->isStaff())
<header class="sticky top-0 z-40 pt-3.5 pb-2 pointer-events-none">
  <div class="max-w-7xl mx-auto px-6 lg:px-12 grid grid-cols-[1fr_auto_1fr] items-center gap-4 [&>*]:pointer-events-auto">
    <a href="{{ route('cats.index') }}" class="justify-self-start inline-flex items-center gap-2 px-4 py-2 rounded-full bg-[#161B3D] border border-white/[0.12] text-[#F8FAFC] font-display font-bold tracking-tight focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple">
      <svg class="w-5 h-5 text-brand-purple" viewBox="0 0 24 24" aria-hidden="true"><path d="M4 3l4 4h8l4-4v9a8 8 0 0 1-16 0z" fill="currentColor"/></svg>
      EISD Meowdopt
    </a>

    <nav class="flex flex-wrap justify-center gap-1.5" aria-label="Menu utama">
      @foreach ([['cats.index', 'cats.*', 'Katalog'], ['adoptions.index', 'adoptions.*', $isStaff ? 'Pengajuan Masuk' : 'Pengajuan Saya']] as [$route, $pattern, $label])
        <a href="{{ route($route) }}"
           @if (request()->routeIs($pattern)) aria-current="page" @endif
           class="inline-flex items-center min-h-10 px-[1.125rem] rounded-full border text-[15px] transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple {{ request()->routeIs($pattern) ? 'bg-brand-purple border-brand-purple text-white' : 'bg-[#161B3D] border-white/[0.12] text-slate-400 hover:bg-[#121630] hover:text-white' }}">
          {{ $label }}
        </a>
      @endforeach
    </nav>

    <div class="justify-self-end flex items-center gap-2">
      @if ($isStaff)
        <a href="{{ route('cats.create') }}" class="hidden sm:inline-flex items-center min-h-10 px-[1.125rem] rounded-full bg-brand-pink hover:bg-brand-pink-hover text-white text-sm font-semibold transition-colors">Tambah Kucing</a>
      @endif
      <div class="relative">
        <button type="button" id="user-menu-button" aria-label="Menu akun" onclick="toggleUserDropdown()"
                class="user-icon-btn w-10 h-10 rounded-full bg-[#494CA0] text-white font-bold text-sm shadow-md cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60">
          {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
        </button>
        <div id="user-dropdown" class="hidden absolute right-0 top-[calc(100%+0.625rem)] w-60 rounded-2xl bg-[#141519] border border-white/10 shadow-[0_16px_40px_rgba(0,0,0,0.65)] p-3.5 z-50 space-y-1">
          <div class="flex items-center gap-3 px-2 py-2 mb-1">
            <span class="w-10 h-10 shrink-0 rounded-full bg-[#494CA0] flex items-center justify-center text-white font-bold text-sm" aria-hidden="true">
              {{ strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}
            </span>
            <div class="min-w-0">
              <strong class="block text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</strong>
              <span class="block text-xs text-slate-400 truncate">{{ auth()->user()->email }}</span>
            </div>
          </div>
          <div class="flex items-center justify-between px-2.5 py-2 rounded-xl text-sm font-medium text-white">
            <span>{{ $isStaff ? 'Staff Shelter' : 'Adopter' }}</span>
            <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
          </div>
          <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="w-full flex items-center justify-between px-2.5 py-2 rounded-xl text-sm font-semibold text-rose-500 hover:bg-rose-500/10 hover:text-rose-400 transition-colors cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-400">
              <span>Logout</span>
              <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0013.5 3h-6A2.25 2.25 0 005.25 5.25v13.5A2.25 2.25 0 007.5 21h6a2.25 2.25 0 002.25-2.25V15m3-3H9m9 0l-3-3m3 3l-3 3"/></svg>
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</header>

@if (session('status'))
  <div id="flash-banner" role="status"
       class="flash fixed top-[4.75rem] left-1/2 -translate-x-1/2 z-50 flex items-center gap-2.5 px-5 py-3 rounded-[14px] bg-[#141519] border border-[#00D97A]/40 text-[#00D97A] text-sm font-semibold shadow-[0_16px_40px_rgba(0,0,0,0.65)] cursor-pointer transition-all duration-200">
    <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.25" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
    <span id="flash-message">{{ session('status') }}</span>
  </div>
  <script>
    (() => {
      const el = document.getElementById('flash-banner');
      if (!el) return;
      const dismiss = () => {
        el.classList.add('opacity-0', '-translate-y-2', 'pointer-events-none');
        setTimeout(() => el.remove(), 250);
      };
      if (!navigator.webdriver) setTimeout(dismiss, 2500);
      setTimeout(() => document.addEventListener('click', dismiss, { once: true }), 50);
    })();
  </script>
@endif
