<?php

namespace Tests\Feature\Auth;

use App\Admin;
use App\Donator;
use App\Manager;
use App\Pickupman;
use App\Verifier;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ApiAuthenticationTest extends TestCase
{
    use RefreshDatabase;

    public function test_users_can_authenticate_using_the_login_api()
    {
        $donator = Donator::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $donator->email,
            'password' => 'password',
            'role' => 'donator',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'access_token',
                    'token_type',
                    'user',
                ],
            ]);
    }

    public function test_users_can_not_authenticate_with_invalid_password()
    {
        $donator = Donator::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $donator->email,
            'password' => 'wrong-password',
            'role' => 'donator',
        ]);

        $response->assertStatus(401)
            ->assertJson([
                'success' => false,
                'message' => 'Invalid credentials',
            ]);
    }

    public function test_admin_can_authenticate_using_the_login_api()
    {
        $admin = Admin::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $admin->email,
            'password' => 'password',
            'role' => 'admin',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'access_token',
                    'token_type',
                    'user',
                ],
            ]);
    }

    public function test_manager_can_authenticate_using_the_login_api()
    {
        $manager = Manager::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $manager->email,
            'password' => 'password',
            'role' => 'manager',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'access_token',
                    'token_type',
                    'user',
                ],
            ]);
    }

    public function test_pickupman_can_authenticate_using_the_login_api()
    {
        $pickupman = Pickupman::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $pickupman->email,
            'password' => 'password',
            'role' => 'pickupman',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'access_token',
                    'token_type',
                    'user',
                ],
            ]);
    }

    public function test_verifier_can_authenticate_using_the_login_api()
    {
        $verifier = Verifier::factory()->create();

        $response = $this->postJson('/api/login', [
            'email' => $verifier->email,
            'password' => 'password',
            'role' => 'verifier',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'access_token',
                    'token_type',
                    'user',
                ],
            ]);
    }

    public function test_users_can_register_using_the_api()
    {
        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => 'password',
            'role' => 'donator',
        ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'access_token',
                    'token_type',
                    'user',
                ],
                'message',
            ]);

        $this->assertDatabaseHas('donators', [
            'email' => 'test@example.com',
        ]);
    }

    public function test_users_can_not_register_with_existing_email()
    {
        $donator = Donator::factory()->create();

        $response = $this->postJson('/api/register', [
            'name' => 'Test User',
            'email' => $donator->email,
            'password' => 'password',
            'role' => 'donator',
        ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }
}
