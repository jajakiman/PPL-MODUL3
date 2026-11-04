<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0A0C1B]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EISD Meowdopt - Login</title>
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
              dark: '#0A0C1B',
              surface: '#121630',
              card: '#161B3D',
              line: 'rgba(255, 255, 255, 0.12)'
            }
          }
        }
      }
    }
  </script>
</head>
<body class="min-h-full w-full flex flex-col font-sans text-slate-100 bg-[#0A0C1B] antialiased selection:bg-brand-purple selection:text-white">

  <!-- ========================================================================= -->
  <!-- FULL-BLEED ARCHITECTURAL SPLIT CANVAS -->
  <!-- ========================================================================= -->
  <main class="flex-1 w-full grid grid-cols-1 lg:grid-cols-12 divide-y lg:divide-y-0 lg:divide-x divide-white/10 min-h-screen">

    <!-- ======================================================================= -->
    <!-- SISI KIRI: FORM LOGIN DENGAN STYLE REFERENSI BRAND (7 Columns) -->
    <!-- Frosted Glassmorphism, Midnight Indigo Palette, Ambient Geometric Shapes -->
    <!-- ======================================================================= -->
    <div class="lg:col-span-7 flex flex-col justify-between p-8 sm:p-12 lg:p-16 xl:p-20 bg-[#0A0C1B] relative overflow-hidden">
      
      <!-- LAYER 1: Ambient Brand Reference Graphic Overlay (Vibrant Pink & Green Visuals) -->
      <div class="absolute inset-0 pointer-events-none overflow-hidden select-none">
        <!-- Brand Reference Image with High Visibility for the Pink & Green Geometric Shapes -->
        <img 
          src="{{ asset('images/brand-ref.png') }}" 
          alt="" 
          class="w-full h-full object-cover object-left-top opacity-60 mix-blend-screen scale-100"
          onerror="this.src='{{ asset('brand-ref.png') }}'; this.onerror=function(){this.style.display='none';}"
        >

        <!-- Center Readability Shade (Only Dims Behind Text, Preserves Edges) -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-[#0A0C1B]/60 to-[#0A0C1B]/90"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#0A0C1B]/50 to-[#0A0C1B]/80"></div>
      </div>

      <!-- LAYER 2: Top Header Area (Logo & Badge with Brand Pink Touch) -->
      <div class="relative z-10 flex items-center justify-between w-full">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-3 text-white rounded-lg focus:outline-none focus-visible:ring-2 focus-visible:ring-brand-purple">
          <img src="{{ asset('images/EISD Practicum - White 1.png') }}" alt="EISD Practicum" class="h-8 sm:h-9 w-auto object-contain">
          <span class="w-px h-6 bg-white/25" aria-hidden="true"></span>
          <span class="font-display font-bold text-base tracking-tight">EISD Meowdopt</span>
        </a>
      </div>

      <!-- LAYER 3: The Login Card (Clean & Borderless) -->
      <div class="relative z-10 w-full max-w-md mx-auto my-auto py-10">
        
        <div class="space-y-6">
          
          <div class="space-y-1.5">
            <h1 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-[1.12]">
              Login ke akun<br>EISD Meowdopt
            </h1>
            <p class="text-xs sm:text-sm text-slate-400">
              Masuk untuk memilih kucing Bandung dan memantau pengajuan adopsimu
            </p>
          </div>

          @if (session('status'))
            <div id="flash-banner" role="status"
                 class="fixed top-6 left-1/2 -translate-x-1/2 z-50 flex items-center gap-2.5 px-5 py-3 rounded-[14px] bg-[#141519] border border-[#00D97A]/40 text-[#00D97A] text-sm font-semibold shadow-[0_16px_40px_rgba(0,0,0,0.65)] cursor-pointer transition-all duration-200">
              <svg class="w-4 h-4 shrink-0" fill="none" stroke="currentColor" stroke-width="2.25" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
              <span id="flash-message">{{ session('status') }}</span>
            </div>
            <script>
              (() => {
                const el = document.getElementById('flash-banner');
                const dismiss = () => {
                  el.classList.add('opacity-0', '-translate-y-2', 'pointer-events-none');
                  setTimeout(() => el.remove(), 250);
                };
                setTimeout(dismiss, 2500);
                setTimeout(() => document.addEventListener('click', dismiss, { once: true }), 50);
              })();
            </script>
          @endif

          <!-- Live Error Banner (Dusk Skenario 4: "Email atau password salah.") -->
          @if ($errors->any())
            <div id="error-banner" class="p-3.5 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-200 text-xs font-medium text-center" role="alert">
              {{ $errors->first('email') ?: $errors->first('password') ?: $errors->first() }}
            </div>
          @endif

          <!-- Form Input Fields (Clear Contrast & Tactile Definition) -->
          <form id="login-form" action="{{ route('login') }}" method="POST" class="space-y-4" novalidate>
            @csrf
            
            <!-- Email Field (Dusk: type('email', ...)) -->
            <div>
              <label for="email" class="block text-xs font-semibold text-slate-200 mb-1.5">Email</label>
              <input 
                type="email" 
                id="email" 
                name="email" 
                value="{{ old('email') }}" 
                required 
                placeholder="example@mail.com" 
                autocomplete="email"
                class="w-full px-4 py-3 rounded-xl bg-[#161B3A] text-white text-sm font-medium placeholder:text-slate-400 border border-white/15 focus:bg-[#1E234D] focus:outline-none focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/40 transition-all shadow-sm"
              >
            </div>

            <div>
              <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-slate-200">Password</label>
              </div>
              <input 
                type="password" 
                id="password" 
                name="password" 
                required 
                placeholder="••••••••••" 
                autocomplete="current-password"
                class="w-full px-4 py-3 rounded-xl bg-[#161B3A] text-white text-sm font-medium placeholder:text-slate-400 border border-white/15 focus:bg-[#1E234D] focus:outline-none focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/40 transition-all shadow-sm"
                @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
              >
            </div>

            <div class="pt-2">
              <button 
                type="submit" 
                id="btn-login" 
                class="w-full py-3.5 rounded-xl bg-brand-purple hover:bg-brand-purple-hover text-white font-bold text-sm shadow-lg shadow-brand-purple/25 transition-all cursor-pointer text-center"
              >
                Login
              </button>
            </div>

            <div class="pt-2 text-center text-xs text-slate-400">
              <span>Belum punya akun?</span>
              <a 
                href="{{ route('register') }}" 
                id="btn-register" 
                class="text-brand-pink hover:text-pink-300 font-bold underline transition-colors"
              >
                Register
              </a>
            </div>

          </form>

        </div>

      </div>

      <div class="relative z-10 pt-6 border-t border-white/10 flex items-center justify-between text-xs text-slate-500">
        <span>Laboratorium EISD • 2026</span>
        <span class="text-slate-400">EISD Meowdopt</span>
      </div>

    </div>

    <div class="lg:col-span-5 bg-brand-purple flex flex-col justify-between p-8 sm:p-12 lg:p-16 xl:p-20 relative overflow-hidden min-h-[450px] lg:min-h-full">
      
      <div class="absolute inset-0 grid grid-cols-2 grid-rows-2 pointer-events-none divide-x divide-y divide-white/10 opacity-20">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>

      <!-- Center-Top: Heading Font Putih & Narasi -->
      <div class="relative z-10 space-y-5 my-auto py-8">
        <h2 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-[1.12]">
          Setiap kucing<br>Bandung layak punya rumah
        </h2>
        
        <!-- Teks Deskripsi -->
        <p class="text-sm sm:text-base text-purple-100/90 leading-relaxed font-normal max-w-md">
          Kenali profil, sifat, dan status vaksin setiap kucing sebelum kamu mengajukan adopsi.
        </p>

        <!-- Garis Aksen Halus -->
        <div class="w-16 h-0.5 bg-white/30 rounded-full"></div>
      </div>

      <!-- Bottom: Siluet Kucing Putih Bersih & Brand Label -->
      <div class="relative z-10 pt-6 border-t border-white/15 flex items-center gap-4">
        <img src="{{ asset('images/EISD Practicum - White 1.png') }}" alt="" class="h-10 w-auto object-contain">
        <span class="w-px h-8 bg-white/30" aria-hidden="true"></span>
        <span class="font-display font-bold text-xl text-white tracking-tight">EISD Meowdopt</span>
      </div>

    </div>

  </main>
</body>
</html>
