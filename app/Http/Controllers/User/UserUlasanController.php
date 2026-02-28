<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Ulasan;
use Illuminate\Http\Request;

class UserUlasanController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'komentar' => 'nullable|string'
        ]);

        // Cek apakah user benar-benar telah meminjam dan mengembalikan buku ini sesuai peminjaman id
        $peminjaman = Peminjaman::where('id', $id)
            ->where('user_id', auth()->id())
            ->where('status', 'dikembalikan')
            ->firstOrFail();

        // Cek jika sudah pernah mereview
        if (Ulasan::where('peminjaman_id', $id)->exists()) {
            return redirect()->back()->with('error', 'Anda sudah memberikan ulasan untuk peminjaman ini.');
        }

        Ulasan::create([
            'user_id' => auth()->id(),
            'buku_id' => $peminjaman->buku_id,
            'peminjaman_id' => $id,
            'rating' => $request->rating,
            'komentar' => $request->komentar,
        ]);

        return redirect()->back()->with('success', 'Ulasan berhasil ditambahkan.');
    }
}
