<?php

namespace App\Actions\Books;

use App\Models\Book;

class CreateBookAction
{
    /**
     * Create a new book.
     *
     * @param  array<string, mixed>  $data
     */
    public function execute(array $data): Book
    {
        return Book::create($data);
    }
}
