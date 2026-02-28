<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Admin Routes
Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])->name('dashboard');
    Route::resource('akun', \App\Http\Controllers\Admin\AdminAkunController::class);
    Route::resource('buku', \App\Http\Controllers\Admin\AdminBukuController::class);
    Route::resource('kategori', \App\Http\Controllers\Admin\AdminKategoriController::class);
    
    Route::get('peminjaman', [\App\Http\Controllers\Admin\AdminPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('peminjaman/{id}/approve', [\App\Http\Controllers\Admin\AdminPeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('peminjaman/{id}/reject', [\App\Http\Controllers\Admin\AdminPeminjamanController::class, 'reject'])->name('peminjaman.reject');
    
    Route::get('pengembalian', [\App\Http\Controllers\Admin\AdminPengembalianController::class, 'index'])->name('pengembalian.index');
    Route::post('pengembalian/{id}/approve', [\App\Http\Controllers\Admin\AdminPengembalianController::class, 'approve'])->name('pengembalian.approve');
    
    Route::get('laporan', [\App\Http\Controllers\Admin\AdminLaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/pdf', [\App\Http\Controllers\Admin\AdminLaporanController::class, 'pdf'])->name('laporan.pdf');
});

// Petugas Routes
Route::middleware(['auth', 'role:petugas'])->prefix('petugas')->name('petugas.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\Petugas\PetugasDashboardController::class, 'index'])->name('dashboard');
    Route::get('akun', [\App\Http\Controllers\Petugas\PetugasAkunController::class, 'index'])->name('akun.index'); // Petugas hanya bisa melihat user
    Route::resource('buku', \App\Http\Controllers\Petugas\PetugasBukuController::class);
    Route::resource('kategori', \App\Http\Controllers\Petugas\PetugasKategoriController::class);
    
    Route::get('peminjaman', [\App\Http\Controllers\Petugas\PetugasPeminjamanController::class, 'index'])->name('peminjaman.index');
    Route::post('peminjaman/{id}/approve', [\App\Http\Controllers\Petugas\PetugasPeminjamanController::class, 'approve'])->name('peminjaman.approve');
    Route::post('peminjaman/{id}/reject', [\App\Http\Controllers\Petugas\PetugasPeminjamanController::class, 'reject'])->name('peminjaman.reject');
    
    Route::get('pengembalian', [\App\Http\Controllers\Petugas\PetugasPengembalianController::class, 'index'])->name('pengembalian.index');
    Route::post('pengembalian/{id}/approve', [\App\Http\Controllers\Petugas\PetugasPengembalianController::class, 'approve'])->name('pengembalian.approve');
    
    Route::get('laporan', [\App\Http\Controllers\Petugas\PetugasLaporanController::class, 'index'])->name('laporan.index');
    Route::get('laporan/pdf', [\App\Http\Controllers\Petugas\PetugasLaporanController::class, 'pdf'])->name('laporan.pdf');
});

// User Routes
Route::middleware(['auth', 'role:user'])->prefix('user')->name('user.')->group(function () {
    Route::get('/beranda', [\App\Http\Controllers\User\UserBerandaController::class, 'index'])->name('beranda');
    
    Route::get('buku/{id}', [\App\Http\Controllers\User\UserBukuController::class, 'show'])->name('buku.show');
    Route::post('buku/{id}/pinjam', [\App\Http\Controllers\User\UserBukuController::class, 'pinjam'])->name('buku.pinjam');
    
    Route::get('koleksi', [\App\Http\Controllers\User\UserKoleksiController::class, 'index'])->name('koleksi.index');
    Route::post('koleksi/{id}', [\App\Http\Controllers\User\UserKoleksiController::class, 'toggle'])->name('koleksi.toggle');
    
    Route::get('history', [\App\Http\Controllers\User\UserPeminjamanController::class, 'index'])->name('history.index');
    Route::post('history/{id}/kembalikan', [\App\Http\Controllers\User\UserPeminjamanController::class, 'ajukanKembali'])->name('history.kembalikan');
    
    Route::post('ulasan/{id}', [\App\Http\Controllers\User\UserUlasanController::class, 'store'])->name('ulasan.store');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
