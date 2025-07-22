<?php

namespace App\Domain\BlackListToken\Service;

use App\Domain\BlackListToken\Repository\BlackListTokenRepository;

class BlackListTokenService
{

    public function __construct(private readonly BlackListTokenRepository $blackListTokenRepository){}

    public function create_token_for_user(int $user_id, string $token) : bool {
        return $this->blackListTokenRepository->create_token_for_user($user_id, $token);
    }
}
