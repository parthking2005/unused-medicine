<?php

use Illuminate\Database\Seeder;
use App\Donator;
use Illuminate\Support\Facades\Hash;

class DonatorSeeder extends Seeder
{
    public function run()
    {
        $donators = [
            [
                'name' => 'Ravi Donator',
                'email' => 'donator1@medcharity.com',
                'password' => Hash::make('donator123'),
                'contact' => '9876543219',
                'gender' => 'Male',
                'address' => '123 Donor Street, Andheri',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'pincode' => '400069',
                'profileimage' => 'default.jpg',
                'bfcount' => 0,
                'blocked' => false
            ],
            [
                'name' => 'Sneha Donator',
                'email' => 'donator2@medcharity.com',
                'password' => Hash::make('donator123'),
                'contact' => '9876543220',
                'gender' => 'Female',
                'address' => '456 Donor Road, Vastrapur',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380015',
                'profileimage' => 'default.jpg',
                'bfcount' => 0,
                'blocked' => false
            ],
            [
                'name' => 'Kiran Donator',
                'email' => 'donator3@medcharity.com',
                'password' => Hash::make('donator123'),
                'contact' => '9876543221',
                'gender' => 'Male',
                'address' => '789 Donor Avenue, Koramangala',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'pincode' => '560034',
                'profileimage' => 'default.jpg',
                'bfcount' => 0,
                'blocked' => false
            ]
        ];

        foreach ($donators as $donator) {
            Donator::create($donator);
        }
    }
}
