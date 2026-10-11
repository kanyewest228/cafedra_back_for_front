<?php

namespace App\Http\Resources;

use App\Enums\CommentCategory;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @mixin Comment
 */
class CommentResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $category = $this->category instanceof CommentCategory
            ? $this->category->value
            : (string) $this->category;

        return [
            'id' => $this->id,
            'book_id' => $this->book_id,
            'parent_id' => $this->parent_id,
            'category' => $category,
            'author' => $this->author,
            'text' => $this->text,
            'created_at' => $this->created_at?->toISOString(),
            'children' => CommentResource::collection($this->children ?? collect()),
        ];
    }
}
