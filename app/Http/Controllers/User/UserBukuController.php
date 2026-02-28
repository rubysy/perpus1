<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class UserBukuController extends Controller
{
    public function show($id)
    {
        $buku = Buku::with(['kategori', 'ulasan.user'])->findOrFail($id);
        
        $user_id = auth()->id();
        $is_koleksi = \App\Models\KoleksiPribadi::where('user_id', $user_id)->where('buku_id', $id)->exists();
        
        // Cek jika sedang meminjam buku ini namun belum dikembalikan
        $sedang_dipinjam = Peminjaman::where('user_id', $user_id)
            ->where('buku_id', $id)
            ->whereIn('status', ['menunggu', 'disetujui', 'dipinjam', 'pengajuan_kembali'])
            ->exists();

        return response()->json([
            'buku' => $buku,
            'is_koleksi' => $is_koleksi,
            'sedang_dipinjam' => $sedang_dipinjam,
            'average_rating' => $buku->averageRating()
        ]);
    }

    public function pinjam(Request $request, $id)
    {
        $request->validate([
            'nama_peminjam' => 'required|string|max:255',
            'alamat' => 'required|string',
            'durasi_pinjam' => 'required|integer|min:1|max:14',
        ]);

        $buku = Buku::findOrFail($id);
        $user_id = auth()->id();

        if ($buku->stok <= 0) {
            return response()->json(['success' => false, 'message' => 'Stok buku habis.']);
            // return redirect()->back()->with('error', 'Stok buku habis.');
        }

        // Cek apakah user sedang meminjam buku yang sama
        $sedang_dipinjam = Peminjaman::where('user_id', $user_id)
            ->where('buku_id', $id)
            ->whereIn('status', ['menunggu', 'disetujui', 'dipinjam', 'pengajuan_kembali'])
            ->exists();

        if ($sedang_dipinjam) {
            return response()->json(['success' => false, 'message' => 'Anda masih meminjam buku ini.']);
        }

        Peminjaman::create([
            'user_id' => $user_id,
            'buku_id' => $id,
            'nama_peminjam' => $request->nama_peminjam,
            'alamat' => $request->alamat,
            'tanggal_pinjam' => today(),
            'durasi_pinjam' => $request->durasi_pinjam,
            'status' => 'menunggu'
        ]);

        return response()->json(['success' => true, 'message' => 'Pengajuan peminjaman berhasil.']);
        // return redirect()->route('user.history.index')->with('success', 'Pengajuan peminjaman berhasil.');
    }
}
