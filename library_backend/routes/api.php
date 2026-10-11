<?php

use App\Http\Controllers\Api\BookController;
use App\Http\Controllers\Api\CommentController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
| Endpoints designed for frontend sprint specification (52sprint.md):
| - GET    /api/books             (paginated books list, 8 per page)
| - POST   /api/books             (create book)
| - GET    /api/books/{id}        (single book details)
| - PUT    /api/books/{id}        (update book)
| - DELETE /api/books/{id}        (delete book)
| - GET    /api/books/{id}/comments  (comment tree, optional ?category= filter)
| - POST   /api/books/{id}/comments  (create root comment or nested reply)
| - DELETE /api/comments/{id}        (delete comment and its thread)
|--------------------------------------------------------------------------
*/

// Books endpoints
Route::apiResource('books', BookController::class);

// Comments endpoints
Route::get('books/{book}/comments', [CommentController::class, 'index'])->name('books.comments.index');
Route::post('books/{book}/comments', [CommentController::class, 'store'])->name('books.comments.store');
Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');
