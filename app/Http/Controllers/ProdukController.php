<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use Illuminate\Http\Request;

class ProdukController extends Controller
{
    // Halaman daftar harga (publik)
    public function harga()
    {
        $produks = Produk::orderBy('kategori')->get();
        return view('harga', compact('produks'));
    }

    // Halaman kelola produk
    public function index(Request $request)
{
    $search = $request->get('search');

    $produks = Produk::when($search, function ($query, $search) {
                    $query->where('nama_produk', 'like', "%{$search}%")
                          ->orWhere('kategori', 'like', "%{$search}%");
                })
                ->orderBy('kategori')
                ->get();

    return view('produk.index', compact('produks', 'search'));
}

    // Form tambah produk
    public function create()
    {
        return view('produk.create');
    }

    // Simpan produk baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori'    => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
        ]);

        Produk::create($request->all());

        return redirect()->route('produk.index')
            ->with('sukses', 'Produk berhasil ditambahkan!');
    }

    // Form edit produk
    public function edit(Produk $produk)
    {
        return view('produk.edit', compact('produk'));
    }

    // Update produk
    public function update(Request $request, Produk $produk)
    {
        $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori'    => 'required|string|max:255',
            'harga'       => 'required|numeric|min:0',
        ]);

        $produk->update($request->all());

        return redirect()->route('produk.index')
            ->with('sukses', 'Produk berhasil diperbarui!');
    }

    // Hapus produk
    public function destroy(Produk $produk)
    {
        $produk->delete();

        return redirect()->route('produk.index')
            ->with('sukses', 'Produk berhasil dihapus!');
    }
}