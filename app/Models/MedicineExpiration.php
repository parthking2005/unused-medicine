<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MedicineExpiration extends Model
{
    protected $fillable = [
        'medicine_stock_id',
        'quantity',
        'expiry_date',
        'status',
        'disposal_notes',
        'disposed_at'
    ];

    protected $casts = [
        'expiry_date' => 'date',
        'disposed_at' => 'datetime'
    ];

    public function medicineStock()
    {
        return $this->belongsTo(MedicineStock::class);
    }

    public function scopeExpiringSoon($query, $days = 30)
    {
        return $query->where('status', 'active')
                    ->whereDate('expiry_date', '<=', now()->addDays($days))
                    ->whereDate('expiry_date', '>', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'active')
                    ->whereDate('expiry_date', '<=', now());
    }

    public function markAsExpired()
    {
        $this->status = 'expired';
        $this->save();
    }

    public function dispose($notes = null)
    {
        $this->status = 'disposed';
        $this->disposal_notes = $notes;
        $this->disposed_at = now();
        $this->save();

        // Update medicine stock quantity
        $this->medicineStock->decrement('quantity', $this->quantity);
    }
}
