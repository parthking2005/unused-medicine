<?php

namespace App\Models;

class Medicine extends Model
{
    /**
     * Get the category that this medicine belongs to.
     */
    public function category()
    {
        return $this->belongsTo(MedicineCategory::class, 'medicine_category_id');
    }

    /**
     * Get the stocks of this medicine across all NGOs.
     */
    public function stocks()
    {
        return $this->hasMany(MedicineStock::class);
    }

    /**
     * Get the donations that include this medicine.
     */
    public function donations()
    {
        return $this->belongsToMany(Donation::class, 'donation_medicines')
            ->withPivot(['quantity', 'expiry_date'])
            ->withTimestamps();
    }

    /**
     * Get the total stock quantity of this medicine across all NGOs.
     */
    public function getTotalStockAttribute()
    {
        return $this->stocks()->sum('quantity');
    }

    /**
     * Get the stock quantity of this medicine for a specific NGO.
     */
    public function getStockForNgo($ngoId)
    {
        return $this->stocks()->where('ngo_id', $ngoId)->sum('quantity');
    }
}
