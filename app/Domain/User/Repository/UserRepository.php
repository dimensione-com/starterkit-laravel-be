<?php

namespace App\Domain\User\Repository;

use App\Domain\User\Enum\UserStatus;
use App\Models\User;
use Carbon\Carbon;

class UserRepository
{

    public function getByEmail(string $email): ?User {
        return User::where('email', '=', $email)->first();
    }


    public function create(array $data) : User {
        return User::create($data);
    }

    public function activate(int $user_id) : void
    {
        $user = User::find($user_id);
        $user->status = UserStatus::Active->value;
        $user->email_verified_at = Carbon::now();
        $user->save();
    }

}
