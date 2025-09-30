<?php

namespace App\Models;

class DonationMedicineExpiration extends Model
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
     * Get the donation medicine that this expiration belongs to.
     */
    public function donationMedicine()
    {
        return $this->belongsTo(DonationMedicine::class);
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
