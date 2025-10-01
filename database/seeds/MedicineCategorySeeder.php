<?php

use Illuminate\Database\Seeder;
use App\MedicineCategory;

class MedicineCategorySeeder extends Seeder
{
    public function run()
    {
        $categories = [
            ['name' => 'Antibiotics'],
            ['name' => 'Pain Relievers'],
            ['name' => 'Antacids'],
            ['name' => 'Antivirals'],
            ['name' => 'Antidiabetics'],
            ['name' => 'Cardiovascular'],
            ['name' => 'Respiratory'],
            ['name' => 'Vitamins & Supplements']
        ];

        foreach ($categories as $category) {
            MedicineCategory::create($category);
        }
    }
}
