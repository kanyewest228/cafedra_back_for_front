<?php

namespace App\Actions\Comments;

use App\Models\Book;
use App\Models\Comment;
use Illuminate\Validation\ValidationException;

class CreateCommentAction
{
    /**
     * Create a new comment or threaded reply for a book.
     *
     * @param  array<string, mixed>  $data
     *
     * @throws ValidationException
     */
    public function execute(Book $book, array $data): Comment
    {
        $parentId = $data['parent_id'] ?? null;

        if ($parentId !== null) {
            $parent = Comment::find($parentId);
            if (! $parent || $parent->book_id !== $book->id) {
                throw ValidationException::withMessages([
                    'parent_id' => ['Родительский комментарий не принадлежит этой книге.'],
                ]);
            }
        }

        return $book->comments()->create([
            'parent_id' => $parentId,
            'category' => $data['category'],
            'author' => $data['author'],
            'text' => $data['text'],
        ]);
    }
}
