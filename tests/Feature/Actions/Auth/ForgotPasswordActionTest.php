<?php

namespace Tests\Feature\Actions\Auth;

use Tests\TestCase;
use App\Models\User;
use App\Models\Token;
use App\Models\PasswordReset;
use App\Mail\ForgotPasswordMail;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\ForgotPasswordRequest;
use App\Actions\Auth\ForgotPasswordAction;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use App\Exceptions\NotFoundException;

class ForgotPasswordActionTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_can_send_reset_password_mail_for_existing_verified_user()
    {
        Mail::fake();

        $user = User::factory()->create([
            'email_verified_at' => now(),
        ]);

        $request = new ForgotPasswordRequest([
            'email' => $user->email,
        ]);

        $action = new ForgotPasswordAction();
        $action->execute($request);

        Mail::assertSent(ForgotPasswordMail::class, function ($mail) use ($user) {
            return $mail->hasTo($user->email);
        });

        $this->assertDatabaseHas('password_resets', [
            'email' => $user->email,
        ]);
    }

    /** @test */
    public function it_throws_not_found_exception_for_non_existing_user()
    {
        $request = new ForgotPasswordRequest([
            'email' => 'nonexisting@example.com',
        ]);

        $action = new ForgotPasswordAction();

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Account could not be found.');

        $action->execute($request);
    }

    /** @test */
    public function it_throws_bad_request_exception_for_unverified_email()
    {

        $user = User::factory()->create([
            'email_verified_at' => null,
        ]);

        $request = new ForgotPasswordRequest([
            'email' => $user->email,
        ]);

        $action = new ForgotPasswordAction();

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("We noticed that you havn't verify your email, kindly verify your email to reset password");

        $action->execute($request);
    }
}
