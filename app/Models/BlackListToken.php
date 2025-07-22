<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BlackListToken extends Model
{
    protected $table = 'blacklisted_tokens';

    protected $fillable = [
        'ip',
        'user_id',
        'user_agent',
        'token',
        'expires_at',
        'used',
        'revoked'
    ];


}
