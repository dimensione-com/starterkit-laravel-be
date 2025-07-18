<?php

namespace App\Domain\User\Service;

use App\Domain\User\Repository\UserRepository;
use App\Models\User;

class UserService
{

    public function __construct(private readonly UserRepository $userRepository){}

    public function getUserByEmail(string $email) : ?User {
        return $this->userRepository->getByEmail($email);
    }
}
