<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Kategori;
use App\Models\Product; // Wajib dipanggil untuk dropdown produk

class KategoriController extends Controller
{
    public function index()
    {
        $kategoris = Kategori::with('product')->get();
        return view('kategori.index', compact('kategoris'));
    }

    public function create()
    {
        $products = Product::all(); // Ambil semua data produk untuk pilihan di form
        return view('kategori.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
        ]);

        Kategori::create([
            'name' => $request->name,
            'product_id' => $request->product_id,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function show($id)
    {
        $kategori = Kategori::with('product')->findOrFail($id);
        return view('kategori.view', compact('kategori'));
    }

    public function edit($id)
    {
        $kategori = Kategori::findOrFail($id);
        $products = Product::all();
        return view('kategori.edit', compact('kategori', 'products'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
        ]);

        $kategori = Kategori::findOrFail($id);
        $kategori->update([
            'name' => $request->name,
            'product_id' => $request->product_id,
        ]);

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy($id)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->delete();

        return redirect()->route('kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}