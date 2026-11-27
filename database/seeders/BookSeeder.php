<?php

namespace Database\Seeders;

use App\Models\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = [
            [
                'title' => 'Madilog (Materialisme, Dialektika, Logika)',
                'author' => 'Tan Malaka',
                'year' => 1943,
                'stock' => 14,
                'category_id' => 7,
            ],
            [
                'title' => 'Kekerasan Budaya Pasca 1965',
                'author' => 'Wijaya Herlambang',
                'year' => 2013,
                'stock' => 15,
                'category_id' => 8,
            ],
            [
                'title' => 'Orang-Orang di Persimpangan Kiri Jalan',
                'author' => 'Soe Hok Gie',
                'year' => 1997,
                'stock' => 8,
                'category_id' => 8,
            ],
            [
                'title' => 'Tetralogi Buru (Bumi Manusia, dkk)',
                'author' => 'Pramoedya Ananta Toer',
                'year' => 1980,
                'stock' => 19,
                'category_id' => 5,
            ],
            [
                'title' => 'Massa Aksi',
                'author' => 'Tan Malaka',
                'year' => 1926,
                'stock' => 12,
                'category_id' => 8,
            ],
            [
                'title' => 'Dibawah Bendera Revolusi',
                'author' => 'Soekarno',
                'year' => 1959,
                'stock' => 10,
                'category_id' => 9,
            ],
            [
                'title' => 'Mastering Web Framework',
                'author' => 'Taylor Otwell',
                'year' => 2023,
                'stock' => 5,
                'category_id' => 6,
            ],
            [
                'title' => 'Kosmos (Cosmos)',
                'author' => 'Carl Sagan',
                'year' => 1980,
                'stock' => 15,
                'category_id' => 7,
            ],
            [
                'title' => 'Cantik Itu Luka',
                'author' => 'Eka Kurniawan',
                'year' => 2002,
                'stock' => 18,
                'category_id' => 5,
            ],
            [
                'title' => 'Sejarah Indonesia Modern',
                'author' => 'M.C. Ricklefs',
                'year' => 2001,
                'stock' => 10,
                'category_id' => 8,
            ],
            [
                'title' => 'Jejak yang Melampaui Zaman',
                'author' => 'Seri Buku Tempo',
                'year' => 2010,
                'stock' => 30,
                'category_id' => 9,
            ],
        ];

        foreach ($books as $book) {
            Book::firstOrCreate(
                ['title' => $book['title']],
                $book
            );
        }
    }
}

