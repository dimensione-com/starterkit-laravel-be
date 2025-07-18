<?php

namespace App\Domain\Auth\Service;

use App\Domain\User\Enum\UserStatus;
use App\Domain\User\Service\UserService;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;

class AuthService
{

    public function __construct(private readonly UserService $userService){}

    public function sign_in(array $data) : array {
        $user = $this->userService->getUserByEmail($data['email']);
        if (
            !$user ||
            $user->status !== UserStatus::Active->value ||
            !Auth::attempt(['email' => $data['email'], 'password' => $data['password']])
        )
        {
            throw new UnauthorizedHttpException('', 'Unauthorized');
        }
        //$token = $user->createToken('access-token')->plainTextToken;
        //dd($token);
        $response = Http::asForm()->post(config('app.url') . '/oauth/token', [
            'grant_type' => 'password',
            config('services.passport.client_id'),
            config('services.passport.client_secret'),
            'username' => $data['email'],
            'password' => $data['password']
        ]);
        if($response->failed()){
            throw new UnauthorizedHttpException('', 'Unauthorized');
        }
        $parsed_response = json_decode($response->json(), true);
        return [
            'access_token' => $parsed_response['access_token'],
            'refresh_token' => $parsed_response['refresh_token'],
            'token_type' => 'Bearer',
            'expires_in' => $parsed_response['expires_in'],
        ];
    }


    public function refresh(array $data) : array {
        $response = Http::asForm()->post(config('app.url') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $data['refresh_token'],
            'client_id' => env('PASSWORD_CLIENT_ID'),
            'client_secret' => env('PASSWORD_CLIENT_SECRET'),
        ]);
        if($response->failed()){
            throw new UnauthorizedHttpException('', 'Unauthorized');
        }
        $parsed_response = json_decode($response->json(), true);
        //dd($parsed_response);
        return [
            'access_token' => $parsed_response['access_token'],
            'refresh_token' => $parsed_response['refresh_token'],
            'token_type' => 'Bearer',
            'expires_in' => $parsed_response['expires_in'],
        ];
    }
}
