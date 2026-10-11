<?php

namespace App\Models;

use App\Enums\CommentCategory;
use Database\Factories\CommentFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Comment extends Model
{
    /** @use HasFactory<CommentFactory> */
    use HasFactory;

    protected $fillable = [
        'book_id',
        'parent_id',
        'category',
        'author',
        'text',
    ];

    /**
     * Attributes casting definition.
     *
     * @return array<string, string|class-string>
     */
    protected function casts(): array
    {
        return [
            'category' => CommentCategory::class,
        ];
    }

    /**
     * Book that this comment belongs to.
     *
     * @return BelongsTo<Book, $this>
     */
    public function book(): BelongsTo
    {
        return $this->belongsTo(Book::class);
    }

    /**
     * Parent comment (if this is a nested reply).
     *
     * @return BelongsTo<Comment, $this>
     */
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Direct child replies.
     *
     * @return HasMany<Comment, $this>
     */
    public function children(): HasMany
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }

    /**
     * Scope to filter top-level (root) comments.
     */
    public function scopeRoot(Builder $query): Builder
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope to filter comments by category.
     */
    public function scopeOfCategory(Builder $query, CommentCategory|string|null $category): Builder
    {
        if (blank($category)) {
            return $query;
        }

        $value = $category instanceof CommentCategory ? $category->value : (string) $category;

        return $query->where('category', $value);
    }
}
