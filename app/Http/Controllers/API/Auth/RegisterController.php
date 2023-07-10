<?php

namespace App\Http\Controllers\API\Auth;

use App\Models\User;
use App\Actions\Auth\RegisterAction;
use App\Actions\Auth\VerifyOtpAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\ResendOtpRequest;
use App\Http\Requests\VerifyOtpRequest;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = (new RegisterAction())->execute($request);

        $this->sendRegistrationOtpToUser($user);

        return $this->createdResponse('Registration was successful. An OTP has been sent to your email');
    }

    public function resendOtp(ResendOtpRequest $request)
    {
        $user =  User::where('email', $request->email)->first();

        $this->sendRegistrationOtpToUser($user);

        return $this->successResponse('Kindly Input the verification code sent to your email address');
    }

    public function verifyOtp(VerifyOtpRequest $request)
    {
        $user = (new VerifyOtpAction())->execute($request);

        return $this->successResponse('Otp verification successful', $this->generateAuthData($user));
    }
}
