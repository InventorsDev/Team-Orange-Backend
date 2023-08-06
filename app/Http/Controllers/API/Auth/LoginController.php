<?php

namespace App\Http\Controllers\API\Auth;

use App\Actions\Auth\LoginAction;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = (new LoginAction())->execute($request);

        return $this->successResponse('User successfully logged in', $this->generateAuthData($user));
    }
}
