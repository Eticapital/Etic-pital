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
        'image' => [
            'path' => 'projects/images/',
            'sizes' => ['854:480'], // https://support.google.com/youtube/answer/6375112?hl=en
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
}
