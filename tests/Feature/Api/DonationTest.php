<?php

namespace Tests\Feature\Api;

use App\Donator;
use App\NGO;
use App\Medicine;
use App\Donation;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DonationTest extends TestCase
{
    use RefreshDatabase;

    public function test_donator_can_create_donation()
    {
        $donator = Donator::factory()->create();
        $ngo = NGO::factory()->create();
        $medicine = Medicine::factory()->create();

        $response = $this->actingAs($donator, 'sanctum')
            ->postJson('/api/donator/donations', [
                'ngo_id' => $ngo->id,
                'pickup_date' => now()->addDays(2)->format('Y-m-d'),
                'pickup_address' => '123 Test Street',
                'medicines' => [
                    [
                        'medicine_id' => $medicine->id,
                        'quantity' => 5,
                        'expiry_date' => now()->addMonths(6)->format('Y-m-d'),
                    ],
                ],
            ]);

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    'id',
                    'donator_id',
                    'ngo_id',
                    'pickup_date',
                    'pickup_address',
                    'status',
                    'medicines',
                ],
                'message',
            ]);

        $this->assertDatabaseHas('donations', [
            'donator_id' => $donator->id,
            'ngo_id' => $ngo->id,
            'status' => 'pending',
        ]);
    }

    public function test_donator_can_view_their_donations()
    {
        $donator = Donator::factory()->create();
        $donations = Donation::factory()->count(3)->create([
            'donator_id' => $donator->id,
        ]);

        $response = $this->actingAs($donator, 'sanctum')
            ->getJson('/api/donator/donations');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data' => [
                    '*' => [
                        'id',
                        'donator_id',
                        'ngo_id',
                        'pickup_date',
                        'status',
                    ],
                ],
            ]);
    }

    public function test_donator_can_view_donation_feedback()
    {
        $donator = Donator::factory()->create();
        $donation = Donation::factory()->create([
            'donator_id' => $donator->id,
        ]);

        $response = $this->actingAs($donator, 'sanctum')
            ->getJson('/api/donator/feedback');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ]);
    }

    public function test_donator_cannot_create_donation_with_invalid_data()
    {
        $donator = Donator::factory()->create();

        $response = $this->actingAs($donator, 'sanctum')
            ->postJson('/api/donator/donations', [
                'ngo_id' => 999, // Non-existent NGO
                'pickup_date' => now()->subDays(1)->format('Y-m-d'), // Past date
                'pickup_address' => '',
                'medicines' => [],
            ]);

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['ngo_id', 'pickup_date', 'pickup_address', 'medicines']);
    }

    public function test_donator_cannot_view_other_donators_donations()
    {
        $donator1 = Donator::factory()->create();
        $donator2 = Donator::factory()->create();
        $donation = Donation::factory()->create([
            'donator_id' => $donator2->id,
        ]);

        $response = $this->actingAs($donator1, 'sanctum')
            ->getJson('/api/donator/donations');

        $response->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'data',
            ]);

        $this->assertEmpty($response->json('data'));
    }

    public function test_unauthenticated_user_cannot_access_donation_endpoints()
    {
        $response = $this->getJson('/api/donator/donations');

        $response->assertStatus(401);
    }
}
