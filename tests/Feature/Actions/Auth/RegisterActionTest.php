<?php

namespace Tests\Feature\Actions\Auth;

use App\Actions\Auth\RegisterAction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegisterActionTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_can_register_a_new_user()
    {
        $registerRequestData = [
            'full_name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => 'password123',
        ];

        $registerRequest = new \App\Http\Requests\RegisterRequest($registerRequestData);

        $registerAction = new RegisterAction();
        $user = $registerAction->execute($registerRequest);

        $this->assertDatabaseHas('users', [
            'id' => $user->id,
            'full_name' => $registerRequestData['full_name'],
            'email' => $registerRequestData['email'],
        ]);

        $this->assertTrue(Hash::check($registerRequestData['password'], $user->password));
    }
}
