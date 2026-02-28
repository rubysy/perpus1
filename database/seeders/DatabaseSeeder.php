<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\KategoriBuku;
use App\Models\Buku;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin
        User::create([
            'name' => 'Administrator',
            'email' => 'admin@perpus.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'alamat' => 'Jl. Perpustakaan No. 1',
        ]);

        // Create Petugas
        User::create([
            'name' => 'Petugas Perpus',
            'email' => 'petugas@perpus.com',
            'password' => bcrypt('password'),
            'role' => 'petugas',
            'alamat' => 'Jl. Petugas No. 2',
        ]);

        // Create sample User
        User::create([
            'name' => 'Budi Santoso',
            'email' => 'user@perpus.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'alamat' => 'Jl. User No. 3',
        ]);

        // Create Categories
        $kategoris = ['Fiksi', 'Non-Fiksi', 'Sains', 'Teknologi', 'Sejarah', 'Sastra', 'Pendidikan', 'Agama', 'Komik', 'Biografi'];
        foreach ($kategoris as $kategori) {
            KategoriBuku::create(['nama' => $kategori]);
        }

        // Create sample Books
        $books = [
            [
                'judul' => 'Laskar Pelangi',
                'penulis' => 'Andrea Hirata',
                'penerbit' => 'Bentang Pustaka',
                'isbn' => '9789793062792',
                'tahun_terbit' => 2005,
                'deskripsi' => 'Novel yang menceritakan kisah 10 anak dari keluarga miskin yang bersekolah di sebuah sekolah Muhammadiyah di Belitung.',
                'stok' => 5,
                'kategori' => [1, 6], // Fiksi, Sastra
            ],
            [
                'judul' => 'Bumi Manusia',
                'penulis' => 'Pramoedya Ananta Toer',
                'penerbit' => 'Hasta Mitra',
                'isbn' => '9789799731234',
                'tahun_terbit' => 1980,
                'deskripsi' => 'Novel pertama dari tetralogi Buru yang mengisahkan kehidupan Minke, seorang pribumi terpelajar di era kolonial Belanda.',
                'stok' => 3,
                'kategori' => [1, 5, 6], // Fiksi, Sejarah, Sastra
            ],
            [
                'judul' => 'Sapiens: A Brief History of Humankind',
                'penulis' => 'Yuval Noah Harari',
                'penerbit' => 'Gramedia',
                'isbn' => '9786020332420',
                'tahun_terbit' => 2011,
                'deskripsi' => 'Buku yang membahas sejarah evolusi manusia dari Zaman Batu hingga era modern.',
                'stok' => 4,
                'kategori' => [2, 3, 5], // Non-Fiksi, Sains, Sejarah
            ],
            [
                'judul' => 'Clean Code',
                'penulis' => 'Robert C. Martin',
                'penerbit' => 'Prentice Hall',
                'isbn' => '9780132350884',
                'tahun_terbit' => 2008,
                'deskripsi' => 'Panduan untuk menulis kode yang bersih, mudah dibaca, dan mudah dipelihara.',
                'stok' => 2,
                'kategori' => [2, 4], // Non-Fiksi, Teknologi
            ],
            [
                'judul' => 'Filosofi Teras',
                'penulis' => 'Henry Manampiring',
                'penerbit' => 'Kompas',
                'isbn' => '9786024126711',
                'tahun_terbit' => 2018,
                'deskripsi' => 'Buku tentang filsafat Stoisisme yang dikemas dengan bahasa yang ringan dan contoh-contoh kekinian.',
                'stok' => 6,
                'kategori' => [2, 7], // Non-Fiksi, Pendidikan
            ],
            [
                'judul' => 'Si Juki: Lika-Liku Anak Kos',
                'penulis' => 'Faza Meonk',
                'penerbit' => 'Bukune',
                'isbn' => '9786022205012',
                'tahun_terbit' => 2013,
                'deskripsi' => 'Komik strip yang mengisahkan kehidupan lucu dan seru anak kos bernama Juki.',
                'stok' => 8,
                'kategori' => [1, 9], // Fiksi, Komik
            ],
        ];

        foreach ($books as $bookData) {
            $kategoriIds = $bookData['kategori'];
            unset($bookData['kategori']);
            $book = Buku::create($bookData);
            $book->kategori()->attach($kategoriIds);
        }
    }
}
