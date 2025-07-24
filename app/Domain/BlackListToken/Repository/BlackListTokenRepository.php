<?php

namespace App\Domain\BlackListToken\Repository;

use App\Models\BlackListToken;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;

class BlackListTokenRepository
{

    public function create_token_for_user(int $user_id, string $token_type, string $token) : bool {
        BlackListToken::create(['user_id' => $user_id, 'token' => $token, 'expires_at' => Carbon::now()->addMinutes(5), 'type' => $token_type]);
        return true;
    }

    public function get_token_for_user(int $user_id) : Collection
    {
        return BlackListToken::where('user_id', $user_id)->get();
    }

    public function upgrade_tokens(int $user_id, string $token_type, array $data) : void
    {
        BlackListToken::where('user_id', $user_id)->where('type', $token_type)->update($data);
    }


    public function get_user_by_token(string $token) : ?BlackListToken
    {
        $hashed_token = hash('sha256', $token);
        return BlackListToken::where('token', $hashed_token)->first();
    }

}
