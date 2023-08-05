<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Token;


class VerifyOtpControllerTest extends TestCase
{

    /** @test */
    public function it_can_verify_otp_and_return_auth_data()
    {
        $user = User::factory()->create(['email_verified_at' => null]);
        $token = Token::factory()->create(['user_id' => $user->id]);

        $response = $this->postJson('/api/v1/auth/verify-otp', [
            'email' => $user->email,
            'token' => $token->token,
        ]);

        $response->assertStatus(200);

        $response->assertJsonStructure([
            'message',
            'data' => [
                'token',
                'expires_at',
                'user' => [
                    'id',
                    'full_name',
                    'email',
                    'created_at',
                    'updated_at',
                ],
            ],
        ]);
    }
}
