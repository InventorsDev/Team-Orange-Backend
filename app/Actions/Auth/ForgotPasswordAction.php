<?php

namespace App\Actions\Auth;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Token;
use App\Models\PasswordReset;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Exceptions\NotFoundException;
use App\Http\Requests\ForgotPasswordRequest;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ForgotPasswordAction
{
    public function execute(ForgotPasswordRequest $request): void
    {

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            throw new NotFoundException('Account could not be found.');
        }

        if ($user->email_verified_at == null) {
            throw new BadRequestException("We noticed that you havn't verify your email, kindly verify your email to reset password");
        }

        $tokenData = PasswordReset::updateOrCreate(['email' => $user->email], [
            'email' => $user->email,
            'token' => Token::createForUser($user, 4, null, false)->token,
            'created_at' => Carbon::now(),
        ]);

        Mail::to($user->email)->send(new ForgotPasswordMail($user, $tokenData->token));
    }
}
