<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;
use App\Http\Requests\ResetPasswordRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Actions\Auth\ResetPasswordAction;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class ResetPasswordControllerTest extends TestCase
{

    /** @test */
    public function valid_token_should_reset_password_and_return_success_response()
    {
        $user = User::factory()->create();
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => 'valid_token',
            'created_at' => now(),
        ]);

        $response = $this->postJson('/api/v1/auth/reset-password', [
            'token' => 'valid_token',
            'password' => 'Password#12345',
        ]);


        $response->assertStatus(200);

        $this->assertTrue(Hash::check('Password#12345', $user->fresh()->password));

        $this->assertDatabaseMissing('password_resets', ['email' => $user->email]);
    }

    public function test_invalid_token_should_return_error_response()
    {
        $response = $this->postJson('/api/v1/auth/reset-password', [
            'token' => 'invalid_token',
            'password' => 'Password#12345',
        ]);

        $response->assertStatus(400);
    }

    public function test_expired_token_should_return_error_response()
    {
        $user = User::factory()->create();
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => 'expired_token',
            'created_at' => now()->subMinutes(15),
        ]);

        $response = $this->postJson('/api/v1/auth/reset-password', [
            'token' => 'expired_token',
            'password' => 'Password#12345',
        ]);

        $response->assertStatus(400);
    }
}
