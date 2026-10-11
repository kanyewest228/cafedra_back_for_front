<?php

namespace App\Actions\Books;

use App\Models\Book;

class GetBookAction
{
    /**
     * Retrieve a single book entity.
     */
    public function execute(Book $book): Book
    {
        return $book;
    }
}
