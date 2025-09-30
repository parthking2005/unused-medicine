<?php

namespace App\Models;

class Pickupman extends User
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    /**
     * Get the NGO that the pickupman belongs to.
     */
    public function ngo()
    {
        return $this->belongsTo(NGO::class);
    }

    /**
     * Get the donations assigned to this pickupman.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the active donations assigned to this pickupman.
     */
    public function activeDonations()
    {
        return $this->donations()->whereIn('status', ['pending', 'assigned']);
    }

    /**
     * Get the completed donations by this pickupman.
     */
    public function completedDonations()
    {
        return $this->donations()->where('status', 'collected');
    }
}
