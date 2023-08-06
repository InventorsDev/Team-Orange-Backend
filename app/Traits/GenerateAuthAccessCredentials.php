<?php

namespace App\Traits;

use App\Models\User;
use Carbon\Carbon;

trait GenerateAuthAccessCredentials
{
    private function generateAccessCredentialsFor(User $user, ?array $abilities = []): array
    {
        $token = $user->createToken($user->email, $abilities);
        $expiresAt = Carbon::now()->addWeek(4)->getTimestamp();
        $user->withAccessToken($token->accessToken);

        return [$token->plainTextToken, $expiresAt];
    }
}
