<?php

namespace App\Http\Controllers\API\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\SetUsernameRequest;

class SetUsernameController extends Controller
{
    public function setUsername(SetUsernameRequest $request)
    {
        $user = $request->user();

        $user->username = $request->username;
        $user->save();

        return $this->successResponse('Username successfully set');
    }
}
