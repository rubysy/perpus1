<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminAkunController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'user')->latest()->paginate(10, ['*'], 'user_page');
        $petugas = User::where('role', 'petugas')->latest()->paginate(10, ['*'], 'petugas_page');
        
        return view('admin.akun.index', compact('users', 'petugas'));
    }
    public function create()
    {
        return view('admin.akun.create');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'alamat' => ['required', 'string'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'petugas', // Force set to petugas from this form
            'alamat' => $request->alamat,
        ]);

        return redirect()->route('admin.akun.index')->with('success', 'Akun petugas berhasil dibuat!');
    }

    public function edit(User $akun)
    {
        return view('admin.akun.edit', compact('akun'));
    }

    public function update(Request $request, User $akun)
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($akun->id)],
            'alamat' => ['required', 'string'],
        ];

        if ($request->filled('password')) {
            $rules['password'] = ['string', 'min:8', 'confirmed'];
        }

        $request->validate($rules);

        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'alamat' => $request->alamat,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $akun->update($data);

        return redirect()->route('admin.akun.index')->with('success', 'Akun berhasil diupdate!');
    }

    public function destroy(User $akun)
    {
        // Don't allow destroying self or other admins
        if ($akun->id === auth()->id() || $akun->role === 'admin') {
            return redirect()->route('admin.akun.index')->with('error', 'Tidak dapat menghapus akun ini!');
        }

        $akun->delete();
        return redirect()->route('admin.akun.index')->with('success', 'Akun berhasil dihapus!');
    }
}

// hahay