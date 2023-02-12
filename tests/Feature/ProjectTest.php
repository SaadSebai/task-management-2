<?php

namespace Tests\Feature;

use App\Enums\ProjectStatuses;
use App\Models\Project;
use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProjectTest extends TestCase
{
    /**
     * Test Project Index.
     *
     * @return void
     */
    public function test_index(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $response = $this->get("/api/projects?token=$token");

        $response->assertStatus(200);
    }

    /**
     * Test Project Index with filter.
     *
     * @return void
     */
    public function test_index_with_filter(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $response = $this->get(
            "/api/projects?token=$token",
            [
                'filters[search]'   => fake()->randomLetter(),
                'sort_attribute'    => 'id',
                'sort_order'        => 'desc'
            ]
        );

        $response->assertStatus(200);
    }

    /**
     * Test Project Show.
     *
     * @return void
     */
    public function test_show(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $project = Project::factory()->create();

        $response = $this->get("/api/projects/{$project->id}?token={$token}");

        $response->assertStatus(200);
    }

    /**
     * Test Project Store.
     *
     * @return void
     */
    public function test_store(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $response = $this->post(
            "/api/projects?token={$token}",
            [
                'name'          => fake()->name(),
                'description'   => fake()->text(50),
                'status'        => fake()->randomElement(ProjectStatuses::values()),
                'started_at'    => now()->format('Y-m-d H:i:s'),
                'finished_at'   => now()->format('Y-m-d H:i:s'),
                'team_id'       => Team::factory()->create()->id
            ]
        );

        $response->assertStatus(200);
    }

    /**
     * Test Project Update.
     *
     * @return void
     */
    public function test_update(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $project = Project::factory()->create();

        $response = $this->put(
            "/api/projects/{$project->id}?token={$token}",
            [
                'name'          => fake()->name(),
                'description'   => fake()->text(50),
                'status'        => fake()->randomElement(ProjectStatuses::values()),
                'started_at'    => now()->format('Y-m-d H:i:s'),
                'finished_at'   => now()->format('Y-m-d H:i:s'),
                'team_id'       => Team::factory()->create()->id
            ]
        );

        $response->assertStatus(200);
    }

    /**
     * Test Delete Project.
     *
     * @return void
     */
    public function test_delete(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $project = Project::factory()->create();

        $response = $this->delete("/api/projects/{$project->id}?token={$token}");

        $response->assertStatus(200);
    }
}
