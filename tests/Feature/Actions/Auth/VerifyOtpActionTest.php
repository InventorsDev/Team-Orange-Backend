<?php

namespace Tests\Feature\Actions\Auth;

use Carbon\Carbon;
use Tests\TestCase;
use App\Models\User;
use App\Models\Token;
use App\Actions\Auth\VerifyOtpAction;
use App\Http\Requests\VerifyOtpRequest;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class VerifyOtpActionTest extends TestCase
{
    use DatabaseTransactions;

    /** @test */
    public function it_can_verify_otp_and_mark_user_as_verified()
    {
        $user = User::factory()->create();
        $token = Token::createForUser($user, 4);

        $requestData = [
            'token' => $token->token,
            'email' => $user->email,
        ];

        $request = new VerifyOtpRequest($requestData);

        $action = new VerifyOtpAction();

        $result = $action->execute($request);

        $this->assertNotNull($result->email_verified_at);

        $this->assertDatabaseMissing('tokens', ['id' => $token->id]);
    }

    /** @test */
    public function it_throws_bad_request_exception_for_invalid_token()
    {
        $user = User::factory()->create();
        $token = Token::createForUser($user, 4);

        $requestData = [
            'token' => 'invalid_token',
            'email' => $user->email,
        ];

        $request = new VerifyOtpRequest($requestData);

        $action = new VerifyOtpAction();

        $this->expectException(BadRequestException::class);

        $action->execute($request);
    }
}
