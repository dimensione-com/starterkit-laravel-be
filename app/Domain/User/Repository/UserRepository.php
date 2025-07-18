<?php

namespace App\Domain\User\Repository;

use App\Models\User;

class UserRepository
{

    public function getByEmail(string $email): ?User {
        return User::where('email', '=', $email)->first();
    }
}
