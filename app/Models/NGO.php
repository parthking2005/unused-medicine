<?php

namespace App\Models;

class NGO extends Model
{
    /**
     * Get the manager of this NGO.
     */
    public function manager()
    {
        return $this->hasOne(Manager::class);
    }

    /**
     * Get the pickupmen of this NGO.
     */
    public function pickupmen()
    {
        return $this->hasMany(Pickupman::class);
    }

    /**
     * Get the verifiers of this NGO.
     */
    public function verifiers()
    {
        return $this->hasMany(Verifier::class);
    }

    /**
     * Get the medicine stocks of this NGO.
     */
    public function medicineStocks()
    {
        return $this->hasMany(MedicineStock::class);
    }

    /**
     * Get the donations received by this NGO.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the active pickupmen of this NGO.
     */
    public function activePickupmen()
    {
        return $this->pickupmen()->where('is_active', true);
    }

    /**
     * Get the pending donations for this NGO.
     */
    public function pendingDonations()
    {
        return $this->donations()->whereIn('status', ['pending', 'assigned']);
    }

    /**
     * Get the verified donations for this NGO.
     */
    public function verifiedDonations()
    {
        return $this->donations()->where('status', 'verified');
    }

    /**
     * Get the donators who have donated to this NGO.
     */
    public function donators()
    {
        return $this->belongsToMany(Donator::class, 'donations')
            ->withTimestamps()
            ->distinct();
    }
}
