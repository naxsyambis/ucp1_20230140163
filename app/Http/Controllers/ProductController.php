<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use App\Models\Kategori; 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Http\Requests\StoreProductRequest;

class ProductController extends Controller
{
    /**
     * Menampilkan daftar produk.
    */
    public function index()
    {
        // Mengambil produk yang memiliki relasi 'kategori' menggunakan has()
        $products = Product::has('kategori')->with('kategori', 'user')->get();

        return view('product.index', compact('products'));
    }

    /**
     * Menampilkan form untuk menambah produk baru.
     */
    public function create()
    {
        // Mengambil semua data kategori untuk pilihan dropdown di form
        $categories = Kategori::orderBy('name')->get();

        return view('product.create', compact('categories'));
    }

    /**
     * Menyimpan data produk baru ke database.
     */
    public function store(StoreProductRequest $request)
    {
        // Mengambil data yang telah lolos validasi dari StoreProductRequest
        $validated = $request->validated();

        // Mengisi 'user_id' secara otomatis dengan ID user yang sedang login
        $validated['user_id'] = auth()->id();

        // Membuat data produk baru
        Product::create($validated);

        return redirect()->route('product.index')->with('success', 'Product created successfully.');
    }

    /**
     * Menampilkan detail produk tertentu berdasarkan ID.
     */
    public function show($id)
    {
        // Mencari data produk atau menampilkan error 404 jika tidak ditemukan
        $product = Product::findOrFail($id);

        return view('product.view', compact('product'));
    }

    /**
     * Menampilkan form untuk mengedit produk yang sudah ada.
     */
    public function edit(Product $product)
    {
        // Mengambil semua data kategori untuk pilihan dropdown saat edit
        $categories = Kategori::orderBy('name')->get();

        // Mengirimkan data produk yang akan diedit dan daftar kategori ke view
        return view('product.edit', compact('product', 'categories'));
    }

    /**
     * Memperbarui data produk di database.
     */
    public function update(StoreProductRequest $request, $id)
    {
        // Mencari produk yang akan diperbarui berdasarkan ID
        $product = Product::findOrFail($id);

        // Mengambil data baru yang telah divalidasi
        $validated = $request->validated();

        // Melakukan pembaruan data pada model produk
        $product->update($validated);

        return redirect()->route('product.index')->with('success', 'Product updated successfully.');
    }

    /**
     * Menghapus data produk dari database.
     */
    public function delete($id)
    {
        // Mencari data produk berdasarkan ID
        $product = Product::findOrFail($id);

        $product->delete();

        return redirect()->route('product.index')->with('success', 'Product berhasil dihapus');
    }
}