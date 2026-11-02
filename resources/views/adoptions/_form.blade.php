<form class="panel form" method="POST" action="{{ $action }}" novalidate>
    @csrf
    @if ($adoption->exists)
        @method('PUT')
    @else
        <input type="hidden" name="cat_id" value="{{ $cat->id }}">
    @endif

    <div class="field">
        <label class="label" for="address">Alamat Tempat Tinggal</label>
        <input class="input" id="address" type="text" name="address" value="{{ old('address', $adoption->address) }}" maxlength="255" placeholder="Contoh: Kos Sukabirus Blok B" required @error('address') aria-invalid="true" aria-describedby="address-error" @enderror>
        @error('address')
            <p class="error" id="address-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label class="label" for="housing_type">Tipe Hunian</label>
        <select class="input" id="housing_type" name="housing_type" required @error('housing_type') aria-invalid="true" aria-describedby="housing_type-error" @enderror>
            <option value="">Pilih tipe hunian</option>
            @foreach (\App\Models\Adoption::HOUSING as $housing)
                <option value="{{ $housing }}" @selected(old('housing_type', $adoption->housing_type) === $housing)>{{ $housing }}</option>
            @endforeach
        </select>
        @error('housing_type')
            <p class="error" id="housing_type-error">{{ $message }}</p>
        @enderror
    </div>

    <fieldset class="field" @error('experience') aria-describedby="experience-error" @enderror>
        <legend>Pengalaman Memelihara Kucing</legend>
        <div class="choices">
            @foreach (\App\Models\Adoption::EXPERIENCE as $experience)
                <label class="choice">
                    <input type="radio" name="experience" value="{{ $experience }}" @checked(old('experience', $adoption->experience) === $experience)>
                    {{ $experience }}
                </label>
            @endforeach
        </div>
        @error('experience')
            <p class="error" id="experience-error">{{ $message }}</p>
        @enderror
    </fieldset>

    <label class="check">
        <input type="checkbox" name="indoor" value="1" @checked(old('indoor', $adoption->indoor))>
        <span>Kucing akan dipelihara di dalam ruangan</span>
    </label>

    <label class="check">
        <input type="checkbox" name="cost_commitment" value="1" @checked(old('cost_commitment', $adoption->cost_commitment)) @error('cost_commitment') aria-invalid="true" aria-describedby="cost_commitment-error" @enderror>
        <span>Saya sanggup membiayai pakan dan vaksin rutin</span>
    </label>
    @error('cost_commitment')
        <p class="error" id="cost_commitment-error">{{ $message }}</p>
    @enderror

    <div class="form-actions">
        <button type="submit" class="btn">{{ $submit }}</button>
        <a class="btn btn-ghost" href="{{ $adoption->exists ? route('adoptions.index') : route('cats.show', $cat) }}">Batal</a>
    </div>
</form>
