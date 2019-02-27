<?php

use Illuminate\Database\Seeder;
use App\Book;
use App\Author;

class BooksSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Sample penulis
        $author1 = Author::create(['name' => 'Mohammad Fauzil Adhim']);
        $author2 = Author::create(['name' => 'Khofidin']);
        $author3 = Author::create(['name' => 'Mukhlisin Lahuddin']);

        // Sample buku
        $buku1 = Book::create(['title' => 'Mangan mangan', 'amount' => 3, 'author_id' => $author1->id]);
        $buku2 = Book::create(['title' => 'Madang madang', 'amount' => 2, 'author_id' => $author2->id]);
        $buku3 = Book::create(['title' => 'Mlaku mlaku', 'amount' => 10, 'author_id' => $author2->id]);
        $buku4 = Book::create(['title' => 'Nyunyak nyunyuk', 'amount' => 7, 'author_id' => $author3->id]);
    }
}
