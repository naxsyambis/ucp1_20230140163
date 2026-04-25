<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Product; 

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar semua kategori.
     */
    public function index()
    {
        // Mengambil semua kategori beserta relasi produknya
        $kategoris = Kategori::with('products')->get(); 
        
        return view('kategori.index', compact('kategoris'));
    }

    /**
     * Menampilkan form untuk membuat kategori baru.
     */
    public function create()
    {
        // Berdasarkan struktur baru, Kategori tidak butuh data Produk saat dibuat.
        // Cukup tampilkan view form saja.
        return view('kategori.create');
    }

    /**
     * Menyimpan kategori baru ke database.
     */
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

    /**
     * Menampilkan detail kategori tertentu.
     */
    public function show($id)
    {
        // Mencari kategori berdasarkan ID dan memuat relasi produk yang dimilikinya
        $kategori = Kategori::with('products')->findOrFail($id);
        
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