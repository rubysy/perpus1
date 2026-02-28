<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class PetugasKategoriController extends Controller
{
    public function index()
    {
        $kategori = KategoriBuku::latest()->paginate(10);
        return view('petugas.kategori.index', compact('kategori'));
    }

    public function create()
    {
        return view('petugas.kategori.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_buku',
        ]);

        KategoriBuku::create($request->all());

        return redirect()->route('petugas.kategori.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function edit(KategoriBuku $kategori)
    {
        return view('petugas.kategori.edit', compact('kategori'));
    }

    public function update(Request $request, KategoriBuku $kategori)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:kategori_buku,nama,' . $kategori->id,
        ]);

        $kategori->update($request->all());

        return redirect()->route('petugas.kategori.index')->with('success', 'Kategori berhasil diupdate!');
    }

    public function destroy(KategoriBuku $kategori)
    {
        $kategori->delete();
        return redirect()->route('petugas.kategori.index')->with('success', 'Kategori berhasil dihapus!');
    }
}
