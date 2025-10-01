<?php

use Illuminate\Database\Seeder;
use App\Verifier;
use Illuminate\Support\Facades\Hash;

class VerifierSeeder extends Seeder
{
    public function run()
    {
        $verifiers = [
            [
                'name' => 'Dr. Amit Verifier',
                'email' => 'verifier1@medcharity.com',
                'password' => Hash::make('verifier123'),
                'ngo_id' => 1,
                'contact' => '9876543216',
                'gender' => 'Male',
                'profileimage' => 'default.jpg'
            ],
            [
                'name' => 'Dr. Neha Verifier',
                'email' => 'verifier2@medcharity.com',
                'password' => Hash::make('verifier123'),
                'ngo_id' => 2,
                'contact' => '9876543217',
                'gender' => 'Female',
                'profileimage' => 'default.jpg'
            ],
            [
                'name' => 'Dr. Suresh Verifier',
                'email' => 'verifier3@medcharity.com',
                'password' => Hash::make('verifier123'),
                'ngo_id' => 3,
                'contact' => '9876543218',
                'gender' => 'Male',
                'profileimage' => 'default.jpg'
            ]
        ];

        foreach ($verifiers as $verifier) {
            Verifier::create($verifier);
        }
    }
}
