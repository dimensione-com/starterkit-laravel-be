<?php

namespace App\Domain\Auth\Service;

use App\Domain\BlackListToken\Enum\BlackListTokenType;
use App\Domain\BlackListToken\Service\BlackListTokenService;
use App\Domain\User\Enum\UserStatus;
use App\Domain\User\Service\UserService;
use App\Mail\SendResetPasswordEmail;
use App\Mail\SendVerifyEmail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Laravel\Passport\RefreshToken;
use Laravel\Passport\Token;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;

class AuthService
{

    public function __construct(private readonly UserService $userService, private readonly BlackListTokenService $blackListTokenService){}

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

        $user->tokens()->each(function (Token $token) {
            $token->revoke();
            $token->refreshToken?->revoke();
        });
        $response = Http::asForm()->timeout(2)->post(config('app.url') . '/oauth/token', [
            'grant_type' => 'password',
            'client_id' =>config('app.client_id'),
            'client_secret' => config('app.client_secret'),
            'username' => $data['email'],
            'password' => $data['password']
        ]);
        if($response->failed()){
            throw new UnauthorizedHttpException('', 'Unauthorized');
        }
        $parsed_response = $response->json();
        return [
            'access_token' => $parsed_response['access_token'],
            'refresh_token' => $parsed_response['refresh_token'],
            'token_type' => 'Bearer',
            'expires_in' => $parsed_response['expires_in'],
        ];
    }


    public function refresh(array $data) : array {
        // Trova e revoca il vecchio access e refresh token
        $oldRefreshToken = RefreshToken::where('id', $data['refresh_token'])->first();

        if ($oldRefreshToken) {
            $accessToken = Token::find($oldRefreshToken->access_token_id);

            if ($accessToken) {
                $accessToken->revoke();
            }

            $oldRefreshToken->revoke();
        }

        $response = Http::asForm()->timeout(2)->post(config('app.url') . '/oauth/token', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $data['refresh_token'],
            'client_id' =>config('app.client_id'),
            'client_secret' => config('app.client_secret'),
        ]);
        if($response->failed()){
            throw new UnauthorizedHttpException('', 'Unauthorized');
        }
        $parsed_response = $response->json();
        return [
            'access_token' => $parsed_response['access_token'],
            'refresh_token' => $parsed_response['refresh_token'],
            'token_type' => 'Bearer',
            'expires_in' => $parsed_response['expires_in'],
        ];
    }


    public function sign_out(Request $request): bool
    {
        $user = $request->user();
        if ($user) {
            $user->tokens->each(function (Token $token) {
                $token->revoke();
                $token->refreshToken?->revoke();
            });
        }
        return true;
    }


    public function sign_up(array $data): bool
    {
        $created_user = $this->userService->createUser([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'username' => $data['username'],
            'password' => Hash::make($data['password']),
        ]);
        $plainToken = Str::random(64);
        $hashedToken = hash('sha256', $plainToken);
        $this->blackListTokenService->create_token_for_user($created_user['id'], BlackListTokenType::Email->value, $hashedToken);
        Mail::to($created_user->email)->send(new SendVerifyEmail($plainToken));
        return true;
    }

    public function send_email_verification(string $email): bool
    {
        $user = $this->userService->getUserByEmail($email);
        if($user->status === UserStatus::Active->value)
        {
            throw new UnauthorizedHttpException('', 'Already Verified');
        }
        $plainToken = Str::random(64);
        $hashedToken = hash('sha256', $plainToken);
        $this->blackListTokenService->update_tokens($user->id, BlackListTokenType::Email->value);
        $this->blackListTokenService->create_token_for_user($user['id'], BlackListTokenType::Email->value, $hashedToken);
        Mail::to($user['email'])->send(new SendVerifyEmail($plainToken));
        return true;
    }


    public function send_reset_password_link(string $email): bool
    {
        $user = $this->userService->getUserByEmail($email);
        if($user->status !== UserStatus::Active->value){
            throw new UnauthorizedHttpException('', 'Unauthorized');
        }
        $plainToken = Str::random(64);
        $hashedToken = hash('sha256', $plainToken);
        $this->blackListTokenService->update_tokens($user->id, BlackListTokenType::Password->value);
        $this->blackListTokenService->create_token_for_user($user['id'], BlackListTokenType::Password->value, $hashedToken);
        Mail::to($user['email'])->send(new SendResetPasswordEmail($plainToken));
        return true;
    }


    public function reset_password(string $token, string $password): bool
    {
        $found_token = $this->blackListTokenService->get_user_by_token($token);
        //dd(!$found_token, Carbon::now() > Carbon::parse($found_token->expires_at),$found_token->revoked === true,$found_token->used === true );
        if(!$found_token || Carbon::now() > Carbon::parse($found_token->expires_at) || $found_token->revoked === true || $found_token->used === true){
            throw new UnauthorizedHttpException('', 'Unauthorized');
        }
        $user = $this->userService->getUserById($found_token->user_id);
        if($user->status !== UserStatus::Active->value){
            throw new UnauthorizedHttpException('', 'Unauthorized');
        }
        $user->password = Hash::make($password);
        $user->save();
        $found_token->used = true;
        $found_token->save();
        return true;
    }

}
