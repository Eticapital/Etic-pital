<?php

namespace App\Models;

use App\Models\Project;
use App\Models\Traits\HasPolicyAttributes;
use App\Models\Traits\LazyAppends;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class Investment extends Model
{
    use HasPolicyAttributes, Searchable, LazyAppends;

    const STATUS_NEW = 0;
    const STATUS_ACCEPTED = 1;
    const STATUS_REJECTED = -1;

    protected $fillable = [
        'amount',
        'name',
        'email',
        'phone',
        'residence',
        'organization',
    ];

    protected $appends = [
        'status_label',
        'status_class',
        'status_icon',
    ];

    protected $appendable = [
        'can_update',
        'can_delete',
        'can_accept',
        'can_reject',
        'project',
        'owner',
        'owner.can_show',
        'project.can_show',
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
            'project_name' => optional($this->project)->name,
        ];
    }

    public function scopeNew($query)
    {
        return $query->whereInvestmentStatus(self::STATUS_NEW);
    }

    public function scopeAccepted($query)
    {
        return $query->whereInvestmentStatus(self::STATUS_ACCEPTED);
    }

    public function scopeRejected($query)
    {
        return $query->whereInvestmentStatus(self::STATUS_REJECTED);
    }

    public function scopeActive($query)
    {
        return $query->where('investment_status', '>=', self::STATUS_NEW);
    }

    public function getStatusLabelAttribute()
    {
        if ($this->investment_status === self::STATUS_NEW) {
            return 'Pendiente';
        }
        if ($this->investment_status === self::STATUS_ACCEPTED) {
            return 'Aceptada';
        }
        if ($this->investment_status === self::STATUS_REJECTED) {
            return 'Rechazada';
        }
    }

    public function getStatusClassAttribute()
    {
        if ($this->investment_status === self::STATUS_NEW) {
            return 'info';
        }
        if ($this->investment_status === self::STATUS_ACCEPTED) {
            return 'success';
        }
        if ($this->investment_status === self::STATUS_REJECTED) {
            return 'danger';
        }
    }

    public function getStatusIconAttribute()
    {
        if ($this->investment_status === self::STATUS_NEW) {
            return 'more';
        }
        if ($this->investment_status === self::STATUS_ACCEPTED) {
            return 'checkmark';
        }
        if ($this->investment_status === self::STATUS_REJECTED) {
            return 'cross';
        }
    }

    /**
     * Una inversión pertence a un proyecto
     *
     * @return BelongsTo
     */
    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * El proyecto como atirbuto
     *
     * @return [type] [description]
     */
    public function getProjectAttribute()
    {
        return $this->project()->first();
    }

    /**
     * Marca la inversión como aceptada
     *
     * @return boolean
     */
    public function accept()
    {
        $this->investment_status = self::STATUS_ACCEPTED;
        return $this->save();
    }

    /**
     * Marca la inversión como rechazada
     *
     * @return boolean
     */
    public function reject()
    {
        $this->investment_status = self::STATUS_REJECTED;
        return $this->save();
    }

    /**
     * Uusairo del sistema dueño de la inversión
     *
     * @return
     */
    public function owner()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Devuelve el dueño del proyecto como atributo
     *
     * @return User
     */
    public function getOwnerAttribute()
    {
        return $this->owner()->first();
    }

    /**
     * Filtra segun atributos predefinidos en el request
     * @param  [type] $query   [description]
     * @param  [type] $request [description]
     * @return [type]          [description]
     */
    public function scopeSortByRequest($query, $request)
    {
        if (!$request->input('sort')) {
            return $query;
        }

        list($by, $order) = explode('|', $request->input('sort'));
        $order = strtolower($order) === 'desc' ? 'desc' : 'asc';

         $status_sort_sql = <<<SQL
    CASE WHEN investment_status = 0 THEN 1
    ELSE
        CASE WHEN investment_status = 1 THEN 2 ELSE 3 END
    END $order
SQL;

        switch ($by) {
            case 'name':
            case 'created_at':
            case 'amount':
                return $query->orderBy($by, $order);
            case 'project':
                return $query->select('investments.*')
                    ->groupBy('investments.id')
                    ->join('projects', 'projects.id', '=', 'investments.project_id')
                    ->orderBy('projects.name', $order);
            case 'owner':
                return $query->select('investments.*')
                    ->groupBy('investments.id')
                    ->join('users', 'users.id', '=', 'investments.owner_id')
                    ->orderBy('users.name', $order);
            case 'status':
                $query->orderByRaw($status_sort_sql);
                return $query;
        }

        return $query;
    }

    public function scopeFilterByRequest($query, $request)
    {
        if ($from = $request->input('from')) {
            $query->whereDate('created_at', '>=', Carbon::parse($from)->startOfDay());
        }

        if ($to = $request->input('to')) {
            $query->whereDate('created_at', '<=', Carbon::parse($to)->endOfDay());
        }

        return $query;
    }
}
