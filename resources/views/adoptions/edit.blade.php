<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0D0E15]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pengajuan {{ $adoption->cat->name }} | EISD Meowdopt</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Google Fonts: Space Grotesk & Inter -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Space+Grotesk:wght@500;600;700&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['Inter', 'sans-serif'],
            display: ['"Space Grotesk"', 'sans-serif']
          },
          colors: {
            brand: {
              purple: '#494CA0',
              'purple-hover': '#3C3E86',
              green: '#00D97A',
              pink: '#C6149F',
              'pink-hover': '#A61084',
              dark: '#0D0E15',
              surface: '#12141F',
              card: '#161926',
              line: 'rgba(255, 255, 255, 0.12)'
            }
          }
        }
      }
    }
  </script>
</head>
<body class="min-h-full flex flex-col font-sans text-slate-100 bg-[#0D0E15] antialiased selection:bg-brand-purple selection:text-white">

  <!-- ========================================================================= -->
  <!-- TOPBAR -->
  <!-- ========================================================================= -->
  <header class="w-full border-b border-brand-line bg-[#12141F]/90 backdrop-blur-md sticky top-0 z-40">
    <div class="w-full px-6 lg:px-12 h-16 flex items-center justify-between">
      <!-- Brand & Title -->
      <a href="{{ route('cats.index') }}" class="flex items-center gap-2.5 text-white focus:outline-none">
        <div class="w-5 h-5 text-brand-purple flex items-center justify-center">
          <svg viewBox="0 0 100 100" class="w-full h-full fill-current">
            <path d="M20 25 L40 50 L60 50 L80 25 L80 75 Q80 85 70 85 L30 85 Q20 85 20 75 Z" />
          </svg>
        </div>
        <span class="font-display font-bold text-sm tracking-tight">EISD Meowdopt</span>
        <span class="text-xs text-slate-500 hidden sm:inline">• Edit Pengajuan Adopsi</span>
      </a>

      <!-- Navigation & Action Links -->
      <div class="flex items-center gap-3 sm:gap-4">
        <!-- Back Link to Adoption List (Preserves Dusk navigation contract) -->
        <a href="{{ route('adoptions.index') }}" class="back-link text-xs font-semibold text-slate-300 hover:text-white transition-colors flex items-center gap-1.5">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          <span class="hidden sm:inline">Kembali ke pengajuan saya</span>
          <span class="sm:hidden">Kembali</span>
        </a>

        <!-- User Menu Dropdown -->
        @auth
          <div class="relative">
            <button type="button" id="user-menu-button" aria-label="Menu akun" onclick="toggleUserDropdown()" class="user-icon-btn flex items-center gap-2 p-1.5 px-3 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-xs font-semibold text-slate-200 transition-colors">
              <span class="hidden sm:inline">{{ auth()->user()->name }}</span>
              <div class="w-6 h-6 rounded-full bg-brand-purple text-white font-display font-bold text-[10px] flex items-center justify-center">
                {{ strtoupper(mb_substr(auth()->user()->name, 0, 2)) }}
              </div>
            </button>

            <!-- Dropdown Body -->
            <div id="user-dropdown" class="hidden absolute right-0 mt-2 w-56 rounded-xl bg-[#1A1D2D] border border-white/15 shadow-2xl py-2 z-50">
              <div class="px-4 py-2 border-b border-white/10">
                <p class="text-[10px] text-slate-400">Masuk sebagai</p>
                <p class="text-xs font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                <p class="text-[11px] text-purple-300 truncate">{{ auth()->user()->email }} ({{ auth()->user()->isStaff() ? 'Staff Shelter' : 'Adopter' }})</p>
              </div>
              <a href="{{ route('cats.index') }}" class="block px-4 py-2 text-xs font-medium text-slate-300 hover:bg-white/10 hover:text-white">
                Katalog Kucing
              </a>
              <a href="{{ route('adoptions.index') }}" class="block px-4 py-2 text-xs font-medium text-slate-300 hover:bg-white/10 hover:text-white">
                {{ auth()->user()->isStaff() ? 'Pengajuan Masuk' : 'Pengajuan Saya' }}
              </a>
              <div class="border-t border-white/10 my-1"></div>
              <form action="{{ route('logout') }}" method="POST" class="px-2">
                @csrf
                <button type="submit" class="w-full text-left px-2 py-1.5 rounded-lg text-xs font-semibold text-rose-400 hover:bg-rose-500/10 transition-colors">
                  Logout
                </button>
              </form>
            </div>
          </div>
        @endauth
      </div>
    </div>
  </header>

  <!-- ========================================================================= -->
  <!-- MAIN FULL-BLEED ARCHITECTURAL LAYOUT -->
  <!-- ========================================================================= -->
  <main id="konten" class="flex-1 w-full grid grid-cols-1 lg:grid-cols-12 divide-y lg:divide-y-0 lg:divide-x divide-brand-line">

    <!-- ======================================================================= -->
    <!-- SISI KIRI: NARRATIVE, CONTEXT & CAT PHOTO (5 Columns) -->
    <!-- ======================================================================= -->
    <div class="lg:col-span-5 p-6 sm:p-10 lg:p-14 flex flex-col justify-between space-y-8 bg-[#12141F]/40">
      <div class="space-y-6">

        <!-- Breed & Status Badge -->
        <div class="flex items-center gap-2.5 flex-wrap">
          <span class="text-xs font-mono font-semibold tracking-widest text-purple-400 uppercase">
            #0{{ $adoption->cat->id }} / {{ $adoption->cat->breed }}
          </span>
          <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
          <span class="text-xs font-semibold text-amber-400">Status: {{ $adoption->status }}</span>
        </div>

        <!-- Headline & Narrative -->
        <div class="page-head space-y-2">
          <div>
            <h1 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-tight">
              Edit Pengajuan {{ $adoption->cat->name }}
            </h1>
            <p class="text-sm text-slate-300 leading-relaxed mt-2">
              Perbarui data selama pengajuan belum dikonfirmasi.
            </p>
          </div>
        </div>

        <!-- ===================================================================== -->
        <!-- CAT PHOTO FRAME & QUICK STATS -->
        <!-- ===================================================================== -->
        <div class="rounded-2xl border border-brand-line bg-[#161926] overflow-hidden shadow-2xl">
          <!-- Photo Container -->
          <div class="relative h-64 sm:h-72 w-full bg-gradient-to-br from-[#1A1D2D] to-[#12141F] flex items-center justify-center overflow-hidden group">
            @if ($adoption->cat->image_url)
              <img 
                src="{{ $adoption->cat->image_url }}" 
                alt="Foto Kucing {{ $adoption->cat->name }}" 
                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500"
              >
            @else
              <div class="w-24 h-24 text-brand-purple/70 transition-transform group-hover:scale-110 duration-300">
                <svg viewBox="0 0 100 100" class="w-full h-full fill-current drop-shadow-md">
                  <path d="M20 25 L40 50 L60 50 L80 25 L80 75 Q80 85 70 85 L30 85 Q20 85 20 75 Z" />
                </svg>
              </div>
            @endif

            <!-- Dark Gradient Scrim -->
            <div class="absolute inset-0 bg-gradient-to-t from-[#161926] via-transparent to-transparent opacity-85"></div>

            <!-- Floating Label in Photo -->
            <div class="absolute bottom-3 left-4 right-4 flex items-center justify-between text-white">
              <span class="font-display font-bold text-xl drop-shadow-md">{{ $adoption->cat->name }}</span>
              <span class="text-xs px-2.5 py-1 rounded-full bg-black/60 backdrop-blur-md border border-white/20 font-medium">
                {{ $adoption->cat->age }} Bulan
              </span>
            </div>
          </div>

          <!-- Quick Specs Grid -->
          <div class="grid grid-cols-2 divide-x divide-brand-line border-t border-brand-line text-xs">
            <div class="p-3.5 space-y-1">
              <span class="text-[11px] text-slate-400 block font-medium">Ras & Karakter</span>
              <span class="font-semibold text-white block">{{ $adoption->cat->breed }} • {{ $adoption->cat->temper }}</span>
            </div>
            <div class="p-3.5 space-y-1">
              <span class="text-[11px] text-slate-400 block font-medium">Lokasi Ditemukan</span>
              <span class="font-semibold text-white truncate block">{{ $adoption->cat->found_at }}</span>
            </div>
          </div>
          <div class="px-3.5 py-2.5 bg-[#12141F] border-t border-brand-line flex items-center justify-between text-[11px]">
            <span class="text-slate-400">Status Vaksinasi</span>
            <span class="font-semibold {{ $adoption->cat->vaccinated ? 'text-brand-green' : 'text-slate-400' }}">
              {{ $adoption->cat->vaccinated ? '✓ Sudah Vaksin Rutin' : 'Belum Vaksinasi' }}
            </span>
          </div>
        </div>

        <!-- Info Box -->
        <div class="p-5 rounded-2xl bg-[#161926]/70 border border-brand-line space-y-2">
          <h3 class="font-display font-bold text-xs uppercase tracking-wider text-slate-200 flex items-center gap-2">
            <svg class="w-4 h-4 text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            Catatan Perubahan Data
          </h3>
          <p class="text-xs text-slate-400 leading-relaxed">
            Data yang Anda perbarui akan langsung menggantikan pengajuan sebelumnya dan digunakan oleh tim shelter untuk proses verifikasi adopsi.
          </p>
        </div>

      </div>

      <!-- Footer Info -->
      <div class="pt-6 border-t border-brand-line flex items-center justify-between text-xs text-slate-500">
        <span>EISD Meowdopt • Shelter Kampus</span>
        <a href="{{ route('cats.show', $adoption->cat) }}" class="hover:text-purple-300 transition-colors">
          Lihat Profil Kucing &rarr;
        </a>
      </div>
    </div>

    <!-- ======================================================================= -->
    <!-- SISI KANAN: FORMULIR EDIT (7 Columns) -->
    <!-- ======================================================================= -->
    <div class="lg:col-span-7 p-6 sm:p-10 lg:p-14 flex flex-col justify-center bg-[#0D0E15]">
      <div class="w-full max-w-xl mx-auto space-y-6">

        <!-- Form Section Header -->
        <div class="space-y-1">
          <span class="text-xs font-bold uppercase tracking-wider text-purple-400 block">Formulir Pembaruan</span>
          <h2 class="font-display font-bold text-2xl text-white">Data Pengajuan Adopsi</h2>
          <p class="text-xs text-slate-400">Perbarui informasi tempat tinggal atau komitmen adopsi Anda sebelum dikonfirmasi oleh shelter.</p>
        </div>

        <!-- Flash Message Notification -->
        @if (session('status'))
          <div class="flash p-4 rounded-xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-200 text-xs font-medium" role="status">
            {{ session('status') }}
          </div>
        @endif

        <!-- Form Component -->
        @include('adoptions._form', [
          'action' => route('adoptions.update', $adoption),
          'submit' => 'Perbarui Pengajuan',
          'cat' => $adoption->cat,
          'adoption' => $adoption
        ])

      </div>
    </div>

  </main>

  <!-- ========================================================================= -->
  <!-- JAVASCRIPT: USER DROPDOWN TOGGLE -->
  <!-- ========================================================================= -->
  <script>
    function toggleUserDropdown() {
      const dropdown = document.getElementById('user-dropdown');
      if (dropdown) {
        dropdown.classList.toggle('hidden');
      }
    }

    document.addEventListener('click', function(e) {
      const btn = document.getElementById('user-menu-button');
      const dropdown = document.getElementById('user-dropdown');
      if (btn && dropdown && !btn.contains(e.target) && !dropdown.contains(e.target)) {
        dropdown.classList.add('hidden');
      }
    });
  </script>
</body>
</html>
