<?php

namespace App\Actions\User;

use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\ChangePasswordRequest;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ChangePasswordAction
{
    public function execute(ChangePasswordRequest $request)
    {
        $user = $request->user();

        if (!$user || !Hash::check($request->old_password, $user->password)) {
            throw new BadRequestException('Previous Passwords do not match');
        }

        if (strcmp($request->old_password, $request->new_password) == 0) {
            throw new BadRequestException('You have used this password before. Try a new one!');
        }

        $user->update(['password' => bcrypt($request->new_password)]);

        return $user;
    }
}
