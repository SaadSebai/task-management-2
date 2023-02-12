<?php

namespace Tests\Feature;

use App\Models\Team;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TeamTest extends TestCase
{
    /**
     * Test Team Index.
     *
     * @return void
     */
    public function test_index(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $response = $this->get("/api/teams?token=$token");

        $response->assertStatus(200);
    }

    /**
     * Test Team Index with filter.
     *
     * @return void
     */
    public function test_index_with_filter(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $response = $this->get(
            "/api/teams?token=$token",
            [
                'filters[search]'   => fake()->randomLetter(),
                'sort_attribute'    => 'id',
                'sort_order'        => 'desc'
            ]
        );

        $response->assertStatus(200);
    }

    /**
     * Test Team Show.
     *
     * @return void
     */
    public function test_show(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $team = Team::factory()->create();

        $response = $this->get("/api/teams/{$team->id}?token={$token}");

        $response->assertStatus(200);
    }

    /**
     * Test Team Store.
     *
     * @return void
     */
    public function test_store(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $response = $this->post(
            "/api/teams?token={$token}",
            ['name' => fake()->unique()->name()]
        );

        $response->assertStatus(200);
    }

    /**
     * Test Team Update.
     *
     * @return void
     */
    public function test_update(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $team = Team::factory()->create();

        $response = $this->put(
            "/api/teams/{$team->id}?token={$token}",
            ['name' => fake()->unique()->name()]
        );

        $response->assertStatus(200);
    }

    /**
     * Test Delete Team.
     *
     * @return void
     */
    public function test_delete(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $team = Team::factory()->create();

        $response = $this->delete("/api/teams/{$team->id}?token={$token}");

        $response->assertStatus(200);
    }

    /**
     * Test Delete Team.
     *
     * @return void
     */
    public function test_add_member(): void
    {
        $user = User::factory()->create();

        $token = auth()->fromUser($user);

        $team = Team::factory()->create();

        $response = $this->post(
            "/api/teams/{$team->id}/add-member?token={$token}",
            ['user_id' => User::factory()->create()->id]
        );

        $response->assertStatus(200);
    }
}
