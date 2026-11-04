<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0D0E15]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ auth()->user()->isStaff() ? 'Pengajuan Masuk' : 'Pengajuan Saya' }} | EISD Meowdopt</title>
  <link rel="icon" type="image/png" href="{{ asset('images/Vertical Logo 5.png') }}">
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Google Fonts: Bricolage Grotesque & Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bricolage+Grotesque:opsz,wght@12..96,600..800&family=Plus+Jakarta+Sans:wght@400;500;600;700&display=swap" rel="stylesheet">
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: {
            sans: ['"Plus Jakarta Sans"', 'sans-serif'],
            display: ['"Bricolage Grotesque"', 'sans-serif']
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
    $indoorCount = $adoptions->where('indoor', true)->count();
    $vaccinatedCount = $adoptions->filter(fn ($a) => $a->cat->vaccinated)->count();
    $pct = $total ? round($vaccinatedCount / $total * 100) : 0;
  @endphp

  <!-- ========================================================================= -->
  <!-- TOPBAR -->
  <!-- ========================================================================= -->
  @include('partials.navbar')

  <!-- ========================================================================= -->
  <!-- MAIN DASHBOARD CONTENT -->
  <!-- ========================================================================= -->
  <main id="konten" class="flex-1 max-w-7xl w-full mx-auto px-6 lg:px-12 py-8 sm:py-12 space-y-8">

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
          {{ $isStaff ? 'Kelola dan verifikasi data calon adopter Bandung.' : 'Pantau dan kelola daftar pengajuan adopsi kucing yang sudah kamu kirim.' }}
        </p>
      </div>

      <div class="dash-actions flex items-center gap-3">
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
        <small class="text-xs text-slate-400 block">{{ $isStaff ? 'dari seluruh adopter Bandung' : 'riwayat pengajuan adopsi' }}</small>
      </div>

      <!-- Metric 2: Indoor -->
      <div class="metric p-6 rounded-2xl bg-[#12141F] border border-brand-line flex flex-col justify-between space-y-4">
        <div>
          <span class="text-xs font-medium text-slate-400 block">Perawatan indoor</span>
          <strong class="font-display font-bold text-3xl sm:text-4xl text-white mt-2 block">{{ $indoorCount }}</strong>
        </div>
        <small class="text-xs text-slate-400 block">kucing dirawat di dalam ruangan</small>
      </div>

      <!-- Metric 3: Vaccinated -->
      <div class="metric p-6 rounded-2xl bg-[#12141F] border border-brand-line flex flex-col justify-between space-y-4">
        <div>
          <span class="text-xs font-medium text-slate-400 block">Sudah divaksin</span>
          <strong class="font-display font-bold text-3xl sm:text-4xl text-brand-green mt-2 block">{{ $vaccinatedCount }} dari {{ $total }}</strong>
        </div>
        <div>
          <div class="rail w-full bg-white/10 h-1.5 rounded-full overflow-hidden" aria-hidden="true">
            <i class="block bg-brand-green h-full rounded-full" style="width: {{ $pct }}%;"></i>
          </div>
          <small class="text-xs text-slate-400 mt-2 block">kucing dengan vaksin lengkap</small>
        </div>
      </div>
    </section>

    <!-- ======================================================================= -->
    <!-- TABLE CARD -->
    <!-- ======================================================================= -->
    <section class="card table-card rounded-2xl bg-[#12141F] border border-brand-line" aria-labelledby="pengajuan-title">
      <!-- Card Head -->
      <div class="card-head p-6 rounded-t-2xl border-b border-brand-line flex flex-col sm:flex-row sm:items-center justify-between gap-2 bg-[#161926]">
        <div>
          <h2 id="pengajuan-title" class="font-display font-bold text-lg text-white">
            {{ $isStaff ? 'Daftar pengajuan adopter' : 'Daftar pengajuan saya' }}
          </h2>
          <span class="muted text-xs text-slate-400">
            {{ $total }} kucing tercatat dalam daftar {{ $isStaff ? 'adopsi' : 'adopsimu' }}
          </span>
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
              <p class="text-xs text-slate-400 max-w-sm mx-auto">Pengajuan dari adopter Bandung akan langsung muncul di panel ini.</p>
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
        <div class="overflow-x-auto sm:overflow-visible">
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
                        <span class="w-1.5 h-1.5 rounded-full bg-amber-400"></span>
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
                    @if (Gate::allows('adopter'))
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
                            class="menu aksi-menu absolute right-0 top-[calc(100%+0.5rem)] w-48 rounded-2xl bg-[#141519] border border-white/10 shadow-[0_16px_40px_rgba(0,0,0,0.65)] p-1.5 z-40" 
                            id="aksi-menu-{{ $adoption->id }}" 
                            hidden
                          >
                            <a class="menu-item flex items-center justify-between px-3 py-2.5 rounded-xl text-xs font-semibold text-slate-200 hover:bg-white/[0.06] hover:text-white transition-colors whitespace-nowrap focus:outline-none focus-visible:bg-white/10" href="{{ route('adoptions.edit', $adoption) }}">
                              <span>Edit Pengajuan</span>
                              <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" stroke-width="1.75" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                              </svg>
                            </a>
                          </div>
                        </div>

                        <!-- Delete Adoption (triggers custom UI modal) -->
                        <button 
                          type="button" 
                          onclick="openDeleteModal('{{ route('adoptions.destroy', $adoption) }}', '{{ e($adoption->cat->name) }}')"
                          class="icon-btn min-w-[44px] min-h-[44px] p-2.5 rounded-xl bg-rose-500/10 hover:bg-rose-500/20 text-rose-400 border border-rose-500/30 transition-colors shadow-sm cursor-pointer flex items-center justify-center focus:outline-none focus-visible:ring-2 focus-visible:ring-rose-400" 
                          aria-label="Hapus pengajuan" 
                          title="Hapus pengajuan"
                        >
                          <svg class="w-4 h-4" viewBox="0 0 24 24" aria-hidden="true">
                            <path d="M4 7h16M10 11v6M14 11v6M5 7l1 13a1 1 0 0 0 1 1h10a1 1 0 0 0 1-1l1-13M9 7V4h6v3" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
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
      <span>EISD Meowdopt • Portal Adopsi Kucing Bandung</span>
      <span>Temukan Teman Kucing di Daerah Bandung</span>
    </div>
  </footer>

  <!-- ========================================================================= -->
  <!-- DELETE CONFIRMATION MODAL WINDOW -->
  <!-- ========================================================================= -->
  <div id="delete-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/70 backdrop-blur-sm p-4" role="dialog" aria-modal="true" aria-labelledby="delete-modal-title" onclick="if (event.target === this) closeDeleteModal()">
    <div class="w-full max-w-md rounded-2xl bg-[#141519] border border-white/10 shadow-[0_24px_60px_rgba(0,0,0,0.75)] p-6 space-y-5">
      <div class="flex items-start gap-4">
        <div class="w-11 h-11 rounded-full bg-rose-500/15 border border-rose-500/30 text-rose-400 flex items-center justify-center shrink-0">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
          </svg>
        </div>
        <div class="space-y-1.5">
          <h3 id="delete-modal-title" class="font-display font-bold text-lg text-white">Hapus Pengajuan Adopsi?</h3>
          <p class="text-xs text-slate-400 leading-relaxed">
            Apakah kamu yakin ingin menghapus data adopsi kucing <strong id="delete-cat-name" class="text-white font-semibold"></strong>? Kucing akan kembali tersedia di katalog adopsi.
          </p>
        </div>
      </div>

      <form id="delete-adoption-form" method="POST" class="flex items-center justify-end gap-2.5 pt-2 border-t border-white/[0.08]">
        @csrf
        @method('DELETE')
        <button type="button" onclick="closeDeleteModal()" class="px-4 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-xs font-semibold text-slate-300 hover:text-white transition-colors cursor-pointer">
          Batal
        </button>
        <button type="submit" id="confirm-delete-btn" class="px-4 py-2.5 rounded-xl bg-rose-600 hover:bg-rose-700 text-xs font-semibold text-white shadow-lg shadow-rose-600/25 transition-colors cursor-pointer">
          Ya, Hapus
        </button>
      </form>
    </div>
  </div>

  <!-- ========================================================================= -->
  <!-- JAVASCRIPT: USER DROPDOWN & DELETE MODAL -->
  <!-- ========================================================================= -->
  <script>
    function toggleUserDropdown() {
      const dropdown = document.getElementById('user-dropdown');
      if (dropdown) {
        dropdown.classList.toggle('hidden');
      }
    }

    function openDeleteModal(actionUrl, catName) {
      const modal = document.getElementById('delete-modal');
      const form = document.getElementById('delete-adoption-form');
      const nameEl = document.getElementById('delete-cat-name');
      if (!modal || !form || !nameEl) return;
      form.action = actionUrl;
      nameEl.textContent = catName;
      modal.classList.remove('hidden');
      modal.classList.add('flex');
    }

    function closeDeleteModal() {
      const modal = document.getElementById('delete-modal');
      if (!modal) return;
      modal.classList.add('hidden');
      modal.classList.remove('flex');
    }

    document.addEventListener('keydown', function(e) {
      if (e.key === 'Escape') closeDeleteModal();
    });

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
