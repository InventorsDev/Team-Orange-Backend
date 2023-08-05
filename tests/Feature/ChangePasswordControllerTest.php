<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;
use App\Http\Requests\ChangePasswordRequest;
use Symfony\Component\HttpFoundation\Response;
use App\Actions\User\ChangePasswordAction;
use App\Models\User;
use Laravel\Sanctum\Sanctum;

class ChangePasswordControllerTest extends TestCase
{

    public function test_change_password_with_valid_request_should_update_password_and_return_success_response()
    {
        $user = User::factory()->create([
            'password' => Hash::make('Old@12password'),
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/user/change-password', [
            'old_password' => 'Old@12password',
            'new_password' => 'Old@124password',
        ]);

        $response->assertStatus(200);
    }

    public function test_change_password_with_invalid_old_password_should_return_error_response()
    {
        $user = User::factory()->create([
            'password' => Hash::make('old_password'),
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/user/change-password', [
            'old_password' => 'invalid_password',
            'new_password' => 'N%74ew_password',
        ]);

        $response->assertStatus(400);
    }

    public function test_change_password_with_same_old_and_new_password_should_return_error_response()
    {
        $user = User::factory()->create([
            'password' => Hash::make('O&48ld_password'),
        ]);

        Sanctum::actingAs($user);

        $response = $this->postJson('/api/v1/user/change-password', [
            'old_password' => 'O&48ld_password',
            'new_password' => 'O&48ld_password',
        ]);

        $response->assertStatus(400);
    }
}
