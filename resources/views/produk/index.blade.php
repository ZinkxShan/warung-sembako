@extends('layouts.app')

@section('content')

<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-1" style="color: #1f2937;">Kelola Produk</h2>
        <p class="text-muted mb-0">Tambah, edit, dan hapus produk warung</p>
    </div>
    <div class="d-flex gap-2">
        <form method="GET" action="{{ route('produk.index') }}" class="d-flex gap-2">
            <input type="text" name="search" class="form-control"
                   placeholder="Cari produk..."
                   value="{{ $search ?? '' }}"
                   style="min-width: 200px;">
            <button type="submit" class="btn btn-outline-warning">
                <i class="bi bi-search"></i>
            </button>
        </form>
        <a href="{{ route('produk.create') }}" class="btn btn-warning fw-bold">
            <i class="bi bi-plus-circle"></i> Tambah
        </a>
    </div>
</div>

@if(session('sukses'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> {{ session('sukses') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($produks->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-inbox" style="font-size: 4rem; color: #d1d5db;"></i>
        <p class="mt-3 text-muted">Belum ada produk. Silakan tambah produk baru.</p>
        <a href="{{ route('produk.create') }}" class="btn btn-warning fw-bold mt-2">
            <i class="bi bi-plus-circle"></i> Tambah Produk
        </a>
    </div>
@else
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #fef3c7;">
                        <tr>
                            <th class="px-4 py-3" style="color: #92400e;">#</th>
                            <th class="py-3" style="color: #92400e;">Nama Produk</th>
                            <th class="py-3" style="color: #92400e;">Kategori</th>
                            <th class="py-3" style="color: #92400e;">Harga</th>
                            <th class="py-3" style="color: #92400e;">Stok</th>
                            <th class="py-3 text-center" style="color: #92400e;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($produks as $index => $produk)
                        <tr>
                            <td class="px-4">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $produk->nama_produk }}</td>
                            <td>
                                <span class="badge rounded-pill"
                                      style="background-color: #fef3c7; color: #d97706;">
                                    {{ $produk->kategori }}
                                </span>
                            </td>
                            <td class="fw-bold" style="color: #f59e0b;">
                                Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                <span class="text-muted fw-normal small">/ {{ $produk->satuan }}</span>
                            </td>
                            <td>{{ $produk->stok }} {{ $produk->satuan }}</td>
                            <td class="text-center">
                                <a href="{{ route('produk.edit', $produk) }}"
                                   class="btn btn-sm btn-outline-primary me-1">
                                    <i class="bi bi-pencil"></i> Edit
                                </a>
                                <form action="{{ route('produk.destroy', $produk) }}"
                                      method="POST" class="d-inline"
                                      onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

@endsection