<?php

namespace App\Models;

class FeedbackCategory extends Model
{
    /**
     * Get the feedback in this category.
     */
    public function feedback()
    {
        return $this->hasMany(Feedback::class, 'category_id');
    }

    /**
     * Get the average rating for feedback in this category.
     */
    public function getAverageRatingAttribute()
    {
        return $this->feedback()->avg('rating');
    }

    /**
     * Get the count of positive feedback in this category.
     */
    public function getPositiveCountAttribute()
    {
        return $this->feedback()->where('rating', '>=', 4)->count();
    }

    /**
     * Get the count of negative feedback in this category.
     */
    public function getNegativeCountAttribute()
    {
        return $this->feedback()->where('rating', '<=', 2)->count();
    }

    /**
     * Get the count of neutral feedback in this category.
     */
    public function getNeutralCountAttribute()
    {
        return $this->feedback()->where('rating', 3)->count();
    }
}
