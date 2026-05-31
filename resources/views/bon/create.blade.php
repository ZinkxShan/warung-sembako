@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-lg-8">

        <div class="mb-4">
            <a href="{{ route('bon.index') }}" class="text-muted text-decoration-none">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
            <h2 class="fw-bold mt-2 mb-0" style="color: #1f2937;">🧾 Buat Bon / Tambah Belanjaan</h2>
        </div>

        {{-- Alert pelanggan aktif --}}
        <div id="alertPelangganAktif" class="alert alert-warning d-none">
            <i class="bi bi-exclamation-triangle"></i>
            Pelanggan ini sudah punya bon aktif. Belanjaan akan <strong>ditambahkan ke bon yang sudah ada</strong>.
        </div>

        <form action="{{ route('bon.store') }}" method="POST" id="formBon">
            @csrf

            {{-- Info Pelanggan --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <h6 class="fw-bold mb-3" style="color: #d97706;">
                        <i class="bi bi-person"></i> Info Pelanggan
                    </h6>
                    <div class="row g-3">
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Nama Pelanggan</label>
                            <input type="text" name="nama_pelanggan" id="namaPelanggan"
                                   class="form-control @error('nama_pelanggan') is-invalid @enderror"
                                   value="{{ old('nama_pelanggan') }}"
                                   placeholder="Contoh: Bu Sari"
                                   list="daftarPelanggan"
                                   autocomplete="off">
                            {{-- Autocomplete dari pelanggan aktif --}}
                            <datalist id="daftarPelanggan">
                                @foreach($pelangganAktif as $nama)
                                    <option value="{{ $nama }}">
                                @endforeach
                            </datalist>
                            @error('nama_pelanggan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12 col-sm-6">
                            <label class="form-label fw-semibold">Tanggal</label>
                            <input type="date" name="tanggal_bon"
                                   class="form-control @error('tanggal_bon') is-invalid @enderror"
                                   value="{{ old('tanggal_bon', date('Y-m-d')) }}">
                            @error('tanggal_bon')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <div class="col-12">
                            <label class="form-label fw-semibold">
                                Catatan <span class="text-muted fw-normal">(opsional)</span>
                            </label>
                            <input type="text" name="catatan" class="form-control"
                                   value="{{ old('catatan') }}"
                                   placeholder="Contoh: Bayar akhir bulan">
                        </div>
                    </div>
                </div>
            </div>

            {{-- Daftar Produk --}}
            <div class="card border-0 shadow-sm mb-4" style="border-radius: 12px;">
                <div class="card-body p-4">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h6 class="fw-bold mb-0" style="color: #d97706;">
                            <i class="bi bi-cart3"></i> Daftar Belanjaan
                        </h6>
                        <button type="button" class="btn btn-sm btn-warning fw-bold" id="tambahItem">
                            <i class="bi bi-plus"></i> Tambah Item
                        </button>
                    </div>

                    <div id="daftarItem">
                        <div class="item-row row g-2 align-items-end mb-3">
                            <div class="col-12 col-sm-4">
                                <label class="form-label fw-semibold small">Produk</label>
                                <select name="produk_id[]" class="form-select produk-select">
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
                                <input type="number" name="harga_satuan[]"
                                       class="form-control harga-input"
                                       placeholder="0" min="0">
                            </div>
                            <div class="col-6 col-sm-2">
                                <label class="form-label fw-semibold small">Jumlah</label>
                                <input type="number" name="jumlah[]"
                                       class="form-control jumlah-input"
                                       placeholder="1" min="1" value="1">
                            </div>
                            <div class="col-9 col-sm-2">
                                <label class="form-label fw-semibold small">Subtotal</label>
                                <input type="text" class="form-control subtotal-input bg-light"
                                       placeholder="Rp 0" readonly>
                            </div>
                            <div class="col-3 col-sm-1 d-flex align-items-end">
                                <button type="button"
                                        class="btn btn-outline-danger btn-hapus-item w-100"
                                        style="display:none!important">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="d-flex justify-content-end align-items-center gap-3">
                        <span class="fw-bold" style="color: #1f2937;">Total:</span>
                        <span class="fw-bold" id="totalHarga"
                              style="color: #dc2626; font-size: 1.2rem;">Rp 0</span>
                    </div>
                </div>
            </div>

            <button type="submit" class="btn btn-warning fw-bold w-100">
                <i class="bi bi-save"></i> Simpan
            </button>
        </form>

    </div>
</div>

<script>
// Daftar pelanggan yang punya bon aktif
const pelangganAktif = @json($pelangganAktif);

// Deteksi jika nama pelanggan sudah punya bon aktif
document.getElementById('namaPelanggan').addEventListener('input', function() {
    const nama  = this.value.trim().toLowerCase();
    const aktif = pelangganAktif.map(n => n.toLowerCase());
    const alert = document.getElementById('alertPelangganAktif');

    if (nama && aktif.includes(nama)) {
        alert.classList.remove('d-none');
    } else {
        alert.classList.add('d-none');
    }
});

// Auto-isi harga saat pilih produk
document.addEventListener('change', function(e) {
    if (e.target.classList.contains('produk-select')) {
        const row   = e.target.closest('.item-row');
        const harga = e.target.selectedOptions[0]?.dataset.harga || 0;
        row.querySelector('.harga-input').value = harga;
        hitungSubtotal(row);
    }
});

// Hitung subtotal saat harga/jumlah berubah
document.addEventListener('input', function(e) {
    if (e.target.classList.contains('harga-input') ||
        e.target.classList.contains('jumlah-input')) {
        hitungSubtotal(e.target.closest('.item-row'));
    }
});

function hitungSubtotal(row) {
    const harga  = parseFloat(row.querySelector('.harga-input').value) || 0;
    const jumlah = parseFloat(row.querySelector('.jumlah-input').value) || 0;
    const sub    = harga * jumlah;
    row.querySelector('.subtotal-input').value =
        'Rp ' + sub.toLocaleString('id-ID');
    hitungTotal();
}

function hitungTotal() {
    let total = 0;
    document.querySelectorAll('.subtotal-input').forEach(el => {
        const val = el.value.replace('Rp ', '').replace(/\./g, '').replace(',', '.');
        total += parseFloat(val) || 0;
    });
    document.getElementById('totalHarga').textContent =
        'Rp ' + total.toLocaleString('id-ID');
}

// Tambah item baru
document.getElementById('tambahItem').addEventListener('click', function() {
    const container = document.getElementById('daftarItem');
    const template  = container.querySelector('.item-row').cloneNode(true);

    template.querySelector('.produk-select').value  = '';
    template.querySelector('.harga-input').value    = '';
    template.querySelector('.jumlah-input').value   = '1';
    template.querySelector('.subtotal-input').value = '';
    template.querySelector('.btn-hapus-item').style.removeProperty('display');

    container.appendChild(template);
});

// Hapus item
document.addEventListener('click', function(e) {
    if (e.target.closest('.btn-hapus-item')) {
        e.target.closest('.item-row').remove();
        hitungTotal();
    }
});
</script>

@endsection