<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0D0E15]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>{{ $cat->name }} | EISD Meowdopt</title>
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
</head>

<body class="min-h-full flex flex-col font-sans text-slate-100 bg-[#0D0E15] antialiased selection:bg-brand-purple selection:text-white">
  @include('partials.navbar')

  <main id="konten" class="flex-1 w-full max-w-7xl mx-auto px-6 lg:px-12 py-8 sm:py-12 space-y-6">
    <a href="{{ route('cats.index') }}" class="back-link inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/10 text-xs font-semibold text-white transition-colors focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple">
      <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
      </svg>
      <span>Kembali ke katalog</span>
    </a>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
      <div class="lg:col-span-5 rounded-2xl border border-brand-line bg-[#161926] overflow-hidden aspect-[4/3] lg:aspect-auto lg:min-h-[26rem] flex items-center justify-center">
        @if ($cat->image_url)
          <img src="{{ $cat->image_url }}" alt="Foto kucing {{ $cat->name }}" class="w-full h-full object-cover">
        @else
          <svg viewBox="0 0 100 100" class="w-24 h-24 fill-current text-brand-purple/70" aria-hidden="true"><path d="M20 25 L40 50 L60 50 L80 25 L80 75 Q80 85 70 85 L30 85 Q20 85 20 75 Z" /></svg>
        @endif
      </div>

      <div class="lg:col-span-7 flex flex-col gap-6">
        <div class="space-y-3">
          <div class="flex items-center gap-2.5 flex-wrap text-xs">
            <span class="px-2.5 py-1 rounded-full font-semibold bg-brand-purple/30 border border-brand-purple/40 text-purple-100">{{ $cat->breed }}</span>
            <span class="px-2.5 py-1 rounded-full border font-semibold {{ $cat->vaccinated ? 'border-brand-green/40 text-brand-green' : 'border-white/15 text-slate-400' }}">{{ $cat->vaccinated ? 'Sudah Vaksin' : 'Belum Vaksin' }}</span>
          </div>
          <h1 class="font-display font-bold text-4xl sm:text-5xl text-white tracking-tight leading-tight">{{ $cat->name }}</h1>
          <p class="text-base text-slate-300">Ditemukan di {{ $cat->found_at }}</p>
        </div>

        <dl class="grid grid-cols-2 rounded-2xl border border-brand-line bg-[#12141F] divide-x divide-y divide-brand-line overflow-hidden">
          <div class="p-5"><dt class="text-sm text-slate-400">Ras</dt><dd class="mt-1 text-lg font-semibold text-white">{{ $cat->breed }}</dd></div>
          <div class="p-5"><dt class="text-sm text-slate-400">Sifat</dt><dd class="mt-1 text-lg font-semibold text-white">{{ $cat->temper }}</dd></div>
          <div class="p-5"><dt class="text-sm text-slate-400">Umur</dt><dd class="mt-1 text-lg font-semibold text-white">{{ $cat->age }} bulan</dd></div>
          <div class="p-5"><dt class="text-sm text-slate-400">Vaksin</dt><dd class="mt-1 text-lg font-semibold text-white">{{ $cat->vaccinated ? 'Sudah Vaksin' : 'Belum Vaksin' }}</dd></div>
        </dl>

        <div>
          @can('staff')
            <a href="{{ route('cats.edit', $cat) }}" class="btn inline-flex items-center px-6 py-3.5 rounded-xl bg-white/5 hover:bg-white/10 border border-white/15 text-white font-bold text-sm transition-colors">Edit</a>
          @else
            <a href="{{ route('adoptions.create', ['cat' => $cat]) }}" class="btn inline-flex items-center px-6 py-3.5 rounded-xl bg-brand-pink hover:bg-brand-pink-hover text-white font-bold text-sm transition-colors">Ajukan Adopsi</a>
          @endcan
        </div>
      </div>
    </div>
  </main>

  <script>
    function toggleUserDropdown() {
      document.getElementById('user-dropdown')?.classList.toggle('hidden');
    }
    document.addEventListener('click', function (e) {
      const btn = document.getElementById('user-menu-button');
      const dropdown = document.getElementById('user-dropdown');
      if (btn && dropdown && !btn.contains(e.target) && !dropdown.contains(e.target)) dropdown.classList.add('hidden');
    });
  </script>
</body>
</html>