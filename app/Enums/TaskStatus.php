<?php

namespace App\Enums;

enum TaskStatus: string
{
    case Todo = 'Todo';
    case InProgress = 'In Progress';
    case Done = 'Done';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
