<?php

namespace App\Models;

use App\Models\Project;
use App\Models\Traits\HasPolicyAttributes;
use App\Models\Traits\LazyAppends;
use App\User;
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
            'name' => $this->name,
            'email' => $this->email,
        ];
    }

    public function scopeAccepted($query)
    {
        return $query->whereInvestmentStatus(self::STATUS_ACCEPTED);
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

    public function getOwnerAttribute()
    {
        return $this->owner()->first();
    }
}
