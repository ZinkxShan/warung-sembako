@extends('layouts.app')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h2 class="fw-bold mb-1" style="color: #1f2937;">Riwayat Bon</h2>
        <p class="text-muted mb-0">Hutang pelanggan yang sudah lunas</p>
    </div>
</div>

@if($bons->isEmpty())
    <div class="text-center py-5">
        <i class="bi bi-inbox" style="font-size: 4rem; color: #d1d5db;"></i>
        <p class="mt-3 text-muted">Belum ada riwayat bon yang lunas.</p>
    </div>
@else
    <div class="card border-0 shadow-sm" style="border-radius: 12px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead style="background-color: #f0fdf4;">
                        <tr>
                            <th class="px-4 py-3" style="color: #166534;">#</th>
                            <th class="py-3" style="color: #166534;">Pelanggan</th>
                            <th class="py-3" style="color: #166534;">Tanggal Bon</th>
                            <th class="py-3" style="color: #166534;">Tanggal Lunas</th>
                            <th class="py-3" style="color: #166534;">Total</th>
                            <th class="py-3 text-center" style="color: #166534;">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($bons as $index => $bon)
                        <tr>
                            <td class="px-4">{{ $index + 1 }}</td>
                            <td class="fw-semibold">{{ $bon->nama_pelanggan }}</td>
                            <td>{{ \Carbon\Carbon::parse($bon->tanggal_bon)->format('d M Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($bon->tanggal_lunas)->format('d M Y') }}</td>
                            <td class="fw-bold text-success">
                                Rp {{ number_format($bon->total_harga, 0, ',', '.') }}
                            </td>
                            <td class="text-center">
                                <a href="{{ route('bon.show', $bon) }}"
                                   class="btn btn-sm btn-outline-success">
                                    <i class="bi bi-eye"></i> Detail
                                </a>
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