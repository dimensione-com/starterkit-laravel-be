<?php

namespace App\Http\Controllers;

use App\Domain\Auth\DTO\RefreshRequestDTO;
use App\Domain\Auth\DTO\SignInRequestDTO;
use App\Domain\Auth\Service\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AuthController extends Controller
{

    public function __construct(private readonly AuthService $authService){}

    public function sign_in(SignInRequestDTO $request) : JsonResponse {
        $validated_data = $request->validated();
        $data = $this->authService->sign_in($validated_data);
        return response()->json($data);
    }


    public function refresh(RefreshRequestDTO $request) : JsonResponse {
        $validated_data = $request->validated();
        $data = $this->authService->refresh($validated_data);
        return response()->json($data);
    }


    public function sign_out(Request $request) : JsonResponse {
        $result = $this->authService->sign_out($request);
        return response()->json(['success' => $result]);
    }
}
