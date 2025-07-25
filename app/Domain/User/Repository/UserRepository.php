<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Enum\UserStatus;
use App\Models\User;
use Carbon\Carbon;
use PhpParser\Node\Stmt\Return_;

class UserRepository
{

    public function getByEmail(string $email): ?User
    {
        return User::where('email', '=', $email)->first();
    }

    public function getUserById(int $userId): ?User
    {
        return User::find($userId);
    }
    public function create(array $data) : User
    {
        return User::create($data);
    }

    public function activateUser(int $userId) : bool
    {
        return User::where('id', $userId)->update(['status'=> 'Active', 'email_verified_at' => Carbon::now()]);
    }

}
