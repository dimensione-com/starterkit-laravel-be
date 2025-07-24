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


    public function getUserById(int $id) : ?User
    {
        return $this->userRepository->getUserById($id);
    }

    public function createUser(array $data) : User {
        return $this->userRepository->create($data);
    }

}
