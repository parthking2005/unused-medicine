<?php

namespace Tests\Feature\Api;

use App\Admin;
use App\Manager;
use App\NGO;
use App\MedicineStock;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class NGOManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_list_ngos()
    {
        $admin = Admin::factory()->create();
        $ngos = NGO::factory()->count(3)->create();

        $response = $this->actingAs($admin, 'sanctum')
            ->getJson('/api/admin/ngos');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'name',
                        'address',
                        'phone',
                        'email',
                        'manager',
                    ],
                ],
            ]);
    }

    public function test_admin_can_create_ngo()
    {
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/ngos', [
                'name' => 'Test NGO',
                'address' => '123 Test Street',
                'phone' => '1234567890',
                'email' => 'test@ngo.com',
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'name',
                    'address',
                    'phone',
                    'email',
                ],
                'message',
            ]);

        $this->assertDatabaseHas('ngos', [
            'name' => 'Test NGO',
            'email' => 'test@ngo.com',
        ]);
    }

    public function test_manager_can_view_ngo_stats()
    {
        $ngo = NGO::factory()->create();
        $manager = Manager::factory()->create(['ngo_id' => $ngo->id]);
        MedicineStock::factory()->count(3)->create(['ngo_id' => $ngo->id]);

        $response = $this->actingAs($manager, 'sanctum')
            ->getJson("/api/manager/ngo/{$ngo->id}/stats");

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'donations_today',
                    'total_stock',
                    'active_pickupmen',
                    'pending_donations',
                ],
            ]);
    }

    public function test_manager_cannot_view_other_ngo_stats()
    {
        $ngo1 = NGO::factory()->create();
        $ngo2 = NGO::factory()->create();
        $manager = Manager::factory()->create(['ngo_id' => $ngo1->id]);

        $response = $this->actingAs($manager, 'sanctum')
            ->getJson("/api/manager/ngo/{$ngo2->id}/stats");

        $response->assertStatus(403);
    }

    public function test_admin_cannot_create_ngo_with_duplicate_email()
    {
        $admin = Admin::factory()->create();
        $existingNgo = NGO::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/ngos', [
                'name' => 'Test NGO',
                'address' => '123 Test Street',
                'phone' => '1234567890',
                'email' => $existingNgo->email,
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['email']);
    }

    public function test_admin_cannot_create_ngo_with_invalid_data()
    {
        $admin = Admin::factory()->create();

        $response = $this->actingAs($admin, 'sanctum')
            ->postJson('/api/admin/ngos', [
                'name' => '',
                'address' => '',
                'phone' => 'invalid-phone',
                'email' => 'invalid-email',
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['name', 'address', 'phone', 'email']);
    }

    public function test_unauthenticated_user_cannot_access_ngo_endpoints()
    {
        $response = $this->getJson('/api/admin/ngos');

        $response->assertStatus(401);
    }

    public function test_non_admin_cannot_create_ngo()
    {
        $manager = Manager::factory()->create();

        $response = $this->actingAs($manager, 'sanctum')
            ->postJson('/api/admin/ngos', [
                'name' => 'Test NGO',
                'address' => '123 Test Street',
                'phone' => '1234567890',
                'email' => 'test@ngo.com',
            ]);

        $response->assertStatus(403);
    }
}
