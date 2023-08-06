<?php

namespace App\Actions\Auth;

use Exception;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ResetPasswordRequest;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ResetPasswordAction
{
    public function execute(ResetPasswordRequest $request): void
    {
        DB::beginTransaction();
        try {
            $userToken = DB::table('password_resets')->where('token', $request->token)->first();

            if (!$userToken) {
                throw new BadRequestException('Invalid token');
            }

            if (!$userToken || now()->diffInMinutes($userToken->created_at) > 10) {
                throw new BadRequestException('Token is Expired');
            }

            $user = User::where('email', $userToken->email)->first();

            $password = bcrypt($request->password);

            $user->update(['password' => $password]);

            DB::table('password_resets')->where('email', $userToken->email)->delete();
            DB::commit();
        } catch (Exception $e) {
            $errorMessage = $e->getMessage() ?: 'An error occured processing this request';

            if ($e instanceof BadRequestException) {
                throw new BadRequestException($errorMessage);
            }

            throw new Exception($errorMessage);
        }
    }
}
