<?php

use Tests\TestCase;
use App\Models\User;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Actions\Auth\ForgotPasswordAction;
use App\Http\Requests\ForgotPasswordRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Http\Controllers\API\Auth\ForgotPasswordController;

class ForgotPasswordControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_can_send_forgot_password_mail()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/auth/forgot-password', [
            'email' => $user->email,
        ]);

        $response->assertStatus(200)
            ->assertJson([
                'message' => 'An otp has been sent to the provided email address.',
            ]);
    }
}
