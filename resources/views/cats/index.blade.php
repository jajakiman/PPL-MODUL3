<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0D0E15]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EISD Meowdopt - Katalog Kucing Adopsi</title>
  <link rel="icon" type="image/png" href="{{ asset('images/Vertical Logo 5.png') }}">
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Google Fonts: Bricolage Grotesque (display) & Plus Jakarta Sans (body) -->
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
  <style>
    * {
      scroll-behavior: smooth;
    }
    .custom-scrollbar::-webkit-scrollbar {
      height: 6px;
      width: 6px;
    }
    .custom-scrollbar::-webkit-scrollbar-thumb {
      background: #2a2e44;
      border-radius: 4px;
    }
    .hero-spotlight {
      background: radial-gradient(circle at 40% 40%, rgba(73, 76, 160, 0.35) 0%, rgba(18, 20, 31, 0.95) 70%);
    }
  </style>
</head>
<body class="min-h-full w-full flex flex-col font-sans text-slate-100 bg-[#0D0E15] antialiased selection:bg-brand-purple selection:text-white overflow-x-hidden">

  @php
    $total = $cats->count();
    $vaccinated = $cats->where('vaccinated', true)->count();
    $pctVac = $total ? round($vaccinated / $total * 100) : 0;
    $isStaff = auth()->check() && auth()->user()->isStaff();
  @endphp

  <!-- ========================================================================= -->
  <!-- FLOATING MINIMALIST TOPBAR (Floating Pill Over Full-Bleed Canvas) -->
  <!-- ========================================================================= -->
  @include('partials.navbar')

  <section class="w-full border-b border-white/10 bg-[#12141F] hero-spotlight mt-3.5">
    <div class="max-w-7xl mx-auto px-6 lg:px-12 py-10 lg:py-14 grid grid-cols-1 lg:grid-cols-12 gap-10 items-stretch">

      <div class="lg:col-span-7 flex flex-col justify-center gap-8">
        <div class="space-y-5">
          <div class="flex flex-wrap items-center gap-2 text-xs font-semibold text-slate-300">
            <span class="px-2.5 py-0.5 rounded-full bg-brand-purple/40 border border-brand-purple/50 text-purple-100">EISD Meowdopt</span>
            <span>Portal Adopsi Kucing Bandung</span>
          </div>

          <!-- Contains exact string "Katalog Kucing Adopsi" for Dusk assertSee -->
          <h1 class="font-display font-bold text-4xl sm:text-5xl xl:text-6xl text-white tracking-tight leading-[1.05]">
            Katalog Kucing Adopsi
          </h1>

          <p class="text-base sm:text-lg text-slate-300 leading-relaxed max-w-xl">
            Pilih kucing dari berbagai daerah di Bandung yang cocok dengan tempat tinggalmu, lalu ajukan adopsi langsung dari kartunya.
          </p>
        </div>

        <div class="flex flex-wrap items-center gap-4">
          @can('staff')
            <a href="{{ route('cats.create') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-full bg-brand-pink hover:bg-brand-pink-hover text-white text-xs font-bold transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-white/60">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
              </svg>
              <span>Tambah Kucing Baru</span>
            </a>
          @endcan
          <a href="#katalog-grid-section" class="inline-flex items-center px-5 py-3 rounded-xl bg-white/10 hover:bg-white/15 text-white text-xs font-semibold transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple">
            Lihat {{ $total }} kucing tersedia
          </a>
        </div>
      </div>

      <div class="lg:col-span-5 grid grid-cols-2 gap-px rounded-2xl border border-white/10 bg-white/10 overflow-hidden [&>*]:bg-[#0F111A]">
        <div class="p-6 lg:p-8 flex flex-col justify-between gap-6 min-h-[10rem]">
          <span class="text-xs font-medium text-slate-400">Menunggu adopsi</span>
          <div>
            <span class="font-display font-bold text-3xl text-white block">{{ $total }} kucing</span>
            <span class="text-xs text-purple-300 mt-1 block">Siap kamu adopsi</span>
          </div>
        </div>

        <div class="p-6 lg:p-8 flex flex-col justify-between gap-6 min-h-[10rem]">
          <span class="text-xs font-medium text-slate-400">Status vaksinasi</span>
          <div class="space-y-2">
            <span class="font-display font-bold text-3xl text-white block">{{ $vaccinated }} dari {{ $total }}</span>
            <div class="w-full bg-white/10 h-1.5 rounded-full overflow-hidden" aria-hidden="true">
              <div class="bg-brand-green h-full rounded-full" style="width: {{ $pctVac }}%"></div>
            </div>
            <span class="text-xs text-slate-400 block">{{ $pctVac }}% sudah divaksin</span>
          </div>
        </div>

        <div class="p-6 lg:p-8 flex flex-col justify-between gap-6 min-h-[10rem]">
          <span class="text-xs font-medium text-slate-400">Terakhir ditemukan</span>
          <div>
            <span class="font-display font-bold text-lg text-white block">{{ $cats->first()?->found_at ?? '-' }}</span>
            <span class="text-xs text-slate-400 mt-1 block">{{ $cats->first() ? 'Kucing "' . $cats->first()->name . '"' : 'Belum ada kucing' }}</span>
          </div>
        </div>

        <div class="p-6 lg:p-8 flex flex-col justify-between gap-6 min-h-[10rem]">
          <span class="text-xs font-medium text-slate-400">{{ $isStaff ? 'Total adopsi' : 'Adopsi saya' }}</span>
          <div>
            <span class="font-display font-bold text-3xl text-white block">{{ $mine }}</span>
            <a href="{{ route('adoptions.index') }}" class="text-xs text-purple-300 hover:text-white underline underline-offset-4 mt-1 inline-block rounded focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple">
              {{ $isStaff ? 'Lihat pengajuan masuk' : 'Lihat pengajuan saya' }}
            </a>
          </div>
        </div>
      </div>

    </div>
  </section>

  <!-- ========================================================================= -->
  <!-- 100% FULL-BLEED TOOLBAR (No Side Margins, Flushed with Browser Viewport) -->
  <!-- ========================================================================= -->
  <section class="w-full border-b border-white/10 bg-[#0E1018] px-6 lg:px-[max(3rem,calc((100%-80rem)/2+3rem))] py-4 flex flex-col md:flex-row md:items-center justify-between gap-4">
    
    <!-- Breed Selector Chips -->
    <div class="flex items-center gap-2 overflow-x-auto pb-1 md:pb-0">
      <span class="text-xs font-bold uppercase tracking-wider text-slate-400 mr-2 hidden sm:inline">Pilih Ras:</span>
      <button type="button" onclick="setBreedFilter('All')" class="breed-filter-btn px-4 py-2 rounded-xl text-xs font-semibold bg-brand-purple text-white shadow-sm transition-colors" data-breed="All">
        Semua Ras
      </button>
      @foreach (\App\Models\Cat::BREEDS as $breed)
        <button type="button" onclick="setBreedFilter('{{ $breed }}')" class="breed-filter-btn px-4 py-2 rounded-xl text-xs font-medium text-slate-300 hover:text-white hover:bg-white/10 transition-colors" data-breed="{{ $breed }}">
          {{ $breed }}
        </button>
      @endforeach
    </div>

    <!-- Search Field (Clean & High Contrast) -->
    <div class="relative w-full md:w-80">
      <label for="search-input" class="sr-only">Cari kucing</label>
      <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
        </svg>
      </div>
      <input type="text" id="search-input" onkeyup="filterCards()" placeholder="Cari nama atau lokasi temuan..." class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-white/15 bg-[#181B28] text-xs text-white placeholder:text-slate-400 focus:bg-[#202436] focus:outline-none focus:ring-2 focus:ring-brand-purple transition-all">
    </div>

  </section>

  <!-- ========================================================================= -->
  <!-- 100% FULL-BLEED MONOLITHIC CATALOG GRID (Swiss Style, Edge-to-Edge) -->
  <!-- ========================================================================= -->
  <section id="katalog-grid-section" class="w-full flex-1 flex flex-col justify-between">
    
    <!-- Header of the Grid -->
    <div class="w-full px-6 lg:px-[max(3rem,calc((100%-80rem)/2+3rem))] py-6 border-b border-white/10 flex items-center justify-between bg-[#12141F]">
      <div>
        <h2 class="font-display font-bold text-2xl sm:text-3xl text-white">
          Daftar Kucing Tersedia
        </h2>
        <p class="text-xs text-slate-400 mt-1">Pilih kucing yang ingin kamu kenal lebih dekat sebelum mengajukan adopsi</p>
      </div>
      <span class="text-xs font-semibold text-slate-300 bg-[#1A1D2D] border border-white/15 px-4 py-2 rounded-full">
        Menampilkan <strong id="count-visible" class="text-white font-bold">{{ $total }}</strong> Kucing
      </span>
    </div>

    <!-- Edge-to-Edge 4 Column Monolithic Grid (NO Blank Gutters!) -->
    <div id="cat-grid" class="w-full grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 divide-y md:divide-y-0 md:divide-x divide-white/10 bg-[#0F111A]">

      @forelse ($cats as $cat)
        <article id="cat-card-{{ $cat->id }}" data-cat-name="{{ $cat->name }}" data-breed="{{ $cat->breed }}" class="cat-card p-8 lg:p-10 flex flex-col justify-between space-y-8 bg-[#12141F] hover:bg-[#181B2A] transition-colors">
          <div class="space-y-5">
            <!-- Top Tag Row: Index & Actions -->
            <div class="flex items-center justify-between">
              <span class="px-2.5 py-0.5 rounded-md text-[11px] font-semibold bg-brand-purple/30 border border-brand-purple/40 text-purple-100">
                {{ $cat->breed }}
              </span>
              <div class="flex items-center gap-2">
                <span class="px-2.5 py-0.5 rounded text-[10px] font-bold bg-brand-green text-slate-950">
                  Siap Adopsi
                </span>
                
                @can('staff')
                <div class="relative">
                  <button type="button" id="aksi-{{ $cat->id }}" aria-label="Aksi kucing" onclick="toggleActionMenu({{ $cat->id }})" class="p-1.5 text-slate-400 hover:text-white rounded focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                      <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01" />
                    </svg>
                  </button>
                  <div id="menu-aksi-{{ $cat->id }}" class="aksi-menu hidden absolute right-0 mt-1 w-32 bg-[#1A1D2D] rounded-xl border border-white/15 shadow-2xl py-1 z-30">
                      <a href="{{ route('cats.edit', $cat) }}" class="block px-3 py-1.5 text-xs font-semibold text-slate-300 hover:bg-white/10 hover:text-white">
                        Edit
                      </a>
                      <form method="POST" action="{{ route('cats.destroy', $cat) }}" data-confirm="Hapus {{ $cat->name }} dari katalog?" onsubmit="return confirm('Hapus {{ $cat->name }} dari katalog?');" class="px-1 py-0.5">
                        @csrf
                        @method('DELETE')
                        <button type="submit" aria-label="Hapus kucing" class="w-full text-left px-2 py-1 rounded text-xs font-semibold text-rose-400 hover:bg-rose-500/10 transition-colors">
                          Hapus
                        </button>
                      </form>
                  </div>
                </div>
                @endcan
              </div>
            </div>

            <!-- Cat Photo Frame / Silhouette Avatar -->
            <div class="relative h-64 bg-gradient-to-br from-[#1A1D2D] to-[#12141F] overflow-hidden rounded-2xl border border-white/10 flex items-center justify-center group">
              @if ($cat->image_url)
                <img src="{{ $cat->image_url }}" alt="{{ $cat->name }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
              @else
                <div class="w-20 h-20 text-brand-purple/70 transition-transform group-hover:scale-110 duration-300">
                  <svg viewBox="0 0 100 100" class="w-full h-full fill-current drop-shadow-md">
                    <path d="M20 25 L40 50 L60 50 L80 25 L80 75 Q80 85 70 85 L30 85 Q20 85 20 75 Z" />
                  </svg>
                </div>
              @endif
            </div>

            <!-- Cat Typography & Info -->
            <div class="space-y-2.5">
              <div class="flex items-baseline justify-between">
                <h3 class="cat-name font-display font-bold text-2xl text-white">{{ $cat->name }}</h3>
                <span class="text-xs text-slate-400 font-medium">{{ $cat->age }} Bulan</span>
              </div>
              <p class="text-xs text-slate-400 flex items-center gap-1.5">
                <svg class="w-3.5 h-3.5 text-slate-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span>{{ $cat->found_at }}</span>
              </p>

              <!-- Metadata Pairs -->
              <div class="pt-3 border-t border-white/10 grid grid-cols-2 gap-2 text-xs">
                <div>
                  <span class="text-slate-400 block text-[10px] uppercase">Sifat</span>
                  <span class="font-semibold text-purple-200">{{ $cat->temper }}</span>
                </div>
                <div>
                  <span class="text-slate-400 block text-[10px] uppercase">Vaksinasi</span>
                  <span class="font-semibold {{ $cat->vaccinated ? 'text-emerald-400' : 'text-rose-400' }}">
                    {{ $cat->vaccinated ? 'Sudah Vaksin' : 'Belum Vaksin' }}
                  </span>
                </div>
              </div>
            </div>
          </div>

          <!-- Bottom Action Button -->
          <div class="pt-2 flex flex-col gap-2">
            @can('adopter')
              <a href="{{ route('adoptions.create', ['cat' => $cat]) }}" class="w-full text-center py-3 rounded-xl bg-brand-pink hover:bg-brand-pink-hover text-white text-xs font-bold shadow-md transition-colors block">
                Ajukan Adopsi
              </a>
            @endcan
            <a href="{{ route('cats.show', $cat) }}" class="w-full text-center py-2.5 rounded-xl bg-white/10 hover:bg-white/15 text-white text-xs font-semibold transition-colors block">
              Detail
            </a>
          </div>
        </article>
      @empty
        <div class="col-span-full text-center py-24 bg-[#12141F]">
          <h4 class="font-display font-semibold text-white text-lg">Katalog masih kosong</h4>
          <p class="text-xs text-slate-400 mt-1 max-w-sm mx-auto">
            {{ $isStaff ? 'Semua kucing sudah diadopsi. Catat kucing baru yang ditemukan di Bandung.' : 'Semua kucing sudah menemukan rumah. Cek lagi nanti setelah shelter mencatat kucing baru.' }}
          </p>
          @can('staff')
            <a href="{{ route('cats.create') }}" class="mt-4 inline-block px-5 py-2.5 rounded-xl bg-brand-pink text-xs font-semibold text-white shadow-md">
              Tambah Kucing
            </a>
          @endcan
        </div>
      @endforelse

    </div>

    <!-- Empty State for JS Filtering -->
    <div id="empty-state" class="hidden text-center py-20 bg-[#12141F] border-t border-white/10">
      <h4 class="font-display font-semibold text-white text-base">Tidak ada kucing yang sesuai</h4>
      <p class="text-xs text-slate-400 mt-1">Coba sesuaikan kata kunci pencarian atau ganti filter ras.</p>
      <button type="button" onclick="setBreedFilter('All'); document.getElementById('search-input').value=''; filterCards();" class="mt-4 px-5 py-2.5 rounded-xl bg-white/10 hover:bg-white/20 text-xs font-semibold text-white transition-colors">
        Reset Filter
      </button>
    </div>

  </section>

  <!-- Clean Full-Bleed Edge-to-Edge Footer -->
  <footer class="w-full border-t border-white/10 bg-[#0A0B10] px-6 lg:px-[max(3rem,calc((100%-80rem)/2+3rem))] py-8">
    <div class="w-full flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
      <div class="flex flex-wrap items-center gap-2">
        <span class="font-display font-bold text-white">EISD Meowdopt</span>
        <span>· Laboratorium EISD</span>
        <span>· Praktikum PPL 2026</span>
      </div>
      <span>Portal adopsi kucing daerah Bandung</span>
    </div>
  </footer>

  <!-- Interactivity Scripts: Dropdown, Filter -->
  <script>
    let activeBreedFilter = 'All';

    function toggleUserDropdown() {
      const dropdown = document.getElementById('user-dropdown');
      if (dropdown) dropdown.classList.toggle('hidden');
    }

    function toggleActionMenu(catId) {
      const targetMenu = document.getElementById(`menu-aksi-${catId}`);
      document.querySelectorAll('.aksi-menu').forEach(menu => {
        if (menu !== targetMenu) menu.classList.add('hidden');
      });
      if (targetMenu) targetMenu.classList.toggle('hidden');
    }

    document.addEventListener('click', function (e) {
      const userBtn = document.getElementById('user-menu-button');
      const userDropdown = document.getElementById('user-dropdown');
      if (userBtn && userDropdown && !userBtn.contains(e.target) && !userDropdown.contains(e.target)) {
        userDropdown.classList.add('hidden');
      }

      if (!e.target.closest('[aria-label="Aksi kucing"]') && !e.target.closest('.aksi-menu')) {
        document.querySelectorAll('.aksi-menu').forEach(menu => menu.classList.add('hidden'));
      }
    });

    // Breed Filter Function
    function setBreedFilter(breed) {
      activeBreedFilter = breed;
      
      document.querySelectorAll('.breed-filter-btn').forEach(btn => {
        const isSelected = btn.getAttribute('data-breed') === breed;
        if (isSelected) {
          btn.className = 'breed-filter-btn px-4 py-2 rounded-xl text-xs font-semibold bg-brand-purple text-white shadow-sm transition-colors';
        } else {
          btn.className = 'breed-filter-btn px-4 py-2 rounded-xl text-xs font-medium text-slate-300 hover:text-white hover:bg-white/10 transition-colors';
        }
      });

      filterCards();
    }

    function filterCards() {
      const searchVal = document.getElementById('search-input').value.toLowerCase().trim();
      const cards = document.querySelectorAll('.cat-card');
      let visibleCount = 0;

      cards.forEach(card => {
        const catName = card.getAttribute('data-cat-name').toLowerCase();
        const breed = card.getAttribute('data-breed');
        const textContent = card.innerText.toLowerCase();

        const matchesBreed = (activeBreedFilter === 'All' || breed === activeBreedFilter);
        const matchesSearch = textContent.includes(searchVal);

        if (matchesBreed && matchesSearch) {
          card.classList.remove('hidden');
          visibleCount++;
        } else {
          card.classList.add('hidden');
        }
      });

      const emptyState = document.getElementById('empty-state');
      if (emptyState) {
        if (visibleCount === 0 && cards.length > 0) {
          emptyState.classList.remove('hidden');
        } else {
          emptyState.classList.add('hidden');
        }
      }

      const countEl = document.getElementById('count-visible');
      if (countEl) countEl.innerText = visibleCount;
    }
  </script>
</body>
</html>
