<?php

namespace App\Http\Controllers;

use App\Traits\ApiResponses;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserOtpVerificationMail;
use App\Models\Token;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ApiResponses;

    public function sendRegistrationOtpToUser($user)
    {
        $token = Token::createForUser($user, 4);

        Mail::to($user->email)->send(new UserOtpVerificationMail($user, $token->token));
    }
}
