<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\Cat;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CatController extends Controller
{
    public function index(Request $request)
    {
        $cats = Cat::available()->latest()->get();
        $pending = Adoption::where('status', Adoption::PENDING);
        $requested = Cat::available()->whereHas('adoptions', fn ($q) => $q->where('status', Adoption::PENDING))->count();

        $breeds = collect(Cat::BREEDS)->mapWithKeys(fn ($breed) => [$breed => [
            'vaksin' => $cats->where('breed', $breed)->where('vaccinated', true)->count(),
            'belum' => $cats->where('breed', $breed)->where('vaccinated', false)->count(),
        ]]);

        return view('cats.index', [
            'cats' => $cats,
            'breeds' => $breeds,
            'topBreed' => $breeds->sortByDesc(fn ($b) => $b['vaksin'] + $b['belum'])->keys()->first(),
            'pipeline' => [
                'Belum diajukan' => $cats->count() - $requested,
                'Sedang diajukan' => $requested,
                'Sudah diadopsi' => Adoption::where('status', Adoption::DONE)->distinct()->count('cat_id'),
            ],
            'adopters' => User::where('role', User::ADOPTER)->count(),
            'pending' => $request->user()->isStaff()
                ? $pending->count()
                : $pending->where('user_id', $request->user()->id)->count(),
        ]);
    }

    public function create()
    {
        return view('cats.create', ['cat' => new Cat]);
    }

    public function store(Request $request)
    {
        Cat::create($this->validated($request));

        return redirect()->route('cats.index')->with('status', 'Kucing berhasil ditambahkan.');
    }

    public function show(Cat $cat)
    {
        return view('cats.show', compact('cat'));
    }

    public function edit(Cat $cat)
    {
        return view('cats.edit', compact('cat'));
    }

    public function update(Request $request, Cat $cat)
    {
        $cat->update($this->validated($request));

        return redirect()->route('cats.index')->with('status', 'Data kucing berhasil diperbarui.');
    }

    public function destroy(Cat $cat)
    {
        $cat->delete();

        return redirect()->route('cats.index')->with('status', 'Kucing berhasil dihapus.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:50',
            'found_at' => 'required|string|max:100',
            'breed' => ['required', Rule::in(Cat::BREEDS)],
            'temper' => ['required', Rule::in(Cat::TEMPERS)],
            'age' => 'required|integer|min:1|max:300',
        ], [
            'name.required' => 'Kucing tanpa nama tidak bisa diadopsi!',
            'name.max' => 'Nama kucing maksimal 50 karakter.',
            'found_at.required' => 'Lokasi ditemukan wajib diisi.',
            'found_at.max' => 'Lokasi maksimal 100 karakter.',
            'breed.required' => 'Pilih ras kucing.',
            'breed.in' => 'Ras kucing tidak dikenal.',
            'temper.required' => 'Pilih sifat kucing.',
            'temper.in' => 'Sifat kucing tidak dikenal.',
            'age.required' => 'Umur kucing wajib diisi.',
            'age.integer' => 'Umur kucing harus berupa angka bulan.',
            'age.min' => 'Umur kucing minimal 1 bulan.',
            'age.max' => 'Umur kucing maksimal 300 bulan.',
        ]);

        return $data + ['vaccinated' => $request->boolean('vaccinated')];
    }
}
