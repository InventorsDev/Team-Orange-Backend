<?php

use Tests\TestCase;
use App\Models\User;
use App\Models\GoalSetting;
use Laravel\Sanctum\Sanctum;
use App\Enums\GoalSettingDurationEnum;
use Illuminate\Foundation\Testing\WithFaker;

class GoalSettingControllerTest extends TestCase
{
    use WithFaker;

    /** @test */
    public function it_can_retrieve_user_goal_settings()
    {
        $user = User::factory()->create();

        $goalSettings = GoalSetting::factory()
            ->count(5)
            ->for($user)
            ->create();

        Sanctum::actingAs($user);

        $response = $this->getJson('/api/v1/goal-settings', $goalSettings->toArray());

        $response->assertStatus(200);
    }

    /** @test */
    public function it_returns_success_response_with_empty_array_when_no_goal_settings_found()
    {

        $user = User::factory()->create();

        Sanctum::actingAs($user);

        $response = $this->get('/api/v1/goal-settings');

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_create_a_goal_setting()
    {

        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $data = [
            'goal_plan' => $this->faker->sentence,
            'goal_information' => $this->faker->paragraph,
            'duration' => GoalSettingDurationEnum::getRandomValue(),
            'start_date' => "2023-08-04",
            'end_date' => "2023-08-05",
        ];


        $response = $this->postJson('/api/v1/goal-settings', $data);

        $response->assertStatus(201);
    }

    /** @test */
    public function it_can_update_a_goal_setting()
    {

        $user = User::factory()->create();
        $goalSetting = GoalSetting::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $data = [
            'goal_plan' => $this->faker->sentence,
            'goal_information' => $this->faker->paragraph,
            'duration' => GoalSettingDurationEnum::getRandomValue(),
            'start_date' => "2023-08-04",
            'end_date' => "2023-08-05",
        ];

        $response = $this->patchJson('/api/v1/goal-settings/' . $goalSetting->id, $data);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_delete_a_goal_setting()
    {
        $user = User::factory()->create();
        $goalSetting = GoalSetting::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $response = $this->delete('/api/v1/goal-settings/' . $goalSetting->id);

        $response->assertStatus(200);
    }

    /** @test */
    public function it_can_retrieve_a_single_goal_setting()
    {
        $user = User::factory()->create();
        $goalSetting = GoalSetting::factory()->create(['user_id' => $user->id]);

        Sanctum::actingAs($user);

        $response = $this->get('/api/v1/goal-settings/' . $goalSetting->id);

        $response->assertStatus(200);
    }
}
