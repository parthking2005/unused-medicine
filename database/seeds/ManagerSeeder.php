<?php

use Illuminate\Database\Seeder;
use App\Manager;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run()
    {
        $managers = [
            [
                'name' => 'Raj Manager',
                'email' => 'manager1@medcharity.com',
                'password' => Hash::make('manager123'),
                'ngo_id' => 1,
                'contact' => '9876543210',
                'gender' => 'Male',
                'profileimage' => 'default.jpg'
            ],
            [
                'name' => 'Priya Manager',
                'email' => 'manager2@medcharity.com',
                'password' => Hash::make('manager123'),
                'ngo_id' => 2,
                'contact' => '9876543211',
                'gender' => 'Female',
                'profileimage' => 'default.jpg'
            ],
            [
                'name' => 'Arun Manager',
                'email' => 'manager3@medcharity.com',
                'password' => Hash::make('manager123'),
                'ngo_id' => 3,
                'contact' => '9876543212',
                'gender' => 'Male',
                'profileimage' => 'default.jpg'
            ]
        ];

        foreach ($managers as $manager) {
            Manager::create($manager);
        }
    }
}
