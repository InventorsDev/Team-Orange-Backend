<?php

namespace App\Http\Controllers\API\User;

use App\Actions\User\ChangePasswordAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;


class ChangePasswordController extends Controller
{
    public function changePassword(ChangePasswordRequest $request)
    {
        (new ChangePasswordAction())->execute($request);

        return $this->successResponse('Password changed successfully');
    }
}
