<?php

namespace App\Actions\Auth;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;

class RegisterAction
{
    public function execute(RegisterRequest $request)
    {

        return User::create([
            'full_name' => $request->full_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }
}
