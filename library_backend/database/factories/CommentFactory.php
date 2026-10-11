<?php

namespace Database\Factories;

use App\Enums\CommentCategory;
use App\Models\Book;
use App\Models\Comment;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'book_id' => Book::factory(),
            'parent_id' => null,
            'category' => fake()->randomElement(CommentCategory::cases()),
            'author' => fake()->name(),
            'text' => fake()->sentence(),
        ];
    }
}
