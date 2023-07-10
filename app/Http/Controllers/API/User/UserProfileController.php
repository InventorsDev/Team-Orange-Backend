<?php

namespace App\Http\Controllers\API\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    public function show(Request $request)
    {
        $user =  $request->user();

        return $this->successResponse('User profile retreived successfully', $user);
    }
}
