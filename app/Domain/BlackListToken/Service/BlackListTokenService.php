<?php

namespace App\Domain\BlackListToken\Service;

use App\Domain\BlackListToken\Repository\BlackListTokenRepository;
use App\Models\BlackListToken;
use Illuminate\Database\Eloquent\Collection;

class BlackListTokenService
{

    public function __construct(private readonly BlackListTokenRepository $blackListTokenRepository){}

    public function create_token_for_user(int $user_id, string $token_type, string $token) : bool
    {
        return $this->blackListTokenRepository->create_token_for_user($user_id, $token_type, $token);
    }

    public function update_tokens(int $user_id, string $token_type, array $data) : bool
    {
        $this->blackListTokenRepository->upgrade_tokens_by_user_id($user_id, $token_type, $data);
        return true;
    }


    public function get_user_id_by_token(string $token) : int
    {
        return $this->blackListTokenRepository->get_user_id_by_token($token);
    }


    public function get_token_by_token(string $token) : ?BlackListToken
    {
        return $this->blackListTokenRepository->get_token_by_token($token);
    }


    public function update_token_by_id(int $id, array $data) : bool {
        return $this->blackListTokenRepository->update_token_by_id($id, $data);
    }




}
