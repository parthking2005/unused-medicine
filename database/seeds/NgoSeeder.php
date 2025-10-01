<?php

use Illuminate\Database\Seeder;
use App\Ngo;

class NgoSeeder extends Seeder
{
    public function run()
    {
        $ngos = [
            [
                'name' => 'MedHelp Foundation',
                'address' => '123 Health Street, Andheri East',
                'city' => 'Mumbai',
                'state' => 'Maharashtra',
                'pincode' => '400069',
                'dpd' => 5
            ],
            [
                'name' => 'Care Medical Trust',
                'address' => '456 Care Road, Vastrapur',
                'city' => 'Ahmedabad',
                'state' => 'Gujarat',
                'pincode' => '380015',
                'dpd' => 3
            ],
            [
                'name' => 'Health For All',
                'address' => '789 Wellness Avenue, Koramangala',
                'city' => 'Bangalore',
                'state' => 'Karnataka',
                'pincode' => '560034',
                'dpd' => 4
            ]
        ];

        foreach ($ngos as $ngo) {
            Ngo::create($ngo);
        }
    }
}