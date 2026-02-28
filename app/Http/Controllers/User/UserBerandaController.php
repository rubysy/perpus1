<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\KategoriBuku;
use Illuminate\Http\Request;

class UserBerandaController extends Controller
{
    public function index(Request $request)
    {
        $query = Buku::with('kategori');

        // Filter pencarian
        if ($request->filled('search')) {
            $query->where('judul', 'like', '%' . $request->search . '%')
                  ->orWhere('penulis', 'like', '%' . $request->search . '%');
        }

        // Filter kategori
        if ($request->filled('kategori')) {
            $query->whereHas('kategori', function($q) use ($request) {
                $q->where('kategori_buku.id', $request->kategori);
            });
        }

        $buku = $query->latest()->paginate(12);
        $kategori = KategoriBuku::all();

        return view('user.beranda', compact('buku', 'kategori'));
    }
}
