<?php

namespace App\Domain\BlackListToken\Service;

use App\Domain\BlackListToken\Repository\BlackListTokenRepository;
use App\Models\BlackListToken;
use Illuminate\Database\Eloquent\Collection;

class BlackListTokenService
{

    public function __construct(private readonly BlackListTokenRepository $blackListTokenRepository){}

    public function create_token_for_user(int $user_id, string $token) : bool
    {
        return $this->blackListTokenRepository->create_token_for_user($user_id, $token);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Collection<int, BlackListToken>
     */
    public function revoke_token_for_user(int $user_id) : Collection
    {
        return $this->blackListTokenRepository->get_token_for_user($user_id);
    }


    public function update_tokens(int $user_id) : bool
    {
        $this->blackListTokenRepository->upgrade_token($user_id, ['revoked' => true]);
        return true;
    }

}
