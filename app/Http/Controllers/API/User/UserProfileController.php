<?php

namespace App\Http\Controllers\API\User;

use App\Actions\User\UpdateProfileAction;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(Request $request)
    {
        $user =  $request->user()->load('country:id,name,iso3,phone_code,emoji');

        return $this->successResponse('User profile retreived successfully', $user);
    }

    public function updateProfile(UpdateProfileRequest $request)
    {
        $userUpdateProfile = (new UpdateProfileAction())->execute($request);

        return $this->successResponse('User profile updated successfully', $userUpdateProfile);
    }
}
