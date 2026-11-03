<form class="panel form space-y-5" method="POST" action="{{ $action }}" novalidate>
  @csrf
  @if ($adoption->exists)
    @method('PUT')
  @else
    <input type="hidden" name="cat_id" value="{{ $cat->id }}">
  @endif

  <!-- Alamat Tempat Tinggal -->
  <div class="field space-y-1.5">
    <label class="label block text-xs font-semibold text-slate-200" for="address">
      Alamat Tempat Tinggal <span class="text-rose-400">*</span>
    </label>
    <input 
      class="input w-full px-4 py-3 rounded-xl bg-[#161926] text-white text-sm placeholder:text-slate-500 border @error('address') border-rose-500 ring-1 ring-rose-500 @else border-white/10 @enderror focus:outline-none focus:border-brand-purple focus:ring-1 focus:ring-brand-purple transition-all" 
      id="address" 
      type="text" 
      name="address" 
      value="{{ old('address', $adoption->address) }}" 
      maxlength="255" 
      placeholder="Contoh: Kos Sukabirus Blok B No. 12" 
      required 
      @error('address') aria-invalid="true" aria-describedby="address-error" @enderror
    >
    @error('address')
      <p class="error text-xs text-rose-400 mt-1" id="address-error">{{ $message }}</p>
    @enderror
  </div>

  <!-- Tipe Hunian -->
  <div class="field space-y-1.5">
    <label class="label block text-xs font-semibold text-slate-200" for="housing_type">
      Tipe Hunian <span class="text-rose-400">*</span>
    </label>
    <div class="relative">
      <select 
        class="input w-full px-4 py-3 rounded-xl bg-[#161926] text-white text-sm border @error('housing_type') border-rose-500 ring-1 ring-rose-500 @else border-white/10 @enderror focus:outline-none focus:border-brand-purple focus:ring-1 focus:ring-brand-purple transition-all appearance-none cursor-pointer" 
        id="housing_type" 
        name="housing_type" 
        required 
        @error('housing_type') aria-invalid="true" aria-describedby="housing_type-error" @enderror
      >
        <option value="" class="bg-[#161926] text-slate-400">Pilih tipe hunian</option>
        @foreach (\App\Models\Adoption::HOUSING as $housing)
          <option value="{{ $housing }}" class="bg-[#161926] text-white" @selected(old('housing_type', $adoption->housing_type) === $housing)>{{ $housing }}</option>
        @endforeach
      </select>
      <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-slate-400">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
      </div>
    </div>
    @error('housing_type')
      <p class="error text-xs text-rose-400 mt-1" id="housing_type-error">{{ $message }}</p>
    @enderror
  </div>

  <!-- Pengalaman Memelihara Kucing -->
  <fieldset class="field space-y-2" @error('experience') aria-describedby="experience-error" @enderror>
    <legend class="block text-xs font-semibold text-slate-200 mb-1">
      Pengalaman Memelihara Kucing <span class="text-rose-400">*</span>
    </legend>
    <div class="choices grid grid-cols-1 sm:grid-cols-3 gap-2.5">
      @foreach (\App\Models\Adoption::EXPERIENCE as $experience)
        <label class="choice flex items-center gap-2.5 p-3 rounded-xl bg-[#161926] border @error('experience') border-rose-500/50 @else border-white/10 @enderror cursor-pointer hover:border-brand-purple/50 transition-colors">
          <input 
            type="radio" 
            name="experience" 
            value="{{ $experience }}" 
            class="text-brand-purple focus:ring-brand-purple w-4 h-4 bg-slate-900 border-slate-700" 
            @checked(old('experience', $adoption->experience) === $experience)
          >
          <span class="text-xs font-medium text-slate-200 leading-tight">{{ $experience }}</span>
        </label>
      @endforeach
    </div>
    @error('experience')
      <p class="error text-xs text-rose-400 mt-1" id="experience-error">{{ $message }}</p>
    @enderror
  </fieldset>

  <!-- Checkboxes -->
  <div class="space-y-3 pt-1">
    <label class="check flex items-start gap-3 p-3.5 rounded-xl bg-[#161926] border border-white/10 hover:border-white/20 transition-colors cursor-pointer">
      <input 
        type="checkbox" 
        name="indoor" 
        value="1" 
        class="mt-0.5 rounded text-brand-green focus:ring-brand-green w-4 h-4 bg-slate-900 border-slate-700" 
        @checked(old('indoor', $adoption->indoor))
      >
      <div class="space-y-0.5">
        <span class="text-xs font-semibold text-white block">Kucing akan dipelihara di dalam ruangan</span>
        <span class="text-[11px] text-slate-400 block">Menjaga kucing tetap aman dari bahaya jalanan dan infeksi luar</span>
      </div>
    </label>

    <label class="check flex items-start gap-3 p-3.5 rounded-xl bg-[#161926] border @error('cost_commitment') border-rose-500 @else border-white/10 @enderror hover:border-white/20 transition-colors cursor-pointer">
      <input 
        type="checkbox" 
        name="cost_commitment" 
        value="1" 
        class="mt-0.5 rounded text-brand-green focus:ring-brand-green w-4 h-4 bg-slate-900 border-slate-700" 
        @checked(old('cost_commitment', $adoption->cost_commitment)) 
        @error('cost_commitment') aria-invalid="true" aria-describedby="cost_commitment-error" @enderror
      >
      <div class="space-y-0.5">
        <span class="text-xs font-semibold text-white block">Saya sanggup membiayai pakan dan vaksin rutin</span>
        <span class="text-[11px] text-slate-400 block">Menyediakan pakan berkualitas dan perawatan medis saat dibutuhkan</span>
      </div>
    </label>
    @error('cost_commitment')
      <p class="error text-xs text-rose-400 mt-1" id="cost_commitment-error">{{ $message }}</p>
    @enderror
  </div>

  <!-- Form Actions -->
  <div class="form-actions pt-4 flex items-center justify-between gap-4">
    <a class="btn btn-ghost px-5 py-3.5 rounded-xl bg-white/5 hover:bg-white/10 text-slate-300 text-xs font-semibold transition-colors" href="{{ $adoption->exists ? route('adoptions.index') : route('cats.show', $cat) }}">
      Batal
    </a>
    <button 
      type="submit" 
      class="btn flex-1 py-3.5 rounded-xl bg-brand-pink hover:bg-brand-pink-hover text-white font-bold text-sm shadow-md transition-colors cursor-pointer text-center"
    >
      {{ $submit }}
    </button>
  </div>
</form>