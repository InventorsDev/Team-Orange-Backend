<?php

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Testing\WithFaker;
use App\Traits\GenerateAuthAccessCredentials;
use App\Http\Controllers\API\Auth\LoginController;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginControllerTest extends TestCase
{
    use WithFaker;
    use GenerateAuthAccessCredentials;

    /** @test */
    public function it_can_login_user_and_return_auth_data()
    {

        $password = 'secretPassword';
        $user = User::factory()->create([
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/auth/login', [
            'email' => $user->email,
            'password' => $password,
        ]);

        $response->assertStatus(200);
    }
}
