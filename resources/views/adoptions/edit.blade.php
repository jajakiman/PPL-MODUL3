<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0D0E15]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pengajuan {{ $adoption->cat->name }} | EISD Meowdopt</title>
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

  <!-- ========================================================================= -->
  <!-- TOPBAR -->
  <!-- ========================================================================= -->
  @include('partials.navbar')

  <!-- ========================================================================= -->
  <!-- MAIN FULL-BLEED ARCHITECTURAL LAYOUT -->
  <!-- ========================================================================= -->
  <main id="konten" class="flex-1 w-full grid grid-cols-1 lg:grid-cols-12 divide-y lg:divide-y-0 lg:divide-x divide-brand-line">

    <!-- ======================================================================= -->
    <!-- SISI KIRI: NARRATIVE, CONTEXT & CAT PHOTO (5 Columns) -->
    <!-- ======================================================================= -->
    <div class="lg:col-span-5 p-6 sm:p-10 lg:p-14 lg:pl-[max(3rem,calc((100vw-80rem)/2+3rem))] flex flex-col justify-between space-y-8 bg-[#12141F]/40">
      <div class="space-y-6">

        <!-- Breed & Status Badge -->
        <div class="flex items-center gap-2.5 flex-wrap">
          <span class="px-2.5 py-0.5 rounded-full text-xs font-semibold bg-brand-purple/30 border border-brand-purple/40 text-purple-100">
            {{ $adoption->cat->breed }}
          </span>
          <span class="w-1.5 h-1.5 rounded-full bg-brand-green"></span>
          <span class="text-xs font-semibold text-brand-green">Status: {{ $adoption->status }}</span>
        </div>

        <!-- Headline & Narrative -->
        <div class="page-head space-y-2">
          <div>
            <h1 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-tight">
              Edit Pengajuan {{ $adoption->cat->name }}
            </h1>
            <p class="text-sm text-slate-300 leading-relaxed mt-2">
              Perbarui alamat tempat tinggal, tipe hunian, atau pengalaman merawat kucingmu.
            </p>
          </div>
        </div>

        <!-- ===================================================================== -->
        <!-- CAT PHOTO FRAME & QUICK STATS -->
        <!-- ===================================================================== -->
        <div class="rounded-2xl border border-brand-line bg-[#161926] overflow-hidden">
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
              <span class="text-xs px-2.5 py-1 rounded-full bg-[#0D0E15]/85 border border-white/20 font-medium">
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
            Perubahan yang kamu simpan akan langsung memperbarui data pengajuan adopsi untuk {{ $adoption->cat->name }}.
          </p>
        </div>

      </div>

      <!-- Footer Info -->
      <div class="pt-6 border-t border-brand-line flex flex-wrap items-center justify-between gap-2 text-xs text-slate-400">
        <span>EISD Meowdopt • Portal Adopsi Kucing Bandung</span>
        <a href="{{ route('cats.show', $adoption->cat) }}" class="hover:text-purple-300 transition-colors">
          Lihat Profil Kucing
        </a>
      </div>
    </div>

    <!-- ======================================================================= -->
    <!-- SISI KANAN: FORMULIR EDIT (7 Columns) -->
    <!-- ======================================================================= -->
    <div class="lg:col-span-7 p-6 sm:p-10 lg:p-14 lg:pr-[max(3rem,calc((100vw-80rem)/2+3rem))] flex flex-col justify-center bg-[#0D0E15]">
      <div class="w-full max-w-xl mx-auto space-y-6">

        <!-- Form Section Header -->
        <div class="space-y-1">
          <span class="text-xs font-bold uppercase tracking-wider text-purple-400 block">Formulir Pembaruan</span>
          <h2 class="font-display font-bold text-2xl text-white">Data Pengajuan Adopsi</h2>
          <p class="text-xs text-slate-400">Sesuaikan kembali data tempat tinggal atau komitmen perawatan kucingmu.</p>
        </div>

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
