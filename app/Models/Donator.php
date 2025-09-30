<?php

namespace App\Models;

class Donator extends User
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_blocked' => 'boolean',
    ];

    /**
     * Get all donations made by this donator.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the feedback received for this donator's donations.
     */
    public function feedback()
    {
        return $this->hasManyThrough(Feedback::class, Donation::class);
    }

    /**
     * Get the pending donations by this donator.
     */
    public function pendingDonations()
    {
        return $this->donations()->whereIn('status', ['pending', 'assigned']);
    }

    /**
     * Get the completed donations by this donator.
     */
    public function completedDonations()
    {
        return $this->donations()->where('status', 'verified');
    }

    /**
     * Get the NGOs this donator has donated to.
     */
    public function ngos()
    {
        return $this->belongsToMany(NGO::class, 'donations')
            ->withTimestamps()
            ->distinct();
    }
}
