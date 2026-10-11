<?php

namespace App\Http\Requests;

use App\Enums\CommentCategory;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'parent_id' => [
                'nullable',
                'integer',
                Rule::exists('comments', 'id')->where(function ($query) {
                    $book = $this->route('book');
                    $bookId = is_object($book) ? $book->id : $book;
                    if ($bookId) {
                        $query->where('book_id', $bookId);
                    }
                }),
            ],
            'category' => ['required', 'string', Rule::enum(CommentCategory::class)],
            'author' => ['required', 'string', 'max:255'],
            'text' => ['required', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'parent_id.exists' => 'Родительский комментарий не существует или относится к другой книге.',
        ];
    }
}
