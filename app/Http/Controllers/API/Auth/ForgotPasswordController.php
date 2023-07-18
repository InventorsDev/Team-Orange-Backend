<?php

namespace App\Http\Controllers\API\Auth;

use App\Actions\Auth\ForgotPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ForgotPasswordRequest;


class ForgotPasswordController extends Controller
{
    public function forgotPassword(ForgotPasswordRequest $request)
    {
        (new ForgotPasswordAction())->execute($request);

        return $this->successResponse('An otp has been sent to the provided email address.');
    }
}
