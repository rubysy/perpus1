<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    use HasFactory;

    protected $table = 'kategori_buku';

    protected $fillable = ['nama'];

    public function buku()
    {
        return $this->belongsToMany(Buku::class, 'buku_kategori', 'kategori_buku_id', 'buku_id');
    }
}
