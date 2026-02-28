<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PetugasAkunController extends Controller
{
    public function index()
    {
        // Petugas hanya bisa melihat daftar user (bukan admin dan bukan sesama petugas)
        $users = User::where('role', 'user')->latest()->paginate(10);
        return view('petugas.akun.index', compact('users'));
    }
}
