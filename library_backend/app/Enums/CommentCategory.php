<?php

namespace App\Enums;

enum CommentCategory: string
{
    case ALTERNATIVE = 'alternative';
    case EDIT = 'edit';
    case LORE = 'lore';
    case QUESTION = 'question';

    /**
     * @return array<string>
     */
    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }

    public function label(): string
    {
        return match ($this) {
            self::ALTERNATIVE => 'Альтернатива',
            self::EDIT => 'Правка',
            self::LORE => 'Лор',
            self::QUESTION => 'Вопрос',
        };
    }
}
