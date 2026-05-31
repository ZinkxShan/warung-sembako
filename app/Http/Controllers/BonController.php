<?php

namespace App\Http\Controllers;

use App\Models\Bon;
use App\Models\BonItem;
use App\Models\Produk;
use Illuminate\Http\Request;

class BonController extends Controller
{
    // Daftar bon yang belum lunas
    public function index()
    {
        $bons = Bon::where('status', 'belum_lunas')
                    ->orderBy('tanggal_bon', 'desc')
                    ->get();
        return view('bon.index', compact('bons'));
    }

    // Riwayat bon yang sudah lunas
    public function riwayat()
    {
        $bons = Bon::where('status', 'lunas')
                    ->orderBy('tanggal_lunas', 'desc')
                    ->get();
        return view('bon.riwayat', compact('bons'));
    }

    // Form buat bon baru
    public function create()
    {
        $produks = Produk::orderBy('kategori')->get();
        // Ambil nama pelanggan yang punya bon aktif
        $pelangganAktif = Bon::where('status', 'belum_lunas')
                            ->pluck('nama_pelanggan')
                            ->unique()
                            ->values();
        return view('bon.create', compact('produks', 'pelangganAktif'));
    }

    // Simpan bon baru atau tambah ke bon existing
    public function store(Request $request)
    {
        $request->validate([
            'nama_pelanggan' => 'required|string|max:255',
            'tanggal_bon'    => 'required|date',
            'produk_id'      => 'required|array|min:1',
            'produk_id.*'    => 'required|exists:produks,id',
            'jumlah.*'       => 'required|integer|min:1',
            'harga_satuan.*' => 'required|numeric|min:0',
        ]);

        // Cek apakah pelanggan sudah punya bon aktif
        $bon = Bon::where('nama_pelanggan', $request->nama_pelanggan)
                    ->where('status', 'belum_lunas')
                    ->first();

        // Hitung total tambahan
        $tambahan = 0;
        foreach ($request->produk_id as $index => $produkId) {
            $tambahan += $request->jumlah[$index] * $request->harga_satuan[$index];
        }

        if ($bon) {
            // Tambahkan ke bon yang sudah ada
            $bon->update([
                'total_harga' => $bon->total_harga + $tambahan,
                'catatan'     => $request->catatan ?? $bon->catatan,
            ]);
        } else {
            // Buat bon baru
            $bon = Bon::create([
                'nama_pelanggan' => $request->nama_pelanggan,
                'total_harga'    => $tambahan,
                'jumlah_bayar'   => 0,
                'status'         => 'belum_lunas',
                'tanggal_bon'    => $request->tanggal_bon,
                'catatan'        => $request->catatan,
            ]);
        }

        // Simpan items
        foreach ($request->produk_id as $index => $produkId) {
            $jumlah = $request->jumlah[$index];
            $harga  = $request->harga_satuan[$index];
            BonItem::create([
                'bon_id'       => $bon->id,
                'produk_id'    => $produkId,
                'jumlah'       => $jumlah,
                'harga_satuan' => $harga,
                'subtotal'     => $jumlah * $harga,
            ]);
        }

        return redirect()->route('bon.show', $bon)
            ->with('sukses', 'Belanjaan berhasil ditambahkan ke bon!');
    }

    // Detail bon
    public function show(Bon $bon)
    {
        $bon->load('items.produk');
        $produks = Produk::orderBy('kategori')->get();
        return view('bon.show', compact('bon', 'produks'));
    }

    // Tambah item langsung dari halaman detail
    public function tambahItem(Request $request, Bon $bon)
    {
        $request->validate([
            'produk_id'    => 'required|exists:produks,id',
            'jumlah'       => 'required|integer|min:1',
            'harga_satuan' => 'required|numeric|min:0',
        ]);

        $subtotal = $request->jumlah * $request->harga_satuan;

        BonItem::create([
            'bon_id'       => $bon->id,
            'produk_id'    => $request->produk_id,
            'jumlah'       => $request->jumlah,
            'harga_satuan' => $request->harga_satuan,
            'subtotal'     => $subtotal,
        ]);

        $bon->update([
            'total_harga' => $bon->total_harga + $subtotal,
        ]);

        return redirect()->route('bon.show', $bon)
            ->with('sukses', 'Item berhasil ditambahkan!');
    }

    // Proses bayar/lunasi
    public function bayar(Request $request, Bon $bon)
    {
        $request->validate([
            'jumlah_bayar' => 'required|numeric|min:1',
        ]);

        $totalBayar = $bon->jumlah_bayar + $request->jumlah_bayar;
        $status     = $totalBayar >= $bon->total_harga ? 'lunas' : 'belum_lunas';

        $bon->update([
            'jumlah_bayar'  => $totalBayar,
            'status'        => $status,
            'tanggal_lunas' => $status === 'lunas' ? now()->toDateString() : null,
        ]);

        return redirect()->route('bon.show', $bon)
            ->with('sukses', $status === 'lunas' ? 'Hutang lunas!' : 'Pembayaran berhasil dicatat!');
    }

    // Hapus item dari bon
    public function hapusItem(BonItem $bonItem)
    {
        $bon = $bonItem->bon;
        $bon->update([
            'total_harga' => $bon->total_harga - $bonItem->subtotal,
        ]);
        $bonItem->delete();

        return redirect()->route('bon.show', $bon)
            ->with('sukses', 'Item berhasil dihapus!');
    }

    // Hapus bon
    public function destroy(Bon $bon)
    {
        $bon->delete();
        return redirect()->route('bon.index')
            ->with('sukses', 'Bon berhasil dihapus!');
    }
}