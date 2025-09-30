<?php

namespace App\Models;

class MedicineCategory extends Model
{
    /**
     * Get the medicines in this category.
     */
    public function medicines()
    {
        return $this->hasMany(Medicine::class);
    }

    /**
     * Get the total stock quantity of all medicines in this category.
     */
    public function getTotalStockAttribute()
    {
        return $this->medicines()->with('stocks')->get()
            ->sum(function ($medicine) {
                return $medicine->total_stock;
            });
    }

    /**
     * Get the stock quantity of all medicines in this category for a specific NGO.
     */
    public function getStockForNgo($ngoId)
    {
        return $this->medicines()->with(['stocks' => function ($query) use ($ngoId) {
            $query->where('ngo_id', $ngoId);
        }])->get()->sum(function ($medicine) {
            return $medicine->stocks->sum('quantity');
        });
    }
}
