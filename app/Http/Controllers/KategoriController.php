<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Product; // Wajib dipanggil untuk dropdown produk

class KategoriController extends Controller
{
    public function index()
    {
        // Mengambil semua kategori beserta jumlah produk yang berelasi
        $kategoris = Kategori::with('product')->get();
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        // Cukup tampilkan view form saja.
        return view('kategori.create');
    }

    public function store(Request $request)
    {
        // Validasi input: Nama wajib diisi, berupa teks, dan unik di tabel kategoris
        $request->validate([
            'name' => 'required|string|max:255|unique:kategoris,name',
        ]);

        Kategori::create([
            'name' => $request->name,
        ]);

        // Kembali ke halaman index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show($id)
    {
        // mencari kategori berdasarkan id dan memuat relasi produk
        $kategori = Kategori::with('product')->findOrFail($id);
        return view('kategori.view', compact('kategori'));
    }

    /**
     * Menampilkan form untuk mengedit kategori.
     */

    public function edit($id)
    {
        // Mencari data kategori yang ingin diubah
        $kategori = Kategori::findOrFail($id);
        
        // Cukup kirim data kategori ke view
        return view('kategori.edit', compact('kategori'));
    }

    /**
     * Memperbarui data kategori di database.
     */

    public function update(Request $request, $id)
    {
        // Validasi: unique kecuali untuk ID kategori itu sendiri (agar tidak error saat klik save tanpa ganti nama)
        $request->validate([
            'name' => 'required|string|max:255|unique:kategoris,name,' . $id,
        ]);

        // Cari data kategori yang dimaksud
        $kategori = Kategori::findOrFail($id);

        $kategori->update([
            'name' => $request->name,
        ]);

        // Redirect ke index dengan pesan sukses
        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    /**
     * Menghapus data kategori.
     */

    public function destroy($id)
    {
        // Mencari data yang akan dihapus
        $kategori = Kategori::findOrFail($id);
        
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}