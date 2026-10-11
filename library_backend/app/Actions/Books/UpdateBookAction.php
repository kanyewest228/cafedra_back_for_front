<?php

namespace App\Actions\Books;

use App\Models\Book;

class UpdateBookAction
{
    /**
     * Update an existing book.
     *
     * @param  array<string, mixed>  $data
     */
    public function execute(Book $book, array $data): Book
    {
        $book->update($data);

        return $book->fresh();
    }
}
