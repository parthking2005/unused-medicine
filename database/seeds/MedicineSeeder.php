<?php

use Illuminate\Database\Seeder;
use App\Medicine;

class MedicineSeeder extends Seeder
{
    public function run()
    {
        $medicines = [
            // Antibiotics
            [
                'category_id' => 1,
                'name' => 'Amoxicillin',
                'brand' => 'Amoxil'
            ],
            [
                'category_id' => 1,
                'name' => 'Azithromycin',
                'brand' => 'Zithromax'
            ],
            // Pain Relievers
            [
                'category_id' => 2,
                'name' => 'Paracetamol',
                'brand' => 'Crocin'
            ],
            [
                'category_id' => 2,
                'name' => 'Ibuprofen',
                'brand' => 'Brufen'
            ],
            // Antacids
            [
                'category_id' => 3,
                'name' => 'Pantoprazole',
                'brand' => 'Pan-D'
            ],
            [
                'category_id' => 3,
                'name' => 'Ranitidine',
                'brand' => 'Rantac'
            ],
            // Antivirals
            [
                'category_id' => 4,
                'name' => 'Acyclovir',
                'brand' => 'Zovirax'
            ],
            // Antidiabetics
            [
                'category_id' => 5,
                'name' => 'Metformin',
                'brand' => 'Glucophage'
            ],
            // Cardiovascular
            [
                'category_id' => 6,
                'name' => 'Amlodipine',
                'brand' => 'Amlong'
            ],
            // Respiratory
            [
                'category_id' => 7,
                'name' => 'Salbutamol',
                'brand' => 'Asthalin'
            ],
            // Vitamins
            [
                'category_id' => 8,
                'name' => 'Vitamin B Complex',
                'brand' => 'Becosules'
            ],
            [
                'category_id' => 8,
                'name' => 'Vitamin C',
                'brand' => 'Celin'
            ]
        ];

        foreach ($medicines as $medicine) {
            Medicine::create($medicine);
        }
    }
}
