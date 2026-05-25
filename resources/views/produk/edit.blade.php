@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-md-7 col-lg-6">

        <div class="mb-4">
            <a href="{{ route('produk.index') }}" class="text-muted text-decoration-none">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <h2 class="fw-bold mt-2 mb-0" style="color: #1f2937;">✏️ Edit Produk</h2>
        </div>

        <div class="card border-0 shadow-sm" style="border-radius: 12px;">
            <div class="card-body p-4">
                <form action="{{ route('produk.update', $produk) }}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Nama Produk</label>
                        <input type="text" name="nama_produk"
                               class="form-control @error('nama_produk') is-invalid @enderror"
                               value="{{ old('nama_produk', $produk->nama_produk) }}"
                               placeholder="Contoh: Beras Premium">
                        @error('nama_produk')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label class="form-label fw-semibold">Kategori</label>
                        <input type="text" name="kategori"
                               class="form-control @error('kategori') is-invalid @enderror"
                               value="{{ old('kategori', $produk->kategori) }}"
                               placeholder="Contoh: Beras, Minyak, Gula">
                        @error('kategori')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="row g-3 mb-3">
                        <div class="col-6">
                            <label class="form-label fw-semibold">Harga (Rp)</label>
                            <input type="number" name="harga"
                                   class="form-control @error('harga') is-invalid @enderror"
                                   value="{{ old('harga', $produk->harga) }}"
                                   placeholder="Contoh: 15000">
                            @error('harga')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-6">
                            <label class="form-label fw-semibold">Stok</label>
                            <input type="number" name="stok"
                                   class="form-control @error('stok') is-invalid @enderror"
                                   value="{{ old('stok', $produk->stok) }}"
                                   placeholder="Contoh: 100">
                            @error('stok')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="form-label fw-semibold">Satuan</label>
                        <input type="text" name="satuan"
                               class="form-control @error('satuan') is-invalid @enderror"
                               value="{{ old('satuan', $produk->satuan) }}"
                               placeholder="Contoh: kg, liter, pcs, bungkus">
                        @error('satuan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <button type="submit" class="btn btn-warning fw-bold w-100">
                        <i class="bi bi-save"></i> Simpan Perubahan
                    </button>
                </form>
            </div>
        </div>

    </div>
</div>

@endsection