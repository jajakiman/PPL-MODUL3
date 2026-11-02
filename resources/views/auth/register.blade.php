<!DOCTYPE html>
<html lang="id" class="h-full bg-[#0A0C1B]">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>EISD Meowdopt - Register Relawan</title>
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
<body class="min-h-full w-full flex flex-col justify-between font-sans text-slate-100 bg-[#0A0C1B] antialiased selection:bg-brand-purple selection:text-white p-6 sm:p-10 relative overflow-x-hidden">

  <!-- Ambient Brand Reference Graphic Overlay -->
  <div class="fixed inset-0 pointer-events-none overflow-hidden select-none z-0">
    <img 
      src="{{ asset('images/brand-ref.png') }}" 
      alt="" 
      class="w-full h-full object-cover object-left-top opacity-40 mix-blend-screen scale-105"
      onerror="this.src='{{ asset('brand-ref.png') }}'; this.onerror=function(){this.style.display='none';}"
    >
    <div class="absolute -top-10 -left-10 w-80 h-80 rounded-full bg-brand-pink/20 blur-3xl"></div>
    <div class="absolute -bottom-10 right-10 w-96 h-96 rounded-full bg-brand-green/15 blur-3xl"></div>
    <div class="absolute inset-0 bg-[#0A0C1B]/80 backdrop-blur-[2px]"></div>
  </div>

  <!-- ========================================================================= -->
  <!-- TOPBAR -->
  <!-- ========================================================================= -->
  <header class="w-full flex items-center justify-between relative z-10 max-w-4xl mx-auto">
    <a href="{{ url('/') }}" class="inline-flex items-center gap-2.5 text-white/90 hover:text-white transition-opacity focus:outline-none group">
      <div class="w-6 h-6 text-brand-purple flex items-center justify-center transition-transform group-hover:scale-110">
        <svg viewBox="0 0 100 100" class="w-full h-full fill-current">
          <path d="M20 25 L40 50 L60 50 L80 25 L80 75 Q80 85 70 85 L30 85 Q20 85 20 75 Z" />
        </svg>
      </div>
      <span class="font-display font-bold text-sm tracking-tight text-white">
        EISD Meowdopt
      </span>
    </a>

    <div class="flex items-center gap-2 text-xs text-slate-400">
      <span>Sudah punya akun?</span>
      <a href="{{ route('login') }}" class="text-brand-pink hover:text-pink-300 font-semibold underline transition-colors">
        Login
      </a>
    </div>
  </header>

  <!-- ========================================================================= -->
  <!-- MAIN REGISTRATION FORM (Laravel Dusk Skenario 1 & 2) -->
  <!-- ========================================================================= -->
  <main class="w-full max-w-md mx-auto my-auto py-8 space-y-6 relative z-10">
    
    <!-- Title & Badge -->
    <div class="space-y-2 text-center">
      <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-brand-pink/15 border border-brand-pink/30 text-[11px] font-bold uppercase tracking-wider text-pink-300">
        <span class="w-1.5 h-1.5 rounded-full bg-brand-pink animate-pulse"></span>
        <span>Pendaftaran Relawan Baru</span>
      </div>

      <h1 class="font-display font-bold text-3xl sm:text-4xl text-white tracking-tight leading-tight">
        Daftar Akun Relawan
      </h1>
      <p class="text-xs text-slate-400 max-w-xs mx-auto">
        Bergabung bersama tim shelter kampus merawat dan mencatat satwa binaan
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
          placeholder="Nama relawan" 
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
        <label for="email" class="block text-xs font-semibold text-slate-200 mb-1.5">Email Kampus</label>
        <input 
          type="email" 
          id="email" 
          name="email" 
          required 
          placeholder="relawan@meowdopt.test" 
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
            Saya pecinta kucing dan berkomitmen merawat satwa kampus dengan penuh kasih sayang
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

      <div class="text-center pt-2">
        <a href="{{ url('/') }}" class="text-xs text-slate-400 hover:text-slate-200 transition-colors">
          ← Kembali ke Beranda
        </a>
      </div>

    </form>

  </main>

  <!-- Footer -->
  <footer class="w-full text-center text-xs text-slate-500 py-4 relative z-10">
    Laboratorium Rekayasa Perangkat Lunak / EISD • 2026
  </footer>

</body>
</html>
