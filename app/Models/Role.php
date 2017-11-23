<?php

namespace App\Models;

use App\Models\Traits\HasPolicyAttributes;
use App\Models\Traits\UseDataTable;
use Cviebrock\EloquentSluggable\Sluggable;
use Laratrust\Models\LaratrustRole;
use Laravel\Scout\Searchable;

class Role extends LaratrustRole
{
    use UseDataTable, Searchable, HasPolicyAttributes, Sluggable;

    protected $appends = [
        'can_create',
        'can_view',
        'can_update',
        'can_delete',
        'can_permissions',
        'can_permissionsToggle',
        'can_users',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['display_name', 'description'];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return collect($this->toArray())
            ->only('id', 'display_name')
            ->toArray();
    }

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'name' => [
                'source' => 'display_name'
            ]
        ];
    }
}
