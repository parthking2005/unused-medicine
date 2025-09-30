<?php

namespace App\Models;

class Feedback extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'rating' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the donation that this feedback is for.
     */
    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    /**
     * Get the verifier who provided this feedback.
     */
    public function verifier()
    {
        return $this->belongsTo(Verifier::class);
    }

    /**
     * Get the category of this feedback.
     */
    public function category()
    {
        return $this->belongsTo(FeedbackCategory::class, 'category_id');
    }

    /**
     * Get the donator who received this feedback.
     */
    public function donator()
    {
        return $this->hasOneThrough(Donator::class, Donation::class, 'id', 'id', 'donation_id', 'donator_id');
    }

    /**
     * Scope a query to only include positive feedback.
     */
    public function scopePositive($query)
    {
        return $query->where('rating', '>=', 4);
    }

    /**
     * Scope a query to only include negative feedback.
     */
    public function scopeNegative($query)
    {
        return $query->where('rating', '<=', 2);
    }

    /**
     * Scope a query to only include neutral feedback.
     */
    public function scopeNeutral($query)
    {
        return $query->where('rating', 3);
    }
}
