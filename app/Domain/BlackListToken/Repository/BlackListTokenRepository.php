<?php

namespace App\Domain\BlackListToken\Repository;

use App\Models\BlackListToken;
use Carbon\Carbon;

class BlackListTokenRepository
{

    public function create_token_for_user(int $user_id, string $token) : bool {
        BlackListToken::create(['user_id' => $user_id, 'token' => $token, 'expires_at' => Carbon::now()->addMinutes(5)]);
        return true;
    }
}
