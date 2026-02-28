<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\KoleksiPribadi;
use Illuminate\Http\Request;

class UserKoleksiController extends Controller
{
    public function index()
    {
        $koleksi = KoleksiPribadi::with(['buku.kategori'])
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12);
            
        return view('user.koleksi.index', compact('koleksi'));
    }

    public function toggle($id)
    {
        $user_id = auth()->id();
        
        $koleksi = KoleksiPribadi::where('user_id', $user_id)->where('buku_id', $id)->first();
        
        if ($koleksi) {
            $koleksi->delete();
            return response()->json(['success' => true, 'status' => 'removed', 'message' => 'Dihapus dari koleksi pribadi.']);
        } else {
            KoleksiPribadi::create([
                'user_id' => $user_id,
                'buku_id' => $id
            ]);
            return response()->json(['success' => true, 'status' => 'added', 'message' => 'Ditambahkan ke koleksi pribadi.']);
        }
    }
}
