<?php

namespace App\Models;

class Manager extends User
{
    /**
     * Get the NGO that the manager belongs to.
     */
    public function ngo()
    {
        return $this->belongsTo(NGO::class);
    }

    /**
     * Get the pickupmen that belong to this manager's NGO.
     */
    public function pickupmen()
    {
        return $this->hasMany(Pickupman::class, 'ngo_id', 'ngo_id');
    }

    /**
     * Get the verifiers that belong to this manager's NGO.
     */
    public function verifiers()
    {
        return $this->hasMany(Verifier::class, 'ngo_id', 'ngo_id');
    }

    /**
     * Get the medicine stocks that belong to this manager's NGO.
     */
    public function medicineStocks()
    {
        return $this->hasMany(MedicineStock::class, 'ngo_id', 'ngo_id');
    }

    /**
     * Get the donations that belong to this manager's NGO.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class, 'ngo_id', 'ngo_id');
    }
}
