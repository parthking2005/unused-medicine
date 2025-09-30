<?php

namespace App\Models;

class Donation extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'pickup_date' => 'date',
        'collected_at' => 'datetime',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the donator who made this donation.
     */
    public function donator()
    {
        return $this->belongsTo(Donator::class);
    }

    /**
     * Get the NGO that received this donation.
     */
    public function ngo()
    {
        return $this->belongsTo(NGO::class);
    }

    /**
     * Get the pickupman assigned to this donation.
     */
    public function pickupman()
    {
        return $this->belongsTo(Pickupman::class);
    }

    /**
     * Get the verifier assigned to this donation.
     */
    public function verifier()
    {
        return $this->belongsTo(Verifier::class);
    }

    /**
     * Get the medicines included in this donation.
     */
    public function medicines()
    {
        return $this->belongsToMany(Medicine::class, 'donation_medicines')
            ->withPivot(['quantity', 'expiry_date'])
            ->withTimestamps();
    }

    /**
     * Get the feedback for this donation.
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class);
    }

    /**
     * Get the medicine expirations for this donation.
     */
    public function medicineExpirations()
    {
        return $this->hasMany(DonationMedicineExpiration::class);
    }

    /**
     * Scope a query to only include pending donations.
     */
    public function scopePending($query)
    {
        return $query->whereIn('status', ['pending', 'assigned']);
    }

    /**
     * Scope a query to only include collected donations.
     */
    public function scopeCollected($query)
    {
        return $query->where('status', 'collected');
    }

    /**
     * Scope a query to only include verified donations.
     */
    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    /**
     * Check if the donation is pending.
     */
    public function isPending()
    {
        return in_array($this->status, ['pending', 'assigned']);
    }

    /**
     * Check if the donation is collected.
     */
    public function isCollected()
    {
        return $this->status === 'collected';
    }

    /**
     * Check if the donation is verified.
     */
    public function isVerified()
    {
        return $this->status === 'verified';
    }
}
