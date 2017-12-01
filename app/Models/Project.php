<?php

namespace App\Models;

use App\Models\Traits\HasImages;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasImages, Sluggable;

    protected $casts = [
        'links' => 'json',
        'holder_links' => 'json'
    ];

    public static $images = [
        'photo' => [
            'path' => 'projects/images/',
            'sizes' => ['854:480', '380:280'], // https://support.google.com/youtube/answer/6375112?hl=en
            'default_path' => 'img/projects/images/',
            'default_name' => 'default.png',
        ],
    ];

    protected $dates = ['published_at'];

    /**
     * Return the sluggable configuration array for this model.
     *
     * @return array
     */
    public function sluggable()
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'slug';
    }

    /**
     * El link de la vista del proyecto
     *
     * @return string
     */
    public function getLinkAttribute()
    {
        return route('projects.show', $this->slug);
    }

    /**
     * El nombre del sector
     *
     * @return string
     */
    public function getSectorAttribute()
    {
        $count = $this->sectors()->count();
        $label = optional($this->sectors()->first())->label;

        if ($count > 1) {
            return $label . ' y ' . ($count-1) . ' más';
        }

        return $label;
    }

    /**
     * Todos los sectores separados por coma
     *
     * @return string
     */
    public function getSectorsAttribute()
    {
        return $this->sectors()->get()->pluck('label')->implode(', ');
    }

    public function getShortDescriptionAttribute()
    {
        return str_limit($this->description, 155);
    }

    /**
     * Devuelve el avance del proyecto
     *
     * @return integer
     */
    public function getCollectedAttribute()
    {
        // @TODO
        return 0;
    }

    /**
     * Devuelve la meta del proyecto
     *
     * @return integer
     */
    public function getGoalAttribute()
    {
        return $this->minimal_needed;
    }

    public function owner()
    {
        return $this->belongsTo(\App\User::class, 'owner_id');
    }

    /**
     * Un proyecto tiene muchos Sectores
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function sectors()
    {
        return $this->belongsToMany(\App\Models\Sector::class);
    }

    /**
     * Un proyecto tiene muchos recompensas
     *
     * @return Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function rewards()
    {
        return $this->belongsToMany(\App\Models\Reward::class);
    }

    /**
     * Primero muestra los marcado con la bandera "is_featured"
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeFeaturedFirst($query)
    {
        return $query->orderBy('is_featured', 'desc');
    }

    /**
     * Filtra para solo mostrar los publicados
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopePublished($query)
    {
        return $query->whereRaw('published_at >= NOW()');
    }
}
