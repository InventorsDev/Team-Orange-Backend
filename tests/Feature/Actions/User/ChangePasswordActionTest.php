<?php

namespace Tests\Feature\Actions\User;

use Tests\TestCase;
use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Actions\User\ChangePasswordAction;
use App\Http\Requests\ChangePasswordRequest;
use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class ChangePasswordActionTest extends TestCase
{
    public function test_change_password_with_valid_request_should_update_password_and_return_user()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old_password'),
        ]);

        $request = new ChangePasswordRequest([
            'old_password' => 'old_password',
            'new_password' => 'new_password',
        ]);

        // Assign the user to the request to simulate authentication
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $action = new ChangePasswordAction();
        $updatedUser = $action->execute($request);

        $this->assertTrue(Hash::check('new_password', $user->fresh()->password));

        $this->assertEquals($user->id, $updatedUser->id);
        $this->assertEquals($user->email, $updatedUser->email);
    }

    public function test_change_password_with_invalid_old_password_should_throw_exception()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old_password'),
        ]);

        $request = new ChangePasswordRequest([
            'old_password' => 'invalid_password',
            'new_password' => 'new_password',
        ]);

        $action = new ChangePasswordAction();

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('Previous Passwords do not match');

        $action->execute($request);
    }

    public function test_change_password_with_same_old_and_new_password_should_throw_exception()
    {
        $user = User::factory()->create([
            'password' => 'old_password',
        ]);


        $request = new ChangePasswordRequest([
            'old_password' => 'old_password',
            'new_password' => 'old_password',
        ]);

        // Assign the user to the request to simulate authentication
        $request->setUserResolver(function () use ($user) {
            return $user;
        });

        $action = new ChangePasswordAction();

        $this->expectException(BadRequestException::class);
        $this->expectExceptionMessage('You have used this password before. Try a new one!');

        $action->execute($request);
    }
}
