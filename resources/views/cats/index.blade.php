@extends('layouts.app')

@section('title', 'Katalog Kucing Adopsi | EISD Meowdopt')
@section('page-class', 'page-dash')

@section('content')
    @php
        $isStaff = auth()->user()->isStaff();
        $total = $cats->count();
        $vaccinated = $cats->where('vaccinated', true)->count();
        $pct = fn ($n, $of) => $of ? round($n / $of * 100) : 0;
        $tallest = max(1, $breeds->max(fn ($b) => $b['vaksin'] + $b['belum']));
        $pipeTotal = max(1, array_sum($pipeline));
    @endphp

    <div class="dash-head">
        <div class="dash-title">
            <h1>Katalog Kucing Adopsi</h1>
            <span class="chip">
                <svg viewBox="0 0 24 24" aria-hidden="true"><rect x="3" y="5" width="18" height="16" rx="3" fill="none" stroke="currentColor" stroke-width="2"/><path d="M8 3v4M16 3v4M3 10h18" stroke="currentColor" stroke-width="2"/></svg>
                Hari ini, {{ now()->locale('id')->translatedFormat('j F Y') }}
            </span>
        </div>
        <div class="dash-actions">
            <span class="role-label">{{ $isStaff ? 'Panel Staff Shelter' : 'Dashboard Adopter' }}</span>
            @can('staff')
                <a class="btn btn-dark" href="{{ route('cats.create') }}">Tambah Kucing</a>
            @endcan
        </div>
    </div>

    <section class="card metrics" aria-label="Ringkasan">
        <div class="rail" aria-hidden="true" title="Rasio vaksin"><i style="--p: {{ $pct($vaccinated, $total) }}%"></i></div>
        <div class="metric">
            <span>Siap diadopsi</span>
            <strong>{{ $total }}</strong>
            <small>kucing di katalog</small>
        </div>
        <div class="metric">
            <span>{{ $isStaff ? 'Belum vaksin' : 'Sudah vaksin' }}</span>
            <strong>{{ $isStaff ? $total - $vaccinated : $vaccinated }}</strong>
            <small>{{ $isStaff ? 'perlu dijadwalkan vaksin' : $pct($vaccinated, $total).'% dari katalog' }}</small>
        </div>
        <a class="metric metric-link" href="{{ route('adoptions.index') }}">
            <span>{{ $isStaff ? 'Pengajuan menunggu' : 'Pengajuan saya' }}</span>
            <strong>{{ $pending }}</strong>
            <small>{{ $isStaff ? 'lihat pengajuan masuk' : 'lihat status pengajuan' }}</small>
        </a>
    </section>

    <div class="dash-grid">
        <section class="card" aria-labelledby="ras-title">
            <div class="card-head">
                <h2 id="ras-title">Kucing per ras</h2>
                <span class="chip chip-sunk">{{ count(\App\Models\Cat::BREEDS) }} ras &middot; katalog aktif</span>
            </div>
            <div class="breed-body">
                <div class="chart">
                    <ol class="y-axis" aria-hidden="true">
                        <li>{{ $tallest }}</li>
                        <li>{{ $tallest > 1 ? round($tallest / 2, 1) : '' }}</li>
                        <li>0</li>
                    </ol>
                    <div class="pills" role="img" aria-label="@foreach ($breeds as $breed => $b){{ $breed }}: {{ $b['vaksin'] }} sudah vaksin, {{ $b['belum'] }} belum vaksin. @endforeach">
                        @foreach ($breeds as $breed => $b)
                            @php($sum = $b['vaksin'] + $b['belum'])
                            <div class="pill-col">
                                <div class="pill-stack {{ $sum ? '' : 'is-empty' }}" style="--h: {{ $sum ? $sum / $tallest * 100 : 55 }}%">
                                    <span class="pill-label">{{ $breed }} <b>{{ $sum }}</b></span>
                                    @if ($sum === 0)
                                        <i class="seg seg-empty" style="flex: 1"></i>
                                    @endif
                                    @if ($b['belum'])
                                        <i class="seg seg-hatch" style="flex: {{ $b['belum'] }}"></i>
                                    @endif
                                    @if ($b['vaksin'])
                                        <i class="seg seg-sun" style="flex: {{ $b['vaksin'] }}"></i>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <ul class="legend-box">
                    <li><i class="swatch seg-sun"></i><span>Sudah vaksin</span><strong>{{ $vaccinated }}</strong></li>
                    <li><i class="swatch seg-hatch"></i><span>Belum vaksin</span><strong>{{ $total - $vaccinated }}</strong></li>
                </ul>
            </div>
            @if ($topBreed && $total)
                <p class="note"><b class="note-icon" aria-hidden="true">i</b><span>Ras paling banyak di katalog saat ini: <strong>{{ $topBreed }}</strong>.</span></p>
            @endif
        </section>

        <section class="card" aria-labelledby="status-title">
            <div class="card-head">
                <h2 id="status-title">Status adopsi</h2>
                <span class="chip chip-sunk">Semua waktu</span>
            </div>
            <div class="status-body">
                <div class="bubbles" aria-hidden="true">
                    @foreach ($pipeline as $label => $n)
                        <span class="bubble bubble-{{ $loop->index }}" style="--s: {{ 34 + $n / $pipeTotal * 66 }}%">
                            {{ $n }}
                            <span class="tag"><i class="dot bubble-{{ $loop->index }}"></i>{{ $label }}</span>
                        </span>
                    @endforeach
                </div>
                <ul class="status-list">
                    @foreach ($pipeline as $label => $n)
                        <li>
                            <span>{{ $label }}</span>
                            <strong>{{ $n }} ({{ $pct($n, $pipeTotal) }}%)</strong>
                            <i class="meter"><i class="bubble-{{ $loop->index }}" style="width: {{ $pct($n, $pipeTotal) }}%"></i></i>
                        </li>
                    @endforeach
                </ul>
            </div>
            <p class="note"><b class="note-icon note-count">{{ $adopters }}</b><span>adopter terdaftar di EISD Meowdopt.</span></p>
        </section>
    </div>

    <section class="card table-card" aria-labelledby="daftar-title">
        <div class="card-head">
            <h2 id="daftar-title">Daftar kucing</h2>
            <span class="muted">{{ $total }} kucing menunggu rumah baru.</span>
        </div>

        @if ($cats->isEmpty())
            <div class="empty">
                <h2>Katalog masih kosong</h2>
                @can('staff')
                    <p>Semua kucing sudah diadopsi. Catat kucing baru yang ditemukan di kampus.</p>
                    <a class="btn btn-dark" href="{{ route('cats.create') }}">Tambah Kucing</a>
                @else
                    <p>Semua kucing sudah menemukan rumah. Cek lagi nanti setelah shelter mencatat kucing baru.</p>
                @endcan
            </div>
        @else
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">Nama</th>
                        <th scope="col" class="hide-sm">Ras</th>
                        <th scope="col">Sifat</th>
                        <th scope="col" class="num hide-sm">Umur</th>
                        <th scope="col">Vaksin</th>
                        <th scope="col"><span class="sr-only">Aksi</span></th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($cats as $cat)
                        <tr>
                            <td>
                                <span class="cat-name">{{ $cat->name }}</span>
                                <span class="cat-place">{{ $cat->found_at }}</span>
                            </td>
                            <td class="hide-sm">{{ $cat->breed }}</td>
                            <td>{{ $cat->temper }}</td>
                            <td class="num hide-sm">{{ $cat->age }} bln</td>
                            <td>
                                <span class="badge {{ $cat->vaccinated ? 'badge-ok' : 'badge-warn' }}">{{ $cat->vaccinated ? 'Sudah Vaksin' : 'Belum Vaksin' }}</span>
                            </td>
                            <td>
                                <div class="row-actions">
                                    <a href="{{ route('cats.show', $cat) }}">Detail</a>

                                    @can('staff')
                                        <div class="menu-wrap">
                                            <button type="button" class="icon-btn" aria-label="Aksi kucing" aria-expanded="false" aria-controls="aksi-menu-{{ $cat->id }}" data-menu-toggle>
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="5" cy="12" r="2" fill="currentColor"/><circle cx="12" cy="12" r="2" fill="currentColor"/><circle cx="19" cy="12" r="2" fill="currentColor"/></svg>
                                            </button>
                                            <div class="menu aksi-menu" id="aksi-menu-{{ $cat->id }}" hidden>
                                                <a class="menu-item" href="{{ route('cats.edit', $cat) }}">Edit</a>
                                            </div>
                                        </div>

                                        <form method="POST" action="{{ route('cats.destroy', $cat) }}" data-confirm="Hapus {{ $cat->name }} dari katalog?">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="icon-btn" aria-label="Hapus kucing" title="Hapus kucing">
                                                <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M4 7h16M9 7V4h6v3M6 7l1 13h10l1-13" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                                            </button>
                                        </form>
                                    @endcan
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </section>
@endsection
