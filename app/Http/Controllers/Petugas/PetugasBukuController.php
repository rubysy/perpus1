<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PetugasBukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->latest()->paginate(10);
        return view('petugas.buku.index', compact('buku'));
    }

    public function create()
    {
        $kategori = KategoriBuku::all();
        return view('petugas.buku.create', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:255|unique:buku',
            'tahun_terbit' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori' => 'required|array',
            'kategori.*' => 'exists:kategori_buku,id'
        ]);

        $data = $request->except(['cover', 'kategori']);

        if ($request->hasFile('cover')) {
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku = Buku::create($data);
        $buku->kategori()->sync($request->kategori);

        return redirect()->route('petugas.buku.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(Buku $buku)
    {
        // Not used
    }

    public function edit(Buku $buku)
    {
        $kategori = KategoriBuku::all();
        $bukuKategori = $buku->kategori->pluck('id')->toArray();
        return view('petugas.buku.edit', compact('buku', 'kategori', 'bukuKategori'));
    }

    public function update(Request $request, Buku $buku)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'penerbit' => 'required|string|max:255',
            'isbn' => 'nullable|string|max:255|unique:buku,isbn,'.$buku->id,
            'tahun_terbit' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
            'stok' => 'required|integer|min:0',
            'cover' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'kategori' => 'required|array',
            'kategori.*' => 'exists:kategori_buku,id'
        ]);

        $data = $request->except(['cover', 'kategori']);

        if ($request->hasFile('cover')) {
            if ($buku->cover) {
                Storage::disk('public')->delete($buku->cover);
            }
            $data['cover'] = $request->file('cover')->store('covers', 'public');
        }

        $buku->update($data);
        $buku->kategori()->sync($request->kategori);

        return redirect()->route('petugas.buku.index')->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy(Buku $buku)
    {
        if ($buku->cover) {
            Storage::disk('public')->delete($buku->cover);
        }
        $buku->delete();

        return redirect()->route('petugas.buku.index')->with('success', 'Buku berhasil dihapus!');
    }
}
