<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    use HasFactory;

    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'buku_id',
        'nama_peminjam',
        'alamat',
        'tanggal_pinjam',
        'durasi_pinjam',
        'tanggal_kembali',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_kembali' => 'date',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function ulasan()
    {
        return $this->hasOne(Ulasan::class);
    }

    public function tanggalHarusKembali()
    {
        return $this->tanggal_pinjam->copy()->addDays($this->durasi_pinjam);
    }

    public function getBatasKembali()
    {
        return $this->tanggalHarusKembali();
    }
}
