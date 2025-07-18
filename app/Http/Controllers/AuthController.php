<?php

namespace App\Http\Controllers;

use App\Domain\Auth\DTO\SignInRequestDTO;
use App\Domain\Auth\Service\AuthService;
use Illuminate\Http\JsonResponse;

class AuthController extends Controller
{

    public function __construct(private readonly AuthService $authService){}

    public function sign_in(SignInRequestDTO $request) : JsonResponse {
        $validated_data = $request->validated();
        $data = $this->authService->sign_in($validated_data);
        return response()->json($data);
    }
}
