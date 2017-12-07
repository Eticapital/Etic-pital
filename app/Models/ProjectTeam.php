<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProjectTeam extends Model
{
    protected $casts = [
        'links' => 'json'
    ];

    protected $fillable = [
        'name',
        'links'
    ];
}
