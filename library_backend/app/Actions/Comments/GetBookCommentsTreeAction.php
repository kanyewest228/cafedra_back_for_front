<?php

namespace App\Actions\Comments;

use App\Enums\CommentCategory;
use App\Models\Book;
use App\Models\Comment;
use Illuminate\Support\Collection;

class GetBookCommentsTreeAction
{
    /**
     * Build and return the nested comment tree for a book,
     * with optional category filtering for the root threads.
     *
     * @return Collection<int, Comment>
     */
    public function execute(Book $book, ?string $category = null): Collection
    {
        // 1. Fetch all comments for the given book in one query
        $allComments = Comment::query()
            ->where('book_id', $book->id)
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc')
            ->get();

        // 2. Initialize children relation as an empty collection on each comment
        foreach ($allComments as $comment) {
            $comment->setRelation('children', collect());
        }

        // 3. Assemble the tree in memory using id indexing
        $commentMap = $allComments->keyBy('id');
        $rootComments = collect();

        foreach ($allComments as $comment) {
            if ($comment->parent_id === null) {
                $rootComments->push($comment);
            } else {
                /** @var Comment|null $parent */
                $parent = $commentMap->get($comment->parent_id);
                if ($parent) {
                    $parent->children->push($comment);
                }
            }
        }

        // 4. If a category filter is specified, filter root comments by that category
        if (! blank($category)) {
            $rootComments = $rootComments->filter(function (Comment $comment) use ($category) {
                $val = $comment->category instanceof CommentCategory
                    ? $comment->category->value
                    : (string) $comment->category;

                return $val === $category;
            })->values();
        }

        return $rootComments;
    }
}
