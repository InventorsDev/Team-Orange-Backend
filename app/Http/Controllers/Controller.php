<?php

namespace App\Http\Controllers;

use App\Models\Token;
use App\Traits\ApiResponses;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserOtpVerificationMail;
use App\Traits\GenerateAuthAccessCredentials;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests, ApiResponses, GenerateAuthAccessCredentials;

    public function sendRegistrationOtpToUser($user)
    {
        $token = Token::createForUser($user, 4);

        Mail::to($user->email)->send(new UserOtpVerificationMail($user, $token->token));
    }

    protected function generateAuthData($user)
    {
        [$accessToken, $expiresAt] = $this->generateAccessCredentialsFor($user);

        return [
            'token' => $accessToken,
            'expires_at' => $expiresAt,
            'user' => new UserResource($user),
        ];
    }
}
