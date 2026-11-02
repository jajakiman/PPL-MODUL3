<form class="panel form" method="POST" action="{{ $action }}" novalidate>
    @csrf
    @if ($cat->exists)
        @method('PUT')
    @endif

    <div class="field">
        <label class="label" for="name">Nama Kucing</label>
        <input class="input" id="name" type="text" name="name" value="{{ old('name', $cat->name) }}" maxlength="50" required @error('name') aria-invalid="true" aria-describedby="name-error" @enderror>
        @error('name')
            <p class="error" id="name-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field">
        <label class="label" for="found_at">Lokasi Ditemukan</label>
        <input class="input" id="found_at" type="text" name="found_at" value="{{ old('found_at', $cat->found_at) }}" maxlength="100" placeholder="Contoh: Parkiran Gedung C" required @error('found_at') aria-invalid="true" aria-describedby="found_at-error" @enderror>
        @error('found_at')
            <p class="error" id="found_at-error">{{ $message }}</p>
        @enderror
    </div>

    <div class="field-row">
        <div class="field">
            <label class="label" for="breed">Ras</label>
            <select class="input" id="breed" name="breed" required @error('breed') aria-invalid="true" aria-describedby="breed-error" @enderror>
                <option value="">Pilih ras</option>
                @foreach (\App\Models\Cat::BREEDS as $breed)
                    <option value="{{ $breed }}" @selected(old('breed', $cat->breed) === $breed)>{{ $breed }}</option>
                @endforeach
            </select>
            @error('breed')
                <p class="error" id="breed-error">{{ $message }}</p>
            @enderror
        </div>

        <div class="field">
            <label class="label" for="age">Umur (bulan)</label>
            <input class="input" id="age" type="number" name="age" value="{{ old('age', $cat->age) }}" min="1" max="300" inputmode="numeric" required @error('age') aria-invalid="true" aria-describedby="age-error" @enderror>
            @error('age')
                <p class="error" id="age-error">{{ $message }}</p>
            @enderror
        </div>
    </div>

    <fieldset class="field" @error('temper') aria-describedby="temper-error" @enderror>
        <legend>Sifat</legend>
        <div class="choices">
            @foreach (\App\Models\Cat::TEMPERS as $temper)
                <label class="choice">
                    <input type="radio" name="temper" value="{{ $temper }}" @checked(old('temper', $cat->temper) === $temper)>
                    {{ $temper }}
                </label>
            @endforeach
        </div>
        @error('temper')
            <p class="error" id="temper-error">{{ $message }}</p>
        @enderror
    </fieldset>

    <label class="check">
        <input type="checkbox" name="vaccinated" value="1" @checked(old('vaccinated', $cat->vaccinated))>
        <span>Sudah divaksin</span>
    </label>

    <div class="form-actions">
        <button type="submit" class="btn">{{ $submit }}</button>
        <a class="btn btn-ghost" href="{{ route('cats.index') }}">Batal</a>
    </div>
</form>
