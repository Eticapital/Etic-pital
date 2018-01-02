<?php

namespace App\Models;

use App\Models\ProjectDocument;
use App\Models\Traits\HasImages;
use App\Models\Traits\HasPolicyAttributes;
use App\Models\Traits\LazyAppends;
use Carbon\Carbon;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;
use Laravel\Scout\Searchable;

class Project extends Model
{
    use HasImages, Sluggable, Searchable, LazyAppends, SoftDeletes;

    use HasImages, HasPolicyAttributes {
        HasPolicyAttributes::getAttribute insteadof HasImages;
        HasPolicyAttributes::mutateAttribute insteadof HasImages;
    }

    protected $casts = [
        'links' => 'json',
        'holder_links' => 'json',
        'latitude' => 'float',
        'longitude' => 'float',
        'has_interested_investor' => 'boolean',
    ];

    protected $appends = [
        'link',
        'photo_url',
        'status'
    ];

    protected $appendable = [
        'can_update',
        'can_destroy',
        'can_show',
        'can_publish',
        'can_reject',
        'can_finish',
        'owner_name',
        'email_link',
        'photo_380_url',
        'photo_854_url',
        'map',
        'sectors_list',
        'sectors',
        'stage_label',
        'stage_description',
        'rewards',
        'rewards_list',
        'team',
        'kpis',
        'key_documents',
        'company_documents',
        'extra_documents',
        'status',
        'is_pending',
        'is_published',
        'is_rejected',
    ];

    public static $images = [
        'photo' => [
            'path' => 'projects/images/',
            'sizes' => ['854:480', '380:280'], // https://support.google.com/youtube/answer/6375112?hl=en
            'default_path' => 'img/projects/images/',
            'default_name' => 'default.png',
        ],
    ];

    protected $dates = ['published_at', 'rejected_at', 'deleted_at'];

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


    /**
     * Para evitar collisions entre traits HasImages y HasPolicyAttributes
     *
     * @param $key
     * @return mixec
     */
    public function getAttribute($key)
    {
        $result = $this->getImageAttribute($key);
        if ($result !== null) {
            return $result;
        }

        $result = $this->callGateAttribute($key);
        if ($result !== null) {
            return $result;
        }

        return parent::getAttribute($key);
    }

     /**
     * Para evitar collisions entre traits HasImages y HasPolicyAttributes
     *
     * @param $key
     * @param $value
     * @return mixec
     */
    protected function mutateAttribute($key, $value)
    {
        $result = $this->getImageAttribute($key);
        if ($result !== null) {
            return $result;
        }

        $result = $this->callGateAttribute($key);
        if ($result !== null) {
            return $result;
        }

        return parent::mutateAttribute($key, $value);
    }

    /**
     * Get the indexable data array for the model.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        return [
            'name' => $this->name,
            'holder' => $this->holder,
            'owner' => $this->owner->name,
            'owner_email' => $this->owner->email,
        ];
    }

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
     * El link como un enlace html
     *
     * @return strin
     */
    public function getEmailLinkAttribute()
    {
        if (!$this->email) {
            return null;
        }

        return sprintf('<a href="mailto:%s">%s</a>', $this->email, $this->email);
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
        return $this->sectors()->get()->pluck('id');
    }

    /**
     * Los sectores separados por coma
     * @return array
     */
    public function getSectorsNamesAttribute()
    {
        return $this->sectors_list->implode(', ');
    }

    /**
     * Los nombres de los sectores como lista
     * @return array
     */
    public function getSectorsListAttribute()
    {
        return $this->sectors()->get()->pluck('label');
    }

    /**
     * Descripción de máximo 155 caracaters
     *
     * @return string
     */
    public function getShortDescriptionAttribute()
    {
        return str_limit($this->description, 155);
    }

    /**
     * Devuelve el avance del proyecto como atributo
     *
     * @return integer
     */
    public function getCollectedAttribute()
    {
        return $this->collected();
    }

    /**
     * Devuelve el avance del proyecto
     *
     * @return integer
     */
    public function collected()
    {
        return $this->investments()->accepted()->sum('amount');
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

    /**
     * El nombre del dueño del proyecto
     *
     * @return string
     */
    public function getOwnerNameAttribute()
    {
        return optional($this->owner)->name;
    }

    /**
     * El dueño del proyecto
     *
     * @return Builder
     */
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
     * Devuelve un arreglo con los nombres de las recompensas
     *
     * @return array
     */
    public function getRewardsAttribute()
    {
        return $this->rewards()->pluck('id');
    }

    /**
     * Devuelve un arreglo con los nombres de las recompensas
     *
     * @return array
     */
    public function getRewardsListAttribute()
    {
        return $this->rewards()->get()->pluck('label');
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
        return $query->whereNotNull('published_at')->whereNull('finished_at')->whereNull('rejected_at');
    }

    /**
     * Filtra para solo mostrar los no publicados
     *
     * @param  Illuminate\Database\Eloquent\Builder $query
     * @return Illuminate\Database\Eloquent\Builder
     */
    public function scopeUnpublished($query)
    {
        return $query->whereNull('published_at');
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
     * Devuelve la lista de integrantes del equipo como un atributo
     *
     * @return array
     */
    public function getTeamAttribute()
    {
        return $this->team()->get();
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
     * Devuelve los kpis como un atributo
     *
     * @return array
     */
    public function getKpisAttribute()
    {
        return $this->kpis()->get();
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
     * Permite llamar el mapa como atributo
     *
     * @return string
     */
    public function getMapAttribute()
    {
        return $this->map();
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
            })->map(function ($document) {
                return [
                    'file_name' => $document['tmp_name'],
                    'is_new' => 1,
                    'file' => $document['name'],
                    'id' => $document['id']
                ];
            })->map(function ($file) use ($category) {
                $document = new ProjectDocument;
                $document->project_id = $this->id;
                $document->file = $file;
                $document->category = $category;
                $document->save();
                return $document->id;
            });

        $existing_ids = collect($documents)
            ->filter(function ($document) {
                return !@$document['tmp_name'] && !@$document['deleted'];
            })->pluck('id');

        $ids = $ids->merge($existing_ids);

        // Los documents que no vinieron en la lista se eliminan
        $this->documents()
            ->where('category', $category)
            ->whereNotIn('id', $ids)
            ->delete();
    }

    /**
     * La etapa a a que pertenece
     *
     * @return BelongsTo
     */
    public function stage()
    {
        return $this->belongsTo(\App\Models\ProjectStage::class);
    }

    /**
     * El nombre de la etapa a la que pertenece la oportunidad
     *
     * @return string
     */
    public function getStageLabelAttribute()
    {
        return optional($this->stage)->label;
    }

    /**
     * La descripción de la etapa a la que pertenece la oportunidad
     *
     * @return string
     */
    public function getStageDescriptionAttribute()
    {
        return optional($this->stage)->description;
    }

    /**
     * Devuelve la lista de documentos como un atributo
     *
     * @return array
     */
    public function getKeyDocumentsAttribute()
    {
        return $this->documents()->key()->get();
    }

    /**
     * Devuelve la lista de documentos como un atributo
     *
     * @return array
     */
    public function getCompanyDocumentsAttribute()
    {
        return $this->documents()->company()->get();
    }

    /**
     * Devuelve la lista de documentos como un atributo
     *
     * @return array
     */
    public function getExtraDocumentsAttribute()
    {
        return $this->documents()->extra()->get();
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

    /**
     * Devuevle el nombre del status
     * @return [type] [description]
     */
    public function getStatusAttribute()
    {
        if ($this->is_rejected) {
            return 'Rechazado';
        }

        if ($this->is_pending) {
            return 'En revisión';
        }

        if ($this->is_published) {
            return 'Publicado';
        }

        if ($this->is_finished) {
            return 'Finalizado';
        }

        return 'Sin definir';
    }

    /**
     * Si el proyecto está reachado
     *
     * @return boolena
     */
    public function getIsRejectedAttribute()
    {
        return $this->rejected_at;
    }

    /**
     * Si el proyecto esta pendiente de publicar
     *
     * @return boolena
     */
    public function getIsPendingAttribute()
    {
        return !$this->published_at && !$this->rejected_at && !$this->finished_at;
    }

    /**
     * Si el proyecto está publicado
     *
     * @return boolena
     */
    public function getIsPublishedAttribute()
    {
        return $this->published_at && !$this->rejected_at && !$this->finished_at;
    }

    /**
     * Si el proyecto está publicado
     *
     * @return boolena
     */
    public function getIsFinishedAttribute()
    {
        return $this->finished_at && !$this->rejected_at && !$this->published_at;
    }

    /**
     * Marca un proyecto como publicado
     *
     * @return boolean
     */
    public function publish()
    {
        $this->rejected_at = null;
        $this->published_at = Carbon::now();
        $this->finished_at = null;
        return $this->save();
    }

    /**
     * Filtra los rechazados
     * @param  [type] $query [description]
     * @return [type]        [description]
     */
    public function scopeRejected($query)
    {
        return $query->whereNotNull('rejected_at')->whereNull('published_at')->whereNull('finished_at');
    }

    /**
     * Marca un proyecto como rechazado
     *
     * @return boolean
     */
    public function reject()
    {
        $this->rejected_at = Carbon::now();
        $this->published_at = null;
        $this->finished_at = null;
        return $this->save();
    }

    /**
     * Marca un proyecto como finalizado
     *
     * @return boolean
     */
    public function finish()
    {
        $this->rejected_at = null;
        $this->published_at = null;
        $this->finished_at = Carbon::now();
        return $this->save();
    }

    /**
     * Un proyecto tiene muchas promesas de inversión
     *
     * @return HasMany
     */
    public function investments()
    {
        return $this->hasMany(\App\Models\Investment::class);
    }

    public function scopeSortByRequest($query, $request)
    {
        if (!$request->input('sort')) {
            return $query;
        }

        list($by, $order) = explode('|', $request->input('sort'));
        $order = strtolower($order) === 'desc' ? 'desc' : 'asc';

        $status_sort_sql = <<<SQL
    CASE WHEN
        -- Pendiente
        (published_at is NULL AND rejected_at is NULL AND finished_at is null)
    THEN
        1
    ELSE
        CASE WHEN
            -- Publicado
            (rejected_at IS NULL AND published_at is NOT null AND finished_at is null)
        THEN 2
        ELSE
            CASE WHEN
                -- Rechazado
                (rejected_at IS NOT NULL AND published_at is null AND finished_at is null)
            THEN 3
            ELSE 4
            END
        END
    END $order
SQL;
        switch ($by) {
            case 'name':
            case 'holder':
                return $query->orderBy($by, $order);
            case 'status':
                $query->orderByRaw($status_sort_sql);
                return $query;
        }

        return $query;
    }
}
