<?php

namespace App;

use App\Models\Traits\HasPolicyAttributes;
use App\Models\Traits\LazyAppends;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Laravel\Scout\Searchable;

class User extends Authenticatable
{
    use Notifiable, LaratrustUserTrait, Searchable, HasPolicyAttributes, LazyAppends;

    use Authorizable {
        LaratrustUserTrait::can insteadof Authorizable;
        Authorizable::can as policyCan;
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appendable = [
        'can_update', 'can_destroy', 'can_show'
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return collect($this->toArray())
            ->only('id', 'name', 'email')
            ->toArray();
    }

    /**
     * Regresa solo el primer nombre
     *
     * @return string
     */
    public function getShortNameAttribute()
    {
        return collect(explode(' ', trim($this->name)))->first();
    }
}
