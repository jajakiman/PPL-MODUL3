<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0A0C1B]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EISD Meowdopt - Login</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <!-- Google Fonts: Space Grotesk (Brand Primary) & Inter (Brand Secondary) -->
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

        <!-- Dedicated Glowing Pink Accent Bloom in Top-Left (Matches Reference) -->
        <div class="absolute -top-10 -left-10 w-80 h-80 rounded-full bg-brand-pink/30 blur-3xl pointer-events-none"></div>

        <!-- Dedicated Glowing Green Accent Bloom in Bottom-Left (Matches Reference) -->
        <div class="absolute -bottom-10 left-10 w-80 h-80 rounded-full bg-brand-green/20 blur-3xl pointer-events-none"></div>

        <!-- Center Readability Shade (Only Dims Behind Text, Preserves Edges) -->
        <div class="absolute inset-0 bg-gradient-to-r from-transparent via-[#0A0C1B]/60 to-[#0A0C1B]/90"></div>
        <div class="absolute inset-0 bg-gradient-to-b from-transparent via-[#0A0C1B]/50 to-[#0A0C1B]/80"></div>
      </div>

      <!-- LAYER 2: Top Header Area (Logo & Badge with Brand Pink Touch) -->
      <div class="relative z-10 flex items-center justify-between w-full">
        <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5 text-white/95 hover:text-white transition-opacity focus:outline-none group">
          <div class="w-6 h-6 text-brand-purple flex items-center justify-center transition-transform group-hover:scale-110">
            <svg viewBox="0 0 100 100" class="w-full h-full fill-current">
              <path d="M20 25 L40 50 L60 50 L80 25 L80 75 Q80 85 70 85 L30 85 Q20 85 20 75 Z" />
            </svg>
          </div>
          <span class="font-display font-bold text-sm tracking-tight text-white">
            EISD Meowdopt
          </span>
        </a>

        <!-- Badge dengan Aksen Pink Brand (#C6149F) Sesuai Referensi -->
        <div class="inline-flex items-center gap-2 px-3.5 py-1 rounded-full bg-brand-pink/15 backdrop-blur-md border border-brand-pink/30 text-[11px] font-bold uppercase tracking-wider text-pink-300 shadow-[0_0_15px_rgba(198,20,159,0.2)]">
          <span class="w-1.5 h-1.5 rounded-full bg-brand-pink animate-pulse"></span>
          <span>Inisiatif Kampus</span>
          <span class="text-pink-400/50">•</span>
          <span class="text-pink-200">Modul 3 Automated Testing</span>
        </div>
      </div>

      <!-- LAYER 3: The Login Card (Clean & Borderless) -->
      <div class="relative z-10 w-full max-w-md mx-auto my-auto py-10">
        
        <div class="space-y-6">
          
          <!-- Judul Space Grotesk Putih Bersih -->
          <div class="space-y-1.5">
            <h1 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-[1.12]">
              Login ke akun<br>EISD Meowdopt
            </h1>
            <p class="text-xs sm:text-sm text-slate-400">
              Masuk untuk mengakses sistem informasi dan mengelola katalog shelter
            </p>
          </div>

          <!-- Live Success Banner (Dusk Skenario 10: "Logout berhasil.") -->
          @if (session('status'))
            <div id="success-banner" class="p-3.5 rounded-xl bg-emerald-950/80 border border-emerald-500/40 text-emerald-200 text-xs font-medium text-center" role="status">
              {{ session('status') }}
            </div>
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
                placeholder="staff@meowdopt.test" 
                autocomplete="email"
                class="w-full px-4 py-3 rounded-xl bg-[#161B3A] text-white text-sm font-medium placeholder:text-slate-400 border border-white/15 focus:bg-[#1E234D] focus:outline-none focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/40 transition-all shadow-sm"
              >
            </div>

            <!-- Password Field (Dusk: type('password', ...)) -->
            <div>
              <div class="flex items-center justify-between mb-1.5">
                <label for="password" class="block text-xs font-semibold text-slate-200">Password</label>
                <a href="#lupa" class="text-[11px] text-pink-400 hover:text-pink-300 transition-colors">Lupa password?</a>
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

            <!-- SATU-SATUNYA TOMBOL LOGIN (Dusk Skenario 3 & 4: press('Login')) -->
            <div class="pt-2">
              <button 
                type="submit" 
                id="btn-login" 
                class="w-full py-3.5 rounded-xl bg-brand-purple hover:bg-brand-purple-hover text-white font-bold text-sm shadow-lg shadow-brand-purple/25 transition-all cursor-pointer text-center"
              >
                Login
              </button>
            </div>

            <!-- SATU-SATUNYA TAUTAN REGISTER (Dusk Skenario 1: clickLink('Register')) -->
            <div class="pt-2 text-center text-xs text-slate-400">
              <span>Belum punya akun relawan? </span>
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

      <!-- LAYER 4: Bottom Footer Info -->
      <div class="relative z-10 pt-6 border-t border-white/10 flex items-center justify-between text-xs text-slate-500">
        <span>Laboratorium Rekayasa Perangkat Lunak / EISD • 2026</span>
        <span class="text-slate-400">EISD Meowdopt Platform</span>
      </div>

    </div>

    <!-- ======================================================================= -->
    <!-- SISI KANAN: SOLID BRAND PURPLE (#494CA0) WITH WHITE HEADING & CAT SILHOUETTE -->
    <!-- ======================================================================= -->
    <div class="lg:col-span-5 bg-brand-purple flex flex-col justify-between p-8 sm:p-12 lg:p-16 xl:p-20 relative overflow-hidden min-h-[450px] lg:min-h-full">
      
      <!-- Subtle Swiss Hairline Grid Accent in Background -->
      <div class="absolute inset-0 grid grid-cols-2 grid-rows-2 pointer-events-none divide-x divide-y divide-white/10 opacity-20">
        <div></div>
        <div></div>
        <div></div>
        <div></div>
      </div>

      <!-- Top Tag Area -->
      <div class="relative z-10">
        <div class="inline-flex items-center gap-2 text-[11px] font-bold uppercase tracking-wider text-purple-200">
          <span>Inisiatif Kampus</span>
          <span class="text-purple-300/60">•</span>
          <span>Penyelamatan Satwa</span>
        </div>
      </div>

      <!-- Center-Top: Heading Font Putih & Narasi -->
      <div class="relative z-10 space-y-5 my-auto py-8">
        <!-- Heading Font Putih (Space Grotesk) -->
        <h2 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-[1.12]">
          Setiap kucing<br>kampus layak punya rumah
        </h2>
        
        <!-- Teks Deskripsi -->
        <p class="text-sm sm:text-base text-purple-100/90 leading-relaxed font-normal max-w-md">
          Relawan shelter mencatat kucing yang ditemukan di sekitar kampus, merawatnya, lalu mempertemukannya dengan calon pengadopsi.
        </p>

        <!-- Garis Aksen Halus -->
        <div class="w-16 h-0.5 bg-white/30 rounded-full"></div>
      </div>

      <!-- Bottom: Siluet Kucing Putih Bersih & Brand Label -->
      <div class="relative z-10 pt-6 border-t border-white/15 flex items-end">
        <div class="flex items-center gap-4">
          <div class="w-14 h-14 sm:w-16 sm:h-16 text-white flex-shrink-0 drop-shadow-lg">
            <svg viewBox="0 0 100 100" class="w-full h-full fill-current">
              <path d="M20 25 L40 50 L60 50 L80 25 L80 75 Q80 85 70 85 L30 85 Q20 85 20 75 Z" />
            </svg>
          </div>
          <div class="space-y-0.5">
            <span class="font-display font-bold text-xl text-white tracking-tight block">
              EISD Meowdopt
            </span>
            <span class="text-[11px] text-purple-200 font-medium tracking-wider uppercase block">
              Shelter Satwa Kampus
            </span>
          </div>
        </div>
      </div>

    </div>

  </main>
</body>
</html>
