<?php

namespace App\Domain\Auth\Service;

use App\Domain\User\Enum\UserStatus;
use App\Domain\User\Service\UserService;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{

    public function __construct(private readonly UserService $userService){}

    public function sign_in(array $data) : array {
        $user = $this->userService->getUserByEmail($data['email']);
        if (!$user || $user->status !== UserStatus::Active->value || !Hash::check($data['password'], $user->password)) {
            throw new UnauthorizedHttpException('', 'Unauthorized');
        }
        $token = $user->createToken('access-token')->plainTextToken;
        dd($token);
    }
}
