<?php

use Illuminate\Database\Seeder;
use App\Pickupman;
use Illuminate\Support\Facades\Hash;

class PickupmanSeeder extends Seeder
{
    public function run()
    {
        $pickupmen = [
            [
                'name' => 'Rahul Pickup',
                'email' => 'pickup1@medcharity.com',
                'password' => Hash::make('pickup123'),
                'ngo_id' => 1,
                'contact' => '9876543213',
                'gender' => 'Male',
                'profileimage' => 'default.jpg',
                'available' => true
            ],
            [
                'name' => 'Sanjay Pickup',
                'email' => 'pickup2@medcharity.com',
                'password' => Hash::make('pickup123'),
                'ngo_id' => 2,
                'contact' => '9876543214',
                'gender' => 'Male',
                'profileimage' => 'default.jpg',
                'available' => true
            ],
            [
                'name' => 'Meera Pickup',
                'email' => 'pickup3@medcharity.com',
                'password' => Hash::make('pickup123'),
                'ngo_id' => 3,
                'contact' => '9876543215',
                'gender' => 'Female',
                'profileimage' => 'default.jpg',
                'available' => true
            ]
        ];

        foreach ($pickupmen as $pickupman) {
            Pickupman::create($pickupman);
        }
    }
}
