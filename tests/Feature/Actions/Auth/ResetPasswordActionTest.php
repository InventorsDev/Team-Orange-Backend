<?php

namespace Tests\Feature\Actions\Auth;

use Tests\TestCase;

use Illuminate\Support\Facades\DB;
use App\Actions\Auth\ResetPasswordAction;
use App\Models\User;
use App\Http\Requests\ResetPasswordRequest;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ResetPasswordActionTest extends TestCase
{

    /** @test */
    public function valid_token_should_reset_password()
    {
        $user = User::factory()->create();
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => 'valid_token',
            'created_at' => now(),
        ]);

        $resetPasswordAction = new ResetPasswordAction();
        $request = new ResetPasswordRequest([
            'token' => 'valid_token',
            'password' => 'new_password',
        ]);

        $resetPasswordAction->execute($request);

        $this->assertCredentials([
            'email' => $user->email,
            'password' => 'new_password',
        ]);

        $this->assertDatabaseMissing('password_resets', ['email' => $user->email]);
    }

    /** @test */
    public function invalid_token_should_throw_exception()
    {
        $resetPasswordAction = new ResetPasswordAction();
        $request = new ResetPasswordRequest([
            'token' => 'invalid_token',
            'password' => 'new_password',
        ]);

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Invalid token');

        $resetPasswordAction->execute($request);
    }

    /** @test */
    public function expired_token_should_throw_exception()
    {

        $user = User::factory()->create();
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => 'expired_token',
            'created_at' => now()->subMinutes(15),
        ]);

        $resetPasswordAction = new ResetPasswordAction();
        $request = new ResetPasswordRequest([
            'token' => 'expired_token',
            'password' => 'new_password',
        ]);

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Token is Expired');

        $resetPasswordAction->execute($request);
    }
}
