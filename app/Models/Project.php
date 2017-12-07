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

    protected $fillable = [
        'name',
        'holder',
        'phone',
        'email',
        'holder_links',
        'photo',
        'video',
        'latitude',
        'longitude',
        'address',
        // 2.
        'description',
        // 3.
        'opportunity',
        // 4.
        'competition',
        // 5.
        // 'company_documents',
        // // 6.
        'links',
        // 7.
        //✓'sectors',
        // 8.
        'stage_id',
        // 9.
        'business_model',
        // 10.
        'previous_capital',
        'total_sales',
        'round_size',
        'minimal_needed',
        'has_interested_investor',
        'interested_investor_name',
        'expected_sales_year_1',
        'expected_sales_year_2',
        'expected_sales_year_3',
        //✓'rewards',
        // 11.
        //✓'team',
        // 12.
        //✓ 'kpis',
        // // 13.
        // 'key_documents',
        // // 14.
        // 'extra_documents',
    ];

    protected $appends = ['link'];

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
     * Define los sectores. debería recibir un arreglo de ids
     *
     * @param  $sectors array
     *
     */
    public function setSectorsAttribute($sectors)
    {
        $this->sectors()->sync($sectors);
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
     * Define los rewards. debería recibir un arreglo de ids
     *
     * @param  array $rewards
     *
     */
    public function setRewardsAttribute($rewards)
    {
        $this->rewards()->sync($rewards);
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
     * Recibe un arreglo de miembros del equipo y los agrega/actuliza segun aplique
     * @param array $kpis
     */
    public function setTeamAttribute($team)
    {
        $ids = collect($team)->map(function ($member) {
            return $this->team()->updateOrCreate(['id' => $member['id']], $member);
        })->pluck('id');

        // Los KPIs que no vinieron en la lista se eliminan
        $this->team()->whereNotIn('id', $ids)->delete();
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

    /**
     * Recibe un arreglo de kpis y los agrega/actuliza segun aplique
     * @param array $kpis
     */
    public function setKpisAttribute($kpis)
    {
        $ids = collect($kpis)->map(function ($kpi) {
            return $this->kpis()->updateOrCreate(['id' => $kpi['id']], $kpi);
        })->pluck('id');

        // Los KPIs que no vinieron en la lista se eliminan
        $this->kpis()->whereNotIn('id', $ids)->delete();
    }

    /**
     * Si tiene latitud y longitud
     *
     * @return boolean
     */
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

    public function setDocuments($documents, $category)
    {
        $ids = collect($documents)
            ->filter(function ($document) {
                return $document['tmp_name'];
            })->map(function ($document) use ($category) {
                return [
                    'category' => $category,
                    'file_name' => $document['tmp_name'],
                    'is_new' => 1,
                    'file' => $document['name'],
                    'id' => $document['id']
                ];
            })->map(function ($file) {
                $document = new ProjectDocument;
                $document->project_id = $this->id;
                $document->file = $file;
                $document->save();
                return $document->id;
            })->pluck('id');

        // Los documents que no vinieron en la lista se eliminan
        $this->documents()
            ->where('category', $category)
            ->whereNotIn('id', $ids)
            ->delete();
    }

    /**
     * Recibe un arreglo con infomración sobre los documetnos y crea o actualiza segun
     * sea el caso
     *
     * @param array $documents
     */
    public function setKeyDocumentsAttribute($documents)
    {
        $this->setDocuments($documents, ProjectDocument::CATEGORY_KEY);
    }

    /**
     * Recibe un arreglo con infomración sobre los documetnos y crea o actualiza segun
     * sea el caso
     *
     * @param array $documents
     */
    public function setExtraDocumentsAttribute($documents)
    {
        $this->setDocuments($documents, ProjectDocument::CATEGORY_EXTRA);
    }

    /**
     * Recibe un arreglo con infomración sobre los documetnos y crea o actualiza segun
     * sea el caso
     *
     * @param array $documents
     */
    public function setCompanyDocumentsAttribute($documents)
    {
        $this->setDocuments($documents, ProjectDocument::CATEGORY_COMPANY);
    }

    /**
     * Arreglo que recibe el formualrio de nuevo proyecto
     *
     * @return array
     */
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
