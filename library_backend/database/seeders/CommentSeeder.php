<?php

namespace Database\Seeders;

use App\Models\Comment;
use Illuminate\Database\Seeder;

class CommentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $comments = [
            // --- Book 1 Comments (matching 52sprint.md specifications) ---
            [
                'id' => 101,
                'book_id' => 1,
                'parent_id' => null,
                'category' => 'lore',
                'author' => 'Мария П.',
                'text' => 'А кто такой Главный Герой в первой главе?',
                'created_at' => '2026-10-02 15:30:00',
            ],
            [
                'id' => 102,
                'book_id' => 1,
                'parent_id' => 101,
                'category' => 'lore',
                'author' => 'Иван И.',
                'text' => 'Это потомок древнего рода...',
                'created_at' => '2026-10-02 16:00:00',
            ],
            [
                'id' => 104,
                'book_id' => 1,
                'parent_id' => 102,
                'category' => 'lore',
                'author' => 'Мария П.',
                'text' => 'Спасибо! А почему тогда у него нет фамильного медальона?',
                'created_at' => '2026-10-02 16:45:00',
            ],
            [
                'id' => 103,
                'book_id' => 1,
                'parent_id' => null,
                'category' => 'alternative',
                'author' => 'Петр С.',
                'text' => 'А что если в конце он не уедет?',
                'created_at' => '2026-10-03 10:00:00',
            ],
            [
                'id' => 105,
                'book_id' => 1,
                'parent_id' => 103,
                'category' => 'alternative',
                'author' => 'Иван Иванов',
                'text' => 'Интересный поворот! Тогда придется переписать встречу у маяка.',
                'created_at' => '2026-10-03 11:20:00',
            ],
            [
                'id' => 106,
                'book_id' => 1,
                'parent_id' => null,
                'category' => 'edit',
                'author' => 'Анна Корректор',
                'text' => 'Во 2-м абзаце: "пронизывал до костей" — лучше убрать тавтологию в следующем предложении.',
                'created_at' => '2026-10-03 12:15:00',
            ],
            [
                'id' => 107,
                'book_id' => 1,
                'parent_id' => 106,
                'category' => 'edit',
                'author' => 'Иван Иванов',
                'text' => 'Принято, заменил на "обжигал холодом".',
                'created_at' => '2026-10-03 13:00:00',
            ],
            [
                'id' => 108,
                'book_id' => 1,
                'parent_id' => null,
                'category' => 'question',
                'author' => 'Сергей К.',
                'text' => 'Будет ли карта этого мира приложена к электронной версии?',
                'created_at' => '2026-10-03 14:00:00',
            ],
            [
                'id' => 109,
                'book_id' => 1,
                'parent_id' => 108,
                'category' => 'question',
                'author' => 'Иван Иванов',
                'text' => 'Да, иллюстратор сейчас заканчивает картографию северных земель.',
                'created_at' => '2026-10-03 14:30:00',
            ],

            // --- Book 2 Comments ("Призрак каштака") ---
            [
                'id' => 201,
                'book_id' => 2,
                'parent_id' => null,
                'category' => 'lore',
                'author' => 'Василий Т.',
                'text' => 'Каштак реально существует или это собирательный образ закрытого поселка?',
                'created_at' => '2026-10-04 10:15:00',
            ],
            [
                'id' => 202,
                'book_id' => 2,
                'parent_id' => 201,
                'category' => 'lore',
                'author' => 'Олег Бачаров',
                'text' => 'Это реальный микрорайон и историческая местность, но мистика добавлена художественно.',
                'created_at' => '2026-10-04 11:00:00',
            ],
            [
                'id' => 203,
                'book_id' => 2,
                'parent_id' => null,
                'category' => 'alternative',
                'author' => 'Екатерина Н.',
                'text' => 'Предлагаю сделать призрака не враждебным, а хранителем забытой тайны шахтеров.',
                'created_at' => '2026-10-04 14:20:00',
            ],
            [
                'id' => 204,
                'book_id' => 2,
                'parent_id' => 203,
                'category' => 'alternative',
                'author' => 'Олег Бачаров',
                'text' => 'Отличная мысль! Добавлю это в поворотный момент 4 главы.',
                'created_at' => '2026-10-04 15:10:00',
            ],
            [
                'id' => 205,
                'book_id' => 2,
                'parent_id' => null,
                'category' => 'edit',
                'author' => 'Григорий',
                'text' => 'В описании шахтного оборудования есть неточность: в 70-е использовались другие клети.',
                'created_at' => '2026-10-04 16:00:00',
            ],
            [
                'id' => 206,
                'book_id' => 2,
                'parent_id' => null,
                'category' => 'question',
                'author' => 'Ольга М.',
                'text' => 'Планируется ли аудиокнига с атмосферными звуками тайги?',
                'created_at' => '2026-10-04 17:30:00',
            ],
        ];

        foreach ($comments as $commentData) {
            Comment::updateOrCreate(['id' => $commentData['id']], $commentData);
        }
    }
}
