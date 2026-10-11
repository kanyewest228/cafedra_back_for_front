<?php

namespace App\Http\Controllers\Api;

use App\Actions\Comments\CreateCommentAction;
use App\Actions\Comments\DeleteCommentAction;
use App\Actions\Comments\GetBookCommentsTreeAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\CommentIndexRequest;
use App\Http\Requests\StoreCommentRequest;
use App\Http\Resources\CommentResource;
use App\Models\Book;
use App\Models\Comment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CommentController extends Controller
{
    /**
     * Get the comment tree for a book, optionally filtered by category.
     */
    public function index(
        CommentIndexRequest $request,
        Book $book,
        GetBookCommentsTreeAction $action,
    ): AnonymousResourceCollection {
        $tree = $action->execute(
            book: $book,
            category: $request->validated('category'),
        );

        return CommentResource::collection($tree);
    }

    /**
     * Store a comment or nested reply for a book.
     */
    public function store(
        StoreCommentRequest $request,
        Book $book,
        CreateCommentAction $action,
    ): JsonResponse {
        $comment = $action->execute(
            book: $book,
            data: $request->validated(),
        );

        return (new CommentResource($comment))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Delete the specified comment (cascades to replies).
     */
    public function destroy(Comment $comment, DeleteCommentAction $action): Response
    {
        $action->execute($comment);

        return response()->noContent();
    }
}
