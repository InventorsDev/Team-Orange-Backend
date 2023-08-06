<?php

namespace Database\Factories;

use App\Models\User;
use App\Enums\GoalSettingDurationEnum;
use Spatie\Enum\Laravel\Faker\FakerEnumProvider;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\GoalSetting>
 */
class GoalSettingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = $this->faker;

        $faker->addProvider(new FakerEnumProvider($faker));
        return [
            'user_id' => User::factory()->create()->id,
            'goal_plan' => $faker->title(),
            'goal_information' => $faker->sentence(),
            'duration' => $faker->randomEnumValue(GoalSettingDurationEnum::class),
            'start_date' => $faker->date(),
            'end_date' => $faker->date(),

        ];
    }
}
