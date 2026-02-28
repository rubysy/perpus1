<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

class AdminPengembalianController extends Controller
{
    public function index()
    {
        $pengembalian = Peminjaman::with(['user', 'buku'])
            ->whereIn('status', ['pengajuan_kembali', 'dikembalikan'])
            ->latest()
            ->paginate(10);
            
        return view('admin.pengembalian.index', compact('pengembalian'));
    }

    public function approve($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        
        if ($peminjaman->status !== 'pengajuan_kembali') {
            return redirect()->back()->with('error', 'Status peminjaman tidak valid.');
        }

        // Kembalikan stok buku
        $peminjaman->buku->increment('stok');

        $peminjaman->update([
            'status' => 'dikembalikan'
        ]);

        return redirect()->back()->with('success', 'Pengembalian disetujui.');
    }
}
