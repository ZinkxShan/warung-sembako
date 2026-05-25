@extends('layouts.app')

@section('content')

<!-- Header -->
<div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-center mb-4 gap-3">
    <div>
        <h2 class="fw-bold mb-1" style="color: #1f2937;">Daftar Harga</h2>
        <p class="text-muted mb-0">Harga produk warung hari ini</p>
    </div>
    <form method="GET" action="{{ route('harga') }}" class="d-flex gap-2">
        <input type="text" name="search" class="form-control"
               placeholder="Cari produk..."
               value="{{ $search ?? '' }}"
               style="min-width: 200px;">
        <button type="submit" class="btn btn-warning">
            <i class="bi bi-search"></i>
        </button>
    </form>
</div>

<!-- Notifikasi -->
@if(session('sukses'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        <i class="bi bi-check-circle"></i> {{ session('sukses') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

<!-- Cek data kosong -->
@if($produks->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-inbox" style="font-size: 4rem; color: #d1d5db;"></i>
        <p class="mt-3 text-muted">Belum ada produk tersedia.</p>
    </div>
@else

<!-- Group produk berdasarkan kategori -->
@foreach($produks->groupBy('kategori') as $kategori => $items)
<div class="mb-4">
    <h5 class="fw-bold mb-3 px-2 py-1 rounded"
        style="background-color: #fef3c7; color: #d97706; display: inline-block;">
        <i class="bi bi-tag"></i> {{ $kategori }}
    </h5>

    <div class="row g-3">
        @foreach($items as $produk)
        <div class="col-12 col-sm-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100"
                 style="border-radius: 12px; transition: transform 0.2s;"
                 onmouseover="this.style.transform='translateY(-3px)'"
                 onmouseout="this.style.transform='translateY(0)'">
                <div class="card-body">
                    <h6 class="fw-bold mb-1" style="color: #1f2937;">
                        {{ $produk->nama_produk }}
                    </h6>
                    <p class="text-muted small mb-2">
                        Stok: {{ $produk->stok }} {{ $produk->satuan }}
                    </p>
                    <p class="fw-bold mb-0" style="color: #f59e0b; font-size: 1.1rem;">
                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        <span class="text-muted fw-normal" style="font-size: 0.8rem;">
                            / {{ $produk->satuan }}
                        </span>
                    </p>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endforeach

@endif

@endsection