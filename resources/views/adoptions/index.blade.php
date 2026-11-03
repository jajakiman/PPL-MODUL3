<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0D0E15]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ auth()->user()->isStaff() ? 'Pengajuan Masuk' : 'Pengajuan Saya' }} | EISD Meowdopt</title>
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
  <!-- Native Interactivity Script (Modal & Action Menus) -->
  <script src="{{ asset('js/app.js') }}" defer></script>
</head>
<body class="min-h-full flex flex-col font-sans text-slate-100 bg-[#0D0E15] antialiased selection:bg-brand-purple selection:text-white">

  @php
    $isStaff = auth()->user()->isStaff();
    $total = $adoptions->count();
    $pendingCount = $adoptions->where('status', \App\Models\Adoption::PENDING)->count();
    $doneCount = $total - $pendingCount;
    $pct = $total ? round($doneCount / $total * 100) : 0;
  @endphp

  <!-- ========================================================================= -->
  <!-- TOPBAR -->
  <!-- ========================================================================= -->
  <header class="w-full border-b border-brand-line bg-[#12141F]/90 backdrop-blur-md sticky top-0 z-40">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 h-16 flex items-center justify-between">
      <!-- Brand & Title -->
      <a href="{{ route('cats.index') }}" class="flex items-center gap-2.5 text-white focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple rounded-lg">
        <div class="w-5 h-5 text-brand-purple flex items-center justify-center">
          <svg viewBox="0 0 100 100" class="w-full h-full fill-current" aria-hidden="true">
            <path d="M20 25 L40 50 L60 50 L80 25 L80 75 Q80 85 70 85 L30 85 Q20 85 20 75 Z" />
          </svg>
        </div>
        <span class="font-display font-bold text-sm tracking-tight">EISD Meowdopt</span>
        <span class="text-xs text-slate-400 hidden sm:inline">• {{ $isStaff ? 'Panel Staff Shelter' : 'Riwayat Pengajuan Adopter' }}</span>
      </a>

      <!-- Middle Navigation Tabs -->
      <nav class="hidden md:flex items-center gap-1.5 bg-[#161926] p-1 rounded-full border border-white/10 text-xs">
        <a href="{{ route('cats.index') }}" class="px-4 py-1.5 rounded-full text-slate-300 hover:text-white hover:bg-white/5 transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple">
          Katalog
        </a>
        <a href="{{ route('adoptions.index') }}" class="px-4 py-1.5 rounded-full bg-brand-purple text-white font-semibold shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple">
          {{ $isStaff ? 'Pengajuan Masuk' : 'Pengajuan Saya' }}
        </a>
      </nav>

      <!-- Action & Profile Buttons -->
      <div class="flex items-center gap-3">
        @can('staff')
          <a href="{{ route('cats.create') }}" class="hidden sm:inline-flex px-4 py-2 rounded-full bg-brand-pink hover:bg-brand-pink-hover text-white text-xs font-semibold shadow-sm transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-pink">
            Tambah Kucing
          </a>
        @endcan

        <!-- User Menu Dropdown -->
        @auth
          <div class="relative">
            <button type="button" id="user-menu-button" aria-label="Menu akun" onclick="toggleUserDropdown()" class="user-icon-btn flex items-center gap-2 p-1.5 px-3 rounded-full bg-white/5 hover:bg-white/10 border border-white/10 text-xs font-semibold text-slate-200 transition-colors cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple">
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
                <p class="text-[11px] text-purple-300 truncate">{{ auth()->user()->email }} ({{ $isStaff ? 'Staff Shelter' : 'Adopter' }})</p>
              </div>
              <a href="{{ route('cats.index') }}" class="block px-4 py-2 text-xs font-medium text-slate-300 hover:bg-white/10 hover:text-white md:hidden">
                Katalog Kucing
              </a>
              <a href="{{ route('adoptions.index') }}" class="block px-4 py-2 text-xs font-medium text-slate-300 hover:bg-white/10 hover:text-white md:hidden">
                {{ $isStaff ? 'Pengajuan Masuk' : 'Pengajuan Saya' }}
              </a>
              <div class="border-t border-white/10 my-1"></div>
              <form action="{{ route('logout') }}" method="POST" class="px-2">
                @csrf
                <button type="submit" class="w-full text-left px-2 py-1.5 rounded-lg text-xs font-semibold text-rose-400 hover:bg-rose-500/10 transition-colors cursor-pointer focus:outline-none focus-visible:ring-1 focus-visible:ring-rose-400">
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
  <!-- MAIN DASHBOARD CONTENT -->
  <!-- ========================================================================= -->
  <main id="konten" class="flex-1 max-w-7xl w-full mx-auto px-6 lg:px-12 py-8 sm:py-12 space-y-8">

    <!-- Flash Messages -->
    @if (session('status'))
      <div class="flash p-4 rounded-xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-200 text-xs font-medium flex items-center gap-2" role="status">
        <svg class="w-4 h-4 text-emerald-400 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
        </svg>
        <span>{{ session('status') }}</span>
      </div>
    @endif

    @error('adoption')
      <div class="error-box p-4 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-200 text-xs font-medium" role="alert">
        {{ $message }}
      </div>
    @enderror

    <!-- ======================================================================= -->
    <!-- DASHBOARD HEADER -->
    <!-- ======================================================================= -->
    <div class="dash-head flex flex-col md:flex-row md:items-end justify-between gap-4 pb-6 border-b border-brand-line">
      <div class="dash-title space-y-2">
        <div class="flex items-center gap-2.5">
          <span class="text-xs font-bold uppercase tracking-wider text-purple-400">
            {{ $isStaff ? 'Panel Staff Shelter' : 'Dashboard Adopter' }}
          </span>
          <span class="text-slate-600">•</span>
          <span class="chip text-xs px-2.5 py-0.5 rounded-full bg-white/5 border border-white/10 text-slate-300 font-medium">
            {{ $total }} pengajuan tercatat
          </span>
        </div>
        <h1 class="font-display font-bold text-3xl sm:text-4xl text-white tracking-tight">
          {{ $isStaff ? 'Pengajuan Adopsi Masuk' : 'Pengajuan Adopsi Saya' }}
        </h1>
        <p class="text-xs text-slate-400 max-w-xl">
          {{ $isStaff ? 'Kelola dan verifikasi data calon adopter kampus secara transparan dan menyeluruh.' : 'Pantau perkembangan status pengajuan adopsi kucing Anda hingga resmi diserahkan.' }}
        </p>
      </div>

      <div class="dash-actions flex items-center gap-3">
        <span class="role-label hidden lg:inline text-xs font-medium text-slate-400">
          {{ $isStaff ? 'Panel Staff Shelter' : 'Dashboard Adopter' }}
        </span>
        <a class="btn btn-dark px-4 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-white text-xs font-semibold transition-colors flex items-center gap-2 cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple" href="{{ route('cats.index') }}">
          <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
          </svg>
          <span>Lihat Katalog</span>
        </a>
      </div>
    </div>

    <!-- ======================================================================= -->
    <!-- BENTO METRICS CARDS -->
    <!-- ======================================================================= -->
    <section class="card metrics grid grid-cols-1 sm:grid-cols-3 gap-4" aria-label="Ringkasan pengajuan">
      <!-- Metric 1: Total -->
      <div class="metric p-6 rounded-2xl bg-[#12141F] border border-brand-line flex flex-col justify-between space-y-4">
        <div>
          <span class="text-xs font-medium text-slate-400 block">{{ $isStaff ? 'Total pengajuan masuk' : 'Total pengajuan saya' }}</span>
          <strong class="font-display font-bold text-3xl sm:text-4xl text-white mt-2 block">{{ $total }}</strong>
        </div>
        <small class="text-xs text-slate-400 block">{{ $isStaff ? 'dari seluruh adopter kampus' : 'riwayat pengajuan adopsi' }}</small>
      </div>

      <!-- Metric 2: Pending -->
      <div class="metric p-6 rounded-2xl bg-[#12141F] border border-brand-line flex flex-col justify-between space-y-4">
        <div>
          <span class="text-xs font-medium text-slate-400 block">Menunggu konfirmasi</span>
          <strong class="font-display font-bold text-3xl sm:text-4xl text-amber-400 mt-2 block">{{ $pendingCount }}</strong>
        </div>
        <small class="text-xs text-slate-400 block">{{ $isStaff ? 'sedang diajukan adopter' : 'siap dikonfirmasi atau diedit' }}</small>
      </div>

      <!-- Metric 3: Done -->
      <div class="metric p-6 rounded-2xl bg-[#12141F] border border-brand-line flex flex-col justify-between space-y-4">
        <div>
          <span class="text-xs font-medium text-slate-400 block">{{ $isStaff ? 'Resmi teradopsi' : 'Kucing saya adopsi' }}</span>
          <strong class="font-display font-bold text-3xl sm:text-4xl text-brand-green mt-2 block">{{ $doneCount }}</strong>
        </div>
        <div>
          <div class="rail w-full bg-white/10 h-1.5 rounded-full overflow-hidden" aria-hidden="true" title="Rasio selesai">
            <i class="block bg-brand-green h-full rounded-full transition-all duration-500" style="--p: {{ $pct }}%; width: {{ $pct }}%;"></i>
          </div>
          <small class="text-xs text-slate-400 mt-2 block">{{ $pct }}% pengajuan selesai</small>
        </div>
      </div>
    </section>

    <!-- ======================================================================= -->
    <!-- TABLE CARD -->
    <!-- ======================================================================= -->
    <section class="card table-card rounded-2xl bg-[#12141F] border border-brand-line overflow-hidden shadow-2xl" aria-labelledby="pengajuan-title">
      <!-- Card Head -->
      <div class="card-head p-6 border-b border-brand-line flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-[#161926]">
        <div>
          <h2 id="pengajuan-title" class="font-display font-bold text-lg text-white">
            {{ $isStaff ? 'Daftar pengajuan adopter' : 'Daftar pengajuan saya' }}
          </h2>
          <span class="muted text-xs text-slate-400">
            {{ $pendingCount }} menunggu konfirmasi &middot; {{ $doneCount }} selesai
          </span>
        </div>
        <div class="text-xs text-slate-400 font-medium">
          Pembaruan Real-Time
        </div>
      </div>

      @if ($adoptions->isEmpty())
        <!-- Empty State -->
        <div class="empty text-center py-20 px-6 space-y-4">
          <div class="w-16 h-16 rounded-2xl bg-[#161926] border border-white/10 text-brand-purple flex items-center justify-center mx-auto">
            <svg viewBox="0 0 100 100" class="w-8 h-8 fill-current" aria-hidden="true">
              <path d="M20 25 L40 50 L60 50 L80 25 L80 75 Q80 85 70 85 L30 85 Q20 85 20 75 Z" />
            </svg>
          </div>
          <div class="space-y-1">
            <h2 class="font-display font-bold text-lg text-white">Belum ada pengajuan</h2>
            @can('staff')
              <p class="text-xs text-slate-400 max-w-sm mx-auto">Pengajuan dari adopter kampus akan langsung muncul di panel ini.</p>
            @else
              <p class="text-xs text-slate-400 max-w-sm mx-auto">Pilih kucing di katalog, buka detailnya, lalu ajukan adopsi.</p>
              <div class="pt-3">
                <a class="btn btn-dark inline-block px-5 py-2.5 rounded-xl bg-brand-pink hover:bg-brand-pink-hover text-white font-semibold text-xs transition-colors shadow-md cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-pink" href="{{ route('cats.index') }}">
                  Lihat Katalog
                </a>
              </div>
            @endcan
          </div>
        </div>
      @else
        <!-- Responsive Table -->
        <div class="overflow-x-auto">
          <table class="table w-full text-left border-collapse">
            <thead>
              <tr class="border-b border-brand-line bg-[#161926]/60 text-[11px] font-semibold text-slate-400 uppercase tracking-wider">
                <th scope="col" class="py-3.5 px-6">Kucing</th>
                @can('staff')
                  <th scope="col" class="py-3.5 px-6">Pengaju</th>
                @endcan
                <th scope="col" class="hide-sm py-3.5 px-6 hidden sm:table-cell">Hunian</th>
                <th scope="col" class="py-3.5 px-6">Pengalaman</th>
                <th scope="col" class="py-3.5 px-6">Status</th>
                <th scope="col" class="py-3.5 px-6 text-right"><span class="sr-only">Aksi</span></th>
              </tr>
            </thead>
            <tbody class="divide-y divide-brand-line text-xs">
              @foreach ($adoptions as $adoption)
                <tr class="hover:bg-white/[0.02] transition-colors">
                  <!-- Kucing Column with Photo Thumbnail -->
                  <td class="py-4 px-6">
                    <div class="flex items-center gap-3">
                      <div class="w-11 h-11 rounded-xl overflow-hidden bg-[#1A1D2D] border border-brand-line shrink-0 flex items-center justify-center">
                        @if ($adoption->cat->image_url)
                          <img src="{{ $adoption->cat->image_url }}" alt="{{ $adoption->cat->name }}" width="44" height="44" class="w-full h-full object-cover">
                        @else
                          <div class="w-6 h-6 text-brand-purple">
                            <svg viewBox="0 0 100 100" class="w-full h-full fill-current" aria-hidden="true">
                              <path d="M20 25 L40 50 L60 50 L80 25 L80 75 Q80 85 70 85 L30 85 Q20 85 20 75 Z" />
                            </svg>
                          </div>
                        @endif
                      </div>
                      <div class="space-y-0.5">
                        <span class="cat-name font-display font-bold text-white text-sm block">
                          {{ $adoption->cat->name }}
                        </span>
                        <span class="cat-place text-[11px] text-slate-400 block truncate max-w-xs">
                          {{ $adoption->address }}
                        </span>
                      </div>
                    </div>
                  </td>

                  <!-- Pengaju Column (Staff Only) -->
                  @can('staff')
                    <td class="py-4 px-6">
                      <div class="space-y-0.5">
                        <span class="cat-name font-semibold text-white block">{{ $adoption->user->name }}</span>
                        <span class="cat-place text-[11px] text-purple-300 block">{{ $adoption->user->email }}</span>
                      </div>
                    </td>
                  @endcan

                  <!-- Hunian Column -->
                  <td class="hide-sm py-4 px-6 hidden sm:table-cell">
                    <div class="space-y-1">
                      <span class="text-slate-200 block font-medium">{{ $adoption->housing_type }}</span>
                      @if ($adoption->indoor)
                        <span class="inline-block text-[10px] px-1.5 py-0.5 rounded bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 font-medium">
                          Indoor
                        </span>
                      @endif
                    </div>
                  </td>

                  <!-- Pengalaman Column -->
                  <td class="py-4 px-6">
                    <div class="space-y-1">
                      <span class="text-slate-300 block">{{ $adoption->experience }}</span>
                      @if ($adoption->cost_commitment)
                        <span class="inline-block text-[10px] px-1.5 py-0.5 rounded bg-purple-500/10 text-purple-300 border border-purple-500/20 font-medium">
                          Komitmen Pakan & Vaksin
                        </span>
                      @endif
                    </div>
                  </td>

                  <!-- Status Column -->
                  <td class="py-4 px-6">
                    @if ($adoption->isPending())
                      <span class="badge badge-warn inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-amber-500/10 text-amber-400 border border-amber-500/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400 animate-pulse"></span>
                        {{ $adoption->status }}
                      </span>
                    @else
                      <span class="badge badge-ok inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-[11px] font-semibold bg-emerald-500/10 text-brand-green border border-emerald-500/30">
                        <span class="w-1.5 h-1.5 rounded-full bg-brand-green"></span>
                        {{ $adoption->status }}
                      </span>
                    @endif
                  </td>

                  <!-- Aksi Column (Preserves all Dusk selectors) -->
                  <td class="py-4 px-6 text-right">
                    @if ($adoption->isPending() && Gate::allows('adopter'))
                      <div class="row-actions inline-flex items-center justify-end gap-2">
                        <!-- Three-dot Menu Wrap -->
                        <div class="menu-wrap relative">
                          <button 
                            type="button" 
                            class="icon-btn min-w-[44px] min-h-[44px] p-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-slate-300 hover:text-white transition-colors border border-white/5 flex items-center justify-center cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple" 
                            aria-label="Aksi pengajuan" 
                            aria-expanded="false" 
                            aria-controls="aksi-menu-{{ $adoption->id }}" 
                            data-menu-toggle
                          >
                            <svg class="w-4 h-4" viewBox="0 0 24 24" aria-hidden="true">
                              <circle cx="5" cy="12" r="2" fill="currentColor"/>
                              <circle cx="12" cy="12" r="2" fill="currentColor"/>
                              <circle cx="19" cy="12" r="2" fill="currentColor"/>
                            </svg>
                          </button>
                          <!-- Dropdown Menu -->
                          <div 
                            class="menu aksi-menu absolute right-0 mt-1 w-44 rounded-xl bg-[#1A1D2D] border border-white/15 shadow-2xl py-1.5 z-30" 
                            id="aksi-menu-{{ $adoption->id }}" 
                            hidden
                          >
                            <a class="menu-item block px-3.5 py-2 text-xs font-medium text-slate-200 hover:bg-white/10 hover:text-white transition-colors text-left focus:outline-none focus-visible:bg-white/10" href="{{ route('adoptions.edit', $adoption) }}">
                              Edit Pengajuan
                            </a>
                          </div>
                        </div>

                        <!-- Confirm Adoption Button -->
                        <button 
                          type="button" 
                          class="icon-btn min-w-[44px] min-h-[44px] p-2.5 rounded-xl bg-brand-green/10 hover:bg-brand-green/20 text-brand-green border border-brand-green/30 transition-colors shadow-sm cursor-pointer flex items-center justify-center focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-green" 
                          aria-label="Konfirmasi adopsi" 
                          title="Konfirmasi adopsi" 
                          data-confirm-url="{{ route('adoptions.confirm', $adoption) }}" 
                          data-confirm-cat="{{ $adoption->cat->name }}"
                        >
                          <svg class="w-4 h-4" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M3 11l9-7 9 7v9a1 1 0 0 1-1 1h-5v-6h-6v6H4a1 1 0 0 1-1-1z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
                          </svg>
                        </button>
                      </div>
                    @endif
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      @endif
    </section>

  </main>

  <!-- ========================================================================= -->
  <!-- SEMANTIC LANDMARK FOOTER -->
  <!-- ========================================================================= -->
  <footer class="w-full border-t border-brand-line bg-[#0D0E15] py-6 text-center text-xs text-slate-400">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 flex flex-col sm:flex-row items-center justify-between gap-3">
      <span>EISD Meowdopt • Shelter Kucing Kampus</span>
      <span>Platform Pengelolaan & Adopsi Satwa</span>
    </div>
  </footer>

  <!-- ========================================================================= -->
  <!-- MODAL KONFIRMASI ADOPSI (Preserves Dusk Contract) -->
  <!-- ========================================================================= -->
  @can('adopter')
    <dialog class="modal fixed inset-0 m-auto rounded-2xl bg-[#161926] border border-white/15 shadow-2xl p-0 backdrop:bg-black/75 backdrop:backdrop-blur-sm max-w-md w-full" id="modal-confirm" aria-labelledby="modal-title" aria-describedby="modal-desc">
      <form class="modal-card p-6 sm:p-8 space-y-5" method="POST" action="">
        @csrf
        <div class="modal-head flex items-center justify-between">
          <span class="modal-icon w-11 h-11 rounded-xl bg-brand-green/10 border border-brand-green/30 text-brand-green flex items-center justify-center" aria-hidden="true">
            <svg class="w-5 h-5" viewBox="0 0 24 24">
              <path d="M3 11l9-7 9 7v9a1 1 0 0 1-1 1h-5v-6h-6v6H4a1 1 0 0 1-1-1z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/>
            </svg>
          </span>
          <span class="chip chip-sunk px-3 py-1 rounded-full bg-white/5 border border-white/10 text-xs font-semibold text-slate-300">
            Komitmen Adopter
          </span>
        </div>
        <div class="space-y-2">
          <h2 id="modal-title" class="font-display font-bold text-xl sm:text-2xl text-white">
            Konfirmasi Adopsi <span data-cat-name>Kucing</span>
          </h2>
          <p id="modal-desc" class="muted text-xs text-slate-300 leading-relaxed">
            Yakin kamu siap bertanggung jawab penuh merawat <strong class="text-white" data-cat-name>kucing ini</strong> seumur hidupnya? Setelah dikonfirmasi, kucing resmi menjadi tanggung jawabmu dan keluar dari katalog.
          </p>
        </div>
        <div class="modal-actions pt-2 flex items-center justify-end gap-3">
          <button type="button" class="btn btn-ghost px-4 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 text-slate-300 text-xs font-semibold transition-colors cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple" data-modal-close>
            Batal
          </button>
          <button type="submit" class="btn btn-dark px-5 py-2.5 rounded-xl bg-brand-green hover:bg-emerald-400 text-[#0D0E15] text-xs font-bold shadow-lg transition-colors cursor-pointer focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-green">
            Ya, Saya Siap
          </button>
        </div>
      </form>
    </dialog>
  @endcan

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
