<?php

namespace App\Models;

class Verifier extends User
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
     * Get the NGO that the verifier belongs to.
     */
    public function ngo()
    {
        return $this->belongsTo(NGO::class);
    }

    /**
     * Get the donations assigned to this verifier.
     */
    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    /**
     * Get the feedback provided by this verifier.
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Get the pending donations assigned to this verifier.
     */
    public function pendingDonations()
    {
        return $this->donations()->where('status', 'collected');
    }

    /**
     * Get the verified donations by this verifier.
     */
    public function verifiedDonations()
    {
        return $this->donations()->where('status', 'verified');
    }
}
