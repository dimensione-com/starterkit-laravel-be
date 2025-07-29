<?php

namespace App\Http\Controllers;

use App\Domain\Auth\DTO\RefreshRequestDTO;
use App\Domain\Auth\DTO\ResetPasswordRequestDTO;
use App\Domain\Auth\DTO\SendEmailVerificationRequestDTO;
use App\Domain\Auth\DTO\SendResetPasswordRequestDTO;
use App\Domain\Auth\DTO\SignInRequestDTO;
use App\Domain\Auth\DTO\SignUpRequestDTO;
use App\Domain\Auth\Service\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AuthController extends Controller
{

    public function __construct(private readonly AuthService $authService){}

    public function sign_in(SignInRequestDTO $request) : JsonResponse
    {
        $validated_data = $request->validated();
        $data = $this->authService->sign_in($validated_data);
        return response()->json($data);
    }


    public function refresh(RefreshRequestDTO $request) : JsonResponse
    {
        $validated_data = $request->validated();
        $data = $this->authService->refresh($validated_data);
        return response()->json($data);
    }


    public function sign_out(Request $request) : JsonResponse
    {
        $result = $this->authService->sign_out($request);
        return response()->json(['success' => $result]);
    }


    public function sign_up(SignUpRequestDTO $request): JsonResponse
    {
        $validated_data = $request->validated();
        $result = $this->authService->sign_up($validated_data);
        return response()->json(['success' => $result]);
    }


    public function get_client_credentials(): JsonResponse
    {

        return response()->json(
            [
            'client_id' =>config('app.client_id'),
            'client_secret' => config('app.client_secret'),
            ]
        );
    }

    public function send_email_verification(SendEmailVerificationRequestDTO $request): JsonResponse
    {
        $validated_data = $request->validated();
        $result = $this->authService->send_email_verification($validated_data['email']);
        return response()->json(['success' => $result]);
    }

    public function send_reset_password_email(SendResetPasswordRequestDTO $request): JsonResponse
    {
        $validated_data = $request->validated();
        $result = $this->authService->send_reset_password_link($validated_data['email']);
        return response()->json(['success' => $result]);
    }


    public function reset_password(ResetPasswordRequestDTO $request) : JsonResponse {
        $validated_data = $request->validated();
        $result = $this->authService->reset_password($validated_data['token'], $validated_data['password']);
        return response()->json(['success' => $result]);
    }

    public function confirm_user_account(string $token): JsonResponse
    {
        if(empty($token))
        {
            throw new NotFoundHttpException('Token inserito non valido.');
        }
        else
        {
            $result = $this->authService->activate_user_account($token);
            return response()->json([
                'success' => $result,
                'message' => $result ? 'Account verificato con successo.' : 'Token non valido o già usato. Attenzione se hai attiva una VPN ti chiediamo di disattivarla.'
            ]);
        }
    }


}
