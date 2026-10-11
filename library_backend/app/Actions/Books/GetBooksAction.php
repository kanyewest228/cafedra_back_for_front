<?php

namespace App\Actions\Books;

use App\Models\Book;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class GetBooksAction
{
    /**
     * Retrieve paginated books with optional search filter.
     * Default page size is 8 as specified in the requirements.
     */
    public function execute(?string $search = null, int $perPage = 8): LengthAwarePaginator
    {
        return Book::query()
            ->search($search)
            ->oldest('id')
            ->paginate($perPage);
    }
}
