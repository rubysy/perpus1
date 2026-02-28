<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminPeminjamanController extends Controller
{
    public function index()
    {
        $peminjaman = Peminjaman::with(['user', 'buku'])
            ->whereIn('status', ['menunggu', 'disetujui', 'dipinjam', 'ditolak'])
            ->latest()
            ->paginate(10);
            
        return view('admin.peminjaman.index', compact('peminjaman'));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Status peminjaman tidak valid.');
        }

        if ($peminjaman->buku->stok <= 0) {
            return redirect()->back()->with('error', 'Stok buku habis.');
        }

        // Kurangi stok buku
        $peminjaman->buku->decrement('stok');

        $peminjaman->update([
            'status' => 'dipinjam' // Langsung jadi dipinjam saat disetujui (sesuai instruksi)
        ]);

        return redirect()->back()->with('success', 'Peminjaman disetujui.');
    }

    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->status !== 'menunggu') {
            return redirect()->back()->with('error', 'Status peminjaman tidak valid.');
        }

        $peminjaman->update([
            'status' => 'ditolak'
        ]);

        return redirect()->back()->with('success', 'Peminjaman ditolak.');
    }
}
