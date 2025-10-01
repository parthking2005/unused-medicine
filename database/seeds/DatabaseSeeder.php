<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            AdminSeeder::class,
            NgoSeeder::class,
            MedicineCategorySeeder::class,
            MedicineSeeder::class,
            DonatorSeeder::class,
            ManagerSeeder::class,
            PickupmanSeeder::class,
            VerifierSeeder::class,
            DonationSeeder::class,
        ]);
    }
}