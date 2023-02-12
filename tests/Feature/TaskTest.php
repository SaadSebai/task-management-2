<?php

namespace Tests\Feature;

use App\Enums\TaskStatuses;
use App\Models\Project;
use App\Models\Task;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TaskTest extends TestCase
{
    /**
     * Test Task Index.
     *
     * @return void
     */
    public function test_index(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $project = Project::factory()->create();

        $response = $this->get(
            "/api/projects/{$project->id}/tasks?token=$token"
        );

        $response->assertStatus(200);
    }

    /**
     * Test Task Index with filter.
     *
     * @return void
     */
    public function test_index_with_filter(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $project = Project::factory()->create();

        $response = $this->get(
            "/api/projects/{$project->id}/tasks?token=$token",
            [
                'filters[search]'   => fake()->randomLetter(),
                'sort_attribute'    => 'id',
                'sort_order'        => 'desc'
            ]
        );

        $response->assertStatus(200);
    }

    /**
     * Test Task Show.
     *
     * @return void
     */
    public function test_show(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $project = Project::factory()->create();

        $task = Task::factory()->create(['project_id' => $project]);

        $response = $this->get(
            "/api/projects/{$project->id}/tasks/{$task->id}?token={$token}"
        );

        $response->assertStatus(200);
    }

    /**
     * Test Task Store.
     *
     * @return void
     */
    public function test_store(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $project = Project::factory()->create();

        $member = User::factory()->create();

        $member->teams()->attach($project->team_id);

        $response = $this->post(
            "/api/projects/{$project->id}/tasks?token={$token}",
            [
                'name'          => fake()->name(),
                'description'   => fake()->text(50),
                'status'        => fake()->randomElement(TaskStatuses::values()),
                'started_at'    => now()->format('Y-m-d H:i:s'),
                'finished_at'   => now()->format('Y-m-d H:i:s'),
                'user_id'       => $member->id
            ]
        );

        $response->assertStatus(200);
    }

    /**
     * Test Task Update.
     *
     * @return void
     */
    public function test_update(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $project = Project::factory()->create();

        $member = User::factory()->create();

        $member->teams()->attach($project->team_id);

        $task = Task::factory()->create(['project_id' => $project]);

        $response = $this->put(
            "/api/projects/{$project->id}/tasks/{$task->id}?token={$token}",
            [
                'name'          => fake()->name(),
                'description'   => fake()->text(50),
                'status'        => fake()->randomElement(TaskStatuses::values()),
                'started_at'    => now()->format('Y-m-d H:i:s'),
                'finished_at'   => now()->format('Y-m-d H:i:s'),
                'user_id'       => $member->id
            ]
        );

        $response->assertStatus(200);
    }

    /**
     * Test Delete Task.
     *
     * @return void
     */
    public function test_delete(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $project = Project::factory()->create();

        $task = Task::factory()->create(['project_id' => $project]);

        $response = $this->delete(
            "/api/projects/{$project->id}/tasks/{$task->id}?token={$token}"
        );

        $response->assertStatus(200);
    }
}
