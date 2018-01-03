<?php

namespace App;

use App\Models\Project;
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
        'name',
        'email',
        'password',
        'phone',
        'residence',
        'organization',
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
        'can_update', 'can_destroy', 'can_show', 'roles_ids', 'roles_list'
    ];

    protected $appends = [
        'is_admin'
    ];

    protected $casts = [
        'is_published' => 'boolean'
    ];

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    /**
     * La información que se usa en los formularios
     * @return array
     */
    public function toFormArray()
    {
        return collect($this->toArray())
            ->only('id', 'name', 'email', 'phone', 'organization', 'residence');
    }

    /**
     * La información que se usará como variable globar
     * @return array
     */
    public function toPublicArray()
    {
        return collect($this->toArray())
            ->only('id', 'name', 'email', 'is_admin')
            ->toArray();
    }

    public function getIsAdminAttribute()
    {
        return $this->hasRole(['root', 'admin']);
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

    /**
     * Devuelve el mail como un link HTML
     *
     * @return string
     */
    public function getEmailLinkAttribute()
    {
        if (!$this->email) {
            return null;
        }
        return sprintf('<a href="mailto:%s">%s</a>', $this->email, $this->email);
    }

    /**
     * Un usuario tiene multiples proyectos
     * @return HasMany
     */
    public function projects()
    {
        return $this->hasMany(\App\Models\Project::class, 'owner_id');
    }

    /**
     * Un usuario tiene multiples promesas de inversión
     *
     * @return HasMany
     */
    public function investments()
    {
        return $this->hasMany(\App\Models\Investment::class, 'owner_id');
    }

    /**
     * Send the password reset notification.
     *
     * @param  string  $token
     * @return void
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new \App\Notifications\ResetPasswordNotification($token));
    }

    /**
     * Si ss invesionista del proyecto
     *
     * @param  Project $project
     * @return boolean
     */
    public function isInvestorOf(Project $project)
    {
        return $project->investments()->accepted()->where('owner_id', $this->id)->count() > 0;
    }

    /**
     * Regresa los id de los roles del usuario
     *
     * @return array
     */
    public function getRolesIdsAttribute()
    {
        return $this->roles()->pluck('id');
    }

    public function getRolesListAttribute()
    {
        return $this->roles()->pluck('display_name')->implode(', ');
    }
}
