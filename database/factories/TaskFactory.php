<?php

namespace Database\Factories;

use App\Enums\TaskStatuses;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'          => fake()->name(),
            'description'   => fake()->text(50),
            'status'        => fake()->randomElement(TaskStatuses::values()),
            'started_at'    => fake()->dateTime(),
            'finished_at'   => fake()->dateTime(),
            'project_id'    => Project::factory(),
            'creator_id'    => User::factory(),
        ];
    }
}
