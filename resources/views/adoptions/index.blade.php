@extends('layouts.app')

@section('title', (auth()->user()->isStaff() ? 'Pengajuan Masuk' : 'Pengajuan Saya').' | EISD Meowdopt')
@section('page-class', 'page-dash')

@section('content')
    @php
        $isStaff = auth()->user()->isStaff();
        $total = $adoptions->count();
        $pendingCount = $adoptions->where('status', \App\Models\Adoption::PENDING)->count();
        $doneCount = $total - $pendingCount;
        $pct = $total ? round($doneCount / $total * 100) : 0;
    @endphp

    <div class="dash-head">
        <div class="dash-title">
            <h1>{{ $isStaff ? 'Pengajuan Adopsi Masuk' : 'Pengajuan Adopsi Saya' }}</h1>
            <span class="chip">{{ $total }} pengajuan tercatat</span>
        </div>
        <div class="dash-actions">
            <span class="role-label">{{ $isStaff ? 'Panel Staff Shelter' : 'Dashboard Adopter' }}</span>
            <a class="btn btn-dark" href="{{ route('cats.index') }}">Lihat Katalog</a>
        </div>
    </div>

    @error('adoption')
        <p class="error-box" role="alert">{{ $message }}</p>
    @enderror

    <section class="card metrics" aria-label="Ringkasan pengajuan">
        <div class="rail" aria-hidden="true" title="Rasio selesai"><i style="--p: {{ $pct }}%"></i></div>
        <div class="metric">
            <span>{{ $isStaff ? 'Total pengajuan masuk' : 'Total pengajuan saya' }}</span>
            <strong>{{ $total }}</strong>
            <small>{{ $isStaff ? 'dari seluruh adopter kampus' : 'riwayat pengajuan adopsi' }}</small>
        </div>
        <div class="metric">
            <span>Menunggu konfirmasi</span>
            <strong>{{ $pendingCount }}</strong>
            <small>{{ $isStaff ? 'sedang diajukan adopter' : 'siap dikonfirmasi atau diedit' }}</small>
        </div>
        <div class="metric">
            <span>{{ $isStaff ? 'Resmi teradopsi' : 'Kucing saya adopsi' }}</span>
            <strong>{{ $doneCount }}</strong>
            <small>{{ $pct }}% pengajuan selesai</small>
        </div>
    </section>

    <section class="card table-card" aria-labelledby="pengajuan-title">
        <div class="card-head">
            <h2 id="pengajuan-title">{{ $isStaff ? 'Daftar pengajuan adopter' : 'Daftar pengajuan saya' }}</h2>
            <span class="muted">{{ $pendingCount }} menunggu konfirmasi &middot; {{ $doneCount }} selesai</span>
        </div>

        @if ($adoptions->isEmpty())
            <div class="empty">
                <h2>Belum ada pengajuan</h2>
                @can('staff')
                    <p>Pengajuan dari adopter akan muncul di sini.</p>
                @else
                    <p>Pilih kucing di katalog, buka detailnya, lalu ajukan adopsi.</p>
                    <a class="btn btn-dark" href="{{ route('cats.index') }}">Lihat Katalog</a>
                @endcan
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Kucing</th>
                        @can('staff')
                            <th scope="col">Pengaju</th>
                        @endcan
                        <th scope="col" class="hide-sm">Hunian</th>
                        <th scope="col">Pengalaman</th>
                        <th scope="col">Status</th>
                        <th scope="col"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($adoptions as $adoption)
                        <tr>
                            <td>
                                <span class="cat-name">{{ $adoption->cat->name }}</span>
                                <span class="cat-place">{{ $adoption->address }}</span>
                            </td>
                            @can('staff')
                                <td>
                                    <span class="cat-name">{{ $adoption->user->name }}</span>
                                    <span class="cat-place">{{ $adoption->user->email }}</span>
                                </td>
                            @endcan
                            <td class="hide-sm">{{ $adoption->housing_type }}</td>
                            <td>{{ $adoption->experience }}</td>
                            <td>
                                <span class="badge {{ $adoption->isPending() ? 'badge-warn' : 'badge-ok' }}">{{ $adoption->status }}</span>
                            </td>
                            <td>
                                @if ($adoption->isPending() && Gate::allows('adopter'))
                                    <div class="row-actions">
                                        <div class="menu-wrap">
                                            <button type="button" class="icon-btn" aria-label="Aksi pengajuan" aria-expanded="false" aria-controls="aksi-menu-{{ $adoption->id }}" data-menu-toggle>
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="5" cy="12" r="2" fill="currentColor"/><circle cx="12" cy="12" r="2" fill="currentColor"/><circle cx="19" cy="12" r="2" fill="currentColor"/></svg>
                                            </button>
                                            <div class="menu aksi-menu" id="aksi-menu-{{ $adoption->id }}" hidden>
                                                <a class="menu-item" href="{{ route('adoptions.edit', $adoption) }}">Edit Pengajuan</a>
                                            </div>
                                        </div>

                                        <button type="button" class="icon-btn" aria-label="Konfirmasi adopsi" title="Konfirmasi adopsi" data-confirm-url="{{ route('adoptions.confirm', $adoption) }}" data-confirm-cat="{{ $adoption->cat->name }}">
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 11l9-7 9 7v9a1 1 0 0 1-1 1h-5v-6h-6v6H4a1 1 0 0 1-1-1z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                                        </button>
                                    </div>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>

    @can('adopter')
        <dialog class="modal" id="modal-confirm" aria-labelledby="modal-title" aria-describedby="modal-desc">
            <form class="modal-card" method="POST" action="">
                @csrf
                <div class="modal-head">
                    <span class="modal-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24"><path d="M3 11l9-7 9 7v9a1 1 0 0 1-1 1h-5v-6h-6v6H4a1 1 0 0 1-1-1z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                    </span>
                    <span class="chip chip-sunk">Komitmen Adopter</span>
                </div>
                <h2 id="modal-title">Konfirmasi Adopsi <span data-cat-name>Kucing</span></h2>
                <p id="modal-desc" class="muted">Yakin kamu siap bertanggung jawab penuh merawat <strong data-cat-name>kucing ini</strong> seumur hidupnya? Setelah dikonfirmasi, kucing resmi menjadi tanggung jawabmu dan keluar dari katalog.</p>
                <div class="modal-actions">
                    <button type="button" class="btn btn-ghost" data-modal-close>Batal</button>
                    <button type="submit" class="btn btn-dark">Ya, Saya Siap</button>
                </div>
            </form>
        </dialog>
    @endcan
@endsection
