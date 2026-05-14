<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Kategori; // Sesuaikan dengan nama modelmu (Kategori)
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    // GET: Menampilkan semua kategori
    public function index()
    {
        $categories = Kategori::all();
        return response()->json([
            'message' => 'Daftar kategori berhasil diambil',
            'data' => $categories
        ], 200);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $category = Kategori::create($validated);

        return response()->json([
            'message' => 'Kategori berhasil ditambahkan',
            'data' => $category
        ], 201);
    }

    public function show($id)
    {
        $category = Kategori::find($id);
        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }
        return response()->json(['data' => $category], 200);
    }

    public function update(Request $request, $id)
    {
        $category = Kategori::find($id);
        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        $validated = $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Kategori berhasil diupdate',
            'data' => $category
        ], 200);
    }

    public function destroy($id)
    {
        $category = Kategori::find($id);
        if (!$category) {
            return response()->json(['message' => 'Kategori tidak ditemukan'], 404);
        }

        $category->delete();
        return response()->json(['message' => 'Kategori berhasil dihapus'], 200);
    }
}