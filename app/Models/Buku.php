<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    use HasFactory;

    protected $table = 'buku';

    protected $fillable = [
        'judul',
        'penulis',
        'penerbit',
        'isbn',
        'tahun_terbit',
        'deskripsi',
        'stok',
        'cover',
    ];

    public function kategori()
    {
        return $this->belongsToMany(KategoriBuku::class, 'buku_kategori', 'buku_id', 'kategori_buku_id');
    }

    public function peminjaman()
    {
        return $this->hasMany(Peminjaman::class);
    }

    public function ulasan()
    {
        return $this->hasMany(Ulasan::class);
    }

    public function koleksiPribadi()
    {
        return $this->hasMany(KoleksiPribadi::class);
    }

    public function averageRating()
    {
        return $this->ulasan()->avg('rating') ?? 0;
    }
}
