<?php

namespace App\Models;

class MedicineStockExpiration extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'expiry_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the stock that this expiration record belongs to.
     */
    public function stock()
    {
        return $this->belongsTo(MedicineStock::class, 'medicine_stock_id');
    }

    /**
     * Scope a query to only include expired records.
     */
    public function scopeExpired($query)
    {
        return $query->where('expiry_date', '<=', now());
    }

    /**
     * Scope a query to only include non-expired records.
     */
    public function scopeValid($query)
    {
        return $query->where('expiry_date', '>', now());
    }
}
