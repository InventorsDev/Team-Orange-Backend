<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\Token;
use App\Actions\Auth\RegisterAction;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserOtpVerificationMail;
use App\Http\Requests\RegisterRequest;
use App\Http\Controllers\API\Auth\RegisterController;
use Illuminate\Foundation\Testing\WithFaker;

class RegisterControllerTest extends TestCase
{
    use WithFaker;
    /** @test */
    public function it_can_send_registration_otp_to_user()
    {

        Mail::fake();

        $user = User::factory()->create();
        $token = Token::createForUser($user, 4, '1234', false);

        $controller = new RegisterController();
        $controller->sendRegistrationOtpToUser($user);

        Mail::assertSent(UserOtpVerificationMail::class, function ($mail) use ($user, $token) {
            return $mail->hasTo($user->email) && $token->token;
        });
    }

    /** @test */
    public function it_can_register_a_user()
    {
        $userData = [
            'full_name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'Password#123',
        ];

        $response = $this->post('api/v1/auth/register', $userData);

        $response->assertStatus(201);

        $this->assertDatabaseHas('users', [
            'email' => $userData['email'],
        ]);
    }

    /** @test */
    public function it_requires_full_name_email_and_password_for_registration()
    {

        $response = $this->postJson('api/v1/auth/register', []);

        $response->assertStatus(422);

        $response->assertSee('The full name field is required.');
        $response->assertSee('The email field is required.');
        $response->assertSee('The password field is required.');
    }
}
