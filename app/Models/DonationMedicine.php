<?php

namespace App\Models;

class DonationMedicine extends Model
{
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'quantity' => 'integer',
        'expiry_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Get the donation that this medicine belongs to.
     */
    public function donation()
    {
        return $this->belongsTo(Donation::class);
    }

    /**
     * Get the medicine that was donated.
     */
    public function medicine()
    {
        return $this->belongsTo(Medicine::class);
    }

    /**
     * Get the expiration records for this donated medicine.
     */
    public function expirations()
    {
        return $this->hasMany(DonationMedicineExpiration::class);
    }
}
