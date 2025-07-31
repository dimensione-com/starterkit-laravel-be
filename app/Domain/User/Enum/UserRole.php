<?php

namespace App\Domain\User\Enum;

enum UserRole: string
{
    case Admin = 'Admin';

    case Super_admin = 'Super_admin';

    case User = 'User';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}

