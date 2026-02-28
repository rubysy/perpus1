<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_buku' => Buku::count(),
            'total_user' => User::where('role', 'user')->count(),
            'total_peminjaman' => Peminjaman::count(),
            'peminjaman_aktif' => Peminjaman::where('status', 'dipinjam')->count(),
        ];
        
        $peminjaman_terbaru = Peminjaman::with(['user', 'buku'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'peminjaman_terbaru'));
    }
}
