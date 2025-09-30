<?php

namespace App\Models;

class MedicineStock extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the NGO that owns this stock.
     */
    public function ngo()
    {
        return $this->belongsTo(NGO::class);
    }

    /**
     * Get the medicine that this stock is for.
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    /**
     * Get the expiration records for this stock.
     */
    public function expirations()
    {
        return $this->hasMany(MedicineStockExpiration::class);
    }

    /**
     * Get the non-expired quantity of this stock.
     */
    public function getValidQuantityAttribute()
    {
        return $this->expirations()
            ->where('expiry_date', '>', now())
            ->sum('quantity');
    }

    /**
     * Get the expired quantity of this stock.
     */
    public function getExpiredQuantityAttribute()
    {
        return $this->expirations()
            ->where('expiry_date', '<=', now())
            ->sum('quantity');
    }

    /**
     * Add stock with expiration date.
     */
    public function addStock($quantity, $expiryDate)
    {
        $this->increment('quantity', $quantity);
        
        return $this->expirations()->create([
            'quantity' => $quantity,
            'expiry_date' => $expiryDate,
        ]);
    }

    /**
     * Remove stock with specific expiration date.
     */
    public function removeStock($quantity, $expiryDate)
    {
        $expiration = $this->expirations()
            ->where('expiry_date', $expiryDate)
            ->where('quantity', '>=', $quantity)
            ->first();

        if ($expiration) {
            $expiration->decrement('quantity', $quantity);
            $this->decrement('quantity', $quantity);
            return true;
        }

        return false;
    }
}
