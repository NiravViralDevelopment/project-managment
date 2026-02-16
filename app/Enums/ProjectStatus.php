<?php

namespace App\Enums;

enum ProjectStatus: string
{
    case Active = 'Active';
    case Completed = 'Completed';
    case OnHold = 'On Hold';

    public static function values(): array
    {
        return array_column(self::cases(), 'value');
    }
}
