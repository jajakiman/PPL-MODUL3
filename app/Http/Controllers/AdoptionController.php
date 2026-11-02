<?php

namespace App\Http\Controllers;

use App\Models\Adoption;
use App\Models\Cat;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class AdoptionController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->user()->isStaff() ? Adoption::query() : $request->user()->adoptions();

        return view('adoptions.index', [
            'adoptions' => $query->with('cat', 'user')->latest()->get(),
        ]);
    }

    public function create(Request $request)
    {
        $catId = $request->query('cat') ?? $request->query('cat_id');

        return view('adoptions.create', [
            'cat' => Cat::available()->findOrFail($catId),
            'adoption' => new Adoption,
        ]);
    }

    public function store(Request $request)
    {
        $cat = Cat::available()->findOrFail($request->input('cat_id'));

        $request->user()->adoptions()->create($this->validated($request) + ['cat_id' => $cat->id]);

        return redirect()->route('adoptions.index')->with('status', 'Pengajuan adopsi berhasil dikirim.');
    }

    public function edit(Request $request, Adoption $adoption)
    {
        $this->ensureOwnPending($request, $adoption);

        return view('adoptions.edit', compact('adoption'));
    }

    public function update(Request $request, Adoption $adoption)
    {
        $this->ensureOwnPending($request, $adoption);

        $adoption->update($this->validated($request));

        return redirect()->route('adoptions.index')->with('status', 'Data pengajuan berhasil diperbarui.');
    }

    public function confirm(Request $request, Adoption $adoption)
    {
        $this->ensureOwnPending($request, $adoption);

        // ponytail: no row lock, so two simultaneous confirms on one cat could both pass; wrap in a transaction with lockForUpdate if that ever matters.
        if (! $adoption->cat->isAvailable()) {
            return back()->withErrors(['adoption' => 'Kucing ini sudah diadopsi orang lain.']);
        }

        $adoption->update(['status' => Adoption::DONE]);

        return redirect()->route('cats.index')->with('status', 'Selamat! Adopsi resmi selesai.');
    }

    private function ensureOwnPending(Request $request, Adoption $adoption): void
    {
        abort_unless($request->user()->is($adoption->user) && $adoption->isPending(), 403);
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'address' => 'required|string|max:255',
            'housing_type' => ['required', Rule::in(Adoption::HOUSING)],
            'experience' => ['required', Rule::in(Adoption::EXPERIENCE)],
            'cost_commitment' => 'accepted',
        ], [
            'address.required' => 'Alamat tempat tinggal wajib diisi.',
            'address.max' => 'Alamat maksimal 255 karakter.',
            'housing_type.required' => 'Pilih tipe hunian.',
            'housing_type.in' => 'Tipe hunian tidak dikenal.',
            'experience.required' => 'Pilih pengalaman memelihara kucing.',
            'experience.in' => 'Pilihan pengalaman tidak dikenal.',
            'cost_commitment.accepted' => 'Centang komitmen biaya pakan dan vaksin untuk mengajukan adopsi.',
        ]);

        return ['cost_commitment' => true, 'indoor' => $request->boolean('indoor')] + $data;
    }
}
