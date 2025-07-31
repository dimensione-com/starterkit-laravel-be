<?php

namespace App\Domain\BlackListToken\Repository;

use App\Models\BlackListToken;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Request;

class BlackListTokenRepository
{

    public function create_token_for_user(int $user_id, string $token_type, string $token) : bool {
        BlackListToken::create(['user_id' => $user_id, 'token' => $token, 'expires_at' => Carbon::now()->addMinutes(5), 'type' => $token_type]);
        return true;
    }

    public function upgrade_tokens_by_user_id(int $user_id, string $token_type, array $data) : bool
    {
        return BlackListToken::where('user_id', $user_id)->where('type', $token_type)->update($data);
    }


    public function get_token_by_token(string $token) : ?BlackListToken
    {
        $hashed_token = hash('sha256', $token);
        return BlackListToken::where('token', $hashed_token)->first();
    }

    public function get_user_id_by_token(string $token) : int|null
    {
        $hashed_token = hash('sha256', $token);
        return BlackListToken::where('token', $hashed_token)->first() ? BlackListToken::where('token', $hashed_token)->first()->user_id : null;
    }

    public function update_tokens_at_used(int $user_id, string $ip, array $ipResult) : void
    {
        BlackListToken::where('user_id', $user_id)->update(['used' => true, 'used_at' => Carbon::now(), 'user_agent' => $ipResult['userAgent'], 'ip' => $ip]);
    }


    public function update_token_by_id(int $id, array $data): bool
    {
        BlackListToken::find($id)->update($data);
        return true;
    }

    public function check_token_validity(string $token) : bool
    {
        $expireddateonstorage = BlackListToken::where('token', hash('sha256', $token))->first()->expires_at;
        $now = Carbon::now();
        if($expireddateonstorage > $now)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
