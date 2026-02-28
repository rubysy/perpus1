<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class UserPeminjamanController extends Controller
{
    public function index()
    {
        $history = Peminjaman::with(['buku'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(10);
            
        return view('user.history.index', compact('history'));
    }

    public function ajukanKembali($id)
    {
        $peminjaman = Peminjaman::where('user_id', auth()->id())->findOrFail($id);
        
        if ($peminjaman->status !== 'dipinjam') {
            return redirect()->back()->with('error', 'Status peminjaman tidak valid.');
        }

        $peminjaman->update([
            'status' => 'pengajuan_kembali'
        ]);

        return redirect()->back()->with('success', 'Pengajuan pengembalian berhasil dikirim.');
    }
}
