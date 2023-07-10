<?php

namespace App\Actions\Auth;

use App\Models\User;
use App\Models\Token;
use App\Http\Requests\VerifyOtpRequest;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Illuminate\Support\Facades\DB;

class VerifyOtpAction
{
    public function execute(VerifyOtpRequest $request)
    {
        return DB::transaction(function () use ($request) {
            $token = Token::where('token', $request->token)->first();
            $user = User::where('email', $request->email)->first();

            if (!$token || $token->user_id !== $user->id) {
                throw new BadRequestException('Invalid Token');
            }

            if (!$token->isValid()) {
                throw new BadRequestException('Token is Expired');
            }

            $user->email_verified_at = now();
            $user->save();
            $token->delete();

            return $user;
        });
    }
}
