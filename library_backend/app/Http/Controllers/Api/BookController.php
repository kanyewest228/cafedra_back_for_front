<?php

namespace App\Http\Controllers\Api;

use App\Actions\Books\CreateBookAction;
use App\Actions\Books\DeleteBookAction;
use App\Actions\Books\GetBookAction;
use App\Actions\Books\GetBooksAction;
use App\Actions\Books\UpdateBookAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\BookIndexRequest;
use App\Http\Requests\StoreBookRequest;
use App\Http\Requests\UpdateBookRequest;
use App\Http\Resources\BookResource;
use App\Models\Book;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * Display a listing of books with pagination (default: 8 per page).
     */
    public function index(BookIndexRequest $request, GetBooksAction $action): AnonymousResourceCollection
    {
        $books = $action->execute(
            search: $request->validated('search'),
            perPage: (int) ($request->validated('per_page', 8)),
        );

        return BookResource::collection($books);
    }

    /**
     * Store a newly created book.
     */
    public function store(StoreBookRequest $request, CreateBookAction $action): JsonResponse
    {
        $book = $action->execute($request->validated());

        return (new BookResource($book))
            ->response()
            ->setStatusCode(201);
    }

    /**
     * Display the specified book details.
     */
    public function show(Book $book, GetBookAction $action): BookResource
    {
        return new BookResource($action->execute($book));
    }

    /**
     * Update the specified book.
     */
    public function update(UpdateBookRequest $request, Book $book, UpdateBookAction $action): BookResource
    {
        $updated = $action->execute($book, $request->validated());

        return new BookResource($updated);
    }

    /**
     * Remove the specified book.
     */
    public function destroy(Book $book, DeleteBookAction $action): Response
    {
        $action->execute($book);

        return response()->noContent();
    }
}
