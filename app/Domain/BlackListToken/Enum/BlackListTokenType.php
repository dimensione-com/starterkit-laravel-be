<?php

namespace App\Domain\BlackListToken\Enum;

enum BlackListTokenType: string
{
    case Password = 'Password';
    case Email = 'Email';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}
