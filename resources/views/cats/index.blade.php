@extends('layouts.app')

@section('title', 'Katalog Kucing Adopsi | EISD Meowdopt')

@section('content')
    <div class="page-head">
        <div>
            <h1>Katalog Kucing Adopsi</h1>
            <p>{{ $cats->count() }} kucing menunggu rumah baru.</p>
        </div>
        <a class="btn" href="{{ route('cats.create') }}">Tambah Kucing</a>
    </div>

    <div class="table-wrap">
        @if ($cats->isEmpty())
            <div class="empty">
                <h2>Katalog masih kosong</h2>
                <p>Semua kucing sudah diadopsi. Catat kucing baru yang ditemukan di kampus.</p>
                <a class="btn" href="{{ route('cats.create') }}">Tambah Kucing</a>
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

                                    <div class="menu-wrap">
                                        <button type="button" class="icon-btn" id="aksi-{{ $cat->id }}" aria-label="Aksi kucing" aria-expanded="false" aria-controls="aksi-menu-{{ $cat->id }}" data-menu-toggle>
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><circle cx="5" cy="12" r="2" fill="currentColor"/><circle cx="12" cy="12" r="2" fill="currentColor"/><circle cx="19" cy="12" r="2" fill="currentColor"/></svg>
                                        </button>
                                        <div class="menu aksi-menu" id="aksi-menu-{{ $cat->id }}" hidden>
                                            <a class="menu-item" href="{{ route('cats.edit', $cat) }}">Edit</a>
                                        </div>
                                    </div>

                                    <form method="POST" action="{{ route('cats.destroy', $cat) }}" data-confirm="Yakin {{ $cat->name }} sudah diadopsi?">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="icon-btn" aria-label="Adopsi kucing" title="Tandai sudah diadopsi">
                                            <svg viewBox="0 0 24 24" aria-hidden="true"><path d="M3 11l9-7 9 7v9a1 1 0 0 1-1 1h-5v-6h-6v6H4a1 1 0 0 1-1-1z" fill="none" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
