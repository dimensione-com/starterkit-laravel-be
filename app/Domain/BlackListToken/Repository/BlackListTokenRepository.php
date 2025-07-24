<?php

namespace App\Domain\BlackListToken\Repository;

use App\Models\BlackListToken;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Request;

class BlackListTokenRepository
{

    public function create_token_for_user(int $user_id, string $token) : bool {
        BlackListToken::create(['user_id' => $user_id, 'token' => $token, 'expires_at' => Carbon::now()->addMinutes(5)]);
        return true;
    }

    public function get_token_for_user(int $user_id) : Collection
    {
        return BlackListToken::where('user_id', $user_id)->get();
    }

    public function upgrade_token_for_revoke(int $user_id, array $data) : void
    {
        BlackListToken::where('user_id', $user_id)->update($data);
    }

    public function getUser(string $token) : int
    {
        return BlackListToken::where('token', $token)->first()->user_id;
    }

    public function update_tokens_at_used(int $user_id) : void
    {
        BlackListToken::where('user_id', $user_id)->update(['used' => true, 'used_at' => Carbon::now(), 'user_agent' => Request::userAgent(), 'ip' => Request::ip()]);
    }

}
