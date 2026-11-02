<?php

namespace App\Http\Controllers;

use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CatController extends Controller
{
    public function index()
    {
        return view('cats.index', ['cats' => Cat::latest()->get()]);
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

        return redirect()->route('cats.index')->with('status', 'Kucing berhasil diadopsi.');
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
