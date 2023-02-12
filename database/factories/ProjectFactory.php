<?php

namespace Database\Factories;

use App\Enums\ProjectStatuses;
use App\Models\Team;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'          => fake()->name,
            'description'    => fake()->text(50),
            'status'        => fake()->randomElement(ProjectStatuses::values()),
            'started_at'    => fake()->dateTime(),
            'finished_at'   => fake()->dateTime(),
            'team_id'       => Team::factory(),
            'creator_id'    => User::factory(),
        ];
    }
}
