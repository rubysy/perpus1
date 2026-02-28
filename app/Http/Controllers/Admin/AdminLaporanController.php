<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminLaporanController extends Controller
{
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        $peminjaman = $query->latest()->get();

        return view('admin.laporan.index', compact('peminjaman'));
    }

    public function pdf(Request $request)
    {
        $query = Peminjaman::with(['user', 'buku']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('start_date') && $request->filled('end_date')) {
            $query->whereBetween('tanggal_pinjam', [$request->start_date, $request->end_date]);
        }

        $peminjaman = $query->latest()->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('peminjaman'));
        
        return $pdf->download('laporan-peminjaman-' . now()->format('Y-m-d') . '.pdf');
    }
}
