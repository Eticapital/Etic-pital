<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Investment extends Model
{
    const STATUS_NEW = 0;

    protected $fillable = [
        'amount',
        'name',
        'email',
        'phone',
        'residence',
        'organization',
    ];
}
