@extends('layouts.app')

@section('content')
<div class="d-flex flex-wrap justify-content-between align-items-center gap-2 mb-3">
    <div>
        <h2 class="mb-0">Daftar Barang</h2>
        <small class="text-muted">Kelola inventaris MiniMarkt (tambah, edit, hapus, lihat detail)</small>
    </div>
    <a href="{{ route('barang.create') }}" class="btn btn-primary">
        + Tambah Barang
    </a>
</div>

<div class="card shadow-sm">
    <div class="card-body">

        {{-- Search (frontend only) --}}
        <div class="row g-2 mb-3">
            <div class="col-md-6">
                <input type="text" id="searchInput" class="form-control" placeholder="Cari nama / kode barang...">
            </div>
            <div class="col-md-3">
                <select id="filterStok" class="form-select">
                    <option value="">Semua Stok</option>
                    <option value="habis">Stok Habis</option>
                    <option value="menipis">Stok Menipis (&lt;= 5)</option>
                    <option value="aman">Stok Aman (&gt; 5)</option>
                </select>
            </div>
            <div class="col-md-3 d-grid">
                <button class="btn btn-outline-secondary" type="button" onclick="resetFilter()">
                    Reset Filter
                </button>
            </div>
        </div>

        <div class="table-responsive">
            <table class="table table-hover align-middle" id="barangTable">
                <thead class="table-dark">
                    <tr>
                        <th>Barang</th>
                        <th>Kode</th>
                        <th class="text-center">Stok</th>
                        <th class="text-end">Harga</th>
                        <th>Lokasi</th>
                        <th class="text-center">Foto</th>
                        <th class="text-end" style="width: 220px;">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($barang as $item)
                    @php
                        $stok = (int) $item->stok;
                        $stokLabel = $stok <= 0 ? 'habis' : ($stok <= 5 ? 'menipis' : 'aman');
                    @endphp

                    <tr data-stok="{{ $stokLabel }}">
                        <td>
                            <div class="fw-semibold">{{ $item->nama_barang }}</div>
                            <small class="text-muted">ID: {{ $item->id }}</small>
                        </td>
                        <td>
                            <span class="badge text-bg-light border">{{ $item->kode_barang }}</span>
                        </td>
                        <td class="text-center">
                            @if($stok <= 0)
                                <span class="badge bg-danger">Habis</span>
                            @elseif($stok <= 5)
                                <span class="badge bg-warning text-dark">Menipis</span>
                            @else
                                <span class="badge bg-success">Aman</span>
                            @endif
                            <div class="mt-1 fw-semibold">{{ $stok }}</div>
                        </td>
                        <td class="text-end">
                            <span class="fw-semibold">Rp {{ number_format($item->harga, 0, ',', '.') }}</span>
                        </td>
                        <td>
                            {{ $item->lokasi ?? '—' }}
                        </td>
                        <td class="text-center">
                            @if($item->foto)
                                <img
                                    src="{{ asset('storage/' . $item->foto) }}"
                                    alt="foto"
                                    class="rounded border"
                                    style="width: 56px; height: 56px; object-fit: cover;"
                                >
                            @else
                                <span class="text-muted">—</span>
                            @endif
                        </td>
                        <td class="text-end">
                            <a href="{{ route('barang.show', $item->id) }}" class="btn btn-outline-info btn-sm">
                                Detail
                            </a>
                            <a href="{{ route('barang.edit', $item->id) }}" class="btn btn-outline-warning btn-sm">
                                Edit
                            </a>

                            <form action="{{ route('barang.destroy', $item->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button
                                    type="submit"
                                    class="btn btn-outline-danger btn-sm"
                                    onclick="return confirm('Yakin hapus barang ini?')"
                                >
                                    Hapus
                                </button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="7" class="text-center py-5">
                            <div class="fs-5 fw-semibold">Belum ada data barang</div>
                            <div class="text-muted mb-3">Klik tombol “Tambah Barang” untuk mulai input inventaris.</div>
                            <a href="{{ route('barang.create') }}" class="btn btn-primary">+ Tambah Barang</a>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>
</div>

{{-- Frontend-only filter/search --}}
<script>
const searchInput = document.getElementById('searchInput');
const filterStok = document.getElementById('filterStok');
const table = document.getElementById('barangTable');
const rows = () => table.querySelectorAll('tbody tr');

function applyFilter() {
    const q = (searchInput.value || '').toLowerCase().trim();
    const stokFilter = filterStok.value;

    rows().forEach(row => {
        // skip empty state row (no data-stok)
        const stok = row.getAttribute('data-stok') || '';
        const text = row.innerText.toLowerCase();

        const matchText = q === '' || text.includes(q);
        const matchStok = stokFilter === '' || stok === stokFilter;

        row.style.display = (matchText && matchStok) ? '' : 'none';
    });
}

function resetFilter() {
    searchInput.value = '';
    filterStok.value = '';
    applyFilter();
}

searchInput.addEventListener('input', applyFilter);
filterStok.addEventListener('change', applyFilter);
</script>
@endsection
