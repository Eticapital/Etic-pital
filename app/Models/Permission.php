<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Laratrust\Models\LaratrustPermission;

class Permission extends LaratrustPermission
{
    // use Sluggable;

    // /**
    //  * Return the sluggable configuration array for this model.
    //  *
    //  * @return array
    //  */
    // public function sluggable()
    // {
    //     return ['name'];
    // }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }
}
