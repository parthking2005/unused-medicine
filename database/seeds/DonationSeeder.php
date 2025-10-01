<?php

use Illuminate\Database\Seeder;
use App\Donation;
use Carbon\Carbon;

class DonationSeeder extends Seeder
{
    public function run()
    {
        $donations = [
            [
                'donator_id' => 1,
                'ngo_id' => 1,
                'pickupman_id' => 1,
                'verifier_id' => 1,
                'date' => Carbon::now()->subDays(1),
                'status' => 'Completed'
            ],
            [
                'donator_id' => 2,
                'ngo_id' => 2,
                'pickupman_id' => 2,
                'verifier_id' => 2,
                'date' => Carbon::now(),
                'status' => 'Pending'
            ],
            [
                'donator_id' => 3,
                'ngo_id' => 3,
                'pickupman_id' => 3,
                'verifier_id' => 3,
                'date' => Carbon::now()->addDays(1),
                'status' => 'Scheduled'
            ],
            [
                'donator_id' => 1,
                'ngo_id' => 2,
                'pickupman_id' => 2,
                'verifier_id' => 2,
                'date' => Carbon::now()->subDays(2),
                'status' => 'Completed'
            ],
            [
                'donator_id' => 2,
                'ngo_id' => 3,
                'pickupman_id' => 3,
                'verifier_id' => 3,
                'date' => Carbon::now()->subDays(3),
                'status' => 'Completed'
            ]
        ];

        foreach ($donations as $donation) {
            Donation::create($donation);
        }
    }
}
