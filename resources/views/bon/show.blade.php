@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-lg-7">

        <div class="mb-4">
            <a href="{{ route('bon.index') }}" class="text-muted text-decoration-none">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <h2 class="fw-bold mt-2 mb-0" style="color: #1f2937;">🧾 Detail Bon</h2>
        </div>

        @if(session('sukses'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="bi bi-check-circle"></i> {{ session('sukses') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        {{-- Info Bon --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <div class="d-flex justify-content-between align-items-start mb-3">
                    <div>
                        <h5 class="fw-bold mb-1">{{ $bon->nama_pelanggan }}</h5>
                        <p class="text-muted small mb-0">
                            <i class="bi bi-calendar3"></i>
                            Bon sejak {{ \Carbon\Carbon::parse($bon->tanggal_bon)->format('d M Y') }}
                        </p>
                    </div>
                    @if($bon->status === 'lunas')
                        <span class="badge bg-success fs-6">✅ Lunas</span>
                    @else
                        <span class="badge bg-danger fs-6">❌ Belum Lunas</span>
                    @endif
                </div>
                @if($bon->catatan)
                <p class="text-muted small mb-0">
                    <i class="bi bi-chat-left-text"></i> {{ $bon->catatan }}
                </p>
                @endif
            </div>
        </div>

        {{-- Daftar Belanjaan --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-0">
                <div class="px-4 pt-4 pb-2">
                    <h6 class="fw-bold" style="color: #d97706;">
                        <i class="bi bi-cart3"></i> Daftar Belanjaan
                    </h6>
                </div>
                <div class="table-responsive">
                    <table class="table align-middle mb-0">
                        <thead style="background-color: #fef3c7;">
                            <tr>
                                <th class="px-4 py-2" style="color: #92400e;">Produk</th>
                                <th class="py-2" style="color: #92400e;">Harga</th>
                                <th class="py-2" style="color: #92400e;">Jumlah</th>
                                <th class="py-2" style="color: #92400e;">Subtotal</th>
                                @if($bon->status === 'belum_lunas')
                                <th class="py-2 text-center" style="color: #92400e;">Aksi</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($bon->items as $item)
                            <tr>
                                <td class="px-4 fw-semibold">{{ $item->produk->nama_produk }}</td>
                                <td>Rp {{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                <td>{{ $item->jumlah }}x</td>
                                <td class="fw-bold">
                                    Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                                </td>
                                @if($bon->status === 'belum_lunas')
                                <td class="text-center">
                                    <form action="{{ route('bon.hapusItem', $item) }}"
                                          method="POST"
                                          onsubmit="return confirm('Hapus item ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="btn btn-sm btn-outline-danger">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                @endif
                            </tr>
                            @endforeach
                        </tbody>
                        <tfoot style="background-color: #f9fafb;">
                            <tr>
                                <td colspan="{{ $bon->status === 'belum_lunas' ? 4 : 3 }}"
                                    class="px-4 fw-bold text-end">Total:</td>
                                <td class="fw-bold" style="color: #dc2626;">
                                    Rp {{ number_format($bon->total_harga, 0, ',', '.') }}
                                </td>
                            </tr>
                            @if($bon->jumlah_bayar > 0)
                            <tr>
                                <td colspan="{{ $bon->status === 'belum_lunas' ? 4 : 3 }}"
                                    class="px-4 fw-bold text-end">Sudah Dibayar:</td>
                                <td class="fw-bold text-success">
                                    Rp {{ number_format($bon->jumlah_bayar, 0, ',', '.') }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="{{ $bon->status === 'belum_lunas' ? 4 : 3 }}"
                                    class="px-4 fw-bold text-end">Sisa:</td>
                                <td class="fw-bold" style="color: #f59e0b;">
                                    Rp {{ number_format($bon->total_harga - $bon->jumlah_bayar, 0, ',', '.') }}
                                </td>
                            </tr>
                            @endif
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        @if($bon->status === 'belum_lunas')

        {{-- Tambah Item --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3" style="color: #d97706;">
                    <i class="bi bi-plus-circle"></i> Tambah Belanjaan
                </h6>
                <form action="{{ route('bon.tambahItem', $bon) }}" method="POST">
                    @csrf
                    <div class="row g-2 align-items-end">
                        <div class="col-12 col-sm-4">
                            <label class="form-label fw-semibold small">Produk</label>
                            <select name="produk_id" class="form-select" id="produkSelect">
                                <option value="">-- Pilih Produk --</option>
                                @foreach($produks as $produk)
                                    <option value="{{ $produk->id }}"
                                            data-harga="{{ $produk->harga }}">
                                        {{ $produk->nama_produk }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-6 col-sm-3">
                            <label class="form-label fw-semibold small">Harga (Rp)</label>
                            <input type="number" name="harga_satuan" id="hargaInput"
                                   class="form-control" placeholder="0" min="0">
                        </div>
                        <div class="col-6 col-sm-2">
                            <label class="form-label fw-semibold small">Jumlah</label>
                            <input type="number" name="jumlah"
                                   class="form-control" placeholder="1"
                                   min="1" value="1">
                        </div>
                        <div class="col-12 col-sm-3">
                            <button type="submit" class="btn btn-warning fw-bold w-100">
                                <i class="bi bi-plus"></i> Tambah
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        {{-- Form Bayar --}}
        <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
            <div class="card-body p-4">
                <h6 class="fw-bold mb-3" style="color: #d97706;">
                    <i class="bi bi-cash-coin"></i> Catat Pembayaran
                </h6>
                <form action="{{ route('bon.bayar', $bon) }}" method="POST">
                    @csrf
                    <div class="d-flex gap-2">
                        <input type="number" name="jumlah_bayar"
                               class="form-control @error('jumlah_bayar') is-invalid @enderror"
                               placeholder="Masukkan jumlah bayar" min="1">
                        @error('jumlah_bayar')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <button type="submit" class="btn btn-success fw-bold text-nowrap">
                            <i class="bi bi-check-circle"></i> Bayar
                        </button>
                    </div>
                </form>
            </div>
        </div>

        @endif

        {{-- Tombol Hapus --}}
        <form action="{{ route('bon.destroy', $bon) }}" method="POST"
              onsubmit="return confirm('Yakin ingin menghapus seluruh bon ini?')">
            @csrf
            @method('DELETE')
            <button type="submit" class="btn btn-outline-danger w-100">
                <i class="bi bi-trash"></i> Hapus Bon
            </button>
        </form>

    </div>
</div>

<script>
// Auto-isi harga saat pilih produk
document.getElementById('produkSelect').addEventListener('change', function() {
    const harga = this.selectedOptions[0]?.dataset.harga || '';
    document.getElementById('hargaInput').value = harga;
});
</script>

@endsection