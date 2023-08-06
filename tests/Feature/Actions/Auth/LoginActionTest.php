<?php

namespace Tests\Feature\Actions\Auth;


use Tests\TestCase;
use App\Actions\Auth\LoginAction;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class LoginActionTest extends TestCase
{
    /** @test */
    public function it_can_authenticate_user_with_correct_credentials()
    {
        $password = 'secretPassword';
        $user = User::factory()->create([
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $request = new LoginRequest([
            'email' => $user->email,
            'password' => $password,
        ]);


        $action = new LoginAction();
        $authenticatedUser = $action->execute($request);

        $this->assertEquals($user->id, $authenticatedUser->id);
    }

    /** @test */
    public function it_throws_bad_request_exception_for_incorrect_credentials()
    {
        $password = 'secretPassword';
        $user = User::factory()->create([
            'password' => Hash::make($password),
            'email_verified_at' => now(),
        ]);

        $request = new LoginRequest([
            'email' => $user->email,
            'password' => 'incorrectPassword',
        ]);

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('The provided credentials are incorrect.');

        $action = new LoginAction();
        $action->execute($request);
    }

    /** @test */
    public function it_throws_bad_request_exception_for_unverified_email()
    {
        $password = 'secretPassword';
        $user = User::factory()->create([
            'password' => Hash::make($password),
            'email_verified_at' => null,
        ]);

        $request = new LoginRequest([
            'email' => $user->email,
            'password' => $password,
        ]);

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage("We noticed that you havn't verify your email, kindly verify your email to login");

        $action = new LoginAction();
        $action->execute($request);
    }
}
