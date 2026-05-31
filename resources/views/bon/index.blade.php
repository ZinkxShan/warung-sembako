@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="color: #1f2937;">Daftar Bon</h2>
        <p class="text-muted mb-0">Hutang pelanggan yang belum lunas</p>
    </div>
    <a href="{{ route('bon.create') }}" class="btn btn-warning fw-bold">
        <i class="bi bi-plus-circle"></i> Buat Bon
    </a>
</div>

@if(session('sukses'))
    <div class="alert alert-success alert-dismissible fade show">
        <i class="bi bi-check-circle"></i> {{ session('sukses') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    </div>
@endif

@if($bons->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-journal-check" style="font-size: 4rem; color: #d1d5db;"></i>
        <p class="mt-3 text-muted">Tidak ada hutang yang belum lunas.</p>
    </div>
@else
    <div class="row g-3">
        @foreach($bons as $bon)
        <div class="col-12 col-md-6 col-lg-4">
            <div class="card border-0 shadow-sm h-100" style="border-radius: 12px;">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-start mb-2">
                        <h6 class="fw-bold mb-0" style="color: #1f2937;">
                            <i class="bi bi-person"></i> {{ $bon->nama_pelanggan }}
                        </h6>
                        <span class="badge bg-danger">Belum Lunas</span>
                    </div>
                    <p class="text-muted small mb-2">
                        <i class="bi bi-calendar3"></i>
                        {{ \Carbon\Carbon::parse($bon->tanggal_bon)->format('d M Y') }}
                    </p>
                    <div class="mb-2">
                        <p class="mb-1 small text-muted">Total Hutang</p>
                        <p class="fw-bold mb-0" style="color: #dc2626; font-size: 1.1rem;">
                            Rp {{ number_format($bon->total_harga, 0, ',', '.') }}
                        </p>
                    </div>
                    @if($bon->jumlah_bayar > 0)
                    <div class="mb-2">
                        <p class="mb-1 small text-muted">Sudah Dibayar</p>
                        <p class="fw-bold mb-0 text-success">
                            Rp {{ number_format($bon->jumlah_bayar, 0, ',', '.') }}
                        </p>
                    </div>
                    <div class="mb-3">
                        <p class="mb-1 small text-muted">Sisa</p>
                        <p class="fw-bold mb-0" style="color: #f59e0b;">
                            Rp {{ number_format($bon->total_harga - $bon->jumlah_bayar, 0, ',', '.') }}
                        </p>
                    </div>
                    @endif
                    @if($bon->catatan)
                    <p class="text-muted small mb-3">
                        <i class="bi bi-chat-left-text"></i> {{ $bon->catatan }}
                    </p>
                    @endif
                    <a href="{{ route('bon.show', $bon) }}"
                       class="btn btn-warning btn-sm fw-bold w-100">
                        <i class="bi bi-eye"></i> Lihat Detail
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
@endif

@endsection