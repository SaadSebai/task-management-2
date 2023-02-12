<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * Test Register.
     *
     * @return void
     */
    public function test_register(): void
    {
        $response = $this->post('/api/register', [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'password' => '123456789',
            'password_confirmation' => '123456789',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test Login.
     *
     * @return void
     */
    public function test_login(): void
    {
        $user = User::factory()->create(['password' => 'password']);

        $response = $this->post('/api/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test Logout.
     *
     * @return void
     */
    public function test_logout(): void
    {
        $user = User::factory()->create(['password' => 'password']);

        $token = auth()->fromUser($user);

        $response = $this->post(
            uri: "api/logout?token=$token",
        );

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * Test Refresh.
     *
     * @return void
     */
    public function test_refresh(): void
    {
        $user = User::factory()->create(['password' => 'password']);

        $token = auth()->fromUser($user);

        $response = $this->post(
            uri: "api/refresh?token=$token",
        );

        $response->assertStatus(Response::HTTP_OK);
    }
}
