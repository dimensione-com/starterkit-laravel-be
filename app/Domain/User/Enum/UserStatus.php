<?php

namespace App\Domain\User\Enum;
enum UserStatus: string
{
    case Created = 'Created';

    case Active = 'Active';

    case Inactive = 'Inactive';

    public static function getValues(): array
    {
        return array_column(self::cases(), 'value');
    }
}

