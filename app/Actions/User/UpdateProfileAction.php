<?php

namespace App\Actions\User;

use App\Utils\FileUpload;
use App\Http\Requests\UpdateProfileRequest;

class UpdateProfileAction
{
    public function execute(UpdateProfileRequest $request)
    {
        $user = $request->user();

        $fileUpload = null;

        if (!is_null($request->image)) {
            $fileUpload = (new FileUpload())->uploadFile($request->image, 'profileImages');
        }

        $data = [
            'full_name' => $request->full_name,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
            'country_id' => $request->country_id,
        ];

        if (!is_null($fileUpload)) {
            $data['profile_image_url'] = $fileUpload;
        }

        $user->update($data);

        return $user;
    }
}
