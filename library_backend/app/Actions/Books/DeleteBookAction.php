<?php

namespace App\Actions\Books;

use App\Models\Book;

class DeleteBookAction
{
    /**
     * Delete an existing book.
     */
    public function execute(Book $book): void
    {
        $book->delete();
    }
}
