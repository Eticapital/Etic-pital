<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    const STATUS_NEW = 0;
    const STATUS_ACCEPTED = 1;

    protected $fillable = [
        'amount',
        'name',
        'email',
        'phone',
        'residence',
        'organization',
    ];

    public function scopeAccepted($query)
    {
        return $query->whereInvestmentStatus(self::STATUS_ACCEPTED);
    }
}
