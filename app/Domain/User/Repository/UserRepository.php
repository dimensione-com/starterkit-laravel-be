<?php

namespace App\Domain\User\Repository;

use App\Models\User;

class UserRepository
{

    public function getByEmail(string $email): ?User {
        return User::where('email', '=', $email)->first();
    }


    public function create(array $data) : User {
        return User::create($data);
    }
}
