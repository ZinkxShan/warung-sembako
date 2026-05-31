@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-md-7 col-lg-6">

        <div class="mb-4">
            <a href="{{ route('produk.index') }}" class="text-muted text-decoration-none">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <h2 class="fw-bold mt-2 mb-0" style="color: #1f2937;">Tambah Produk</h2>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <form action="{{ route('produk.store') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" name="nama_produk"
                               class="form-control @error('nama_produk') is-invalid @enderror"
                               value="{{ old('nama_produk') }}"
                               placeholder="Contoh: Beras Premium">
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <input type="text" name="kategori"
                               class="form-control @error('kategori') is-invalid @enderror"
                               value="{{ old('kategori') }}"
                               placeholder="Contoh: Beras, Minyak, Gula">
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Harga (Rp)</label>
                        <input type="number" name="harga"
                               class="form-control @error('harga') is-invalid @enderror"
                               value="{{ old('harga') }}"
                               placeholder="Contoh: 15000">
                        @error('harga')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-warning fw-bold w-100">
                        <i class="bi bi-save"></i> Simpan Produk
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection