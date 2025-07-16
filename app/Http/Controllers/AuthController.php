<?php

namespace App\Http\Controllers;

use App\Domain\Auth\Service\AuthService;

class AuthController extends Controller
{

    public function __construct(private readonly AuthService $authService){}


}
