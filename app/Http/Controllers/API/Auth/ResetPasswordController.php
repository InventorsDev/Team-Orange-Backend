<?php

namespace App\Http\Controllers\API\Auth;

use App\Actions\Auth\ResetPasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ResetPasswordRequest;

class ResetPasswordController extends Controller
{
    public function resetPassword(ResetPasswordRequest $request)
    {
        (new ResetPasswordAction())->execute($request);

        return $this->successResponse('Password reset successfully.');
    }
}
