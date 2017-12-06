<?php

namespace App\Models;

use App\Models\ProjectDocument;
use App\Models\Traits\HasImages;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasImages, Sluggable;

    protected $casts = [
        'links' => 'json',
        'holder_links' => 'json',
        'latitude' => 'float',
        'longitude' => 'float',
        'has_interested_investor' => 'boolean',
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

    public function getVideoTypeAttribute()
    {
        if (!$this->video) {
            return null;
        }

        $regex = '/(?:youtube\.com\/\S*(?:(?:\/e(?:mbed))?\/|watch\?(?:\S*?&?v\=))|youtu\.be\/)([a-zA-Z0-9_-]{6,11})/';
        if (preg_match($regex, $this->video)) {
            return 'youtube';
        }

        $regex = '/(http|https)?:\/\/(www\.)?vimeo.com\/(?:channels\/(?:\w+\/)?|groups\/([^\/]*)\/videos\/|)(\d+)(?:|\/\?)/';
        if (preg_match($regex, $this->video)) {
            return 'vimeo';
        }
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
        return $query->whereNotNull('published_at');
    }

    /**
     * Un proyecto tiene N miembros del equipo
     *
     * @return HasMany
     */
    public function team()
    {
        return $this->hasMany(\App\Models\ProjectTeam::class);
    }

    /**
     * Un proyecto tiene N miembros del equipo
     *
     * @return HasMany
     */
    public function kpis()
    {
        return $this->hasMany(\App\Models\ProjectKpi::class);
    }

    public function getHasLatitudeLongitudeAttribute()
    {
        return $this->latitude && $this->longitude;
    }


    /**
     * Devuelve el código html de embed de google
     *
     * @return string
     */
    public function map($width = '100%', $height = "200")
    {
        $latitude = $this->latitude;
        $longitude = $this->longitude;
        return <<<HTML
<iframe src = "https://maps.google.com/maps?q=$latitude,$longitude&hl=es;z=14&amp;output=embed" width="$width" height="$height" frameborder="0" style="border:0" allowfullscreen></iframe>
HTML;
    }

    /**
     * Un proyecto puede tener múltiples docuemtnos
     *
     * @return HasMany
     */
    public function documents()
    {
        return $this->hasMany(ProjectDocument::class);
    }

    public function toFormArray()
    {
        $array = $this->toArray();
        $array['kpis'] = $this->kpis()->get()->toArray();
        $array['sectors'] = $this->sectors()->pluck('id');
        $array['rewards'] = $this->rewards()->pluck('id');
        $array['team'] = $this->team()->get()->toArray();
        $array['company_documents'] = $this->documents()->company()->get()->toArray();
        $array['key_documents'] = $this->documents()->key()->get()->toArray();
        $array['extra_documents'] = $this->documents()->extra()->get()->toArray();
        return $array;
    }
}
