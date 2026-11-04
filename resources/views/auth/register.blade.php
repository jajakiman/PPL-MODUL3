<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0A0C1B]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EISD Meowdopt - Daftar Pengadopsi</title>
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
    <!-- SISI KIRI: FORM REGISTER DENGAN STYLE REFERENSI BRAND (7 Columns) -->
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

      <!-- LAYER 3: The Register Card (Clean & Borderless) -->
      <div class="relative z-10 w-full max-w-md mx-auto my-auto py-10">
        
        <div class="space-y-6">
          
          <div class="space-y-1.5">
            <h1 class="font-display font-bold text-3xl sm:text-4xl lg:text-5xl text-white tracking-tight leading-[1.12]">
              Daftar akun<br>EISD Meowdopt
            </h1>
            <p class="text-xs sm:text-sm text-slate-400">
              Buat akun untuk memilih kucing Bandung dan mengajukan adopsi
            </p>
          </div>

          <!-- Live Error Banner (Dusk Skenario 2: "Email ini sudah terdaftar.") -->
          @if ($errors->any())
            <div id="error-banner" class="p-3.5 rounded-xl bg-rose-950/80 border border-rose-500/40 text-rose-200 text-xs font-medium text-center" role="alert">
              {{ $errors->first() }}
            </div>
          @endif

          <!-- The Form -->
          <form id="register-form" action="{{ route('register') }}" method="POST" class="space-y-4" novalidate>
            @csrf
            
            <!-- 1. Name Field (Dusk: type('name', ...)) -->
            <div>
              <label for="name" class="block text-xs font-semibold text-slate-200 mb-1.5">Nama Lengkap</label>
              <input 
                type="text" 
                id="name" 
                name="name" 
                required 
                placeholder="Nama lengkap" 
                value="{{ old('name') }}"
                class="w-full px-4 py-3 rounded-xl bg-[#161B3A] text-white text-sm font-medium placeholder:text-slate-400 border border-white/15 focus:bg-[#1E234D] focus:outline-none focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/40 transition-all shadow-sm"
                @error('name') aria-invalid="true" aria-describedby="name-error" @enderror
              >
              @error('name')
                <p class="mt-1 text-xs text-rose-300" id="name-error">{{ $message }}</p>
              @enderror
            </div>

            <!-- 2. Email Field (Dusk: type('email', ...)) -->
            <div>
              <label for="email" class="block text-xs font-semibold text-slate-200 mb-1.5">Email</label>
              <input 
                type="email" 
                id="email" 
                name="email" 
                required 
                placeholder="adopter@meowdopt.test" 
                value="{{ old('email') }}"
                class="w-full px-4 py-3 rounded-xl bg-[#161B3A] text-white text-sm font-medium placeholder:text-slate-400 border border-white/15 focus:bg-[#1E234D] focus:outline-none focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/40 transition-all shadow-sm"
                @error('email') aria-invalid="true" aria-describedby="email-error" @enderror
              >
              @error('email')
                <p class="mt-1 text-xs text-rose-300" id="email-error">{{ $message }}</p>
              @enderror
            </div>

            <!-- 3. Password & Confirmation -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3.5">
              <div>
                <label for="password" class="block text-xs font-semibold text-slate-200 mb-1.5">Password</label>
                <input 
                  type="password" 
                  id="password" 
                  name="password" 
                  required 
                  placeholder="Minimal 8 karakter" 
                  class="w-full px-4 py-3 rounded-xl bg-[#161B3A] text-white text-sm font-medium placeholder:text-slate-400 border border-white/15 focus:bg-[#1E234D] focus:outline-none focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/40 transition-all shadow-sm"
                  @error('password') aria-invalid="true" aria-describedby="password-error" @enderror
                >
                @error('password')
                  <p class="mt-1 text-xs text-rose-300" id="password-error">{{ $message }}</p>
                @enderror
              </div>

              <div>
                <label for="password_confirmation" class="block text-xs font-semibold text-slate-200 mb-1.5">Ulangi Password</label>
                <input 
                  type="password" 
                  id="password_confirmation" 
                  name="password_confirmation" 
                  required 
                  placeholder="Konfirmasi" 
                  class="w-full px-4 py-3 rounded-xl bg-[#161B3A] text-white text-sm font-medium placeholder:text-slate-400 border border-white/15 focus:bg-[#1E234D] focus:outline-none focus:border-brand-purple focus:ring-2 focus:ring-brand-purple/40 transition-all shadow-sm"
                >
              </div>
            </div>

            <!-- 4. Checkbox Cat Lover (Dusk Skenario 1 & 2: check('cat_lover')) -->
            <div class="p-3.5 rounded-xl bg-[#161B3A]/80 border border-white/10">
              <label class="flex items-start gap-3 cursor-pointer">
                <input 
                  type="checkbox" 
                  id="cat_lover" 
                  name="cat_lover" 
                  value="1"
                  @checked(old('cat_lover'))
                  class="mt-0.5 rounded text-brand-green focus:ring-brand-green w-4 h-4 bg-slate-900 border-white/20"
                  @error('cat_lover') aria-invalid="true" aria-describedby="cat_lover-error" @enderror
                >
                <span class="text-xs text-slate-300 leading-snug">
                  Saya pecinta kucing dan siap merawat kucing adopsi dengan penuh tanggung jawab
                </span>
              </label>
              @error('cat_lover')
                <p class="mt-1.5 text-xs text-rose-300" id="cat_lover-error">{{ $message }}</p>
              @enderror
            </div>

            <!-- 5. Submit Button (Dusk Skenario 1 & 2: press('Register')) -->
            <div class="pt-2">
              <button 
                type="submit" 
                id="btn-register" 
                class="w-full py-3.5 rounded-xl bg-brand-purple hover:bg-brand-purple-hover text-white font-bold text-sm shadow-lg shadow-brand-purple/25 transition-all cursor-pointer text-center"
              >
                Register
              </button>
            </div>

            <div class="pt-2 text-center text-xs text-slate-400">
              <span>Sudah punya akun?</span>
              <a href="{{ route('login') }}" class="text-brand-pink hover:text-pink-300 font-bold underline transition-colors">Login</a>
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
